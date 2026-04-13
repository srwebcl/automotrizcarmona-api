<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.quick-actions-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    // Set a high sort priority so it appears at the top
    protected static ?int $sort = -1;
}
