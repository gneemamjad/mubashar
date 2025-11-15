<?php

namespace App\Repository;

use App\Models\Currency;
use App\Models\ExchangeCurrency;
use App\Models\Notification;
use Illuminate\Support\Facades\Cache;

class NotificationsRepository
{

    public function getHistory($request,$user_id)
    {
        return Notification::
            leftJoin('notification_users', function($join) use($user_id)
                         {
                             $join->on('notification_users.notification_id', '=', 'notifications.id')
                                    ->where('notification_users.user_id','=',$user_id);
                         })

            ->where(function($query) use($user_id){
                $query->where('type','all')
                    ->orWhere(function($q) use($user_id){
                        $q->where('type','specific_users')
                        ->where('notification_users.user_id','=',$user_id);
                    });
            })
            ->selectRaw("notifications.*")
            ->orderBy('notifications.id','desc')->paginate(PAGINITION_PER_PAGE);
    }
   
} 