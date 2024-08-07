<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;

interface ShopInterface
{
}

class ShopController extends Controller
{
    public function viewShop(Request $request, $categorySlug = null, $subCategorySlug = null)
    {
        try {

            //Active sub & category
            $categorySelected = '';
            $subCategorySelected = '';

            $categories = Category::orderBy('name', 'asc')->with('sub_categories')->where('status', 1)->get();
            $brands = Brand::orderBy('name', 'asc')->where('status', 1)->get();
            $products = Product::orderBy('id', 'desc')->where('status', 1)->get();


            // Apply Filters Slug

            if (!empty($categorySlug)) {
                $category = Category::where('slug', $categorySlug)->first();
                $products = $products->where('category_id', $category->id);

                $categorySelected = $category->id;
            }

            if (!empty($subCategorySlug)) {
                $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
                $products = $products->where('sub_category_id', $subCategory->id);

                $subCategorySelected = $subCategory->id;

            }
            //
            
            $data['categories'] = $categories;
            $data['brands'] = $brands;
            $data['products'] = $products;
            // Active sub & category
            $data['categorySelected'] = $categorySelected;
            $data['subCategorySelected' ]= $subCategorySelected;


            return view('web.pages.shop', $data);
            // [
                // 'categories' => $categories,
                // 'brands' => $brands,
                // 'products' => $products,
                // // Active sub & category
                // 'categorySelected' => $categorySelected,
                // 'subCategorySelected' => $subCategorySelected
            // ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'As error occured',
                'description' => $exception->getMessage()
            ]);
        }
    }
}
