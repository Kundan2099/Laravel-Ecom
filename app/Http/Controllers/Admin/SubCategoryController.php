<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
class SubCategoryController extends Controller
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

            return view('admin.pages.subcategory.subcategory-list');
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

            return view('admin.pages.subcategory.subcategory-create');
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

            return view('admin.pages.subcategory.subcategory-update', [
                'subcategory' => $subcategory
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
                'slug' => ['required', 'string', 'min:1', 'max:250'],
                'catehory' => ['required', 'string', 'min:1', 'max:250'],
                'img' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mkv'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $subcategory = new SubCategory;
            $subcategory->name = $request->input('name');
            $subcategory->slug = $request->input('slug');
            $subcategory->category = $request->input('category');
            if ($subcategory->hasFile('img')) {
                $subcategory->img = $request->file('img')->store('subcategories');
            }
            $subcategory->save();

            return redirect()->route('admin.view.category.list')->with('message', [
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

    // /**
    //  * Handle SubCategory Update
    //  *  
    //  * @return mixed
    //  */
    // public function handleCategoryUpdate(Request $request, $id): RedirectResponse
    // {
    //     try {
    //         $category = Category::find($id);
    //         if (!$category) {
    //             return redirect()->back()->with('message', [
    //                 'status' => 'warning',
    //                 'title' => 'Category not found',
    //                 'description' => 'Category not found with specified ID'
    //             ]);
    //         }
    //         $validation = Validator::make($request->all(), [
    //             'name' => ['required', 'string', 'min:1', 'max:250'],
    //             'slug' => ['required', 'string', 'min:1', 'max:250'],
    //             'img' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mkv'],
    //         ]);

    //         if ($validation->fails()) {
    //             return redirect()->back()->withErrors($validation)->withInput();
    //         }

    //         $category->name = $request->input('name');
    //         $category->slug = $request->input('slug');
    //         if ($request->hasFile('img')) {
    //             if (!is_null($category->img)) Storage::delete($category->img);
    //             $category->img = $request->file('img')->store('categories');
    //         }
    //         $category->update();


    //         return redirect()->route('admin.view.category.list')->with('message', [
    //             'status' => 'success',
    //             'title' => 'Category saved',
    //             'description' => 'The Category is successfully saved.'
    //         ]);
    //     } catch (Exception $exception) {
    //         return redirect()->back()->with('message', [
    //             'status' => 'error',
    //             'title' => 'An error occcured',
    //             'description' => $exception->getMessage(),
    //         ]);
    //     }
    // }

    // /**
    //  * Handle Toggle SubCategory Status
    //  *  
    //  * @return mixed
    //  */
    // public function handleTogglecategoryStatus(Request $request): Response
    // {
    //     try {

    //         $validation = Validator::make($request->all(), [
    //             'category_id' => ['required', 'string', 'exists:categories,id']
    //         ]);

    //         if ($validation->fails()) {
    //             return response([
    //                 'status' => false,
    //                 'message' => $validation->errors()->first(),
    //                 'error' => $validation->errors()->getMessages()
    //             ], 200);
    //         }

    //         $category = Category::find($request->input('category_id'));
    //         $category->status = !$category->status;
    //         $category->update();

    //         return response([
    //             'status' => true,
    //             'message' => "Status successfully updated",
    //             'data' => $category
    //         ], 200);
    //     } catch (Exception $exception) {
    //         return response([
    //             'status' => false,
    //             'message' => "An error occcured",
    //             'error' => $exception->getMessage()
    //         ], 500);
    //     }
    // }

    // /**
    //  * Handle SubCategory Delete
    //  *  
    //  * @return mixed
    //  */
    // public function handlecategoryDelete($id): RedirectResponse
    // {
    //     try {
    //         $category = Category::find($id);
    //         if (!$category) {
    //             return redirect()->back()->with('message', [
    //                 'status' => 'warning',
    //                 'title' => 'Category not found',
    //                 'description' => 'Category not found with specified ID'
    //             ]);
    //         }

    //         $category->delete();

    //         return redirect()->route('admin.view.category.list')->with('message', [
    //             'status' => 'success',
    //             'title' => 'Category deleted',
    //             'description' => 'The Category access is successfully deleted.'
    //         ]);
    //     } catch (Exception $exception) {
    //         return redirect()->back()->with('message', [
    //             'status' => 'error',
    //             'title' => 'An error occcured',
    //             'description' => $exception->getMessage(),
    //         ]);
    //     }
    // }
}
