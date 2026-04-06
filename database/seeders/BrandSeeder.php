<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandLogos = [
            ['name' => "Toyota", 'src' => "brands/logos/logo-toyota.webp"],
            ['name' => "Volkswagen", 'src' => "brands/logos/logo-vw.webp"],
            ['name' => "Audi", 'src' => "brands/logos/logo-audi.webp"],
            ['name' => "Seat", 'src' => "brands/logos/logo-seat.webp"],
            ['name' => "Cupra", 'src' => "brands/logos/logo-cupra.webp"],
            ['name' => "Honda", 'src' => "brands/logos/logo-honda.webp"],
            ['name' => "BMW", 'src' => "brands/logos/logo-bmw.webp"],
            ['name' => "BMW Motorrad", 'src' => "brands/logos/logo-bmw-motorrad.webp"],
            ['name' => "Mini", 'src' => "brands/logos/logo-mini.webp"],
            ['name' => "Maxus", 'src' => "brands/logos/logo-maxus.webp"],
            ['name' => "Jetour", 'src' => "brands/logos/logo-jetour.webp"],
            ['name' => "Soueast", 'src' => "brands/logos/SOUEAST_BLACK_Logo.png"],
            ['name' => "Kaiyi", 'src' => "brands/logos/logo-kaiyi.webp"],
            ['name' => "Karry", 'src' => "brands/logos/logo-karry.webp"],
            ['name' => "Geely", 'src' => "brands/logos/logo-geely.webp"],
            ['name' => "MG", 'src' => "brands/logos/logo-mg.webp"],
            ['name' => "Dongfeng", 'src' => "brands/logos/logo-dongfeng.webp"],
            ['name' => "Foton", 'src' => "brands/logos/logo-foton.webp"],
        ];

        $truckLogos = [
            ['name' => "Iveco", 'src' => "brands/logos/logo-iveco.webp"],
            ['name' => "MAN", 'src' => "brands/logos/logo-man.webp"],
            ['name' => "VW Camiones", 'src' => "brands/logos/logo-vw-camiones.webp"],
            ['name' => "Maxus", 'src' => "brands/logos/logo-maxus.webp"], // Maxus exists in both, model might handle unique slugs
            ['name' => "Foton Camiones", 'src' => "brands/logos/logo-foton-camiones.webp"],
        ];

        foreach ($brandLogos as $brand) {
            $this->createBrand($brand, 'autos');
        }

        foreach ($truckLogos as $truck) {
            $this->createBrand($truck, 'camiones');
        }
    }

    protected function createBrand(array $data, string $category)
    {
        // Use updateOrCreate to avoid duplicates if re-running
        Brand::updateOrCreate(
            ['slug' => Str::slug($data['name'])],
            [
                'name' => $data['name'],
                'logo_url' => $data['src'],
                'category' => $category,
                'is_active' => true,
                'show_in_services' => true,
                'show_in_parts' => true,
                'show_in_dyp' => true,
                'brand_color_css' => 'text-gray-900', // Default
                'seo_title' => "{$data['name']} - Automotriz Carmona",
            ]
        );
    }
}
