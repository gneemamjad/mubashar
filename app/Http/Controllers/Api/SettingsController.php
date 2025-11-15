<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SettingsController extends Controller
{
    use Response;

    public function getSettings(Request $request)
    {
        $request->validate([
            'version' => 'nullable|string',
            'os' => 'nullable|string'
        ]);

        // Check and update OS if user is authenticated
        if (Auth::check() && $request->os) {
            $user = Auth::user();
            $OS = $request->os;
            if ($user->os !== $OS) {
                $user->update(['os' => $OS]);
            }
        }
        // Add your settings logic here
        if($request->os == 'ios') {
            $settings = [
                'base_url'=>"https://mubashar.tr/api",
                'version' => $request->version ?? '1.0.18',
                'maintenance_mode' => false,
                'soft_update' => false,
                'force_update' => false,
                'latest_version' => '1.0.19',
                'update_url' => 'https://apps.apple.com/eg/app/mubashar-com/id6740783671',
                'contact' => [
                    'phone' => '+1234567890',
                    'email' => 'support@example.com',
                    'whatsapp' => '+1234567890'
                ],
                'social_media' => [
                    'facebook' => 'https://facebook.com/example',
                    'twitter' => 'https://twitter.com/example',
                    'instagram' => 'https://instagram.com/example'
                ]
            ];
        } else {
            $settings = [
                'base_url'=>"https://mubashar.tr/api",
                'version' => $request->version ?? '1.0.1',
                'maintenance_mode' => false,
                'soft_update' => false,
                'force_update' => false,
                'latest_version' => '1.0.1',
                'update_url' => 'https://play.google.com/store/apps/details?id=tr.mubashar.mubashar',
                'contact' => [
                    'phone' => '+1234567890',
                    'email' => 'support@example.com',
                    'whatsapp' => '+1234567890'
                ],
                'social_media' => [
                    'facebook' => 'https://facebook.com/example',
                    'twitter' => 'https://twitter.com/example',
                    'instagram' => 'https://instagram.com/example'
                ]
            ];
        }

        // Compare versions to determine if update is needed
        if (in_array($request->version, FORCE_UPDATE_VERSIONS)) {
            $settings['force_update'] = true;
        }
        if (in_array($request->version, SOFT_UPDATE_VERSIONS)) {
            $settings['soft_update'] = true;
        }

        return $this->successWithData('Settings retrieved successfully', $settings);
    }

    public function getLatestUsers(Request $request) {
        // $usersMobile = 
        // [
        //     '938544087',
        //     '959154450',
        //     '956005692',
        //     '966246906',
        //     '945056883',
        //     '962139028',
        //     '936090746',
        //     '949392741',
        //     '966808815',
        //     '938435593'
        // ];
        $users = User::select('id', 'mobile', 'first_name', 'last_name', 'created_at')
            // ->whereBetween('created_at', [Carbon::now()->subDays(1), Carbon::now()])
            ->whereDate('created_at', Carbon::now())
            ->where('dial_code', '963')
            // ->whereIn('mobile',$usersMobile)
            ->get();
        $usersRes = [];
        foreach($users as &$user) {
            $user->fullName = $user->first_name . " " . $user->last_name;
            $user->createdAt = date('Y-m-d H:i', strtotime($user->created_at));
            array_push($usersRes, $user);
        }
        return $this->successWithData('Latest Users retrieved successfully', $usersRes);
    }
}
