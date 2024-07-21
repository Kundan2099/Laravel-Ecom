<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

interface AdminAccessInterface
{
    public function viewAdminAccessList();
    public function viewAdminAccessCreate();
    public function viewAdminAccessUpdate($id);
    public function handleAdminAccessCreate(Request $request);
    public function handleAdminAccessUpdate(Request $request, $id);
}

class AdminAccessController extends Controller implements AdminAccessInterface
{

    /**
     * create a new controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except('logout');
    }

    /**
     * View Admin Access List
     *  
     * @return mixed
     */
    public function viewAdminAccessList(): mixed
    {
        try {
            $admins = Admin::whereNot('id', auth()->user()->id)->get();
            return view(
                'admin.pages.access.access-list',
                [
                    'admins' => $admins
                ]
            );
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Admin Access Create
     * 
     * @return mixed
     */
    public function viewAdminAccessCreate(): mixed
    {
        try {
            $roles = Role::all();

            return view('admin.pages.access.access-create', [
                'roles' => $roles,
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Admin Access Update
     * 
     * @return mixed
     */
    public function viewAdminAccessUpdate($id): mixed
    {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Admin not foud',
                    'description' => 'Admin not found with specified ID'
                ]);
            }

            $roles = Role::all();

            return view('admin.pages.access.access-update', [
                'admin' => $admin,
                'roles' => $roles,
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Handle Admin Access Create
     * 
     * @return mixed
     */
    public function handleAdminAccessCreate(Request $request): RedirectResponse
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'email' => ['required', 'email', 'min:1', 'max:250', 'unique:admins'],
                'phone' => ['required', 'numeric', 'digits_between:10,12', 'unique:admins'],
                'role_id' => ['required', 'string', 'exists:roles,id'],
                'password' => ['required', 'string', 'min:6', 'max:20', 'confirmed'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $admin = new Admin;
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->phone = $request->input('phone');
            $admin->password = Hash::make('password');
            $admin->save();

            $role = Role::find($request->input('role_id'));
            $admin->assignRole($role);

            return redirect()->route('admin.view.admin.access.list')->with('message', [
                'status' => 'success',
                'title' => 'Admin access created',
                'description' => 'The admin access is successfully created.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Handle Admin Access Update
     * 
     * @return mixed
     */
    public function handleAdminAccessUpdate(Request $request, $id): RedirectResponse
    {
        try {

            $admin = Admin::find($id);
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'email' => ['required', 'email', 'min:1', 'max:250', Rule::unique('admins')->ignore($id)],
                'phone' => ['required', 'numeric', 'digits_between:10,12', Rule::unique('admins')->ignore($id)],
                'password' => ['nullable', 'string', 'min:6', 'max:20', 'confirmed'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->phone = $request->input('phone');
            if ($request->input('password')) {
                $admin->password = Hash::make($request->input('password'));
            }
            $admin->update();

            return redirect()->route('admin.view.admin.access.list')->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The admin access is successfully saved.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }
}
