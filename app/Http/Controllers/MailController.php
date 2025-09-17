<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail()
    {
        Mail::to('receiver@example.com')->send(new WelcomeMail());
        return "Email sent successfully via Postmark!";
    }
}
