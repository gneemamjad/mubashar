<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\NotificationResource;
use App\Repository\NotificationsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{

    protected $notificatoinsRepository;

    public function __construct(NotificationsRepository $notificatoinsRepository)
    {
        $this->notificatoinsRepository = $notificatoinsRepository;
    }


    function getNotificationHistory(Request $request)
    {
        $user = Auth::user();
        $notifications = $this->notificatoinsRepository->getHistory($request,$user->id);

        return $this->successWithDataPagination("success",NotificationResource::collection($notifications),$notifications);

    }
}
