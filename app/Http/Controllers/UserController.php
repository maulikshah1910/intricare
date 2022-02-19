<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function browse(Request $request)
    {
        $query = User::query();

        $table = DataTables::of($query)
            ->addColumn('action', function ($user) {
                $actions = '';

                $actions .= '<button type="button" class="btn btn-sm btn-default btn-info" data-user="' . $user->id . '" data-info="' . route('users.info', ['id' => $user->id]) . '" ><i class="bi bi-eye-fill"></i></button>&nbsp;';
                $actions .= '<button type="button" class="btn btn-sm btn-warning btn-add-edit" data-user="' . $user->id . '" data-info="' . route('users.info', ['id' => $user->id]) . '"><i class="bi bi-pencil-fill"></i></button>&nbsp;';
                $actions .= '<button type="button" class="btn btn-sm btn-danger btn-delete" data-user="' . $user->id . '"><i class="bi bi-trash-fill"></i></button>&nbsp;';
                return $actions;
            })
            ->editColumn('gender', function ($user) {
                $trans = 'users.genders.' . $user->gender;
                return trans($trans);
            })
            ->editColumn('image', function ($user) {
                $imageURL = "";
                if (isset($user->image)) {
                    $imagePath = url('/uploads/users/');
                    $imageURL = $imagePath . '/' . $user->image;
                } else {
                    $imageURL = url('image/default-user.png');
                }
                $img = '<img src="' . $imageURL . '" class="user-image-td" alt="' . $user->name . '" />';

                return $img;
            })
            ->rawColumns(['action', 'gender', 'image']);

        return $table->make(true);
    }

    /**
     * Add or Update user info
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = User::validate($request->all());
        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'messages' => $validator->messages()
            ]);
        }

        try {
            DB::beginTransaction();
            if (isset($request->id)) {
                $user = User::find($request->id);
            } else {
                $user = new User();
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = substr(md5(time()), 1, 10) . "." . $file->getClientOriginalExtension();
                $uploadDir = public_path('uploads/users');
                if (!file_exists($uploadDir)) {
                    File::makeDirectory(public_path('uploads/users'), 0777, true);
                }
                $file->move($uploadDir, $filename);
                $user->image = $filename;
            }

            $user->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'id' => $user->id,
                'data' => $user
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     * Display user info
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user instanceof User) {
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('users.not_found')
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->has('id')) {
            return response()->json([
                'success' => false,
                'messages' => [
                    trans('users.not_found')
                ]
            ], 200);
        }
        try {
            DB::beginTransaction();
            $user = User::find($request->id);
            if (!$user instanceof User) {
                return response()->json([
                    'success' => false,
                    'messages' => [
                        trans('users.not_found')
                    ]
                ]);
            }
            $user->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => trans('users.user_deleted')
            ]);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'messages' => [
                    $ex->getMessage()
                ]
            ]);
        }
    }
}
