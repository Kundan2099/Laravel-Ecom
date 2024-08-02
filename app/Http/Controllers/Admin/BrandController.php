<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

interface BrandInterface
{
    public function viewBrandList();
    public function viewBrandCreate();
    public function viewBrandUpdate($id);
    public function handleBrandCreate(Request $request);
    public function handleBrandUpdate(Request $request, $id);
    public function handleToggleBrandStatus(Request $request);
    public function handleBrandDelete($id);
}
class BrandController extends Controller implements BrandInterface
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
     * view Brand List
     * 
     * @return mixed
     */
    public function viewBrandList(): mixed
    {
        try {
            $brands = Brand::all();
            return view('admin.pages.brand.brand-list', [
                'brands' => $brands
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'As error occcured',
                'description'  => $exception->getMessage()
            ]);
        }
    }

    /**
     * view Brand Create
     * 
     * @return mixed
     */
    public function viewBrandCreate(): mixed
    {
        try {
            return view('admin.pages.brand.brand-create');
            
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'As error occcured',
                'description'  => $exception->getMessage()
            ]);
        }
    }

    /**
     * view Brand Update
     * 
     * @return mixed
     */
    public function viewBrandUpdate($id): mixed
    {
        try {
            $brand = Brand::find($id);
            return view('admin.pages.brand.brand-update', [
                'brand' => $brand
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'As error occcured',
                'description'  => $exception->getMessage()
            ]);
        }
    }

    /**
     * handle Brand Create
     * 
     * @return mixed
     */
    public function handleBrandCreate(Request $request): RedirectResponse
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'slug' => ['required', 'string', 'min:1', 'max:250'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $brand = new Brand;
            $brand->name = $request->input('name');
            $brand->slug = $request->input('slug');
            $brand->save();

            return redirect()->route('admin.view.brand.list')->with('message', [
                'status' => 'success',
                'title' => 'Brand created',
                'description' => 'The Brand is successfully created.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'As error occcured',
                'description'  => $exception->getMessage()
            ]);
        }
    }

    /**
     * handle Brand Update
     * 
     * @return mixed
     */
    public function handleBrandUpdate(Request $request, $id): RedirectResponse
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Brand not found',
                    'description' => 'Brand not found with specified ID'
                ]);
            }
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'slug' => ['required', 'string', 'min:1', 'max:250'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $brand->name = $request->input('name');
            $brand->slug = $request->input('slug');
            $brand->update();

            return redirect()->route('admin.view.brand.list')->with('message', [
                'status' => 'success',
                'title' => 'Brand created',
                'description' => 'The Brand is successfully created.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'As error occcured',
                'description'  => $exception->getMessage()
            ]);
        }
    }

    /**
     * Handle Toggle Brand Status
     *  
     * @return mixed
     */
    public function handleToggleBrandStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'brand_id' => ['required', 'string', 'exists:brands,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], 200);
            }

            $brand = Brand::find($request->input('brand_id'));
            $brand->status = !$brand->status;
            $brand->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $brand
            ], 200);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => "An error occcured",
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * handle Brand Delete
     * 
     * @return mixed
     */
    public function handleBrandDelete($id): RedirectResponse
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Brand not found',
                    'description' => 'Brand not found with specified ID'
                ]);
            }

            $brand->delete();

            return redirect()->route('admin.view.brand.list')->with('message', [
                'status' => 'success',
                'title' => 'Brand deleted',
                'description' => 'The Brand access is successfully deleted.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'As error occcured',
                'description'  => $exception->getMessage()
            ]);
        }
    }
}
