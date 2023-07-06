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
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
            if (!$user->otp_verified) {
                return $this->sendError('Unauthorised.', ['error' => 'OTP not verified.'],404);
            }
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['first_name'] = $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['username'] = $user->username;
            $success['phone_no'] = $user->phone_no;
            $success['email'] = $user->email;
            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'],404);
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
                    $user->otp_verified = true;
                    $user->save();
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
                $userKyc = UserKYC::updateOrCreate(
                    ['user_id' => $user->id],
                    []
                );
                if ($request->hasFile('logo')) {
                    $logo = $request->file('logo');
                    $logoName = time() . '.' . $logo->getClientOriginalExtension();
                    $logo->storeAs('public/userkyc', $logoName);
                    $userKyc->logo = $logoName;
                }

                if ($request->hasFile('business_registration')) {
                    $registration = $request->file('business_registration');
                    $registrationName = time() . '.' . $registration->getClientOriginalExtension();
                    $registration->storeAs('public/userkyc', $registrationName);
                    $userKyc->business_registration = $registrationName;
                }

                if ($request->hasFile('business_license')) {
                    $license = $request->file('business_license');
                    $licenseName = time() . '.' . $license->getClientOriginalExtension();
                    $license->storeAs('public/userkyc', $licenseName);
                    $userKyc->business_license = $licenseName;
                }
                if ($request->hasFile('profile_photo')) {
                    $profile = $request->file('profile_photo');
                    $profileName = time() . '.' . $profile->getClientOriginalExtension();
                    $profile->storeAs('public/userkyc', $profileName);
                    $userKyc->profile_photo = $profileName;
                }
                if ($request->hasFile('national_id')) {
                    $national = $request->file('national_id');
                    $nationalName = time() . '.' . $national->getClientOriginalExtension();
                    $national->storeAs('public/userkyc', $nationalName);
                    $userKyc->national_id = $nationalName;
                }

                $userKyc->save();
                return $this->sendResponse([], 'User KYC Document Uploaded successfully.');

            }else {
                return $this->sendError('User not Found', [], 404);

            }

        } catch (Exception $e) {
            return $this->sendError('Error occurred during Uploading KYC Document.', [], 404);

        }
    }
    public function forgetPassword(Request $request)
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
            Mail::to($email)->send(new ForgetPasswordMail($otp));
            // Save the OTP to the user's record in the database or any other storage
            $user = User::where('email', $email)->first();
            $user->otp = $otp;
            $user->save();
            return $this->sendResponse([], 'Otp Genrated successfully,Kindly check your Email');

        } catch (Exception $e) {
            return $this->sendError('Error occurred during Forget Password Process.', [], 404);

        }
    }
    public function resetPassword(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validation->fails()) {
                return $this->sendError('Validation Error.', $validation->errors());
            }

            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::where('email', $email)->first();

            if (!$user) {
                return $this->sendError('User not found.', [], 404);
            }

            // Update the user's password
            $user->password = bcrypt($password);
            $user->save();

            return $this->sendResponse([], 'Password reset successful.');

        } catch (Exception $e) {
            return $this->sendError('Error occurred during Password Reset Process.', [], 404);
        }
    }

}
