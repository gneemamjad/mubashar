<?php

namespace App\Contracts\Repositories;

interface ReportRepositoryInterface
{
    public function getUsersReport(array $filters);
    public function getAdsReport(array $filters);
} 