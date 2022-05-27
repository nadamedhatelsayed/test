<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Api\ApiResponseTrait;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $products = ProductResource::collection(Product::with(['data','images'])->get());
        return $this->apiResponse($products, 'get all products', 201);
    }

    public function show($id)
    {
        $product = Product::with(['data','images'])->find($id);    
        if($product != null){

            $products = new ProductResource($product);
            return $this->apiResponse($products, 'show product', 201);
        }
        return $this->apiResponse(null, 'product not found', 404);
    }
    // for test
    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id' =>'required',
                'title' =>'required|unique:product_details,title',
                'description' =>'required',
            ]);
            $product = Product::create([
                'category_id' => $request->category_id
            ]);
            ProductDetails::create([
                'product_id'  => $product->id,
                'title'       => $request->title,
                'description' => $request->description,
            ]);
            return $this->apiResponse(null, 'create product succesfully', 201);
 
        } catch (\Exception $e) {
            return $this->apiResponse(null, $e, 400);
        }
    }

    // for test
    public function update(Request $request)
    {
         try {
            $product = Product::find($request->id);
            if( $product != null){
                $product->update([
                    'category_id' => $request->category_id
                ]);
                $details = ProductDetails::where('product_id', $request->id)->first();
                $details->update([
                    'title' => $request->title,
                    'description' => $request->description,
                ]);
                return $this->apiResponse(null, 'update product succesfully', 201);
            }else{
                return $this->apiResponse(null, ' product not found', 404);
            }
           
        } catch (\Exception $e) {

            return $this->apiResponse(null, $e, 400);
        }
    }
    // for test
    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if($product != null){
                ProductDetails::where('product_id', $id)->delete();
                Product::where('id', $id)->delete();
    
                return $this->apiResponse(null, 'delete product succesfully', 201);
            }else{
                return $this->apiResponse(null, 'product not found', 400);

            }
          
        } catch (\Exception $e) {
            return $this->apiResponse(null, $e, 400);
        }
    }

    // for test
    public function uploadImages(Request $request)
    {
        try {
            foreach ($request->file('images') as $image) {
                $filename = $image->getClientOriginalName();
                ProductImage::create([
                    'product_id' => $request->id,
                    'image' => '/uploads/products/' . $request->id . '/' . $filename,
                ]);
                $image->move(public_path('uploads/products/' . $request->id), $filename);
            }
            
            return $this->apiResponse(null, 'upload images succesfully', 201);
        } catch (\Exception $e) {
            return $this->apiResponse(null, $e, 400);
        }

    }

    // for test
    public function showImages(Request $request)
    {
        
        $images =  ProductImage::where('product_id',$request->id)->get();
        if($images!= null){
            return $this->apiResponse($images, 'images for this product', 201);

        }else{
            return $this->apiResponse(null, 'no image for this product', 201);

        } 
        
    }

    // for test
    public function deleteImages($id)
    {
        $image = ProductImage::where('id',$id)->first();
        if($image != null){
            if (File::exists(public_path( $image->image))) {
                File::delete(public_path( $image->image));
            }
            $image->delete();
            return $this->apiResponse(null, 'delete image successfully', 201);
        }else{
            return $this->apiResponse(null, 'image not found', 404);

        }
    }
}
