<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\VehicleModel;
use App\Models\VehicleVersion;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportCatalogCommand extends Command
{
    protected $signature = 'catalog:import {file?} {--path=}';
    protected $description = 'Ingesta idempotente de catálogo (489 vehículos) desde un CSV, limpiando datos y generando URLs estáticas.';

    public function handle()
    {
        $filePath = $this->option('path') ?: storage_path('app/CONSILIDADO-LIVIANOS - carmona.csv');

        // Permitir un argumento directo para mayor facilidad
        if ($this->argument('file')) {
            $filePath = $this->argument('file');
        }

        if (!file_exists($filePath)) {
            $this->error("No se encontró el archivo CSV en: {$filePath}");
            return 1;
        }

        $this->info("🚀 Iniciando Ingesta de Catálogo desde: {$filePath}");

        $handle = fopen($filePath, 'r');
        
        // Ignorar encabezados
        fgetcsv($handle, 1000, ',');

        $rowCount = 0;
        
        while (($data = fgetcsv($handle, 4000, ',')) !== false) {
            if (count($data) < 18) continue; // Precaución contra filas vacías

            // Parseo Limpio de Entidades Principales
            $brandName = trim($data[0]);
            $modelName = trim($data[1]);
            $versionName = trim($data[2]);

            // Limpieza de caracteres especiales para los Slugs
            $brandSlug = Str::slug($this->cleanAccents($brandName));
            $modelSlug = Str::slug($this->cleanAccents($modelName));
            $versionSlug = Str::slug($this->cleanAccents($versionName));

            if (empty($brandSlug) || empty($modelSlug) || empty($versionSlug)) {
                continue;
            }

            // --- 1. IDEMPOTENCIA: MARCA ---
            $brand = Brand::updateOrCreate(
                ['slug' => $brandSlug],
                [
                    'name' => mb_convert_case($brandName, MB_CASE_TITLE, "UTF-8"),
                    'logo_url' => "automotriz/logos/{$brandSlug}.webp",
                ]
            );

            // Valores Booleanos Detectados Automáticamente
            $combustible = strtolower(trim($data[11]));
            $categoria = strtolower(trim($data[8]));
            $isVirtualElectrified = (strpos($combustible, 'eléctrico') !== false || strpos($combustible, 'híbrido') !== false);

            // --- 2. IDEMPOTENCIA: MODELO ---
            $vehicleModel = VehicleModel::updateOrCreate(
                [
                    'brand_id' => $brand->id,
                    'slug' => $modelSlug,
                ],
                [
                    'name' => mb_convert_case($modelName, MB_CASE_TITLE, "UTF-8"),
                    'vehicle_type' => strtolower(trim($data[7])), // liviano, moto, etc
                    'category' => $categoria,
                    // Ruta Agnóstica para el CDN
                    'thumbnail_url' => "automotriz/autos-nuevos/{$brandSlug}/{$modelSlug}/thumb.webp",
                    'is_new' => true,
                    'is_hybrid' => strpos($combustible, 'híbrido') !== false,
                    'is_electric' => strpos($combustible, 'eléctrico') !== false,
                ]
            );

            // --- 3. IDEMPOTENCIA: VERSIÓN ---
            // Limpiadores de Precios e IVA
            $listPrice = $this->cleanPrice($data[3]);
            $brandBonus = $this->cleanPrice($data[4]);
            $financeBonus = $this->cleanPrice($data[5]);
            $financePrice = $this->cleanPrice($data[6]);
            
            $includesIva = strtoupper(trim($data[9])) === 'SÍ' || strtoupper(trim($data[9])) === 'SI';
            
            // Tratamiento Airbags (- significa nulo)
            $airbagsRaw = trim($data[13]);
            $airbags = is_numeric($airbagsRaw) ? (int)$airbagsRaw : null;

            VehicleVersion::updateOrCreate(
                [
                    'vehicle_model_id' => $vehicleModel->id,
                    'slug' => $versionSlug,
                ],
                [
                    'name' => mb_convert_case($versionName, MB_CASE_TITLE, "UTF-8"),
                    'list_price' => $listPrice,
                    'brand_bonus' => $brandBonus,
                    'finance_bonus' => $financeBonus,
                    'finance_price' => $financePrice,
                    
                    'includes_iva' => $includesIva,
                    'engine' => trim($data[10]) === '-' ? null : trim($data[10]),
                    'fuel' => mb_convert_case(trim($data[11]), MB_CASE_TITLE, "UTF-8"),
                    'transmission' => mb_convert_case(trim($data[12]), MB_CASE_TITLE, "UTF-8"),
                    'airbags' => $airbags,
                    'traction' => trim($data[14]) === '-' ? null : trim($data[14]),
                    'mixed_performance' => trim($data[15]) === '-' ? null : trim($data[15]),
                    'autonomy_km' => trim($data[16]) === '-' ? null : trim($data[16]),
                    'power_hp' => trim($data[17]) === '-' ? null : trim($data[17]),
                    'torque_nm' => trim($data[18]) === '-' ? null : trim($data[18]),
                ]
            );

            $rowCount++;
            if ($rowCount % 50 === 0) {
                $this->info("Procesadas {$rowCount} versiones...");
            }
        }

        fclose($handle);

        $this->info("✅ ¡Éxito! Ingestión finalizada idempotentemente con {$rowCount} versiones en total.");
        return 0;
    }

    /**
     * Helper paramétrico que remueve $ y parsea numéricos de forma estricta.
     */
    protected function cleanPrice(string $rawPrice): ?int
    {
        $cleaned = str_replace([' ', '$', '.', ','], '', trim($rawPrice));
        if ($cleaned === '' || $cleaned === '-' || !is_numeric($cleaned)) {
            return null;
        }
        return (int) $cleaned;
    }

    /**
     * Limpia diéresis (ej: Citroën) y tildes para generar slugs consistentes.
     */
    protected function cleanAccents(string $string): string
    {
        $string = str_replace(
            ['á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ','ü','Ü','ë','Ë'], 
            ['a','e','i','o','u','A','E','I','O','U','n','N','u','U','e','E'], 
            $string
        );
        return $string;
    }
}
