<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiController extends Controller
{
    public function profile(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    try {
        $data = User::findOrFail($user->id);
        return response()->json($data);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error retrieving user data'], 500);
    }
}


}
