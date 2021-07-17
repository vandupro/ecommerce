<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Authentication extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        session_start();
        $this->user = $user;
    }
    public function login_get()
    {
        return view('admin.auth.login');
    }
    public function login_post(Request $request)
    {
        $users = DB::table('users')->where("email", $request->email)->first();

        if (!isset($users->email) || empty($users->email)) { // check email exists

            return redirect()->back()->with('status', 'Email không tồn tại!');
        }
        if (!isset($users->status) || $users->status != 1) { // check status account when status != 1
            return redirect()->back()->with('status', 'Tài khoản bị khóa vui lòng liên hệ admin !');
        }
        if (!isset($users->is_manage) || $users->is_manage != 1) { // check manager account when is_manage = 1
            return redirect()->back()->with('status', 'Tài khoản không được quyền truy cập!');
        }
        if (!isset($users->password) || Hash::check($request->password, $users->password) === false) { // check passworrd account
            return redirect()->back()->with('status', 'Tài khoản nhập không đúng!');
        }
        session(['admin_login' => $users]); //store the user's data into the session
        if (isset($request->remember) && $request->remember == "on") {
            $minutes = 3600 * 30;
            $hash = $users->id . $users->email . $request->_token;
            $cookieValue = Hash::make($hash);
            Cookie::queue('admin_login_remember', $cookieValue, $minutes);
            // update phiên token vào phiên làm việc vào database
            /// $this->user->find($users->id)->update(['remember_token' => $cookieValue]);

            try {
                DB::beginTransaction();
                DB::table('users')->where('id', $users->id)->update(['remember_token' => $cookieValue]);
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
            }
        }
        $Cookie_user = Cookie::get('admin_login_remember');
        return redirect("/");
    }
    public function login_out(Request $request)
    {
        Cookie::queue('admin_login_remember', "", -3600);
        Cookie::queue('token_forget', "", -3600);
        $request->session()->forget('admin_login');
        $request->session()->flush();
        return redirect()->back();
    }


    public function forgot()
    {
        return view('admin.auth.forgot');
    }



    public function new_password(Request $request)
    {
        $token_forget = json_decode(Cookie::get('token_forget')) == true ? json_decode(Cookie::get('token_forget')) : "";
        // echo"<pre>";
        // var_dump( $token_forget->address); 
        //  dd( session()->get('admin_login2'),session('admin_login'));
        if (!empty($_REQUEST['tp']) &&!empty($token_forget->token)&& ($_REQUEST['tp'] == $token_forget->token)) {
            return view('admin.auth.new_pass');
        }
        return redirect('auth/login');
    }

    public function strore_password(Request $request)
    {
        // validator
        $rules = [
            'password' => 'required|max:100|min:4',

        ];
        $messages = [
            'password.required' => 'Mời nhập mập khẩu người dùng!',
            'password.max' => 'mập khẩu  không quá 100 ký tự!',
            'password.min' => 'mập khẩu  ít nhất 4 ký tự!',

        ];
        $validator = $request->validate($rules, $messages);

        $token_forget = json_decode(Cookie::get('token_forget')) == true ? json_decode(Cookie::get('token_forget')) : "";
        $users = DB::table('users')->where("email", $token_forget->address)->first();
        $request->password = Hash::make($request->password);
        DB::table('users')->where('id', $users->id)->update(['password' => $request->password]);
        try {
            DB::beginTransaction();
            
            DB::commit();
            Cookie::queue('token_forget', "", -300);
            return redirect("auth/login");
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
        }

    }
}
