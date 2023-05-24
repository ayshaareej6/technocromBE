<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function create(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'category_id' => 'required',
                'title' => 'required|unique:blogs',
                'desc' => 'required',
                'tags' => 'required',
                'image' => 'required|mimes:png,jpeg,jpg|max:2048'
            ]);

            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $file_name = "";

            if($request->file()) {
                $file_name = time().'_'.$request->image->getClientOriginalName();
                $request->file('image')->storeAs('uploads/blog-posts/', $file_name, 'public');
            }

            $blog = Blog::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'desc' => $request->desc,
                'tags' => $request->tags,
                'image' => $file_name,
                'data' => $request->data,
                'created_by' => auth()->user()->id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Blog Created Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function view(Request $request, $slug)
    {
        try {
            $blog = Blog::where('slug', $slug)->with(
                [
                    'category' => function($query) {
                        $query->select('id', 'name');
                    }
                ]
            );

            if(count($blog->get()) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $blog->first(),
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Blog ID is invalid',
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
                'category_id' => 'required',
                'title' => 'required',
                'desc' => 'required',
                'tags' => 'required',
                'image' => 'nullable|mimes:png,jpeg,jpg|max:2048'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $blog = Blog::find($id);
            $blog->category_id = $request->category_id;
            $blog->title = $request->title;
            $blog->desc = $request->desc;
            $blog->tags = $request->tags;
            $blog->data = $request->data;
            
            if($request->file()) {
                $file_name = time().'_'.$request->image->getClientOriginalName();
                $request->file('image')->storeAs('uploads/blog-posts/', $file_name, 'public');
                $blog->image = $file_name;
            }

            $blog->updated_by = auth()->user()->id;

            if($blog->update()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Blog successfully updated.',
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
            $case_studies = Blog::select('id', 'category_id', 'slug', 'title', 'desc', 'tags', 'image', 'created_at','status')
                            ->with(
                                [
                                    'category' => function($query) {
                                        $query->select('id', 'name');
                                    }
                                ]
                            )->get();

            if(count($case_studies) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $case_studies,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Blog Exists.',
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
            if(Blog::where('id', $id)->delete()) {
                return response()->json([
                    'status' => true,
                    'data' => "Blog Deleted Successfully",
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Blog ID is invalid',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'image' => 'required|mimes:png,jpeg,jpg|max:2048'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $file_name = "";

            if($request->file()) {
                $file_name = time().'_'.$request->image->getClientOriginalName();
                $request->file('image')->storeAs('uploads/blog-images/', $file_name, 'public');
            }

            return response()->json([
                'status' => true,
                'path' => asset('public/uploads/blog-images/'.$file_name),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function frontList()
    {
        try {
            $blogs = Blog::select('id', 'slug', 'title', 'desc', 'category_id', 'image', 'created_at','status')
                            ->with(
                                [
                                    'category' => function($query) {
                                        $query->select('id', 'name');
                                    }
                                ]
                            )
                            ->orderBy('id', 'DESC')
                            ->get();

            if(count($blogs) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $blogs,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Blog Exists.',
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
