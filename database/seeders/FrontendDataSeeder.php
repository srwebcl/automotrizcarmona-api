<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\VehicleModel;
use App\Models\VehicleVersion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FrontendDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'toyota' => ['name' => 'Toyota', 'logo' => '/images/logos/logo-toyota.webp', 'seo_title' => 'Electromovilidad que se adapta a tu estilo de vida', 'brand_color_css' => 'text-red-700'],
            'volkswagen' => ['name' => 'Volkswagen', 'logo' => '/images/logos/logo-vw.webp', 'seo_title' => 'Innovación y Tecnología Alemana para tu camino', 'brand_color_css' => 'text-blue-900'],
            'audi' => ['name' => 'Audi', 'logo' => '/images/logos/logo-audi.webp', 'seo_title' => 'Liderazgo a través de la Tecnología y el Diseño', 'brand_color_css' => 'text-gray-900'],
            'honda' => ['name' => 'Honda', 'logo' => '/images/logos/logo-honda.webp', 'seo_title' => 'Honda Chile | El Poder de los Sueños en Automotriz Carmona', 'brand_color_css' => 'text-red-600'],
            'cupra' => ['name' => 'Cupra', 'logo' => '/images/logos/logo-cupra.webp', 'seo_title' => 'Cupra | Siente el Impulso de una nueva era en Automotriz Carmona', 'brand_color_css' => 'text-gray-900'],
            'seat' => ['name' => 'Seat', 'logo' => '/images/logos/logo-seat.webp', 'seo_title' => 'Seat | Emoción en Movimiento y Diseño Urbano en Automotriz Carmona', 'brand_color_css' => 'text-gray-900'],
            'bmw' => ['name' => 'BMW', 'logo' => '/images/logos/logo-bmw.webp', 'seo_title' => 'BMW Chile | El Placer de Conducir en Automotriz Carmona', 'brand_color_css' => 'text-blue-600'],
            'bmw-motorrad' => ['name' => 'BMW Motorrad', 'logo' => '/images/logos/logo-bmw-motorrad.webp', 'seo_title' => 'Make Life a Ride', 'brand_color_css' => 'text-blue-600'],
            'foton' => ['name' => 'Foton', 'logo' => '/images/logos/logo-foton.webp', 'seo_title' => 'Líder en Transporte y Eficiencia para tu Negocio', 'brand_color_css' => 'text-black'],
            'mg' => ['name' => 'MG', 'logo' => '/images/logos/logo-mg.webp', 'seo_title' => 'MG | Driving Forward with Innovation', 'brand_color_css' => 'text-red-600'],
            'maxus' => ['name' => 'Maxus', 'logo' => '/images/logos/logo-maxus.webp', 'seo_title' => 'Maxus | Deliver the Future', 'brand_color_css' => 'text-blue-800'],
            'geely' => ['name' => 'Geely', 'logo' => '/images/logos/logo-geely.webp', 'seo_title' => 'Geely | Bring Happy Life into Your Drive', 'brand_color_css' => 'text-blue-900'],
            'mini' => ['name' => 'Mini', 'logo' => '/images/logos/logo-mini.webp', 'seo_title' => 'Mini | Big Love', 'brand_color_css' => 'text-black'],
            'jetour' => ['name' => 'Jetour', 'logo' => '/images/logos/logo-jetour.webp', 'seo_title' => 'Jetour | Drive Your Future', 'brand_color_css' => 'text-red-700'],
            'dongfeng' => ['name' => 'Dongfeng', 'logo' => '/images/logos/logo-dongfeng.webp', 'seo_title' => 'Dongfeng | Drive Your Dreams', 'brand_color_css' => 'text-red-700'],
            'iveco' => ['name' => 'Iveco', 'logo' => '/images/logos/logo-iveco.webp', 'seo_title' => 'Iveco | Tu Socio para el Transporte Sustentable', 'brand_color_css' => 'text-blue-800'],
            'man' => ['name' => 'MAN', 'logo' => '/images/logos/logo-man.webp', 'seo_title' => 'MAN | Simplifying Business', 'brand_color_css' => 'text-red-700'],
            'vw-camiones' => ['name' => 'VW Camiones y Buses', 'logo' => '/images/logos/logo-vw-camiones.webp', 'seo_title' => 'Volkswagen Camiones y Buses', 'brand_color_css' => 'text-blue-900'],
            'foton-camiones' => ['name' => 'Foton Camiones', 'logo' => '/images/logos/logo-foton-camiones.webp', 'seo_title' => 'Foton Camiones | Eficiencia y Potencia para tu Negocio', 'brand_color_css' => 'text-black'],
        ];

        foreach ($brands as $slug => $data) {
            $brand = Brand::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'logo' => $data['logo'],
                    'seo_title' => $data['seo_title'],
                    'brand_color_css' => $data['brand_color_css'],
                ]
            );

            // If Toyota, seed some models.
            if ($slug === 'toyota') {
                $this->seedToyotaModels($brand);
            }
        }
    }

    private function seedToyotaModels(Brand $brand)
    {
        $models = [
            [
                'id' => 'yaris-cross',
                'name' => 'Yaris Cross',
                'category' => 'SUV',
                'base_price' => 20990000,
                'image' => '/images/toyota/Hibridos/min_yaris_cross.png',
                'is_hybrid' => true,
                'is_new' => true,
                'slogan' => 'Todo eso y más',
                'desktop_banner' => '/images/toyota/SUV/yaris-cross/banner_80492.jpg',
                'mobile_banner' => '/images/toyota/SUV/yaris-cross/banner_80443.jpg',
                'gallery' => [
                    '/images/toyota/SUV/yaris-cross/galeria_80998.jpg',
                    '/images/toyota/SUV/yaris-cross/galeria_80549.jpg',
                ],
                'video_url' => 'https://www.youtube.com/embed/4dBDMEULD1Y',
                'versions' => [
                    [
                        'name' => 'YARIS CROSS HYBRID XI 1.5 CVT',
                        'transmission' => 'Automática',
                        'fuel_type' => 'Híbrido',
                        'price' => 20990000,
                        'year' => 2024,
                    ],
                    [
                        'name' => 'YARIS CROSS HYBRID XG 1.5 CVT',
                        'transmission' => 'Automática',
                        'fuel_type' => 'Híbrido',
                        'price' => 22990000,
                        'year' => 2024,
                    ]
                ]
            ],
            [
                'id' => 'hilux',
                'name' => 'Hilux',
                'category' => 'Camioneta',
                'base_price' => 26990000,
                'image' => '/images/toyota/Pickup/min_hilux.png',
                'is_hybrid' => false,
                'is_new' => true,
                'slogan' => 'La pick-up indestructible',
                'versions' => [
                    [
                        'name' => 'HILUX DX 2.4 MT',
                        'transmission' => 'Manual',
                        'fuel_type' => 'Diésel',
                        'price' => 26990000,
                        'year' => 2024,
                    ]
                ]
            ]
        ];

        foreach ($models as $m) {
            $vModel = VehicleModel::updateOrCreate(
                ['slug' => $m['id']],
                [
                    'brand_id' => $brand->id,
                    'name' => $m['name'],
                    'category' => $m['category'],
                    'base_price' => $m['base_price'],
                    'image' => $m['image'],
                    'slogan' => $m['slogan'],
                    'desktop_banner' => $m['desktop_banner'] ?? null,
                    'mobile_banner' => $m['mobile_banner'] ?? null,
                    'gallery' => $m['gallery'] ?? [],
                    'video_url' => $m['video_url'] ?? null,
                    'is_hybrid' => $m['is_hybrid'],
                    'is_electric' => $m['is_electric'] ?? false,
                    'is_new' => $m['is_new'],
                ]
            );

            if (isset($m['versions'])) {
                foreach ($m['versions'] as $v) {
                    VehicleVersion::updateOrCreate(
                        [
                            'vehicle_model_id' => $vModel->id,
                            'name' => $v['name']
                        ],
                        [
                            'price' => $v['price'],
                            'year' => $v['year'],
                            'transmission' => $v['transmission'],
                            'fuel_type' => $v['fuel_type'],
                        ]
                    );
                }
            }
        }
    }
}
