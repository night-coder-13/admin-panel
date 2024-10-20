<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $trash = Product::onlyTrashed()->get();
        if (count($trash) != 0) {
            $trash = true;
            $products = Product::paginate(3);
            return view('products.index', compact(['products', 'trash']));
        } else {
            $trash = false;
            $products = Product::paginate(3);
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
        $request->validate([
            'primary_image' => 'required|image',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'status' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'images.*' => 'nullable|image'
        ]);

        $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
        $request->primary_image->storeAs('images/products/', $primaryImageName);
        $ImageNames = [];
        foreach($request->images as $img){
            $ImageName = Carbon::now()->microsecond . '-' . $img->getClientOriginalName();
            $img->storeAs('images/products/', $ImageName);

            array_push($ImageNames , $ImageName);
        }

        DB::beginTransaction();

        $product = Product::create([
            'name' => $request->name,
            'slug' => $this->makeSlug($request->name),
            'category_id' => $request->category_id,
            'primary_image' => $primaryImageName,
            'description' => $request->description,
            'status' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request->sale_price !== null ? $request->sale_price : 0,
            'date_on_sale_from' => $request->date_on_sale_from !== null ? getMiladiDate($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? getMiladiDate($request->date_on_sale_to) : null,
        ]);

        
        if ($request->has('images') && $request->images !== null) {
            foreach ($ImageNames as $fileNameImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage
                ]);
            }
        }

        DB::commit();

        return redirect()->route('product.index')->with(['success' => 'محصول با نام "' . $request->name . '" ایجاد شد']);
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
