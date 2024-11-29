<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeMail;
use App\Models\Subscribe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscribeController extends Controller
{
    public function index()
    {
        return view('subscribe');
    }

    public function subscribe(Request $request)
    {
        try {
            $email = $request->input('email');
            Mail::to($email)->send(new SubscribeMail($email));
            Subscribe::create(['email' => $email]);

            return back()->with('success', 'Thank you for subscribing!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->with('error', "Can't subscribe. Please try again!");
        }
    }
}
