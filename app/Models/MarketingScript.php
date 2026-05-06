<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingScript extends Model
{
    protected $fillable = [
        'name',
        'type',
        'value',
        'placement',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Human-readable labels for script types.
     */
    public static function typeLabels(): array
    {
        return [
            'gtm'        => 'Google Tag Manager (GTM)',
            'ga4'        => 'Google Analytics 4 (GA4)',
            'google_ads' => 'Google Ads (Conversiones)',
            'meta_pixel' => 'Meta Pixel (Facebook/Instagram)',
            'hotjar'     => 'Hotjar (Mapas de Calor)',
            'clarity'    => 'Microsoft Clarity',
            'custom'     => '⚙️ Script Personalizado (HTML)',
        ];
    }

    /**
     * Hint text shown below the value field depending on type.
     */
    public static function typeHints(): array
    {
        return [
            'gtm'        => 'Ej: GTM-XXXXX — Encuéntralo en tagmanager.google.com → Administrador → ID del contenedor.',
            'ga4'        => 'Ej: G-XXXXXXXXXX — Encuéntralo en Google Analytics → Administrador → Flujos de datos.',
            'google_ads' => 'Ej: AW-XXXXXXXXX — Encuéntralo en Google Ads → Herramientas → Conversiones → Etiqueta.',
            'meta_pixel' => 'Ej: 123456789012345 — Encuéntralo en Meta Business → Administrador de Eventos → Píxeles.',
            'hotjar'     => 'Ej: 1234567 — Encuéntralo en Hotjar → Settings → Sites & Organizations → Tracking Code.',
            'clarity'    => 'Ej: abcde12345 — Encuéntralo en Microsoft Clarity → Configuración → Código de seguimiento.',
            'custom'     => 'Pega aquí el código HTML completo del script, incluyendo las etiquetas <script>...</script>.',
        ];
    }
}
