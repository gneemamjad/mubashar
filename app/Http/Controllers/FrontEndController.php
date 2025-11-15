<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontEndController extends Controller
{
    public function showAdd($id, Request $request) {
        $ref = trim($request->query('ref', 'not_set'));
        $ref = mb_substr($ref, 0, 255);

        $ip = $this->getClientIp($request);

        $userAgent = $request->header('User-Agent');

        try {
            DB::table('page_requests')->insert([
                'ref' => $ref,
                'ip' => $ip,
                'user_agent' => $userAgent,
            ]);
        } catch (\Exception $e) {
            // لو في خطأ، ما نعرضو للمستخدم بالإنتاج
            // Log::error($e->getMessage());
        }

        $influencer = trim($request->query('influencer', 'not_set'));
        $influencer = mb_substr($influencer, 0, 255);

        $ip = $this->getClientIp($request);

        $userAgent = $request->header('User-Agent');

        try {
            DB::table('influencer_requests')->insert([
                'influencer' => $influencer,
                'ip' => $ip,
                'user_agent' => $userAgent,
            ]);
        } catch (\Exception $e) {
            // لو في خطأ، ما نعرضو للمستخدم بالإنتاج
            // Log::error($e->getMessage());
        }

        return view('showAdd');
    }

    /**
     * استخراج IP الزائر الحقيقي
     */
    private function getClientIp(Request $request)
    {
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ($headers as $key) {
            if ($request->server($key)) {
                $ipList = explode(',', $request->server($key));
                $ip = trim(current($ipList));
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
                    || filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return '0.0.0.0';
    }
}
