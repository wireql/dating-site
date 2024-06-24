<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileOpenInfoController extends Controller
{
    public function store(Request $request, ProfileService $profileService, $id) {
        
        switch ($request->input('action')) {
            case 'profile':

                $profileService->openProfileInfo($id);

                break;
            case 'telephone':
                # code...
                break;
            case 'social':
                # code...
                break;
            
            default:
                # code...
                break;
        }

    }
}
