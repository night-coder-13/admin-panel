<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $trash = Product::onlyTrashed()->get();
        if (count($trash) != 0) {
            $trash = true;
            $products = Product::all();
            return view('products.index', compact(['products', 'trash']));
        } else {
            $trash = false;
            $products = Product::all();
            return view('products.index', compact(['products', 'trash']));
        }
    }
    public function trash()
    {
        $products = Product::onlyTrashed()->get();
        return view('products.trash', compact('products'));
    }
    public function restore($product)
    {
        $product = Product::withTrashed()->find($product);
        $product->restore();
        return redirect()->route('product.index')->with(['warning' => 'اسلایدر با عنوان "' . $product->title . '" بازتولید شد']);
    }
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'primary_image' => 'required|image',
        //     'name' => 'required|string',
        //     'category_id' => 'required|integer',
        //     'description' => 'required',
        //     'price' => 'required|integer',
        //     'status' => 'required|integer',
        //     'quantity' => 'required|integer',
        //     'sale_price' => 'nullable|integer',
        //     'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
        //     'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
        //     'images.*' => 'nullable|image'
        // ]);

        // $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
        // $request->primary_image->storeAs('images/products/', $primaryImageName);
        // $ImageNames = [];
        // foreach($request->images as $img){
        //     $ImageName = Carbon::now()->microsecond . '-' . $img->getClientOriginalName();
        //     $img->storeAs('images/products/', $ImageName);

        //     array_push($ImageNames , $ImageName);
        // }

        // dd(implode('-' , explode(' ' , 'مهدی علی') ));

        dd($this->makeSlug($request->name));
        // return redirect()->route('product.index')->with(['success' => 'اسلایدر با عنوان "' . $request->title . '" ایجاد شد']);
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|min:4|max:30',
            'url' => 'required|string',
            'title_url' => 'required|string',
            'body' => 'required|string|min:10',
        ]);

        $product->update([
            'title' => $request->title,
            'url' => $request->url,
            'title_url' => $request->title_url,
            'body' => $request->body,
        ]);

        return redirect()->route('product.index')->with(['success' => 'اسلایدر با عنوان "' . $request->title . '" ویرایش شد']);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with(['info' => 'اسلایدر با عنوان "' . $product->title . '" حذف شد']);
    }

    
    public function makeSlug($string)
    {
        $slug = slugify($string);
        $count = Product::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $result = $count ? "{$slug}-{$count}" : $slug;

        return $result;
    }
}
