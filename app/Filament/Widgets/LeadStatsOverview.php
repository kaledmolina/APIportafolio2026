<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Interesados', Lead::count())
                ->description('Total de registros')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Nuevos Hoy', Lead::whereDate('created_at', now())->count())
                ->description('Registrados hoy')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Pendientes', Lead::where('status', 'new')->count())
                ->description('Necesitan atención')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
