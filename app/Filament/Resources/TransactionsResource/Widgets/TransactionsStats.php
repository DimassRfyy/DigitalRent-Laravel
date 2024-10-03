<?php

namespace App\Filament\Resources\TransactionsResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionsStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTransactions = Transaction::count();
        $approvedTransactions = Transaction::where('is_paid', true)->count();
        $totalPendingTransactions = Transaction::where('is_paid', false)->count();

        return [
            Stat::make('Total Transactions', $totalTransactions)
            ->description('All Transactions')
            ->descriptionIcon('heroicon-o-currency-dollar'),

            Stat::make('Approved Transactions', $approvedTransactions)
            ->description('Approved Transactions')
            ->descriptionIcon('heroicon-o-check-circle')
            ->color('success'),

            Stat::make('Pending Transactions', $totalPendingTransactions)
            ->description('Total Pending Transactions')
            ->descriptionIcon('heroicon-o-x-circle')
            ->color('danger'),
        ];
    }
}
