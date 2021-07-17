<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cookie;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
public $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content=$content;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
     { $token=$this->content['token']["token"];
        if($this->content['view']=="confirm_pass"){
            // dd($this->content);
            //'Xác nhận mật khẩu mật khẩu ecommerce laravel'
            $token_forget=json_decode(Cookie::get('token_forget'));
            // echo"<pre>";
            // var_dump($token); 
            // die;
            return $this->subject($this->content['title'])->view('email.confirm_pass',compact("token_forget",'token'));
        }
        return $this->subject('ecommerce laravel')->view('welcome');
    }
}
