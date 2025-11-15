<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Ad;
use App\Models\Category;
use App\Models\DraftTransaction;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

class ReportRepository
{
    public function getUsersReport(array $filters)
    {
        $query = User::query();

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['app_version'])) {
            $query->where('version', $filters['version']);
        }

        if (isset($filters['active'])) {
            $query->where('active', $filters['active']);
        }
        
        if (isset($filters['status'])) {
            $query->where('approved', $filters['status']);
        }

        if (isset($filters['blocked'])) {
            $query->where('blocked', $filters['blocked']);
        }

        return $query->get();
    }

    public function getAdsReport(array $filters)
    {
        $query = Ad::query();

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['active'])) {
            $query->where('active', $filters['active']);
        }

        if (isset($filters['paid'])) {
            $query->where('paid', $filters['paid']);
        }

        if (isset($filters['status'])) {
            $query->where('approved', $filters['status']);
        }

        if (isset($filters['has_location'])) {
            $query->whereNotNull('lat')
                  ->whereNotNull('lng');

        }

        if (isset($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (isset($filters['type'])) {
            $type = Category::where('id',$filters['type'])->first();
            $childrenIds = $type->descendants()->pluck('id');
            $query->whereIn('category_id', $childrenIds);
        }

        if (isset($filters['city'])) {
            $query->where('city_id', $filters['city']);
        }

        if (isset($filters['area'])) {
            $query->where('area_id', $filters['area']);
        }

        if (isset($filters['added_by'])) {
            $query->where('added_by', $filters['added_by']);
        }

        if (isset($filters['approved_by'])) {
            $query->where('approved_by', $filters['approved_by']);
        }

        return $query->with(['category', 'city', 'area'])->get();
    }

    public function getTransactionsReport(array $filters)
    {
        $query = DraftTransaction::query()
        ->join('ad', 'draft_transactions.ad_id', '=', 'ad.id')
        ->join('users', 'ad.user_id', '=', 'users.id');

        if (isset($filters['date_from'])) {
            $query->where('ad.created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('ad.created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['payment_method'])) {
            $query->where('ad.bank_id', $filters['payment_method']);
        }

        if (isset($filters['status'])) {
            $query->where('ad.status', $filters['status']);
        }

        return $query->with(['ad.category'])->get();
    }
} 