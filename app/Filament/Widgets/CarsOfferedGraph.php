<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Car;
use Carbon\Carbon;

class CarsOfferedGraph extends ChartWidget
{
    protected static ?string $heading = 'Cars Available for Sale Over Time';
    protected static ?string $pollingInterval = '10s';
    protected static bool $isLazy = false;
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Get all unique months where cars were either listed or sold
        $months = Car::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->union(Car::query()->selectRaw('DATE_FORMAT(sold_at, "%Y-%m") as month')->whereNotNull('sold_at'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('month');

        $totalCarsAvailableForSale = [];
        $runningTotal = 0;

        foreach ($months as $month) {
            $newlyAdded = Car::whereYear('created_at', Carbon::parse($month)->year)
                ->whereMonth('created_at', Carbon::parse($month)->month)
                ->count();

            $soldCars = Car::whereYear('sold_at', Carbon::parse($month)->year)
                ->whereMonth('sold_at', Carbon::parse($month)->month)
                ->count();

            // Add new cars and subtract sold cars
            $runningTotal += $newlyAdded - $soldCars;
            $totalCarsAvailableForSale[] = max($runningTotal, 0); // Ensure no negative values
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Cars Available for Sale',
                    'data' => $totalCarsAvailableForSale,
                    'borderColor' => 'green',
                    'fill' => false,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}