<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function allUser(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = User::whereNull('deleted_at')->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $html = '<a href="' . route('admin.edit.user', $row->id) . '" target="_blank" ><i title="Edit" class="fas fa-edit font-size-18"></i></a>';
                        $html .= ' <a href="javascript:void(0);" data-id="' . $row->id . '"  class="btn btn-xs remove btn-danger btn-delete"><i title="Delete" class="far fa-trash-alt"></i></a>';
                        return $html;
                    })->addColumn('created_at', function ($row) {
                        return date('d-M-Y', strtotime($row->created_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->created_at)->diffForHumans() . '</label>';
                    })->addColumn('email_verified_at', function ($row) {
                        return date('d-M-Y', strtotime($row->email_verified_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->email_verified_at)->diffForHumans() . '</label>';
                    })->addColumn('updated_at', function ($row) {
                        return date('d-M-Y', strtotime($row->updated_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->updated_at)->diffForHumans() . '</label>';
                    })->addColumn('full_name', function ($row) {
                        return $row->name;
                    })->addColumn('status', function ($row) {
                        if ($row->status == '0') {
                            $btn0 = '<div class="square-switch"><input type="checkbox" id="switch' . $row->id . '" class="user_status" switch="bool" data-id="' . $row->id . '" value="1"/><label for="switch' . $row->id . '" data-on-label="Yes" data-off-label="No"></label></div>';
                            return $btn0;
                        } elseif ($row->status == '1') {
                            $btn1 = '<div class="square-switch"><input type="checkbox" id="switch' . $row->id . '" class="user_status" switch="bool" data-id="' . $row->id . '" value="0" checked/><label for="switch' . $row->id . '" data-on-label="Yes" data-off-label="No"></label></div>';
                            return $btn1;
                        }
                    })
                    ->rawColumns(['action', 'full_name', 'email_verified_at', 'created_at', 'updated_at', 'status'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return view('admin.users.all');
    }

    public function addUser()
    {
        $data['user'] = DB::table('users')->whereNull('deleted_at')->get();
        return view('admin.users.add', $data);
    }

    public function addUserProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|max:190',
            'name' => 'required|max:190',
            'email' => 'required|email|unique:users|max:190',
            'password' => 'required|string|min:8|max:190',
            'confirm_password' => 'required|same:password',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = "1";
        $user->email_verified_at = Carbon::now();
        $user->created_at = Carbon::now();
        if ($user->save()) {
            $data['type'] = "success";
            $data['message'] = "user Added Successfuly!.";
            $data['icon'] = 'mdi-check-all';
            return redirect()->route('admin.view.user')->with($data);
        } else {
            $data['type'] = "danger";
            $data['message'] = "Failed to Add user, please try again.";
            $data['icon'] = 'mdi-block-helper';
            return redirect()->route('admin.add.user')->withInput()->with($data);
        }
    }

    public function updateUserStatus(Request $request)
    {
        $update = User::where('id', $request->id)->update(['status' => $request->status]);

        if ($update) {
            $request->status == '1' ? $alertType = 'success' : $alertType = 'info';
            $request->status == '1' ? $message = 'User Activated Successfuly!' : $message = 'User Deactivated Successfuly!';

            $notification = array(
                'message' => $message,
                'type' => $alertType,
                'icon' => 'mdi-check-all'
            );
        } else {
            $notification = array(
                'message' => 'Some Error Occured, Try Again!',
                'type' => 'error',
                'icon'  => 'mdi-block-helper'
            );
        }

        echo json_encode($notification);
    }

    public function removeUser(Request $request)
    {
        $user = User::where('id', $request->id)->delete();
        if ($user) {
            $notification['type'] = "success";
            $notification['message'] = "User Moved to Trash Successfuly!.";
            $notification['icon'] = 'mdi-check-all';

            echo json_encode($notification);
        } else {
            $notification['type'] = "danger";
            $notification['message'] = "Failed to Remove User, please try again.";
            $notification['icon'] = 'mdi-block-helper';

            echo json_encode($notification);
        }
    }

    public function trashUser(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = User::withTrashed()->whereNotNull('deleted_at')->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0);" class="btn btn-primary restore" data-id="' . $row->id . '"><i title="Restore" class="fas fa-trash-restore-alt font-size-18"></i></a>';
                        return $btn;
                    })->addColumn('deleted_at', function ($row) {
                        return date('d-M-Y', strtotime($row->deleted_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->deleted_at)->diffForHumans() . '</label>';
                    })->addColumn('created_at', function ($row) {
                        return date('d-M-Y', strtotime($row->created_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->created_at)->diffForHumans() . '</label>';
                    })->addColumn('email_verified_at', function ($row) {
                        return date('d-M-Y', strtotime($row->email_verified_at)) . '<br /> <label class="text-primary">' . Carbon::parse($row->email_verified_at)->diffForHumans() . '</label>';
                    })->addColumn('full_name', function ($row) {

                        return $row->name;
                    })
                    ->rawColumns(['action', 'email_verified_at', 'full_name', 'deleted_at', 'created_at'])
                    ->make(true);
            }
            return view('admin.users.trash');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function restoreUser(Request $request)
    {
        $user = User::withTrashed()->find($request->id);
        if ($user) {
            $user->restore();
            $notification['type'] = "success";
            $notification['message'] = "User Restored Successfuly!.";
            $notification['icon'] = 'mdi-check-all';

            echo json_encode($notification);
        } else {
            $notification['type'] = "danger";
            $notification['message'] = "Failed to Restore User, please try again.";
            $notification['icon'] = 'mdi-block-helper';

            echo json_encode($notification);
        }
    }

    public function editUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }
        $data['user'] = $user;
        return view('admin.users.edit', $data);
    }

    public function updateUserProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|max:190',
            'name' => 'required|max:190',
            'password' => 'required|string|min:8|max:190',
            'id'   => 'required',
        ]);
        $user = User::find($request->id);
        if (!$user) {
            abort(404);
        }
        $user->name = $request->name;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->updated_at = Carbon::now();
        $user->updated_by = Auth::user()->id;
        if ($user->save()) {
            $data['type'] = "success";
            $data['message'] = "User Updated Successfuly!.";
            $data['icon'] = 'mdi-check-all';
            return redirect()->route('admin.view.user')->with($data);
        } else {
            $data['type'] = "danger";
            $data['message'] = "Failed to Update User, please try again.";
            $data['icon'] = 'mdi-block-helper';
            return redirect()->route('admin.add.user')->withInput()->with($data);
        }
    }

    // API

    public function allUserApi(Request $request, $id = null)
    {
        if (!empty($id)) {
            $data = User::where('id', $id)->first();
        } else {
            $data = User::whereNull('deleted_at')->get();
        }
        return response()->json($data);
    }
}
