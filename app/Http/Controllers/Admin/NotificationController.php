<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Messages\FirebaseV1Service;

class NotificationController extends Controller
{

    public function __construct()
    {
        // Use custom permission middleware
        $this->middleware(['auth:admin', 'custom.permission:list notifications,admin'])->only(['index', 'data']);
        $this->middleware(['auth:admin', 'custom.permission:send notifications,admin'])->only(['create', 'store']);
    }

    public function index()
    {
        $title = __('admin.notifications.title');
        $page = __('admin.notifications.manage');
        return view('admin.notifications.index', compact('title', 'page'));
    }

    public function create()
    {
        $users = User::where('active', true)
        ->where('notification',1)
        ->get();
        $title = __('admin.notifications.add');
        $page = __('admin.notifications.manage');
        return view('admin.notifications.create', compact('users', 'title', 'page'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|in:all,specific_users',
            'user_ids' => 'required_if:type,specific_users|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $notification = Notification::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'type' => $validated['type'],
            'status' => 'pending'
        ]);

        if ($validated['type'] === 'specific_users') {
            $notification->users()->attach($validated['user_ids']);
        }

        // Dispatch the job to queue
        // SendNotificationJob::dispatch($notification);
        $this->sendToService($notification);

        return response()->json(['success' => true]);
    }

    private function sendToService($notification) {
        $firebaseService = new FirebaseV1Service;
        if ($notification->type === 'all') {
            $users = \App\Models\User::whereNotNull('fcm_token')->get();
        } else {
            $users = $notification->users()
            ->whereNotNull('fcm_token')
            ->where('active',true)
            ->where('blocked',false)
            ->where('notification',true)
            ->get();
        }
        foreach ($users as $user) {
            
            $firebaseService->send(
                $user->fcm_token,
                $notification->title,
                $notification->body
            );
        }

        $notification->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    public function data()
    {
        $notifications = Notification::query();

        return datatables()
            ->eloquent($notifications)
            ->addIndexColumn()
            ->editColumn('type', function($notification) {
                $typeText = [
                    'all' => app()->getLocale() == 'ar' ? 'الكل' : 'All',
                    'specific_users' => app()->getLocale() == 'ar' ? 'المستخدمين المحددين' : 'Specific Users'
                ];
                return $typeText[$notification->type];
            })
            ->editColumn('status', function($notification) {
                $statusClasses = [
                    'pending' => 'badge badge-warning',
                    'sent' => 'badge badge-success',
                    'failed' => 'badge badge-danger'
                ];

                $statusText = [
                    'pending' => app()->getLocale() == 'ar' ? 'قيد الإنتظار' : 'Pending',
                    'sent' => app()->getLocale() == 'ar' ? 'تم الإرسال' : 'Sent',
                    'failed' => app()->getLocale() == 'ar' ? 'فشل' : 'Failed'
                ];

                return '<span class="'.$statusClasses[$notification->status].'">' . $statusText[$notification->status] . '</span>';
            })
            ->editColumn('sent_date', function ($notification) {
                return $notification->sent_at ? $notification->sent_at->format('Y-m-d H:i:s') : '-';
            })
            ->addColumn('actions', function ($notification) {
                return view('admin.notifications.actions', compact('notification'))->render();
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function destroy($notification)
    {
        try {
            $notification = Notification::findOrFail($notification);
            $notification->delete();
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting notification'
            ], 500);
        }
    }
}
