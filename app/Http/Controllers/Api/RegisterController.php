<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Models\User;
use App\Models\UserKYC;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;


class RegisterController extends ApiBaseController
{
    public function register(Request $request)
    {

        try {
            $validation = Validator::make($request->all(), User::$rules);

            if ($validation->fails()) {
                return $this->sendError('Validation Error.', $validation->errors());
            }
            $input = $request->all();
            // Check if email already exists
            $existingUser = User::where('email', $input['email'])->first();
            if ($existingUser) {
                return $this->sendError('Email already exists. Please use a different email address.', [], 404);
            }
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['first_name'] = $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['username'] = $user->username;
            $success['phone_no'] = $user->phone_no;
            $success['email'] = $user->email;

            return $this->sendResponse($success, 'User registered successfully.');
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during registration.', [], 404);

        }
    }
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['first_name'] = $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['username'] = $user->username;
            $success['phone_no'] = $user->phone_no;
            $success['email'] = $user->email;
            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during Login.', [], 404);
        }
    }

    public function generateOtp(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);
            if ($validation->fails()) {
                return $this->sendError('Validation Error.', $validation->errors());
            }
            $email = $request->input('email');
            $otp = mt_rand(100000, 999999); // Generate a random 6-digit OTP
            Mail::to($email)->send(new OtpMail($otp));
            // Save the OTP to the user's record in the database or any other storage
            $user = User::where('email', $email)->first();
            $user->otp = $otp;
            $user->save();
            return $this->sendResponse([], 'Otp Genrated successfully,Kindly check your Email');
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during generateOtp.', [], 404);
        }
    }


    public function matchOtp(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|email',
                'otp' => 'required',
            ]);
            if ($validation->fails()) {
                return $this->sendError('Validation Error.', $validation->errors());
            }
            $email = $request->input('email');
            $otp = $request->input('otp');

            // Retrieve the user's record from the database or any other storage
            $user = User::where('email', $email)->first();

            if ($user && $user->otp == $otp) {

                return $this->sendResponse([], 'OTP matched successfully.');

            } else {
                // OTP does not match or user not found, return an error response
                return $this->sendError('Invalid OTP.', [], 404);
            }
        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during matchOtp.', [], 404);
        }
    }

    public function resendOtp(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);
            if ($validation->fails()) {
                return $this->sendError('Validation Error.', $validation->errors());
            }
            $email = $request->input('email');
            $user = User::where('email', $email)->first();
            if ($user) {
                $otp = $user->otp;
                Mail::to($email)->send(new OtpMail($otp));
                return $this->sendResponse([], 'Otp Resend successfully.');

            } else {
                return $this->sendError('User not Found', [], 404);

            }

        } catch (Exception $e) {
            // Handle the exception
            return $this->sendError('Error occurred during resendOtp.', [], 404);
        }
    }

    public function updateaccountUsage(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|email',
                'account_usage' => 'required|string',
            ]);
            if ($validation->fails()) {
                return $this->sendError('Validation Error.', $validation->errors());
            }
            $email = $request->input('email');
            $accountUsage = $request->input('account_usage');

            $user = User::where('email', $email)->first();
            if ($user) {
                $user->account_usage = $accountUsage;
                $user->save();
                return $this->sendResponse([], 'Account Usage Updated successfully.');

            } else {
                return $this->sendError('User not Found', [], 404);

            }
        } catch (Exception $e) {
            return $this->sendError('Error occurred during Update Account Usage.', [], 404);

        }
    }
    public function uploadKYC (Request $request)
    {
        try {
            $validation = Validator::make($request->all(), UserKYC::$rules);

            if ($validation->fails()) {
                return $this->sendError('Validation Error.', $validation->errors());
            }
            $email = $request->input('email');
            $user = User::where('email',$email)->first();
            if ($user)
            {
                UserKYC::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'logo' => $request->input('logo'),
                        'business_registration' => $request->input('business_registration'),
                        'business_license' => $request->input('business_license'),
                    ]
                );
                return $this->sendResponse([], 'User KYC Document Uploaded successfully.');

            }else {
                return $this->sendError('User not Found', [], 404);

            }

        } catch (Exception $e) {
            return $this->sendError('Error occurred during Uploading KYC Document.', [], 404);

        }
    }
}
