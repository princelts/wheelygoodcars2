<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Car;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsNumber extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';
    protected static bool $isLazy = false;
    protected static ?int $sort = 0;

    protected function getCards(): array
    {
        $totalUsers = User::has('cars')->count();
        $totalCars = Car::count();
        $averageCarsPerUser = $totalUsers > 0 ? round($totalCars / $totalUsers, 1) : 0;
        
        return [
            
            Stat::make('Total Cars Still for Sale', Car::whereNull('sold_at')->count())
                ->description('Total number of cars available for sale.')
                ->descriptionIcon('heroicon-o-truck', IconPosition::Before)
                ->chart([0, 50, 100, 150, 200, 250, 300, 350, 400]) // Adjust chart values if needed
                ->color('success'),

            Stat::make('Total Cars Sold', Car::whereNotNull('sold_at')->count())
                ->description('Total number of cars sold.')
                ->descriptionIcon('heroicon-o-check-circle', IconPosition::Before)
                ->chart([0, 10, 20, 30, 40, 50, 60])
                ->color('success'),

            Stat::make('Total Sellers', Car::whereNull('sold_at')->distinct('user_id')->count('user_id'))
                ->description('Total number of active sellers.')
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before)
                ->chart([0, 10, 20, 30, 40, 50, 60, 70, 80]) // Adjust chart values if needed
                ->color('success'),

            Stat::make('Cars Offered Today', Car::whereDate('created_at', Carbon::today())->count())
                ->description('Number of cars added today.')
                ->descriptionIcon('heroicon-o-calendar', IconPosition::Before)
                ->chart([0, 5, 10, 15, 20, 25, 30])
                ->color('info'),

            Stat::make('Avg Cars per User', $averageCarsPerUser)
                ->description('Average number of cars per user.')
                ->descriptionIcon('heroicon-o-chart-bar', IconPosition::Before)
                ->chart([0, 1, 2, 3, 4, 5, 6])
                ->color('gray'),
        ];
    }
}
