<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use DB; 
use Carbon\Carbon; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = $input['role'];
        $input['is_social'] =  0;
        $user = User::create($input);
        $success['token'] =  $user->createToken('construction')->plainTextToken;
        $success['id'] =  $user->id;
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        $success['role'] =  getRole($user->role_id)->name;
   
        return $this->sendResponse($success, trans('auth.register'));
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
       
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('construction')->plainTextToken; 
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            $success['is_social'] =  0;
            $success['role'] = getRole($user->role_id)->name;
   
            return $this->sendResponse($success, trans('auth.login'));
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForget(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $tokenData = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->first();

        if ($tokenData) {
            return $this->sendResponse($request->email, trans('auth.email_already_sent'));
        }
        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return $this->sendResponse($request->email, trans('auth.forgot_password_email'));
    }
   /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
                            ->where([
                            'email' => $request->email, 
                            'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

        return redirect('/')->with('message', 'Your password has been changed!');
    }

    /**
     * Social login api
    */
    public function social_login(Request $request) {
        try {
            // Validate the request data
            $request->validate([
                'login_type' => 'required',
            ]);
            // Check if the user already exists
            $user = User::where('email', $request->email)
                        ->where('is_social','<>',0)
                        ->where('login_type','<>','manual')->first();
            if ($user) {
                // User exists, log them in and generate a token
                $token = $user->createToken('construction')->plainTextToken;
            } else {
                if ($request->hasFile('image')) {
                    $imageName = time().'.'.$request->image->extension();  
                    $request->image->storeAs('public/images', $imageName);
                }
                // User does not exist, create a new account
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role_id' => 2,
                    'image' => $imageName,
                    'social_id' => $request->social_id,
                    'is_social' => 1,
                    'login_type' => $request->login_type
                ]);
              
                // Generate a token
                $token = $user->createToken('construction')->plainTextToken;
            }
            $responseData = [
                'token' => $token,
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_social' => $user->is_social,
                'role' => getRole($user->role_id)->name
            ];
            // Return response with token and user data
            return $this->sendResponse($responseData  , trans('auth.login'));
        } catch (\Throwable $th) {
            return $this->sendResponse('Unauthorised'  , trans('auth.login'));
        }
    }
    
    /**
     * Update Profile
     */
    public function update_profile(Request $request){
        try {

            $input = $request->all();
    
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required',
                'image' => 'required'
            ]);
    
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }

            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();  
                $request->image->storeAs('public/images', $imageName);
            }

            $user = User::findOrFail(auth()->user()->id);
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->image = $imageName;
            $user->save();
            
            $user->image = asset(Storage::url('images/' . $user->image));
            return $this->sendResponse($user, trans('messages.update_profile'));
        } catch (\Throwable $th) {
            return $this->sendError('Unauthorised.', ['error'=>$th->getMessage()]);
        }
    }

    /**
     * Get Profile
     */
     public function get_profile() {
        try {
            $get_profile = User::where('id',auth()->user()->id)->first();
            if($get_profile){
                $get_profile->image = asset(Storage::url('images/' . $get_profile->image));
                return $this->sendResponse($get_profile, trans('messages.get_profile'));
            }
            return $this->sendResponse([], trans('messages.no_profile'));
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.', ['error'=>$th->getMessage()]);
        }
     }

}
