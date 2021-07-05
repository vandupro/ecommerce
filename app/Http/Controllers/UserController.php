<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private $user;
    private $role;
    public function __construct(User $user, Role $role)
    {

        $this->user = $user;
        $this->role = $role;
    }
    public function index()
    {
        $roles = $this->role->all();
        return view('admin.pages.users.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role->all();
        return view("admin.pages.users.add", compact('roles'));
    }
    public function ajax()
    {
        $users = DB::table('roles')
            ->join('roles_users', 'roles.id', '=', 'roles_users.role_id')
            ->join('users', 'users.id', '=', 'roles_users.user_id')
            ->where('roles.id', '=', $_REQUEST['id'])
            ->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // validator
        $rules = [
            'name' => 'required|max:100|min:4',
            'phone_number' => 'required|min:9|numeric',
            'profile' => 'required|max:500|min:4',
            'image' => 'required|mimetypes:image/jpeg,image/png|max:2048',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|max:100|min:4',

        ];
        $messages = [
            'name.required' => 'Mời chọn tên người dùng!',
            'name.max' => 'tên người dùng không quá 100 ký tự!',
            'name.min' => 'tên người dùng  ít nhất 4 ký tự!',
            'phone_number.required' => 'Mời nhập số điện thoại',
            'phone_number.min' => 'số điện thoại ít nhất 9 chữ số',

            'phone_number.numeric' => 'số điện thoại không đúng',
            'profile.required' => 'Mời nhập mô tả người dùng!',
            'profile.max' => 'Mô tả  không quá 500 ký tự!',
            'profile.min' => 'Mô tả  ít nhất 4 ký tự!',
            'image.required' => 'Mời chọn ảnh',
            'image.mimetypes' => 'Ảnh không đúng định dang:jpeg /png /jpg ',
            'image.max' => 'Kích thước ảnh tối đa 2048 kb',
            'password.required' => 'Mời nhập mập khẩu người dùng!',
            'password.max' => 'mập khẩu  không quá 100 ký tự!',
            'password.min' => 'mập khẩu  ít nhất 4 ký tự!',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = User::where('email', $request->email)->get();

        if (isset($user[0]['email'])) { //có dữ liệu
            // dd($user);
            return redirect()->back()->with('erros', 'Email đã tồn tại !');
        }

        $pathAvatar = $request->file('image')->store('public/users');

        $pathAvatar = str_replace("public/", "", $pathAvatar);
        try {
            DB::beginTransaction();
            $user = $this->user->create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'profile' => $request->profile,
                'image' => $pathAvatar,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'intro' => "",
                'register_at' => date('Y-m-d'),
                'last_login' => date('Y-m-d'),

            ]);

            $user->roles()->attach($request->role_id); // upload create array to roles ===> 'attach'
            DB::commit();
            return redirect()->back()->with('status', 'Đăng ký thành công !');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = $this->user->find($_REQUEST['id']);

        $roles = $this->role->all();
        // dd($user);
        $roleOfuser = $user->roles;
        // dd($roleOfuser);
        return view("admin.pages.users.edit", compact('user', 'roles', 'roleOfuser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:100|min:4',
            'phone_number' => 'required|min:9|numeric',
            'profile' => 'required|max:500|min:4',
            'image' => 'mimetypes:image/jpeg,image/png|max:2048',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|max:100|min:4',

        ];
        $messages = [
            'name.required' => 'Mời chọn tên người dùng!',
            'name.max' => 'tên người dùng không quá 100 ký tự!',
            'name.min' => 'tên người dùng  ít nhất 4 ký tự!',
            'phone_number.required' => 'Mời nhập số điện thoại',
            'phone_number.min' => 'số điện thoại ít nhất 9 chữ số',

            'phone_number.numeric' => 'số điện thoại không đúng',
            'profile.required' => 'Mời nhập mô tả người dùng!',
            'profile.max' => 'Mô tả  không quá 500 ký tự!',
            'profile.min' => 'Mô tả  ít nhất 4 ký tự!',
            'image.mimetypes' => 'Ảnh không đúng định dang:jpeg /png /jpg ',
            'image.max' => 'Kích thước ảnh tối đa 2048 kb',
            'password.required' => 'Mời nhập mập khẩu người dùng!',
            'password.max' => 'mập khẩu  không quá 100 ký tự!',
            'password.min' => 'mập khẩu  ít nhất 4 ký tự!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user =  $this->user->find($id);

        if ($request->email != $user->email) { //có dữ liệu

            $usercheck = User::where('email', $request->email)->get();
            if (isset($usercheck[0]['email'])) { //có dữ liệu
                // dd($user);
                return redirect()->back()->with('erros', 'Email đã tồn tại !');
            }
        }
        $pathAvatar = "";
        $password = "";

        if ($request->file('image') != null) {
            unlink("storage/" . $user->image);
            $pathAvatar = $request->file('image')->store('public/users');
            $pathAvatar = str_replace("public/", "", $pathAvatar);
        } else {
            $pathAvatar = $user->image;
            // dd($pathAvatar);
        }
        try {
            DB::beginTransaction();
            $user->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'profile' => $request->profile,
                'image' => $pathAvatar,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'intro' => "",
                'register_at' => date('Y-m-d'),
                'last_login' => date('Y-m-d'),
            ]);

            $user->roles()->sync($request->role_id); // upload update array to role_user ===> 'sync'
            DB::commit();
            return redirect()->back()->with('status', 'Sửa thông tin ' . $request->name . ' thành công !');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = $this->user->find($_REQUEST['id']);
       unlink("storage/" . $user->image);
        $user->delete();
        return redirect()->back()->with('status', 'Bạn đã xóa' . $user->name . ' thành công !');
    }
}
