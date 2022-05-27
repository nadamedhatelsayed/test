<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryData;
use Illuminate\Http\Request;
use App\Models\ProductDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use Yajra\DataTables\Facades\DataTables;

class CategoryController  extends Controller
{
    public function index()
    {
        $category = Category::with('data')->has('data')->get();
        if (request()->ajax()) {

            return DataTables::of($category)
                ->addIndexColumn()
                ->addColumn('title', function ($category) {

                    $title = CategoryData::where('category_id', $category->id)->first();
                    return $title->title;
                })
              
                ->addColumn('image', function ($category) {

                    $url = asset($category->image);
                    return '<img src=' . $url . ' border="0" style=" width: 80px; height: 80px;" class="img-responsive img-rounded" align="center" />';
                })
                ->addColumn('action', function ($category) {
                    $pro = CategoryData::where('category_id', $category->id)->first();

                    $btn =  '<div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       controle
                    </button>
                      <div class="dropdown-menu">
                      <a class="dropdown-item edit-btn" data-toggle="modal" data-target="#exampleModaledit" href="#" data-id="' . $category->id . '"   data-title="' . $pro->title . '" data-image="' . $category->image . '"> edit </a>
                      <a class="dropdown-item delete-btn" href="#" data-id="' . $category->id . '"  > delete </a>
                    
                  </div>';

                    return $btn;
                })
                ->rawColumns([
                    'title',
                    'description',
                    'image',
                    'action',
                ])
                ->make(true);
        }

        return view('admin.categories.index');
    }

    public function store(CategoryRequest $request)
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
            return response()->json('SUCCESS');
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }


    public function update(Request $request)
    {
        
         try {
            $details = CategoryData::where('category_id', $request->id)->first();
            $details->update([
                'title' => $request->title,
            ]);
            $category =Category::find($request->id);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if (File::exists(public_path( $category->image))) {
                    File::delete(public_path( $category->image));
                }
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move(public_path('uploads/categories/' . $request->id), $filename);
                $category->image = '/uploads/categories/' . $request->id . '/' . $filename;
                $category->save();
            }

            return response()->json('SUCCESS');
        } catch (\Exception $e) {

            return response()->json('ERROR');
        }
    }

    public function destroy(Request $request)
    {
        try {
            CategoryData::where('category_id', $request->id)->delete();
            Category::where('id', $request->id)->delete();

            return response()->json('SUCCESS');
        } catch (\Exception $e) {
            return response()->json('ERROR');
        }
    }
}
