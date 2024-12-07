<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $url;
   
    public function __construct($url)
    {
        $this->url = $url;
    }

    public function build(){
        $subject = 'Thông báo từ hệ thống Pharmacity ';
        return $this->subject($subject)->view('emails.forgot_password')->with('url', $this->url);
    }
}
