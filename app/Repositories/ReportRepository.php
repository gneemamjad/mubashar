<?php

namespace App\Repositories;

use App\Models\Transaction;

class ReportRepository
{
    public function getTransactionsReport(array $filters)
    {
        $query = Transaction::query();

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->with(['user', 'ad', 'ad.category'])->get();
    }
} 