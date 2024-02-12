<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category\Category;

class CategoryController extends Controller
{
    public function adminCategoryList()
    {
        $categories = Category::all(); 

        return response()->json($categories);
    }

    public function adminCategoryAdd(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string',
            'category_type' => 'required|string',
        ]);

        $category = Category::create($validatedData);

        return response()->json(['message' => 'Kategoria dodana pomyślnie', 'category' => $category]);
    }

    public function adminCategoryDelete($id)
    {
        $category = Category::where('id', $id)
                                       ->first();

        if (!$category) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
