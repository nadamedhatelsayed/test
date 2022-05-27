<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryData;
use Illuminate\Http\Request;
use App\Models\ProductDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\CategoryRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Resources\CategoryResource;

class CategoryController  extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $categories  = CategoryResource::collection(Category::with('data')->get());
        return $this->apiResponse($categories, 'get all categories', 201);
    }

    public function show($id)
    {
        $category = Category::with('data')->find($id);
        if ($category != null) {
            $categoryy = new CategoryResource($category);
            return $this->apiResponse($categoryy, 'show category', 201);
        }
        return $this->apiResponse(null, 'category not found', 404);
    }

    // for test
    public function store(Request $request)
    {
        try {
            $category = Category::create();
            CategoryData::create([
                'category_id' => $category->id,
                'title' => $request->title,
            ]);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move(public_path('uploads/categories/' . $category->id), $filename);
                $category->image = '/uploads/categories/' . $category->id . '/' . $filename;
                $category->save();
            }
            return $this->apiResponse(null, 'create category succesfully', 201);
        } catch (\Exception $e) {
            return $this->apiResponse(null, $e, 400);
        }
    }

    // for test
    public function update($id, Request $request)
    {

        try {
            $category = Category::find($id);

            if ($category != null) {
                $details = CategoryData::where('category_id', $id)->first();
                $details->update([
                    'title' => $request->title,
                ]);
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    if (File::exists(public_path($category->image))) {
                        File::delete(public_path($category->image));
                    }
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $request->image->move(public_path('uploads/categories/' . $request->id), $filename);
                    $category->image = '/uploads/categories/' . $id . '/' . $filename;
                    $category->save();
                }

                return $this->apiResponse(null, 'update category succesfully', 201);
            } else {
                return $this->apiResponse(null, 'category not found', 404);
            }
        } catch (\Exception $e) {
            return $this->apiResponse(null, $e, 400);
        }
    }
    // for test
    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if ($category == null) {
                return $this->apiResponse(null, 'category not found', 404);
            }
            CategoryData::where('category_id', $id)->delete();
            $category->delete();

            return $this->apiResponse(null, 'delete category succesfully', 201);
        } catch (\Exception $e) {
            return $this->apiResponse(null, $e, 500);
        }
    }
}
