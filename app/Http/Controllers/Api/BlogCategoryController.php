<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BlogCategoryController extends Controller
{
    public function create(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'desc' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $category = BlogCategory::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'created_by' => auth()->user()->id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Category Created Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function view(Request $request, $id)
    {
        try {
            $blog_category = BlogCategory::where('id', $id);

            if(count($blog_category->get()) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $blog_category->first(),
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Category ID is invalid',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'desc' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $blog_category = BlogCategory::find($id);
            $blog_category->name = $request->name;
            $blog_category->desc = $request->desc;
            $blog_category->updated_by = auth()->user()->id;

            if($blog_category->update()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Category successfully updated.',
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Oops! something went wrong.',
                ], 401);
            }
        
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function list()
    {
        try {
            $blog_category = BlogCategory::select('id', 'name', 'desc', 'created_at')->get();

            if(count($blog_category) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $blog_category,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Category Exists.',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function drop(Request $request, $id)
    {
        try {
            if(BlogCategory::where('id', $id)->delete()) {
                return response()->json([
                    'status' => true,
                    'data' => "Category Deleted Successfully",
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Category ID is invalid',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
