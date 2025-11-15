<?php

namespace App\Services;

use Google\Client;
use Google\Service\Playdeveloperreporting;
use Illuminate\Support\Facades\Log;

class GooglePlayService
{
    protected $client;
    protected $reportingService;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google/play-service.json'));
        $this->client->addScope('https://www.googleapis.com/auth/playdeveloperreporting');

        $this->reportingService = new Playdeveloperreporting($this->client);
    }

    public function getInstalls($packageName)
    {
        try {
            $response = $this->reportingService
                ->vitals()
                ->anrs()
                ->get($packageName);

            return $response;
        } catch (\Exception $e) {
            Log::error("Google Play API error: " . $e->getMessage());
            return null;
        }
    }

    public function getAcquisitionReport($packageName)
    {
        try {
            $response = $this->reportingService
                ->userAcquisition()
                ->get($packageName);
            
            return $response;
        } catch (\Exception $e) {
            Log::error("Acquisition report error: " . $e->getMessage());
            return null;
        }
    }
}
