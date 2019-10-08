<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Model\UserModel;
use Response;
use Log;
use Hash;

class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $user = UserModel::where('user_username', $username)
            ->first();
        if($user){
            if (Hash::check($password, $user->user_password)) {
                $response = ['status' => 'success', 'success' => true, 'message' => $user];
            }else{
                $response = ['status' => 'error', 'success' => false, 'message' => 'These credentials do not match our records.'];
            }
        }else{
            $response = ['status' => 'error', 'success' => false, 'message' => 'These credentials do not match our records.'];
        }
        return $response;
    }
}
