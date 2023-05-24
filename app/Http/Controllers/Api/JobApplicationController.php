<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobApplicationController extends Controller
{
    public function create(Request $request)
    {
        try {
            //Validated
            $validateApplication = Validator::make($request->all(), 
            [
                'job_id' => 'required',
                'user_id' => 'required',
                'cv' => 'required|mimes:doc,pdf,docx|max:2048'
            ]);

            if($validateApplication->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateApplication->errors()
                ], 401);
            }

            if($request->file()) {
                $file_name = time().'_'.$request->cv->getClientOriginalName();
                $request->file('cv')->storeAs('uploads', $file_name, 'public');
            }

            $user = User::where('id', $request->user_id)->first();

            JobApplication::create([
                'job_id' => $request->job_id,
                'user_id' => $user->id,
                'cv' => $file_name,
                'data' => $request->data,
                'job_status' => 'pending',
                'created_by' => auth()->user()->id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Applied Successfully',
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
            $job_application = JobApplication::where('id', $id)->with('applicant', 'job');

            if(count($job_application->get()) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $job_application->get(),
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Job Application ID is invalid',
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
                'job_id' => 'required',
                'user_id' => 'required',
                'cv' => 'nullable|mimes:doc,pdf,docx|max:2048',
                'job_status' => 'nullable'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if($request->file()) {
                $file_name = time().'_'.$request->cv->getClientOriginalName();
                $request->file('cv')->storeAs('uploads', $file_name, 'public');
            }

            $user = User::where('id', $request->user_id)->first();

            $job_application = JobApplication::find($id);
            $job_application->job_id = $request->job_id;
            $job_application->user_id = $user->id;
            $job_application->cv = $file_name;
            $job_application->job_status = $request->job_status;
            $job_application->data = $request->data;
            $job_application->updated_by = auth()->user()->id;

            if($job_application->update()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Job Application successfully updated.',
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
            $job_applications = JobApplication::with('applicant', 'job')->get();

            if(count($job_applications) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $job_applications,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Job Applications Exists.',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function listByApplicant()
    {
        try {
            $applicant_id = auth()->user()->id;
            
            $job_applications = JobApplication::where('user_id', $applicant_id)->with('applicant', 'job')->get();

            if(count($job_applications) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $job_applications,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Job Applications Exists.',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function updateJobStatus(Request $request, $job_id)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'job_status' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            
            $job_application = JobApplication::find($job_id);
            $job_application->job_status = $request->job_status;
            $job_application->updated_by = auth()->user()->id;

            if($job_application->update()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Job Application Status successfully updated.',
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
}
