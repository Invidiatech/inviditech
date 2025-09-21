<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkedInDebugController extends Controller
{
    public function showSetupInfo()
    {
        $clientId = config('services.linkedin.client_id');
        $currentUrl = url('/linkedin/callback');
        
        return response()->json([
            'your_client_id' => $clientId,
            'redirect_uri_needed' => $currentUrl,
            'steps' => [
                '1. Go to https://www.linkedin.com/developers/apps',
                '2. Find your app with client ID: ' . $clientId,
                '3. Click on "Auth" tab',
                '4. Add this URL to "Authorized redirect URLs": ' . $currentUrl,
                '5. Save changes',
                '6. Then visit: ' . url('/linkedin/get-token')
            ]
        ]);
    }

    public function getToken()
    {
        $clientId = config('services.linkedin.client_id');
        $redirectUri = url('/linkedin/callback');
        
        $params = [
            'response_type' => 'code',
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => 'w_member_social', // Only the scope needed for sharing
        ];

        $authUrl = 'https://www.linkedin.com/oauth/v2/authorization?' . http_build_query($params);
        
        return redirect($authUrl);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->get('code');
        $error = $request->get('error');
        
        if ($error) {
            return response()->json([
                'error' => 'LinkedIn returned error: ' . $error,
                'description' => $request->get('error_description')
            ]);
        }
        
        if (!$code) {
            return response()->json(['error' => 'No authorization code received']);
        }

        try {
            $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => url('/linkedin/callback'),
                'client_id' => config('services.linkedin.client_id'),
                'client_secret' => config('services.linkedin.client_secret'),
            ]);

            if ($response->successful()) {
                $tokenData = $response->json();
                $accessToken = $tokenData['access_token'];
                
                return response()->json([
                    'success' => true,
                    'access_token' => $accessToken,
                    'expires_in' => $tokenData['expires_in'] ?? 'unknown',
                    'instructions' => [
                        'Copy the access_token above',
                        'Add this to your .env file:',
                        'LINKEDIN_ACCESS_TOKEN=' . $accessToken,
                        'Then restart your application'
                    ]
                ]);
            } else {
                return response()->json([
                    'error' => 'Token exchange failed',
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception during token exchange',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function testCurrentToken()
    {
        $accessToken = config('services.linkedin.access_token');
        
        if (!$accessToken || $accessToken === 'your_access_token_here') {
            return response()->json([
                'error' => 'Access token not configured',
                'current_value' => $accessToken,
                'fix' => 'Visit /linkedin/setup to get instructions'
            ]);
        }
        
        // Test with a simple API call that works with w_member_social scope
        try {
            // Try to create a test post structure (don't actually post it)
            $testData = [
                'author' => 'urn:li:person:test', // This will fail but tells us if the API accepts our token
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => 'Test post'
                        ],
                        'shareMediaCategory' => 'NONE'
                    ]
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
                ]
            ];
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0'
            ])->post('https://api.linkedin.com/v2/ugcPosts', $testData);
            
            // We expect this to fail with a different error (invalid author URN)
            // But if we get a 403 with ACCESS_DENIED, the token doesn't have posting rights
            // If we get a 400 with invalid URN, the token works for posting
            
            if ($response->status() === 400) {
                $responseBody = $response->json();
                if (isset($responseBody['message']) && str_contains($responseBody['message'], 'Invalid person')) {
                    return response()->json([
                        'success' => true,
                        'message' => 'LinkedIn API token is working! Ready for blog publishing.',
                        'note' => 'Test failed as expected (invalid person URN), but this confirms posting permissions work.'
                    ]);
                }
            }
            
            if ($response->status() === 403) {
                return response()->json([
                    'error' => 'Token does not have posting permissions',
                    'message' => 'Your token needs w_member_social scope',
                    'response' => $response->json()
                ]);
            }
            
            return response()->json([
                'info' => 'Unexpected response - check details',
                'status' => $response->status(),
                'response' => $response->json(),
                'note' => 'This might still work for actual blog posting'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception during API test',
                'message' => $e->getMessage()
            ]);
        }
    }
}