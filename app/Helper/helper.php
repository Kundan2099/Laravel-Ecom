<?php

// echo "hi";

use App\Models\Category;

function getCategories()
{
   return Category::with('sub_categories')->orderBy('name', 'asc')
      ->where('status', 1)
      ->orderBy('id', 'asc')
      ->get();
}
