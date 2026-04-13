<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Automotriz Carmona')
            ->brandLogo(fn () => asset('images/logo-carmona.avif'))
            ->brandLogoHeight('2rem')
            ->colors([
                'primary' => '#111827', // Black/dark theme primary
            ])
            ->font('Inter')
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => new \Illuminate\Support\HtmlString('
                    <style>
                        /* Fuerza implacablemente el logo a negro en cualquier pantalla de Filament (login, dashboard, etc) */
                        img[src*="logo-carmona"] { 
                            filter: brightness(0) !important; 
                        }
                        /* Lo revierte a blanco solo si el usuario enciende el dark mode del panel */
                        .dark img[src*="logo-carmona"] { 
                            filter: brightness(0) invert(1) !important; 
                        }
                    </style>
                '),
            )
            ->spa() // Activado para navegación instantánea sin recarga de Assets
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->navigationGroups([
                'Livianos',
                'Camiones',
                'Configuraciones',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
