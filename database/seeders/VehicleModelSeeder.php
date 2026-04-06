<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\VehicleModel;
use App\Models\VehicleVersion;
use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        $toyotaModels = [
            [
                'id' => 'bz4x',
                'name' => 'BZ4X',
                'category' => 'SUV',
                'price' => 41990000,
                'image' => 'images/toyota/Hibridos/min_bZ4X.png',
                'isHybrid' => false,
                'isElectric' => true,
                'isNew' => true,
                'slogan' => 'Más que un eléctrico, un eléctrico Toyota',
            ],
            [
                'id' => 'yaris-cross',
                'name' => 'Yaris Cross',
                'category' => 'SUV',
                'price' => 20990000,
                'image' => 'images/toyota/Hibridos/min_yaris_cross.png',
                'isHybrid' => true,
                'isNew' => true,
                'slogan' => 'Todo eso y más',
                'desktopBanner' => 'images/toyota/SUV/yaris-cross/banner_80492.jpg',
                'mobileBanner' => 'images/toyota/SUV/yaris-cross/banner_80443.jpg',
                'gallery' => [
                    'images/toyota/SUV/yaris-cross/galeria_80998.jpg',
                    'images/toyota/SUV/yaris-cross/galeria_80549.jpg',
                    'images/toyota/SUV/yaris-cross/galeria_80657.jpg',
                    'images/toyota/SUV/yaris-cross/galeria_80714.jpg',
                    'images/toyota/SUV/yaris-cross/galeria_80765.jpg',
                    'images/toyota/SUV/yaris-cross/galeria_80833.jpg',
                    'images/toyota/SUV/yaris-cross/galeria_80901.jpg',
                    'images/toyota/SUV/yaris-cross/galeria_80947.jpg',
                    'images/toyota/SUV/yaris-cross/galeria_81080.jpg'
                ],
                'versions' => [
                    [
                        'name' => 'YARIS CROSS HYBRID XI 1.5 CVT',
                        'transmission' => 'Automática',
                        'traction' => '4x2',
                        'fuel' => 'Híbrido',
                        'listPrice' => 24590000,
                        'bonusPrice' => 20990000
                    ],
                    [
                        'name' => 'YARIS CROSS HYBRID XG 1.5 CVT',
                        'transmission' => 'Automática',
                        'traction' => '4x2',
                        'fuel' => 'Híbrido',
                        'listPrice' => 26590000,
                        'bonusPrice' => 22990000
                    ]
                ],
                'features' => [
                    [
                        'title' => "Rendimiento y Motor 1.5L",
                        'desc' => "Excelente desempeño con un motor 1.5L con opciones de transmisión MT y CVT. Alto rendimiento de combustible, ágil y cómodo.",
                        'icon' => 'images/toyota/SUV/yaris-cross/galeria_80998.jpg'
                    ],
                    [
                        'title' => "Seguridad y Control Real",
                        'desc' => "Frenos ABS, Asistencia de salida en pendiente (HAC), Control de Estabilidad (VSC) y distribución electrónica de frenado (EBD).",
                        'icon' => 'images/toyota/SUV/yaris-cross/galeria_80947.jpg'
                    ],
                    [
                        'title' => "Conectividad y Pantalla TFT",
                        'desc' => "Compatible con Apple CarPlay y Android Auto. Pantalla TFT avanzada de 7 pulgadas y velocímetro LED digital continuo (XG).",
                        'icon' => 'images/toyota/SUV/yaris-cross/galeria_80657.jpg'
                    ],
                    [
                        'title' => "Llantas aro 17” y 18”",
                        'desc' => "Llantas robustas para Yaris Cross acompañadas con un diseño distintivo.",
                        'icon' => 'images/toyota/SUV/yaris-cross/galeria_80714.jpg'
                    ],
                    [
                        'title' => "Botón de Encendido",
                        'desc' => "Máxima tecnología y fluidez. Smart Entry & Keyless Go para todas sus versiones.",
                        'icon' => 'images/toyota/SUV/yaris-cross/galeria_80833.jpg'
                    ]
                ],
                'videoUrl' => 'https://www.youtube.com/embed/4dBDMEULD1Y'
            ],
            [
                'id' => 'corolla-sedan',
                'name' => 'Corolla',
                'category' => 'Sedán',
                'price' => 21990000,
                'image' => 'images/toyota/Sedan/min_corolla.png',
                'isHybrid' => true,
                'isNew' => false,
                'slogan' => 'Sigue haciendo historia'
            ],
            [ 'id' => 'corolla-cross', 'name' => 'NEW Corolla Cross', 'category' => 'SUV', 'price' => 24490000, 'image' => 'images/toyota/Hibridos/min_corolla_cross.png', 'isHybrid' => true, 'isNew' => true, 'slogan' => 'La tradición de innovar' ],
            [ 'id' => 'rav4', 'name' => 'Rav4', 'category' => 'SUV', 'price' => 30790000, 'image' => 'images/toyota/Hibridos/min_rav4.png', 'isHybrid' => true, 'isNew' => false, 'slogan' => 'Recorriendo los caminos' ],
            [ 'id' => 'yaris-sedan', 'name' => 'Yaris', 'category' => 'Sedán', 'price' => 11490000, 'image' => 'images/toyota/Sedan/min_yaris.png', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Tu primer Toyota' ],
            [ 'id' => 'raize', 'name' => 'Raize', 'category' => 'SUV', 'price' => 13990000, 'image' => 'images/toyota/SUV/min_raize.png', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Conecta con tu lado divertido' ],
            [ 'id' => 'land-cruiser-prado', 'name' => 'Land Cruiser Prado', 'category' => 'SUV', 'price' => 48990000, 'image' => 'images/toyota/SUV/min_land_cruiser.png', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Leyenda todoterreno' ],
            [ 'id' => 'hilux', 'name' => 'Hilux', 'category' => 'Camioneta', 'price' => 26990000, 'image' => 'images/toyota/Pickup/min_hilux.png', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'La pick-up indestructible' ],
            [ 'id' => 'fortuner', 'name' => 'Fortuner', 'category' => 'SUV', 'price' => 32990000, 'image' => 'images/toyota/SUV/min_fortuner.png', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Aventura con estilo' ],
            [ 'id' => '4runner', 'name' => '4Runner', 'category' => 'SUV', 'price' => 36990000, 'image' => 'images/toyota/SUV/min_4runner.png', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Espíritu libre' ],
            [ 'id' => 'yaris-gr', 'name' => 'GR Yaris', 'category' => 'Gazoo Racing', 'price' => 41990000, 'image' => 'images/toyota/Gazoo-Racing/min_yaris_gr.png', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Adrenaline has a new Generation' ],
            [ 'id' => 'hilux-gr', 'name' => 'Hilux GR-S', 'category' => 'Gazoo Racing', 'price' => 43990000, 'image' => 'images/toyota/Gazoo-Racing/min_hilux_gr.png', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Gazoo Racing Sport' ],
            [ 'id' => 'fortuner-gr', 'name' => 'Fortuner GR-S', 'category' => 'Gazoo Racing', 'price' => 45990000, 'image' => 'images/toyota/Gazoo-Racing/min_fortuner_gr.png', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Gazoo Racing Sport' ]
        ];

        $audiModels = [
            [ 'id' => 'a3-sportback', 'name' => 'A3 Sportback', 'category' => 'Sportback', 'price' => 32990000, 'image' => 'images/audi/a3sportback.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Vanguardia en cada línea' ],
            [ 'id' => 'a3-sedan', 'name' => 'A3 Sedán', 'category' => 'Sedán', 'price' => 33990000, 'image' => 'images/audi/a3-sedan.webp', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'nuevo-s5', 'name' => 'Nuevo S5', 'category' => 'Deportivo', 'price' => 58990000, 'image' => 'images/audi/nuevo-s5.webp', 'isHybrid' => false, 'isNew' => true ],
            [ 'id' => 'nuevo-a5', 'name' => 'Nuevo A5', 'category' => 'Sedán', 'price' => 45990000, 'image' => 'images/audi/nuevo-a5.webp', 'isHybrid' => false, 'isNew' => true ],
            [ 'id' => 'a6-sportback-etron', 'name' => 'A6 Sportback e-tron', 'category' => 'Eléctrico', 'price' => 85990000, 'image' => 'images/audi/a6-etron.webp', 'isElectric' => true, 'isNew' => true ],
            [ 'id' => 'q3', 'name' => 'Q3', 'category' => 'SUV', 'price' => 37990000, 'image' => 'images/audi/q3.webp', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'q3-sportback', 'name' => 'Q3 Sportback', 'category' => 'Sportback', 'price' => 40990000, 'image' => 'images/audi/q3-sportback.webp', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'nuevo-q3-suv', 'name' => 'Nuevo Q3 SUV', 'category' => 'SUV', 'price' => 38990000, 'image' => 'images/audi/q3-suv.webp', 'isHybrid' => false, 'isNew' => true ],
            [ 'id' => 'nuevo-q3-sportback', 'name' => 'Nuevo Q3 Sportback', 'category' => 'Sportback', 'price' => 42990000, 'image' => 'images/audi/nuevo-q3-sportback.webp', 'isHybrid' => false, 'isNew' => true ],
            [ 'id' => 'q4-sportback-etron', 'name' => 'Q4 Sportback e-tron', 'category' => 'Eléctrico', 'price' => 75990000, 'image' => 'images/audi/q4-etron-sportback.webp', 'isElectric' => true, 'isNew' => true ],
            [ 'id' => 'nuevo-q5-suv', 'name' => 'Nuevo Q5 SUV', 'category' => 'SUV', 'price' => 52990000, 'image' => 'images/audi/nuevo-suv-q5.webp', 'isHybrid' => false, 'isNew' => true ],
            [ 'id' => 'nuevo-sq5-suv', 'name' => 'Nuevo SQ5 SUV', 'category' => 'Deportivo', 'price' => 68990000, 'image' => 'images/audi/Nuevo-SQ5.webp', 'isHybrid' => false, 'isNew' => true ],
            [ 'id' => 'nuevo-q5-sportback', 'name' => 'Nuevo Q5 Sportback', 'category' => 'Sportback', 'price' => 55990000, 'image' => 'images/audi/nuevo-q5-sportback.webp', 'isHybrid' => false, 'isNew' => true ],
            [ 'id' => 'q6-etron', 'name' => 'Q6 e-tron', 'category' => 'Eléctrico', 'price' => 92990000, 'image' => 'images/audi/q6-etron.webp', 'isElectric' => true, 'isNew' => true ],
            [ 'id' => 'q6-sportback-etron', 'name' => 'Q6 Sportback e-tron', 'category' => 'Eléctrico', 'price' => 95990000, 'image' => 'images/audi/q6-sportback-etron.webp', 'isElectric' => true, 'isNew' => true ],
            [ 'id' => 'q7', 'name' => 'Q7', 'category' => 'SUV', 'price' => 72990000, 'image' => 'images/audi/q7.webp', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'sq7', 'name' => 'SQ7', 'category' => 'Deportivo', 'price' => 88990000, 'image' => 'images/audi/sq7.webp', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'q8', 'name' => 'Q8', 'category' => 'SUV', 'price' => 82990000, 'image' => 'images/audi/q8.webp', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'sq8', 'name' => 'SQ8', 'category' => 'Deportivo', 'price' => 98990000, 'image' => 'images/audi/sq8.webp', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'rs-q8-performance', 'name' => 'RS Q8 performance', 'category' => 'Deportivo', 'price' => 145990000, 'image' => 'images/audi/rs-q8-performance.webp', 'isHybrid' => false, 'isNew' => true ]
        ];

        $vwModels = [
            [ 'id' => 'polo-track', 'name' => 'Polo Track', 'category' => 'Hatchback', 'price' => 11690000, 'image' => 'images/volkswagen/polo-track.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Tu primer Volkswagen' ],
            [ 'id' => 'polo', 'name' => 'Polo', 'category' => 'Hatchback', 'price' => 14590000, 'image' => 'images/volkswagen/polo.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Inspiración en cada detalle' ],
            [ 'id' => 'virtus', 'name' => 'Virtus', 'category' => 'Sedán', 'price' => 15290000, 'image' => 'images/volkswagen/virtus.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Eleva tu camino' ],
            [ 'id' => 'jetta', 'name' => 'Nuevo Jetta', 'category' => 'Sedán', 'price' => 19990000, 'image' => 'images/volkswagen/nuevo jetta.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'El clásico renovado' ],
            [ 'id' => 't-cross', 'name' => 'T-Cross', 'category' => 'SUV', 'price' => 17490000, 'image' => 'images/volkswagen/t-cross.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Tu vida en modo T-Cross' ],
            [ 'id' => 'taos', 'name' => 'Taos', 'category' => 'SUV', 'price' => 23990000, 'image' => 'images/volkswagen/taos.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Brillante en cada detalle' ],
            [ 'id' => 'tiguan', 'name' => 'Tiguan', 'category' => 'SUV', 'price' => 27990000, 'image' => 'images/volkswagen/tiguan.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Espacio para tus sueños' ],
            [ 'id' => 'nuevo-tiguan', 'name' => 'Nuevo Tiguan', 'category' => 'SUV', 'price' => 32990000, 'image' => 'images/volkswagen/ Nuevo Tiguan.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'La evolución de un icono' ],
            [ 'id' => 'atlas', 'name' => 'Atlas', 'category' => 'SUV', 'price' => 44990000, 'image' => 'images/volkswagen/atlas.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Poder en gran escala' ],
            [ 'id' => 'nuevo-tera', 'name' => 'Nuevo Tera', 'category' => 'SUV', 'price' => 15990000, 'image' => 'images/volkswagen/Nuevo Tera.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Libertad sin límites' ],
            [ 'id' => 'saveiro-cs', 'name' => 'Saveiro CS', 'category' => 'Pick-up', 'price' => 12990000, 'image' => 'images/volkswagen/saveiro cs.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Tu compañero de trabajo' ],
            [ 'id' => 'saveiro-dc', 'name' => 'Saveiro DC', 'category' => 'Pick-up', 'price' => 14490000, 'image' => 'images/volkswagen/saveiro dc.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Versatilidad total' ],
            [ 'id' => 'amarok', 'name' => 'Amarok', 'category' => 'Pick-up', 'price' => 31990000, 'image' => 'images/volkswagen/Nueva Amarok.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Potencia sin límites' ],
            [ 'id' => 'caravelle', 'name' => 'Nueva Caravelle', 'category' => 'Van', 'price' => 38990000, 'image' => 'images/volkswagen/Nueva Caravelle.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Transporte de clase mundial' ],
            [ 'id' => 'transporter', 'name' => 'Nuevo Transporter', 'category' => 'Furgón', 'price' => 34990000, 'image' => 'images/volkswagen/Nuevo Transporter.png', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Eficiencia para tu negocio' ]
        ];

        $bmwModels = [
            [ 'id' => 'x1', 'name' => 'X1', 'category' => 'SUV', 'price' => 36990000, 'image' => 'images/bmw/X1.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'x2', 'name' => 'X2', 'category' => 'SUV', 'price' => 41990000, 'image' => 'images/bmw/X2.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'x3', 'name' => 'X3', 'category' => 'SUV', 'price' => 48990000, 'image' => 'images/bmw/X3.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'x4', 'name' => 'X4', 'category' => 'SUV', 'price' => 53990000, 'image' => 'images/bmw/X4.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'x5', 'name' => 'X5', 'category' => 'SUV', 'price' => 72990000, 'image' => 'images/bmw/X5.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'x6', 'name' => 'X6', 'category' => 'SUV', 'price' => 82990000, 'image' => 'images/bmw/X6.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'x7', 'name' => 'X7', 'category' => 'SUV', 'price' => 104990000, 'image' => 'images/bmw/X7.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'x2-m35i', 'name' => 'X2 M35i', 'category' => 'SUV', 'price' => 54990000, 'image' => 'images/bmw/X2_M35i.png', 'isHybrid' => false, 'isNew' => true ],
            [ 'id' => 'serie-1', 'name' => 'Serie 1', 'category' => 'HATCHBACK', 'price' => 26990000, 'image' => 'images/bmw/serie-1.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'm135', 'name' => 'M135', 'category' => 'HATCHBACK', 'price' => 44990000, 'image' => 'images/bmw/m135.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'serie-2-coupe', 'name' => 'Serie 2 Coupé', 'category' => 'COUPÉ', 'price' => 33990000, 'image' => 'images/bmw/serie-2_coupe.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'serie-2-gran-coupe', 'name' => 'Serie 2 Gran Coupé', 'category' => 'COUPÉ', 'price' => 31990000, 'image' => 'images/bmw/serie-2_gran-coupe.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'serie-4-coupe', 'name' => 'Serie 4 Coupé', 'category' => 'COUPÉ', 'price' => 46990000, 'image' => 'images/bmw/Serie-4_Coupe.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'serie-4-gran-coupe', 'name' => 'Serie 4 Gran Coupé', 'category' => 'COUPÉ', 'price' => 48990000, 'image' => 'images/bmw/serie-4_gran-coupe.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'serie-8-coupe', 'name' => 'Serie 8 Coupé', 'category' => 'COUPÉ', 'price' => 89990000, 'image' => 'images/bmw/serie-8_coupe.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'm240i', 'name' => 'M240i', 'category' => 'COUPÉ', 'price' => 53990000, 'image' => 'images/bmw/m240i.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'm440i-gran-coupe', 'name' => 'M440i Gran Coupé', 'category' => 'COUPÉ', 'price' => 64990000, 'image' => 'images/bmw/m440i_gran-coue.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'serie-2-gran', 'name' => 'Serie 2 Gran', 'category' => 'COUPÉ', 'price' => 30990000, 'image' => 'images/bmw/serie-2_grand_coupe.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'serie-3', 'name' => 'Serie 3', 'category' => 'SEDAN', 'price' => 38990000, 'image' => 'images/bmw/serie-3.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'serie-5', 'name' => 'Serie 5', 'category' => 'SEDAN', 'price' => 52990000, 'image' => 'images/bmw/serie-5.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'serie-7-hibrido', 'name' => 'Serie 7 Híbrido', 'category' => 'SEDAN', 'price' => 114990000, 'image' => 'images/bmw/serie-7_hibrido.png', 'isHybrid' => true, 'isNew' => true ],
            [ 'id' => 'serie-4-convertible', 'name' => 'Serie 4 Convertible', 'category' => 'CONVERTIBLE', 'price' => 58990000, 'image' => 'images/bmw/serie-4_convertible.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'z4', 'name' => 'Z4', 'category' => 'CONVERTIBLE', 'price' => 53990000, 'image' => 'images/bmw/z4.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'm4-convertible', 'name' => 'M4 Convertible', 'category' => 'CONVERTIBLE', 'price' => 92990000, 'image' => 'images/bmw/m4_convertible.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'm2', 'name' => 'M2', 'category' => 'DEPORTIVOS', 'price' => 72990000, 'image' => 'images/bmw/m2.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'm3', 'name' => 'M3', 'category' => 'DEPORTIVOS', 'price' => 84990000, 'image' => 'images/bmw/m3.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'm4', 'name' => 'M4', 'category' => 'DEPORTIVOS', 'price' => 88990000, 'image' => 'images/bmw/m4.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'm5', 'name' => 'M5', 'category' => 'DEPORTIVOS', 'price' => 114990000, 'image' => 'images/bmw/m5.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'x5m', 'name' => 'X5 M', 'category' => 'DEPORTIVOS', 'price' => 119990000, 'image' => 'images/bmw/x5m.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'x6m', 'name' => 'X6 M', 'category' => 'DEPORTIVOS', 'price' => 124990000, 'image' => 'images/bmw/x6m.png', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'i4', 'name' => 'i4', 'category' => 'ELÉCTRICOS', 'price' => 72990000, 'image' => 'images/bmw/i4.png', 'isElectric' => true, 'isNew' => false ],
            [ 'id' => 'ix', 'name' => 'iX', 'category' => 'ELÉCTRICOS', 'price' => 92990000, 'image' => 'images/bmw/iX.png', 'isElectric' => true, 'isNew' => false ],
            [ 'id' => 'serie-3-hibrido', 'name' => 'Serie 3 Híbrido', 'category' => 'ELÉCTRICOS', 'price' => 48990000, 'image' => 'images/bmw/serie-3_hibrido.png', 'isHybrid' => true, 'isNew' => false ],
            [ 'id' => 'x5-hibrido', 'name' => 'X5 Híbrido', 'category' => 'ELÉCTRICOS', 'price' => 81990000, 'image' => 'images/bmw/x5_hibrido.png', 'isHybrid' => true, 'isNew' => false ],
            [ 'id' => 'ix1', 'name' => 'iX1', 'category' => 'ELÉCTRICOS', 'price' => 52990000, 'image' => 'images/bmw/iX1.png', 'isElectric' => true, 'isNew' => true ],
            [ 'id' => 'x1-hibrido', 'name' => 'X1 Híbrido', 'category' => 'ELÉCTRICOS', 'price' => 44990000, 'image' => 'images/bmw/X1_Hibrido.png', 'isHybrid' => true, 'isNew' => true ],
            [ 'id' => 'i5', 'name' => 'i5', 'category' => 'ELÉCTRICOS', 'price' => 82990000, 'image' => 'images/bmw/i5.png', 'isElectric' => true, 'isNew' => true ],
            [ 'id' => 'i7', 'name' => 'i7', 'category' => 'ELÉCTRICOS', 'price' => 134990000, 'image' => 'images/bmw/i7.png', 'isElectric' => true, 'isNew' => true ],
            [ 'id' => 'ix2', 'name' => 'iX2', 'category' => 'ELÉCTRICOS', 'price' => 58990000, 'image' => 'images/bmw/iX2.png', 'isElectric' => true, 'isNew' => true ],
            [ 'id' => 'serie-5-hibrido', 'name' => 'Serie 5 Híbrido', 'category' => 'ELÉCTRICOS', 'price' => 62990000, 'image' => 'images/bmw/serie-5_hibrido.png', 'isHybrid' => true, 'isNew' => true ],
            [ 'id' => 'x3-hibrido', 'name' => 'X3 Híbrido', 'category' => 'ELÉCTRICOS', 'price' => 52990000, 'image' => 'images/bmw/X3_hibrido.png', 'isHybrid' => true, 'isNew' => false ]
        ];

        $hondaModels = [
            [ 'id' => 'civic', 'name' => 'Honda Civic', 'category' => 'Sedán', 'price' => 24990000, 'image' => 'images/honda/civic.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'El legado continúa' ],
            [ 'id' => 'wr-v', 'name' => 'New Honda WR-V', 'category' => 'SUV', 'price' => 15490000, 'image' => 'images/honda/New-WRV.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Aventuras sin límites' ],
            [ 'id' => 'hr-v', 'name' => 'New Honda HR-V', 'category' => 'SUV', 'price' => 19990000, 'image' => 'images/honda/new-hr-v.webp', 'isHybrid' => false, 'isNew' => true, 'slogan' => 'Sofisticación en cada detalle' ],
            [ 'id' => 'zr-v', 'name' => 'Honda ZR-V', 'category' => 'SUV', 'price' => 26990000, 'image' => 'images/honda/zr-v.webp', 'isHybrid' => false, 'isNew' => false ],
            [ 'id' => 'cr-v', 'name' => 'Honda CR-V', 'category' => 'SUV', 'price' => 31990000, 'image' => 'images/honda/CR-V.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Liderazgo en movimiento' ],
            [ 'id' => 'cr-v-hybrid', 'name' => 'Honda CR-V e:HEV', 'category' => 'SUV', 'price' => 43990000, 'image' => 'images/honda/CR-V_ehev.webp', 'isHybrid' => true, 'isNew' => true, 'slogan' => 'Poder electrificado' ],
            [ 'id' => 'pilot', 'name' => 'Honda Pilot', 'category' => 'SUV', 'price' => 48990000, 'image' => 'images/honda/Pilot.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Espacio para grandes momentos' ]
        ];

        $seatModels = [
            [ 'id' => 'ibiza', 'name' => 'Seat Ibiza', 'category' => 'Hatchback', 'price' => 14990000, 'image' => 'images/seat/ibiza.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Creado en Barcelona' ]
        ];

        $cupraModels = [
            [ 'id' => 'leon', 'name' => 'Leon', 'category' => 'Hatchback', 'price' => 26990000, 'image' => 'images/cupra/leon.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'El pulso de una nueva era' ],
            [ 'id' => 'formentor', 'name' => 'Formentor', 'category' => 'SUV', 'price' => 29990000, 'image' => 'images/cupra/formentor.webp', 'isHybrid' => false, 'isNew' => false, 'slogan' => 'Pura adrenalina' ],
            [ 'id' => 'formentor-ehybrid', 'name' => 'Formentor e-Hybrid', 'category' => 'SUV', 'price' => 35990000, 'image' => 'images/cupra/formentor e-hybrid.webp', 'isHybrid' => true, 'isNew' => false, 'slogan' => 'Potencia electrificada' ],
            [ 'id' => 'terramar', 'name' => 'Terramar', 'category' => 'SUV', 'price' => 38990000, 'image' => 'images/cupra/terramar.webp', 'isHybrid' => true, 'isNew' => true, 'slogan' => 'El nuevo SUV de CUPRA' ],
            [ 'id' => 'tavascan', 'name' => 'Tavascan', 'category' => 'SUV', 'price' => 45990000, 'image' => 'images/cupra/tavascan.webp', 'isElectric' => true, 'isNew' => true, 'slogan' => 'Un sueño hecho realidad' ]
        ];

        $this->seedGroup('Toyota', $toyotaModels);
        $this->seedGroup('Audi', $audiModels);
        $this->seedGroup('Volkswagen', $vwModels);
        $this->seedGroup('BMW', $bmwModels);
        $this->seedGroup('Honda', $hondaModels);
        $this->seedGroup('Seat', $seatModels);
        $this->seedGroup('Cupra', $cupraModels);
    }

    protected function seedGroup(string $brandName, array $models): void
    {
        $brand = Brand::where('name', $brandName)->first();

        if (!$brand) {
            $this->command->error("Brand {$brandName} not found.");
            return;
        }

        foreach ($models as $modelData) {
            $model = VehicleModel::updateOrCreate(
                ['slug' => $modelData['id']],
                [
                    'brand_id' => $brand->id,
                    'name' => $modelData['name'],
                    'category' => $modelData['category'] ?? null,
                    'base_price' => $modelData['price'] ?? 0,
                    'thumbnail_url' => $this->cleanPath($modelData['image']),
                    'desktop_banner_url' => isset($modelData['desktopBanner']) ? $this->cleanPath($modelData['desktopBanner']) : null,
                    'mobile_banner_url' => isset($modelData['mobileBanner']) ? $this->cleanPath($modelData['mobileBanner']) : null,
                    'video_url' => $modelData['videoUrl'] ?? null,
                    'gallery' => isset($modelData['gallery']) ? array_map([$this, 'cleanPath'], $modelData['gallery']) : null,
                    'slogan' => $modelData['slogan'] ?? null,
                    'is_new' => $modelData['isNew'] ?? true,
                    'is_hybrid' => $modelData['isHybrid'] ?? false,
                    'is_electric' => $modelData['isElectric'] ?? false,
                ]
            );

            // Seed Versions
            if (isset($modelData['versions'])) {
                foreach ($modelData['versions'] as $v) {
                    VehicleVersion::updateOrCreate(
                        ['vehicle_model_id' => $model->id, 'name' => $v['name']],
                        [
                            'transmission' => $v['transmission'] ?? null,
                            'traction' => $v['traction'] ?? null,
                            'fuel' => $v['fuel'] ?? null,
                            'list_price' => $v['listPrice'] ?? 0,
                            'bonus_price' => $v['bonusPrice'] ?? 0,
                        ]
                    );
                }
            }

            // Seed Features
            if (isset($modelData['features'])) {
                foreach ($modelData['features'] as $f) {
                    Feature::updateOrCreate(
                        ['vehicle_model_id' => $model->id, 'title' => $f['title']],
                        [
                            'description' => $f['desc'] ?? null,
                            'image_url' => isset($f['icon']) ? $this->cleanPath($f['icon']) : null,
                        ]
                    );
                }
            }
        }
    }

    protected function cleanPath(string $path): string
    {
        // Remove leading slash if exists
        return ltrim($path, '/');
    }
}
