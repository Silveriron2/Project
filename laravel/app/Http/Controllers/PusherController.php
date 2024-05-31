<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SenderMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\NewUserMail;
use App\Events\PusherBroadcast;

class PusherController extends Controller
{
    public function broadcast(Request $request)
    {
        // broadcast(new PusherBroadcast($request->get(key:'message')))->toOther();
        // return view('home.broadcast', ['message' = $request->get(key: 'message')]);
        // Process and return the received message as HTML
        
       event(new PusherBroadcast($request->message));
       return response()->json(['status' => 'Message broadcasted']);
    }
    public function receive(Request $request)
    {
        return view('home.receive', ['message' => $request->message]);
    }
}
