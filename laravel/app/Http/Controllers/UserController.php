<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SenderMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\NewUserMail;

class UserController extends Controller
{
    // public function login(Request $request)
    // {
    //     if(auth()->attempt($request->only(['email', 'password'])))
    //     {
    //         $user = User::where('email', $request->email)->first();
    //         $otp = rand(100000, 999999);
    //         $updateResult = $user->update([
    //             'otp_code' => $otp,
    //         ]);

            

    //         $token = auth()->user()->createToken("tokens");
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Login Successfully',
    //             'user' => auth()->user(),
    //             'token' => $token->plainTextToken,
    //             'otp_code' => $otp,
                
              
                
    //         ]);
    //     }else{
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid Credentials',
    //         ]);
    //     }
    // }

    // public function login(Request $request)
    // {
    //     try {
    //         $validateUser = Validator::make(
    //             $request->all(),
    //             [
    //                 'email' => 'required|email',
    //                 'password' => 'required'
    //             ]
    //         );

    //         if ($validateUser->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validation error',
    //                 'errors' => $validateUser->errors()
    //             ], 401);
    //         }

    //         if (!Auth::attempt($request->only(['email', 'password']))) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Invalid credentials!',
    //             ], 401);
            

    //         }
    //         $user = User::where('email', $request->email)->first();
    //             if(empty($user)){
    //                 return response()->json([
    //                     'message' => '404 not found',
    //                 ], 404);
    //             }
    //         if(!Hash::check($request->password, $user->password)){
    //             return response()->json([
    //                 'message' => 'Invalid Credentials!',
    //             ], 404);
    //         }

    //             $otp = rand(100000, 99999);
    //             $updateResult = $user->update([
    //                 'otp_code' => $otp,
    //             ]);

    //             // Semaphore //
    //             $response = Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
    //                 'apikey' => env('SEMAPHORE_KEY'),
    //                 'number' => '09945364846',
    //                 'message' => 'This is you OTP Code'.$otp,
    //             ]);
    //             // End of Semaphore // 

    //             if($response->successful()){
    //                 return response()->json([
    //                     'status' => true,
    //                     'message' => 'OTP Sent Successfully!',
    //                     'otp_code' => $otp,
    //                     'token' => $user->createToken("API TOKEN")->plainTextToken,
    //                 ], 200);
    //             } else {
    //                 return response()->json([
    //                     'status' => false,
    //                     'message' => 'Failed to Send OTP',
    //                 ], 500);
    //             }
            
            
    //         $token = auth()->user()->createToken('token');
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User Authenticated successfully',
    //             'token' => $token->accessToken,
    //             'user' => auth()->user(),
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $th->getMessage()
    //         ], 500);
    //     }
    // }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials!',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            if (empty($user)) {
                return response()->json([
                    'message' => '404 not found',
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid Credentials!',
                ], 401);
            }

            // Generate OTP and update the user
            $otp = rand(100000, 999999); // Fixed the OTP range
            $updateResult = $user->update([
                'otp_code' => $otp,
            ]);

            // Send OTP via Semaphore
            $response = Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
                'apikey' => env('SEMAPHORE_KEY'),
                'number' => $user->contact_number, // Ensure this is the correct field for the user's phone number
                'message' => 'This is your OTP Code: ' . $otp,
            ]);

            Log::info('Semaphore Response: ', $response->json());

            if ($response->successful()) {
                return response()->json([
                    'status' => true,
                    'message' => 'OTP Sent Successfully!',
                    'otp_code' => $otp,
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'number' => $user->contact_number,
                    'mail' =>  Mail::to('kakaka@gmail.com')->send(new NewUserMail())  // Mailtrap Email // 
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Send OTP',
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    
    public function profile()
    {
        return view('profile.index');
    }
    public function index()
    {
        return view('users.index');
    }
    public function create()
    {
        return view('users.create');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    public function userList()
    {
        $user = User::all();

        return response()->json($user);
    }
    public function getUserId($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'status' => true,
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function createUser(Request $request)
    {
        try {

            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',


                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Create Failed!',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),


            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request, $id )
    {
        try {
            $user = User::findOrFail($id);
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    'password' => 'required',
                ]
            );

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Update Failed!',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Updated Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'User Deleted Successfully!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }   
    }
    
}




