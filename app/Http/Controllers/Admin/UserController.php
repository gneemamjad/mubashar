<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\Messages\SMSServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $service;
    protected $smsService;

    public function __construct(UserService $service, SMSServices $smsService)
    {
        $this->service = $service;
        $this->smsService = $smsService;

        // Use custom permission middleware
        $this->middleware(['auth:admin', 'custom.permission:view_users,admin'])->only(['index', 'getData']);
        $this->middleware(['auth:admin', 'custom.permission:edit_users,admin'])->only(['edit', 'update', 'toggleBlock', 'toggleActive']);
        $this->middleware(['auth:admin', 'custom.permission:delete_users,admin'])->only('destroy');
    }

    public function index()
    {
        $title = __('admin.sidebar.users');
        $page = __('admin.sidebar.users_management');
        return view('admin.users.index',compact(['title','page']));
    }
    public function edit($id)
    {
        $title = __('admin.sidebar.users');
        $page = __('admin.sidebar.users_management');
        
        $user = User::find($id);
        if(!$user) {
            return view('admin.users.index',compact(['title','page']));
        }
        return view('admin.users.edit',compact(['title', 'page', 'user']));
    }
    // public function update($id, Request $request)
    // {
    //     $user = User::find($id);
    //     if(!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'المستخدم غير موجود.'
    //         ], 422);
    //     }

    //     $validated = $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'last_name'  => 'required|string|max:255',
    //         'mobile'     => 'required|string|max:10',
    //         'email'      => 'nullable|email|max:255',
    //     ]);

    //     $mobile = ltrim($validated['mobile'], '0');
    //     if($mobile != $user->mobile) {
    //         $existingUser = User::whereRaw("REPLACE(mobile, '0', '') = ?", [$mobile])->first();
    //         if ($existingUser) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'رقم الموبايل مستخدم بالفعل.'
    //             ], 422);
    //         }
    //     }

    //     $email = $validated['email'];
    //     if($email != $user->email) {
    //         $existingUserEmail = User::where("email", $email)->first();
    //         if ($existingUserEmail) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'البريد الإلكتروني مستخدم بالفعل.'
    //             ], 422);
    //         }
    //     }
    //     $user->update([
    //         'first_name'  => $validated['first_name'],
    //         'last_name'   => $validated['last_name'],
    //         'mobile'      => $mobile,
    //         'email'       => $validated['email'],
    //     ]);

    //     return response()->json(['success' => true, 'user' => $user]);
    // }
    public function update($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'المستخدم غير موجود.'
            ], 422);
        }

        $normalizedMobile = ltrim($request->input('mobile'), '0');

        // Use Validator to capture errors manually
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'mobile'     => [
                'required',
                'string',
                'max:10',
                Rule::unique('users')->where(function ($query) use ($normalizedMobile) {
                    return $query->whereRaw("REPLACE(mobile, '0', '') = ?", [$normalizedMobile]);
                })->ignore($user->id)
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'mobile'     => $normalizedMobile,
            'email'      => $validated['email'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function getData()
    {
        try {
            return $this->service->getDataTable();
        } catch (\Exception $e) {
            Log::error('DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function toggleBlock($id)
    {
        try {
            $user = $this->service->toggleBlock($id);
            $message = $user->blocked ? 'User blocked successfully' : 'User unblocked successfully';
            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating user status'], 500);
        }
    }

    public function toggleActive($id)
    {
        try {
            $user = $this->service->toggleActive($id);
            $message = $user->active ? 'User activated successfully' : 'User deactivated successfully';
            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating user status'], 500);
        }
    }

    public function data()
    {
        try {
            return $this->service->getDataTable();
        } catch (\Exception $e) {
            Log::error('DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load data'], 500);
        }
    }

    public function searchAjax(Request $request) {

        $query = $request->get('q');

        $users = User::query()
            ->where(function($q) use ($query) {
                // معالجة البحث بـ 09 أو 9
                if (Str::startsWith($query, '0') && strlen($query) > 1) {
                    $q->where('mobile', 'like', '%' . $query . '%')
                    ->orWhere('mobile', 'like', '%' . substr($query, 1) . '%');
                } else {
                    $q->where('mobile', 'like', '%' . $query . '%')
                    ->orWhere('mobile', 'like', '%' . '0' . $query . '%');
                }

                // // إضافة بحث بالاسم إذا أحببت
                $q->orWhere('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%');
            })
            ->where('deleted', 0)
            ->where('active', 1)
            ->where('blocked', 0)
            ->limit(20)
            ->get();

        return response()->json($users);
    }


    public function search(Request $request)
    {
        $query = $request->get('q');
        $notify = $request->get('notify');
        $page = $request->get('page', 1);
        $perPage = 10;
        
        $users = User::where(function($q) use ($query) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"])
                  ->orWhere('mobile', 'like', "%{$query}%");
            });
        
        if (isset($notify)) {
            $users->whereNotNull('fcm_token');
        }
        
        $users = $users
            ->select(['id', 'first_name', 'last_name', 'mobile'])
            ->orderByRaw("CONCAT(first_name, ' ', last_name)")
            ->paginate($perPage);
        
        // Add fullName manually after pagination if needed
        $users->getCollection()->transform(function ($user) {
            $user->fullName = $user->first_name . ' ' . $user->last_name;
            return $user;
        });
        
        return response()->json($users);
    }

    public function userAds($user)
    {        

        $ads = Ad::where('user_id',$user)
            ->get();
            $title = 'Near By Ad';
            $page = 'Ads Management';
            return view('admin.users.ads', compact(['ads','title','page']));
    
    }

    public function userAdsData(User $user)
    {
        $ads = $user->ads()->with('category')->select('ads.*');

        return DataTables::of($ads)
            ->addColumn('actions', function ($ad) {
                return view('admin.ads.actions', ['id' => $ad->id]);
            })
            ->editColumn('status', function ($ad) {
                return view('admin.ads.status', ['status' => $ad->status]);
            })
            ->editColumn('created_at', function ($ad) {
                return $ad->created_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'mobile'     => 'required|string|max:10',
            // 'email'      => 'required|email|max:255',
        ]);

        $mobile = ltrim($validated['mobile'], '0');

        $existingUser = User::where('dial_code', "963")
                ->where(function ($query) use ($request, $mobile) {
                    $query->where('mobile', $mobile)
                        ->orWhere('mobile', '0' . $mobile);
                })->notDeleted()->first();
        // dd($existingUser);
        // $existingUser = User::whereRaw("REPLACE(mobile, '0', '') = ?", [$mobile])->first();
        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'رقم الموبايل مستخدم بالفعل.'
            ], 422);
        }

        // $email = $validated['email'];

        // $existingUserEmail = User::where("email", $email)->first();
        // if ($existingUserEmail) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'البريد الإلكتروني مستخدم بالفعل.'
        //     ], 422);
        // }

        $user = User::create([
            'first_name'  => $validated['first_name'],
            'last_name'   => $validated['last_name'],
            'mobile'      => $mobile,
            // 'email'       => $validated['email'],
            'dial_code'   => '963',
            'verified_at' => now(),
            'active'      => 1,
            'currency_id' => 1,
            'call'        => 1,
        ]);

        // $this->smsService->sendWLCMessage($user->mobile);

        return response()->json(['success' => true, 'user' => $user]);
    }

}
