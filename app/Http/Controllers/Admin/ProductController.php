<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $categories = Category::with('data')->get();
        if (request()->ajax()) {

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('title', function ($products) {

                    $title = ProductDetails::where('product_id', $products->id)->first();
                    return $title->title;
                })
                ->addColumn('description', function ($products) {

                    $desc = ProductDetails::where('product_id', $products->id)->first();
                    return $desc->description;
                })
                ->addColumn('action', function ($products) {
                    $pro = ProductDetails::where('product_id', $products->id)->first();
                    $btn =  '<div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       controle
                    </button>
                      <div class="dropdown-menu">
                      <a class="dropdown-item edit-btn" data-toggle="modal" data-target="#exampleModaledit" href="#" data-id="' . $products->id .     '" data-title="' . $pro->title . '" data-description="' . $pro->description . '" data-category_id="' . $products->category_id . '"> edit </a>
                      <a class="dropdown-item image-btn" data-toggle="modal" data-target="#exampleModaledit2" href="#" data-id="' . $products->id . '"   > images </a>

                      <a class="dropdown-item delete-btn" href="#" data-id="' . $products->id . '"  > delete </a>
                    
                  </div>';

                    return $btn;
                })
                ->rawColumns([
                    'title',
                    'description',
                    'action',
                ])
                ->make(true);
        }
        return view('admin.products.index', ['categories' => $categories]);
    }

    public function store(ProductRequest $request)
    {
        try {

            $product = Product::create([
                'category_id' => $request->category_id
            ]);
            ProductDetails::create([
                'product_id' => $product->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return response()->json('SUCCESS');
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }


    public function update(Request $request)
    {
        //update product
        try {
            $product = Product::find($request->id);
            $product->update([
                'category_id' => $request->category_id
            ]);
            $details = ProductDetails::where('product_id', $request->id)->first();
            $details->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);


            return response()->json('SUCCESS');
        } catch (\Exception $e) {

            return response()->json('ERROR');
        }
    }

    public function destroy(Request $request)
    {
        try {
            ProductDetails::where('product_id', $request->id)->delete();
            Product::where('id', $request->id)->delete();

            return response()->json('SUCCESS');
        } catch (\Exception $e) {
            return response()->json('ERROR');
        }
    }

    public function uploadImages(Request $request)
    {
        foreach ($request->file('images') as $image) {
            $filename = $image->getClientOriginalName();
            ProductImage::create([
                'product_id' => $request->id,
                'image' => '/uploads/products/' . $request->id . '/' . $filename,
            ]);
           $image->move(public_path('uploads/products/' . $request->id), $filename);
 

        }
         
        return redirect()->back();
    }
    public function showImages(Request $request)
    {
        
        $images =  ProductImage::where('product_id',$request->id)->get();
        return response(['data' =>$images]);
               
        
    }
    public function deleteImages(Request $request)
    {
        $image = ProductImage::where('id',$request->id)->first();
        if (File::exists(public_path( $image->image))) {
            File::delete(public_path( $image->image));
        }
        $image->delete();
        return response(['data' =>'success']);
               
        
    }
}
