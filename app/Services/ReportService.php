<?php

namespace App\Services;

use App\Exports\UsersExport;
use App\Exports\AdsExport;
use App\Exports\TransactionsExport;
use App\Repository\ReportRepository;
use Maatwebsite\Excel\Facades\Excel;

class ReportService
{
    protected $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function generateUsersReport(array $filters)
    {
        $users = $this->reportRepository->getUsersReport($filters);
        return Excel::download(new UsersExport($users), 'users_report.xlsx');
    }

    public function generateAdsReport(array $filters)
    {
        $ads = $this->reportRepository->getAdsReport($filters);
        return Excel::download(new AdsExport($ads), 'ads_report.xlsx');
    }

    public function generateTransactionsReport(array $filters)
    {
        $transactions = $this->reportRepository->getTransactionsReport($filters);
        return Excel::download(new TransactionsExport($transactions), 'transactions_report.xlsx');
    }
} 