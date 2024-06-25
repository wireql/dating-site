<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileOpenInfoController extends Controller
{
    public function store(Request $request, ProfileService $profileService, $id) {
        
        try {
            switch ($request->input('action')) {
                case 'profile':
    
                    $result = $profileService->openProfileInfo($id);
    
                    break;
                case 'telephone':

                    $result = $profileService->openTelephoneInfo($id);

                    break;
                case 'social':

                    $result = $profileService->openSocialInfo($id);

                    break;
                
                default:
                    # code...
                    break;
            }
        } catch (\Exception $e) {
            return redirect()->route('user', $id)->withErrors([
                'msg-error' => $e->getMessage()
            ]);
        }

        return redirect()->route('user', $id)->with('msg-success', $result['message']);

    }
}
