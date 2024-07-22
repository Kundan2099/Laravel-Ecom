<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

interface CategoryInterface
{
    public function viewCategoryList();
    public function viewCategoryCreate();
    public function viewCategoryUpdate($id);
    public function handleCategoryCreate(Request $request);
    public function handleCategoryUpdate(Request $request, $id);
    public function handleTogglecategoryStatus(Request $request);
    public function handlecategoryDelete($id);
}

class CategoryController extends Controller implements CategoryInterface
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
     * View Category List
     *  
     * @return mixed
     */
    public function viewCategoryList(): mixed
    {
        try {
            $categories = Category::all();

            return view('admin.pages.category.category-list', [
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
     * View Category Create
     *  
     * @return mixed
     */
    public function viewCategoryCreate(): mixed
    {
        try {

            return view('admin.pages.category.category-create');
            
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * View Category Update
     *  
     * @return mixed
     */
    public function viewCategoryUpdate($id): mixed
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Category not foud',
                    'description' => 'Category not found with specified ID'
                ]);
            }

            return view('admin.pages.category.category-update', [
                'category' => $category
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
     * Handle Category Create
     *  
     * @return mixed
     */
    public function handleCategoryCreate(Request $request): RedirectResponse
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'slug' => ['required', 'string', 'min:1', 'max:250'],
                'img' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mkv'],
            ]);

            if ($validation) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $category = new Category;
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            if ($request->hasFile('img')) {
                $category->img = $request->file('img')->store('categories');
            }
            $category->save();

            return redirect()->route('admin.pages.category.category-list')->with('message', [
                'status' => 'success',
                'title' => 'Category created',
                'description' => 'The Category is successfully created.'
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
     * Handle Category Update
     *  
     * @return mixed
     */
    public function handleCategoryUpdate(Request $request, $id): RedirectResponse
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Category not found',
                    'description' => 'Category not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'slug' => ['required', 'string', 'min:1', 'max:250'],
                'img' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mkv'],
            ]);

            if ($validation) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            if ($request->hasFile('img')) {
                if (!is_null($category->img)) Storage::delete($category->img);
                $category->img = $request->file('img')->store('categories');
            }
            $category->update();

            return redirect()->route('admin.pages.category.category-list')->with('message', [
                'status' => 'success',
                'title' => 'Category saved',
                'description' => 'The Category is successfully saved.'
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
     * Handle Toggle Category Status
     *  
     * @return mixed
     */
    public function handleTogglecategoryStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'category_id' => ['required', 'string', 'exists:categories,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], 200);
            }

            $category = Category::find($request->input('category_id'));
            $category->status = !$category->status;
            $category->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $category
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
     * Handle Category Delete
     *  
     * @return mixed
     */
    public function handlecategoryDelete($id): RedirectResponse
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Category not found',
                    'description' => 'Category not found with specified ID'
                ]);
            }

            $category->delete();

            return redirect()->route('admin.pages.category.category-list')->with('message', [
                'status' => 'success',
                'title' => 'Category deleted',
                'description' => 'The Category access is successfully deleted.'
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
