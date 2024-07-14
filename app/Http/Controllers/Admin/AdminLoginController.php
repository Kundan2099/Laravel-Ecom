<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function viewLogin() {
        return view('admin.pages.login');
    }


    /**
     * Handle Login
     *
     * @return mixed
     */
    public function handleLogin(Request $request): mixed
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'min:10', 'max:100', 'exists:users'],
                'password' => ['required', 'string', 'min:1', 'max:20']
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if (Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ], $request->get('remember'))) {
                return redirect(RouteServiceProvider::HOME);
            }

            return redirect()->back()->withErrors([
                'password' => ['Wrong password']
            ])->withInput($request->only('email', 'remember'));
            
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

}
