<?php

// echo "hi";

use App\Models\Category;

function getCategories()
{
   return Category::orderBy('name', 'asc')
      ->with('sub_categories')
      ->where('status', 1)
      ->get();
}
