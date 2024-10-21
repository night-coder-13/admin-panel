<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $trash = Product::onlyTrashed()->get();
        if (count($trash) != 0) {
            $trash = true;
            $products = Product::paginate(5);
            return view('products.index', compact(['products', 'trash']));
        } else {
            $trash = false;
            $products = Product::paginate(5);
            return view('products.index', compact(['products', 'trash']));
        }
    }
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
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
        return redirect()->route('product.index')->with(['warning' => 'محصول با نام "' . $product->name . '" بازتولید شد']);
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
        $image = $request->file('primary_image');
        $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
        // تغییر اندازه و کیفیت تصویر
        Image::read($image)->scale(800, 600)->save(public_path('images/products/' . $primaryImageName));
        //تصویر اصلی
        // $request->primary_image->storeAs('images/products/', $primaryImageName);

        $ImageNames = [];
        if ($request->images !== null) {
            foreach ($request->images as $img) {
                // dd($img);
                $ImageName = Carbon::now()->microsecond . '-' . $img->getClientOriginalName();
                Image::read($img)->scale(800, 600)->save( public_path('images/products/'.$ImageName) );
                // $img->storeAs('images/products/', $ImageName);

                array_push($ImageNames, $ImageName);
            }
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
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            // 'primary_image' => 'required|image',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'status' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            // 'images.*' => 'nullable|image'
        ]);
        if ($request->has('primary_image')) {
            Storage::delete('/images/products/' . $product->primary_image); // حذف تصویر
            $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
            $request->primary_image->storeAs('images/products/', $primaryImageName);
        }

        if ($request->has('images') && $request->images !== null) {
            $ImageNames = [];
            foreach ($request->images as $img) {
                foreach ($product->images as $image) {
                    Storage::delete('/images/products/' . $image->image);
                    $image->delete();
                } // حذف تصاویر

                $ImageName = Carbon::now()->microsecond . '-' . $img->getClientOriginalName();
                $img->storeAs('images/products/', $ImageName);
                array_push($ImageNames, $ImageName);
            }
        }

        DB::beginTransaction();

        $product->update([
            'name' => $request->name,
            'slug' => $request->name != $product->name ? $this->makeSlug($request->name) : $product->slug,
            'category_id' => $request->category_id,
            'primary_image' => $request->primary_image !== null ? $primaryImageName : $product->primary_image,
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

        return redirect()->route('product.index')->with(['success' => 'محصول با نام "' . $request->name . '" ویرایش شد']);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with(['info' => 'محصول با نام "' . $product->name . '" حذف شد']);
    }


    public function makeSlug($string)
    {
        $slug = slugify($string);
        $count = Product::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $result = $count ? "{$slug}-{$count}" : $slug;

        return $result;
    }
}
