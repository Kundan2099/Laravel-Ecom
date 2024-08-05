<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

interface SubCategoryInterface
{
    public function viewSubCategoryList();
    public function viewSubCategoryCreate();
    public function viewSubCategoryUpdate($id);
    public function handleSubCategoryCreate(Request $request);
    public function handleSubCategoryUpdate(Request $request, $id);
    public function handleToggleSubCategoryStatus(Request $request);
    public function handleSubCategoryDelete($id);
}
class SubCategoryController extends Controller implements SubCategoryInterface
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
     * create a new controller instance.
     * 
     * @return mixed
     */
    public function viewSubCategoryList(): mixed
    {
        try {
            $subcategories = SubCategory::with('category')->get();
            return view('admin.pages.subcategory.subcategory-list', [
                'subcategories' => $subcategories
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'As error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View SubCategory Create
     *  
     * @return mixed
     */
    public function viewSubCategoryCreate(): mixed
    {
        try {
            // $categories = Category::select('name')->orderBy('name', 'asc')->get();
            $categories = Category::all();
            return view('admin.pages.subcategory.subcategory-create', [
                'categories' => $categories,
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * View SubCategory Update
     *  
     * @return mixed
     */
    public function viewSubCategoryUpdate($id): mixed
    {
        try {
            $subcategory = SubCategory::find($id);

            if (!$subcategory) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'SubCategory not foud',
                    'description' => 'SubCategory not found with specified ID'
                ]);
            }
            $categories = Category::all();

            return view('admin.pages.subcategory.subcategory-update', [
                'subcategory' => $subcategory,
                'categories' => $categories,

            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Handle SubCategory Create
     *  
     * @return mixed
     */
    public function handleSubCategoryCreate(Request $request): RedirectResponse
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'slug' => ['required', 'string', 'min:1', 'max:250', 'exists:sub_categories,id'],
                'category_id' => ['required', 'string', 'exists:categories,id'],
                'img' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mkv'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $subcategory = new SubCategory;
            $subcategory->name = $request->input('name');
            $subcategory->slug = $request->input('slug');
            $subcategory->category_id = $request->input('category_id');
            if ($request->hasFile('img')) {
                $subcategory->img = $request->file('img')->store('subcategories');
            }
            $subcategory->save();

            return redirect()->route('admin.view.subcategory.list')->with('message', [
                'status' => 'success',
                'title' => 'SubCategory created',
                'description' => 'The SubCategory is successfully created.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Handle SubCategory Update
     *  
     * @return mixed
     */
    public function handleSubCategoryUpdate(Request $request, $id): RedirectResponse
    {
        try {
            $subcategory = SubCategory::find($id);
            if (!$subcategory) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'SubCategory not found',
                    'description' => 'SubCategory not found with specified ID'
                ]);
            }
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'slug' => ['required', 'string', 'min:1', 'max:250', 'exists:sub_categories,id'],
                'category_id' => ['required', 'string', 'exists:categories,id'],
                'img' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mkv'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $subcategory->name = $request->input('name');
            $subcategory->slug = $request->input('slug');
            if ($request->hasFile('img')) {
                if (!is_null($subcategory->img)) Storage::delete($subcategory->img);
                $subcategory->img = $request->file('img')->store('subcategories');
            }
            $subcategory->update();


            return redirect()->route('admin.view.subcategory.list')->with('message', [
                'status' => 'success',
                'title' => 'SubCategory created',
                'description' => 'The SubCategory is successfully created.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Handle Toggle SubCategory Status
     *  
     * @return mixed
     */
    public function handleToggleSubCategoryStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'subcategory_id' => ['required', 'string', 'exists:sub_categories,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], 200);
            }
            $subcategory = SubCategory::find($request->input('subcategory_id'));
            $subcategory->status = !$subcategory->status;
            $subcategory->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $subcategory
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
     * Handle SubCategory Delete
     *  
     * @return mixed
     */
    public function handleSubCategoryDelete($id): RedirectResponse
    {
        try {
            $subcategory = SubCategory::find($id);

            if (!$subcategory) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'SubCategory not found',
                    'description' => 'SubCategory not found with specified ID'
                ]);
            }

            $subcategory->delete();

            return redirect()->route('admin.view.subcategory.list')->with('message', [
                'status' => 'success',
                'title' => 'SubCategory deleted',
                'description' => 'The SubCategory access is successfully deleted.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage(),
            ]);
        }
    }
}
