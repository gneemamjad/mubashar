<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Services\Messages\FirebaseV1Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function handle(FirebaseV1Service $firebaseService)
    {
        
        // Log the function input for debugging purposes
        Log::debug("run job", [
            "type" => $this->notification->type
        ]);
        try {
            if ($this->notification->type === 'all') {
                $users = \App\Models\User::whereNotNull('fcm_token')->get();
            } else {
                $users = $this->notification->users()
                ->whereNotNull('fcm_token')
                ->where('active',true)
                ->where('blocked',false)
                ->where('notification',true)
                ->get();
            }

            foreach ($users as $user) {
                $firebaseService->send(
                    $user->fcm_token,
                    $this->notification->title,
                    $this->notification->body
                );
            }

            $this->notification->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            $this->notification->update(['status' => 'failed']);
            throw $e;
        }
    }
}
