<?php

namespace App\Contracts\Services;

interface ReportServiceInterface
{
    public function generateUsersReport(array $filters);
    public function generateAdsReport(array $filters);
} 