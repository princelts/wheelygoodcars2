<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Car;
use Carbon\Carbon;

class UsersOfferingCarsGraph extends ChartWidget
{

    protected static ?string $pollingInterval = '10s';
    protected static bool $isLazy = false;
    protected static ?int $sort = 1;

    protected function getData(): array
    {
        // Get all unique months where cars were listed
        $months = Car::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('month');

        $usersOfferingCars = [];

        foreach ($months as $month) {
            // Count unique users who listed a car that month
            $monthlyUsers = Car::whereYear('created_at', Carbon::parse($month)->year)
                ->whereMonth('created_at', Carbon::parse($month)->month)
                ->distinct('user_id')
                ->count('user_id');

            $usersOfferingCars[] = $monthlyUsers;
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Users Listing Cars',
                    'data' => $usersOfferingCars,
                    'backgroundColor' => 'green',
                    'borderColor' => 'lightblue', // Change outline color
                    'borderWidth' => 2, // Thickness of the outline
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
