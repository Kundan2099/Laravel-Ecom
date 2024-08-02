<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

interface ProductInterface
{
    public function viewProductList();
    public function viewProductCreate();
    public function viewProductUpdate($id);
    public function handleProductCreate(Request $request);
    public function handleProductUpdate(Request $request, $id);
    public function handleToggleProductStatus(Request $request);
    public function handleProductDelete($id);
}

class ProductController extends Controller implements ProductInterface
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
     * view Product List
     * 
     * @return mixed
     */
    public function viewProductList(): mixed
    {
        try {
            $products = Product::all();
            return view('admin.pages.product.product-list', [
                'products' => $products
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
     * view Product Create
     * 
     * @return mixed
     */
    public function viewProductCreate(): mixed
    {
        try {
            $category = Category::select('id', 'name')->orderBy('name', 'asc')->get();
            $subcategory = SubCategory::select('id', 'name')->orderBy('name', 'asc')->get();
            $brand = Brand::select('id', 'name')->orderBy('name', 'asc')->get();

            return view('admin.pages.product.product-create', [
                'category' => $category,
                'subcategory' => $subcategory,
                'brand' => $brand
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
     * view Product Update
     * 
     * @return mixed
     */
    public function viewProductUpdate($id): mixed
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Product not foud',
                    'description' => 'Product not found with specified ID'
                ]);
            }

            $category = Category::select('id', 'name')->orderBy('name', 'asc')->get();
            $subcategory = SubCategory::select('id', 'name')->orderBy('name', 'asc')->get();
            $brand = Brand::select('id', 'name')->orderBy('name', 'asc')->get();

            return view('admin.pages.product.product-update', [
                'product' => $product,
                'category' => $category,
                'subcategory' => $subcategory,
                'brand' => $brand
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
     * handle Product Create
     * 
     * @return mixed
     */
    public function handleProductCreate(Request $request): RedirectResponse
    {
        try {
            $rules = [
                'title' => ['nullable', 'string', 'min:1', 'max:250'],
                'slug' => ['nullable', 'string', 'min:1', 'max:250'],
                'description' => ['nullable', 'text', 'min:2', 'max:500'],
                'price' => ['nullable', 'numeric', 'min:1'],
                'compare_price' => ['nullable', 'numeric', 'min:1'],
                'category_id' => ['nullable', 'string', 'exists:categories,id'],
                'sub_category_id' => ['nullable', 'string', 'exists:sub_categories,id'],
                'brand_id' => ['nullable', 'string', 'exists:brands,id'],
                'is_featured' => ['nullable', Rule::in(['Yes', 'No'])],
                'sku' => ['nullable', 'string', 'min:1', 'max:250'],
                'barcode' => ['nullable', 'string', 'min:1', 'max:250'],
            ];

            if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
                $rules['qty'] =  ['required', 'numeric'];
            };

            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $product = new Product();
            $product->title = $request->input('title');
            $product->slug = $request->input('slug');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->compare_price = $request->input('compare_price');
            $product->category_id = $request->input('category_id');
            $product->sub_category_id = $request->input('sub_category_id');
            $product->brand_id = $request->input('brand_id');
            $product->is_featured = $request->input('is_featured');
            $product->sku = $request->input('sku');
            $product->barcode = $request->input('barcode');
            $product->qty = $request->input('qty');
            $product->save();

            return redirect()->route('admin.view.product.list')->with('message', [
                'status' => 'success',
                'title' => 'Product created',
                'description' => 'The Product is successfully created.'
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
     * handle Product Update
     * 
     * @return mixed
     */
    public function handleProductUpdate(Request $request, $id): RedirectResponse
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Product not found',
                    'description' => 'Product not found with specified ID'
                ]);
            }

            $rules = [
                'title' => ['nullable', 'string', 'min:1', 'max:250'],
                'slug' => ['nullable', 'string', 'min:1', 'max:250'],
                'description' => ['nullable', 'text', 'min:2', 'max:500'],
                'price' => ['nullable', 'numeric', 'min:1'],
                'compare_price' => ['nullable', 'numeric', 'min:1'],
                'category_id' => ['nullable', 'string', 'exists:categories,id'],
                'sub_category_id' => ['nullable', 'string', 'exists:sub_categories,id'],
                'brand_id' => ['nullable', 'string', 'exists:brands,id'],
                'is_featured' => ['nullable', Rule::in(['Yes', 'No'])],
                'sku' => ['nullable', 'string', 'min:1', 'max:250'],
                'barcode' => ['nullable', 'string', 'min:1', 'max:250'],
            ];

            if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
                $rules['qty'] =  ['required', 'numeric'];
            };

            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $product->title = $request->input('title');
            $product->slug = $request->input('slug');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->compare_price = $request->input('compare_price');
            $product->category_id = $request->input('category_id');
            $product->sub_category_id = $request->input('sub_category_id');
            $product->brand_id = $request->input('brand_id');
            $product->is_featured = $request->input('is_featured');
            $product->sku = $request->input('sku');
            $product->barcode = $request->input('barcode');
            $product->qty = $request->input('qty');
            $product->update();

            return redirect()->route('admin.view.product.list')->with('message', [
                'status' => 'success',
                'title' => 'Product created',
                'description' => 'The Product is successfully created.'
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
     * handle Toggle Product Status
     * 
     * @return mixed
     */
    public function handleToggleProductStatus(Request $request): Response
    {
        try {
            $validation = Validator::make($request->all(), [
                'product_id' => ['required', 'string', 'exists:products,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], 200);
            }

            $product = Product::find($request->input('product_id'));
            $product->status = !$product->status;
            $product->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $product
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
     * handle Product Delete
     * 
     * @return mixed
     */
    public function handleProductDelete($id): RedirectResponse
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Product not found',
                    'description' => 'Product not found with specified ID'
                ]);
            }

            $product->delete();

            return redirect()->route('admin.view.product.list')->with('message', [
                'status' => 'success',
                'title' => 'Product deleted',
                'description' => 'The Product access is successfully deleted.'
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
