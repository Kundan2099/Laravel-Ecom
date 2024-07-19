<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

interface DashboardInterface
{
    public function viewDashboard();
}

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('logout');
    }

    /**
     * View Dashboard
     *
     * @return mixed
     */
    public function viewDashboard(): mixed
    {
        try {
            // $total_admin = Admin::where('status', true)->count();
            $admin = Auth::guard('admin')->user();

            return view('admin.pages.dashboard.dashboard', [
                // $admin->name.'<a href="'.route('admin.logout').'">Logout</a>',
                ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'discription' => $exception->getMessage()
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.view.login');
    }
}
