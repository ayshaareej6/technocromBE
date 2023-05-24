<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaseStudyController extends Controller
{
    public function create(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'title' => 'required',
                'desc' => 'required',
                'challenges' => 'required',
                'solution' => 'required',
                'result' => 'required',
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
                $request->file('image')->storeAs('uploads/case-study/', $file_name, 'public');
            }

            $case_study = CaseStudy::create([
                'title' => $request->title,
                'desc' => $request->desc,
                'challenges' => $request->challenges,
                'solution' => $request->solution,
                'result' => $request->result,
                'image' => $file_name,
                'data' => $request->data,
                'created_by' => auth()->user()->id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Case Study Created Successfully',
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
            $case_study = CaseStudy::where('id', $id);

            if(count($case_study->get()) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $case_study->first(),
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Case Study ID is invalid',
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
                'title' => 'required',
                'desc' => 'required',
                'challenges' => 'required',
                'solution' => 'required',
                'result' => 'required',
                'image' => 'nullable|mimes:png,jpeg,jpg|max:2048'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $case_study = CaseStudy::find($id);
            $case_study->title = $request->title;
            $case_study->desc = $request->desc;
            $case_study->challenges = $request->challenges;
            $case_study->solution = $request->solution;
            
            if($request->file()) {
                $file_name = time().'_'.$request->image->getClientOriginalName();
                $request->file('image')->storeAs('uploads/case-study/', $file_name, 'public');
                $case_study->image = $file_name;
            }

            $case_study->result = $request->result;
            $case_study->updated_by = auth()->user()->id;

            if($case_study->update()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Case Study successfully updated.',
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
            $case_studies = CaseStudy::select('id', 'title', 'desc', 'challenges', 'solution', 'result', 'image', 'created_at','status')->get();

            if(count($case_studies) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $case_studies,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Case Study Exists.',
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
            if(CaseStudy::where('id', $id)->delete()) {
                return response()->json([
                    'status' => true,
                    'data' => "Case Study Deleted Successfully",
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Case Study ID is invalid',
                ], 200);
            }
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
            $case_studies = CaseStudy::select('id', 'title', 'desc', 'challenges', 'solution', 'result', 'image', 'created_at','status')
                            ->orderBy('id', 'DESC')
                            ->get();

            if(count($case_studies) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $case_studies,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Case Study Exists.',
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
