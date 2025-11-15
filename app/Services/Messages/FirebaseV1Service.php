<?php

namespace App\Services\Messages;

use App\Models\Notification;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

// use Illuminate\Support\Facades\Storage;

class FirebaseV1Service
{
    protected $client;
    protected $accessToken;
    protected $googleCredentialsJson;
    public function __construct()
    {
        $this->googleCredentialsJson = '{
                                        "type": "service_account",
                                        "project_id": "mubasher-2db98",
                                        "private_key_id": "8fef0e9452ec602a83591260e71fdccd9351c2d0",
                                        "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCKgzB5mJaCYTOn\nqecn+NtWf/XP8cig/67EbSKv8M3RGpwlOAE/KDpt1uQc8FdsyRNiB49ziiWTYGlV\nPkhfAUwJ/QcqaHLvZ4Ypr+ghn8Qoeg4pMYloZW7jlHQnDxAKpiuYs6so7DvkTh3W\nC2bKQXz+Ko3ClO5O/69AdeAdUkcI9FcbPEAaK92c0KbauKiLGSzDA/ZYDXjJWfGy\nAkiP2ka3XSfKxxk/e3J6knJ8b5l7EwdW9tRbXu2HHGwfFOjgj5oN3DZPXKr7kaX3\n5f58TFl2lFjnauCz8RO4NojH3wJIo47kx9U++JxySbvTwsSQup8uqaw+dNGKH2K7\npIWDgToFAgMBAAECggEARFNCbjjexaG9IU+mPwl66MhmMRVLql91jl9nZPKcFDHU\nJGfj9YuahuQh0kScW4U0kn64PH5A2toMG4iFmpfBMowmJL0xNPcULywejbeJw42x\nvpA4/85JTOnGAh5kA1zE1KaMH7uoL455GUS2h76WMao8E2fzxfRKNrnuu4gCkl97\nZaqWEXLbf4QB0ghOW62Qu0stEO56Ldl/6Ou/OFA6bEgP0VZk2ZCOTfyV9+gCpqqe\nlIbow7/IOXWqCYuU9M2XYS8lBZIdLLOgE0/6wZ9MVA3qtsxoBDkhHDEBXBjLXGKZ\nwUzZWFflfREH6YxXOHvC4fcco1EhxxlYrxHmpD1HYQKBgQDAh1GKIsyoELw/e8eV\nHcbqAHwKMogr7IMnjLVbFhELZuYcqp41181LNxhy4rRsOxK0q1kyb5ekSjsDpqKk\n3LIWT8e1KPjE0Oy+Neh2a5817B+Osx3l52royphGpZyMwd4Ho6G520ALVRSKRNak\nvf/7YmTKGb+a2qkhzzOZzYXJ3wKBgQC4LR1cnCO/QLJDVwGLQUL1Vq1cHjUS3M9U\n/b2gmWcEOhUiXT5xHukyfPnfQZAkM4r0umV2QFjl1K91x8e80l5F/D0gYEyw5ecB\nbFb/d+vvgN9a/I8gjQmkM9t5dj7aNoW/u31yVDCyZbFSSkeo8Gq6Xmc7AVAAlQUc\nbimrXIAAmwKBgE0//n+mpudoj6AJUnOKlx2dRCfzTqARLi7YToxVtlEU4I/wBbsk\n88KSQMUYIbyrlz3W4ttR206YWkWEvw3XX72EFWWjIu4VxmgryTJ6zE8ehysCw6RT\nzpnJcIAoQ0BXKXd3OJUSXAgwAyXXqShA9E0xla9h1XeU9PgT42h7BouRAoGATriZ\n0De838Zba4UI1+ixIgRGXRVcQg+3XvCF2Ns4uQnKdsG8KsW3jyjz9IUlgxO01R3G\nuGCQnsvlo0YdDYwtV2SVC/2dSg86SdVw6gjsA5bl4RIKazNdZ53ytVvhSYv8ZxNQ\nb0mk9tuYiz/MmV0JgVdQcFwDQfxwDtLXZLNI0vkCgYAsffFARr0PMD74CmeWHBs4\ng82Lv5CQvbJDx1MfgjvENE09gCbmqOAvC0rtWQpHHK4AluTF/BhLglp8Bn98kP/a\nXmGP0g+O2PpgHPja0L5AdpK3lHTgz3LLhgRnlcNSN7HXq/5X8tt9yFQiGvemrMG7\nXrvAiChIEeZilbGldGxIpw==\n-----END PRIVATE KEY-----\n",
                                        "client_email": "firebase-adminsdk-es86y@mubasher-2db98.iam.gserviceaccount.com",
                                        "client_id": "115905090915414877312",
                                        "auth_uri": "https://accounts.google.com/o/oauth2/auth",
                                        "token_uri": "https://oauth2.googleapis.com/token",
                                        "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
                                        "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-es86y%40mubasher-2db98.iam.gserviceaccount.com",
                                        "universe_domain": "googleapis.com"
                                        }';

        $this->client = new Client();
    }

    protected function getAccessToken()
    {
        $credentials = json_decode($this->googleCredentialsJson, true);

        $response = $this->client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $this->createJwt($credentials),
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['access_token'];
    }

    protected function createJwt($credentials)
    {
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        $claimSet = [
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => time() + 3600,
            'iat' => time(),
        ];

        $headerEncoded = $this->base64UrlEncode(json_encode($header));
        $claimSetEncoded = $this->base64UrlEncode(json_encode($claimSet));

        $dataToSign = $headerEncoded . '.' . $claimSetEncoded;

        // Sign the data with the private key
        $signature = '';
        openssl_sign($dataToSign, $signature, $credentials['private_key'], 'SHA256');

        $jwt = $dataToSign . '.' . $this->base64UrlEncode($signature);

        return $jwt;
    }

    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function sendNotification($tokens, $notification, $data)
    {
        // Log the function input for debugging purposes
        Log::debug("send FCMV1", [
            "tokens" => $tokens,
            "notification" => $notification,
            "data" => $data
        ]);

        // Initialize an array to hold responses from FCM
        $responses = [];

        // Iterate over each token and send a notification
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Recursively call the function if the value is an array
                $data[$key] = json_encode($value);
            } else {
                // Convert the value to a string if it's not an array
                $data[$key] = (string) $value;
            }
        }
        foreach ($tokens as $token) {
            $message = [
                'message' => [
                    'token' => $token,
                    'notification' => $notification,
                    'data' => $data,
                ],
            ];

            try {
                // Send the POST request to FCM
                $response = $this->client->post(
                    'https://fcm.googleapis.com/v1/projects/' . json_decode($this->googleCredentialsJson, true)['project_id'] . '/messages:send',
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->getAccessToken(),
                            'Content-Type' => 'application/json',
                        ],
                        'json' => $message,
                    ]
                );

                // Decode and store the response for each token
                $responses[] = json_decode($response->getBody(), true);
            } catch (RequestException $e) {
                // Log the error and response for debugging
                Log::error("Error sending FCM notification", [
                    'message' => $e->getMessage(),
                    'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
                ]);

                // Add the error to responses for better visibility
                $responses[] = ['error' => $e->getMessage()];
            }
        }

        // Return all responses
        return $responses;
    }


    public function sendForDevices(array $devicesToken, int $type, string $title)
    {
        $data= [
            "sound" => "true",
            "ntf_type" => "$type",

        ];
        $notification =[
                "body"=> $title,
        ];

         $this->sendNotification($devicesToken,$notification,$data);

    }


    public function send(string $token, string $title, string $body)
    {
        $data = [
            "sound" => "true",
            "ntf_type" => "1"
        ];

        $notification = [
            "title" => $title,
            "body" => $body
        ];

        // return true;
        return $this->sendNotification([$token], $notification, $data);
    }

    public function sendByType(string $token, string $title, string $body, string $ntfCode, array $customData)
    {
        if($ntfCode == "2") {
            $data = [
                "sound" => "true",
                "ntf_type" => $ntfCode,
                "userMobile" => $customData["userMobile"],
                "adId" => $customData["adId"]
            ];
            
        } else {
            $data = [
                "sound" => "true",
                "ntf_type" => $ntfCode
            ];
        }

        $notificationModel = Notification::create([
            'title' => $title,
            'body' => $body,
            'type' => 'specific_users',
            'status' => 'sent',
            'data' => json_encode($customData),
            'sent_at' => now()
        ]);
        
        $notificationModel->users()->attach([$customData["userId"]]);

        $notification = [
            "title" => $title,
            "body" => $body
        ];

        // return true;
        return $this->sendNotification([$token], $notification, $data);
    }

}
