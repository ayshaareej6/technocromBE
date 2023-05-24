<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobBoardController extends Controller
{
    public function create(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'job_code' => 'nullable',
                'title' => 'required',
                'desc' => 'required',
                'type' => 'required',
                'shift' => 'required',
                'mode' => 'required',
                'location' => 'required',
                'last_date' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            JobBoard::create([
                'job_code' => $request->job_code,
                'title' => $request->title,
                'desc' => $request->desc,
                'type' => $request->type,
                'shift' => $request->shift,
                'mode' => $request->mode,
                'location' => $request->location,
                'last_date' => $request->last_date,
                'data' => $request->data,
                'created_by' => auth()->user()->id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Job Created Successfully',
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
            $job_board = JobBoard::where('id', $id);

            if(count($job_board->get()) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $job_board->first(),
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Job ID is invalid',
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
                'job_code' => 'nullable',
                'title' => 'required',
                'desc' => 'required',
                'type' => 'required',
                'shift' => 'required',
                'mode' => 'required',
                'location' => 'required',
                'last_date' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $job_board = JobBoard::find($id);
            $job_board->job_code = $request->job_code;
            $job_board->title = $request->title;
            $job_board->desc = $request->desc;
            $job_board->type = $request->type;
            $job_board->shift = $request->shift;
            $job_board->mode = $request->mode;
            $job_board->last_date = $request->last_date;
            $job_board->location = $request->location;
            $job_board->data = $request->data;
            $job_board->updated_by = auth()->user()->id;

            if($job_board->update()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Job successfully updated.',
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

    public function drop(Request $request, $id)
    {
        try {
            if(JobBoard::where('id', $id)->delete()) {
                return response()->json([
                    'status' => true,
                    'data' => "Job Deleted Successfully",
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Job ID is invalid',
                ], 200);
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
            $jobs = JobBoard::get();

            if(count($jobs) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $jobs,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Jobs Exists.',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function displayList()
    {
        try {
            $jobs = JobBoard::orderBy("id", "DESC")->get();

            if(count($jobs) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $jobs,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Jobs Exists.',
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
