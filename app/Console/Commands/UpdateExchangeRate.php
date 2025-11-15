<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-exchange-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(\App\Services\ExchangeRateUpdater::class)->update();
        $this->info('Exchange rate updated.');
    }
}
