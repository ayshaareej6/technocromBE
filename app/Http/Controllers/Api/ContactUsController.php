<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public function create(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email',
                'contact' => 'required',
                'website' => 'nullable',
                'message' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = ContactUs::create([
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'website' => $request->website,
                'message' => $request->message,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Contact Query Added Successfully',
            ], 200);

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
            $contactQueries = ContactUs::select('id', 'name', 'email', 'contact', 'website', 'message', 'created_at','status')->get();

            if(count($contactQueries) > 0) {
                return response()->json([
                    'status' => true,
                    'data' => $contactQueries,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Contact Queries Exists.',
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
