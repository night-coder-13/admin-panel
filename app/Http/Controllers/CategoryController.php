<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $trash = Category::onlyTrashed()->get();
        $trash = count($trash) != 0 ? true : false;
        $categories = Category::all();
        return view('categories.index', compact(['categories' , 'trash']));
    }
    public function trash()
    {
        $categories = Category::onlyTrashed()->get();
        return view('categories.trash', compact('categories'));
    }
    public function restore($category)
    {
        $category = Category::withTrashed()->find($category);
        $category->restore();
        return redirect()->route('category.index')->with(['warning' => 'دسته با نام "' . $category->name . '" بازتولید شد']);
    }
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:30',
            'status' => 'required|boolean',
        ]);

        Category::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('category.index')->with(['success' => 'دسته با نام "' . $request->name . '" ایجاد شد']);
    }
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:30',
            'status' => 'required|boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('category.index')->with(['success' => 'دسته با نام "' . $request->name . '" ویرایش شد']);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with(['info' => 'دسته با نام "' . $category->name . '" حذف شد']);
    }
}
