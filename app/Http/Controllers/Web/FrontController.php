<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $featuredProduct = Product::with('productimage')
            ->where('is_featured', 'YES')
            ->where('status', 1)
            ->orderBy('id', 'asc')
            ->take(8)
            ->get();

        $latestProducts = Product::with('productimage')
            ->orderBy('id', 'desc')
            ->where('status', 1)->take(3)
            ->get();

        return view('web.pages.index', [
            'featuredProduct' => $featuredProduct,
            'latestProducts' => $latestProducts
        ]);
    }
}
