<?php

namespace App\Http\Controllers\email;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailControllers extends Controller
{

    public function Send($address, $content)
    {
        foreach ($address as $addres) {
            Mail::to($addres)->queue(new SendMail($content));
        }
    }

    public function sendemail(Request $request)
    {
        $users = DB::table('users')->where("email", $request->email)->first();

        if (!isset($users->email) || empty($users->email)) { // check email exists
            return redirect()->back()->with('erros', 'Email không tồn tại!');
        }
        if (!isset($users->status) || $users->status != 1) { // check status account when status != 1
            return redirect()->back()->with('erros', 'Tài khoản bị tạm ngưng vui lòng liên hệ admin !');
        }
        if (!isset($users->is_manage) || $users->is_manage != 1) { // check manager account when is_manage = 1
            return redirect()->back()->with('erros', 'Tài khoản không được quyền truy cập!');
        }
        $minutes = 300;
        $token = Hash::make(rand(100000, 9999999));
        $address = ["phuongddph10045@fpt.edu.vn"];
        $token_forget=["token"=>$token,"address"=>$address];
       Cookie::queue('token_forget',json_encode($token_forget), $minutes);
        $content = [
            'view' => "confirm_pass",
            'title' => "Xác nhận mật khẩu mật khẩu ecommerce laravel",
            'body' => $token,
            'token'=>$token_forget,
        ];
         SendMailControllers::Send($address,$content);
         echo "<pre>";
        var_dump(Cookie::get('token_forget'));
       return redirect("auth/login");
      
    }
}
