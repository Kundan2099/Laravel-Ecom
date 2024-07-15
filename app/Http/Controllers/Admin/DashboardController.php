<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

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
            return view('admin.pages.dashboard.dashboard');

        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'discription' => $exception->getMessage()
            ]);
        }
    }
}
