<?php
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Hash;
use Illuminate\View\View;
use Validator;
use Illuminate\Http\RedirectResponse;
  
class AuthController extends Controller
{
  
    protected $user;
   
    function __construct() {
        $this->user = auth('sanctum')->user() ? auth('sanctum')->user()->id:null;
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(): View
    {
        return view('auth.register');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('admin');
        }
  
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
        Auth::loginUsingId($check->id);
        return redirect('dashboard');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            $stores = Store::count();
            return view('dashboard',compact(['stores']));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role_id' => 2
      ]);
    }
    
    /**
     * Edit Profile
     */
    public function edit_profile(){
        $customers = User::where('role_id',2)->count();
        $vendors = User::where('role_id',3)->count();
        $products = Product::where('is_contribution',0)->count();
        return view('admin.profile.edit',compact(['customers','vendors','products']));
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
                'address' => 'required'
            ]);
    
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
         
            $user = User::findOrFail(Auth::user()->id);
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->address = $input['address'];
            $user->save();
            
            return redirect()->back()->with('status', 'Profile updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('status', $th->getMessage());
        }
    }

    /**
     * Update Profile
     */
    public function update_password(Request $request){
        try {

            $request->validate([
                'old_password' => 'required',
                'password' => 'required|confirmed',
            ]);
        
            $user = Auth::user();
        
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->with('password_status', 'Your current password does not match the one you provided.');
            }
        
            $user->password = Hash::make($request->password);
            $user->save();
        
            return redirect()->back()->with('password_status', 'Password updated successfully!');
        } catch (\Throwable $th) {
            return view('admin.profile.edit',compact(['error'=>$th->getMessage()]));
        }
    }
    /**
     * Update Image
     */
    public function update_image(Request $request) {
        // Validate the request if necessary
        if ($request->hasFile('image')) {

            $newImagePath = time().'.'.$request->image->extension();  
            $request->image->storeAs('public/images', $newImagePath);
            // Assuming you are updating the image path in the database
            $user = Auth::user();
            $user->image = $newImagePath;
            $user->save();

            // Return a response with the new image URL
            return response()->json(['image_url' => asset('storage/' . $newImagePath)]);
        }
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}