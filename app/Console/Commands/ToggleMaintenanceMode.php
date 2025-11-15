<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ToggleMaintenanceMode extends Command
{
    protected $signature = 'maintenance:toggle {mode : The mode to set (on/off)}';
    protected $description = 'Toggle maintenance mode on or off';

    public function handle()
    {
        $mode = $this->argument('mode');
        
        if (!in_array($mode, ['on', 'off'])) {
            $this->error('Invalid mode. Use "on" or "off"');
            return 1;
        }

        $envFile = base_path('.env');
        $contents = File::get($envFile);

        $newValue = $mode === 'on' ? 'true' : 'false';

        if (strpos($contents, 'MAINTENANCE_MODE') !== false) {
            $contents = preg_replace('/MAINTENANCE_MODE=(.*)/', 'MAINTENANCE_MODE=' . $newValue, $contents);
        } else {
            $contents .= "\nMAINTENANCE_MODE=" . $newValue;
        }

        File::put($envFile, $contents);

        $this->info('Maintenance mode has been turned ' . $mode);
        return 0;
    }
} 