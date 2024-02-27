<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Ads;
use App\Models\Customer;
use App\Models\State;
use App\Models\City;
use App\Models\Chat;
use App\Models\Setting;
use Hash;
use Session;
use Auth;
use DB;
Use Image;

class UserController extends Controller
{
   
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function login()
    {

        $title = "Login";
        return view('frontend/login',compact('title'));
    }

    public function login_post(Request $request)
    {
        $this->validate($request, [
            'email'                  => 'required',
            'password'             => 'required',
        ]);
        $email = $request->email;
        $password = $request->password;
        $user = Customer::where("email",$email)->first();
        if($user->status == '1')
        {
            if($user){
                Hash::check($request->password, $user->password);
                if (Hash::check($password, $user->password)) {

                    Session::put('customer_id', $user->id);
                    Session::put('customer_name', $user->first_name);
                    Session::put('profile_image', $user->profile_image);
                    Session::flash('success', 'Login Success.');
                    return redirect('')->with('success', 'Login Success.');
                 }
                 else{
                    Session::flash('error', 'Password Does not Match.');
                    return redirect('user/login');
                 }
            }
            else{
              
                Session::flash('error', 'Email Does not Match.');
                 return redirect('user/login');
             }
        }
        else{
          
            Session::flash('error', 'Your account are disabled ');
             return redirect('user/login');
        }

        
    }

     public function register()
    {
        $title = "Register";
        return view('frontend/register',compact('title'));
    }

     public function register_post(Request $request)
    {


        $this->validate($request, [
            'email'                  => 'required|unique:customer,email',
            'password'             => 'required',
        ]);
        $data = $request->all();
        $data['status'] = 1;
        $data['password'] = Hash::make($request->password);
        //echo "<pre>";print_r($data);die;
        $customer = new Customer;           
        $id = $customer->create($data)->id;

        Session::put('customer_id', $id);
        Session::put('customer_name', $request->first_name);
        Session::put('profile_image', "");

        Session::flash('success', 'Your account Register Successfully. You can login now');
        return redirect('');
        
    }

    public function get_cities_by_id($id)
    {
        $cities = City::where('state_id',$id)->get();

        if($cities){
          $options = '<option value="">Select City</option>';
              foreach($cities as $city){
                  $options  .= '<option value="'.$city->id.'">'.$city->city_name.'</option>';
              }
        echo $options;
      }
    }


    public function forget_password()
    {
        $title = "Forget Password";
        return view('frontend/forget_password',compact('title'));
    }

     public function forget_password_post(Request $request)
    {
        $data = $request->all();
        $email = $data['email'];
        $customer = Customer::where('email',$email)->first();    
        if($customer){

            $setting = Setting::first();
            $otp = mt_rand(1000000000000,99999999999999);
            Customer::where("email",$email)->update(['otp' => $otp]);


            $subject = "Reset Password Link";
            $html =  view('forget_password_link',compact('setting','customer'))->render();
            //echo $html;die;
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // More headers
            $headers .= 'From: <'.$setting->company_email.'>' . "\r\n";
            mail($email,$subject,$html,$headers);

            Session::flash('success', 'Please check your email. We sent reset password link.');
            return redirect('user/forget_password');
        }
        else{
             Session::flash('error', 'Email does not exits.');
             return redirect('user/forget_password');
        }
        
    }

    public function reset_password($otp)
    {
        $customer = Customer::where('otp',$otp)->first();    
        if($customer){
            $title = "Reset Password";
            return view('frontend/reset_password',compact('title','customer'));
        }
        else{
            Session::flash('error', 'Link Expired.');
            return redirect('user/forget_password');

        }
    }


    public function reset_password_post(Request $request)
    {
        $data = $request->all();

        if($data['password']  == $data['cpassword']){
            Customer::where('otp', $data['otp'])->update( array('password' => Hash::make($data['password'])));
            Session::flash('success', 'Your Password is reset successfully. Please login');
            return redirect('user/login');
        }
        else{
            Session::flash('error', 'Password does not match.');
            return redirect('user/reset_password/'.$data['otp']);
        }
    }
    
    public function dashboard()
    {
        $customer_id = $this->get_id();
        if($customer_id == "") return redirect("user/login");
        $title = "Dashboard";
        return view('frontend.dashboard', compact('title'));
    }


    public function profile()
    {
        $customer_id = $this->get_id();
        if($customer_id == "") return redirect("user/login");
        
        $title = "Profile";
        $customer = Customer::where("id",$customer_id)->first();
        return view('frontend.profile', compact('title','customer'));
    }

    public function update_profile(Request $request)
    {
        $customer_id = $this->get_id();
        if($customer_id == "") return redirect("user/login");
        
        $this->validate($request, [
            'first_name'        => 'required',
            'profile_image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        $customer_image = "";
        if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $customer_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/customer');
                $image->move($destinationPath, $customer_image);
                $data['profile_image'] = $customer_image;

                Session::put('profile_image', $customer_image);
        }


        $customer = Customer::find($customer_id);          
        $customer->update($data);

        Session::put('customer_name', $request->first_name);
        Session::flash('message', 'Successfully Saved.');
        return redirect('profile');
    }

    public function ads()
    {
        $customer_id = $this->get_id();
        if($customer_id == "") return redirect("user/login");
        $title = "Ads Listing";

        $ads_listing = Ads::select('ads.*','city.city_name','category.category_name','ads_image.image_name')
              ->leftJoin('city', function($join) 
              {
                $join->on('city.id', '=', 'ads.city_id');
              })
              ->leftJoin('category', function($join) 
              {
                $join->on('category.id', '=', 'ads.category_id');
               })
              ->leftJoin('ads_image', function($join) {
                  $join->on('ads_image.ads_id', '=', 'ads.id');
               })
              ->groupBy('ads.id')
              ->where("customer_id",$customer_id)
              ->orderBy('ads.id','desc')
              ->get();
        return view('frontend.ads', compact('title','ads_listing'));
    }
   

    public function chat(Request $request)
    {
        $slug = $request->ads;
       $customer_id = $this->get_id();
        if($customer_id == "") return redirect("user/login");
        
        $chats = Chat::select('chat.*','ads.ads_name','ads.ads_image','s.first_name as sender_name','r.first_name as receiver_name','ads_image.image_name')
         ->join('ads', function($join) {
            $join->on('chat.ads_id', '=', 'ads.id');
          })
         ->leftJoin('customer as s', function($join) {
            $join->on('s.id', '=', 'chat.sender_id');
          })
         ->leftJoin('customer as r', function($join) {
            $join->on('r.id', '=', 'chat.receiver_id');
          })
          ->leftJoin('ads_image', function($join) {
                  $join->on('ads_image.ads_id', '=', 'ads.id');
               })
        ->where("sender_id",$customer_id)
        ->orWhere("receiver_id",$customer_id)
        ->orderBy('chat.id','desc')
        ->groupBy('ads.id',DB::raw('if (chat.sender_id = '.$customer_id.', chat.receiver_id, chat.sender_id)'))
        ->get();
        //pr($chats);
        $title = "Chat";
        $ads = array();
        if($slug){
           $ads = Ads::select('ads.*','ads_image.image_name','customer.first_name')
              ->leftJoin('ads_image', function($join) {
                  $join->on('ads_image.ads_id', '=', 'ads.id');
                })
               ->Join('customer', function($join) {
                  $join->on('customer.id', '=', 'ads.customer_id');
                })
              ->where('ads.ads_slug',$slug)
              ->where('ads_status',1)
              ->first();
        }
        //pr($ads);die;
        return view('frontend.chat', compact('title','chats','customer_id','ads'));
    }


    public function chat_history(Request $request)
    {
        $customer_id = Session::get('customer_id');
        $ads_id = $request->ads_id;
        $customer_id  = $this->get_id();
        $receiver_id = $request->receiver_id;

        if($ads_id)
        {

            $data['message_to_read'] = 1;

            Chat::where('ads_id',$ads_id)
                 ->where('receiver_id',$customer_id)
                 ->update($data);
        }        

        $history = Chat::select('chat.*')
                    ->where("ads_id",$ads_id)
                    ->Where(function($query) use ($customer_id){
                                 $query->where('sender_id', '=', $customer_id);
                                 $query->orWhere('receiver_id', '=', $customer_id); 

                             })
                    ->Where(function($query) use ($receiver_id){

                        $query->where('sender_id', '=', $receiver_id);
                         $query->orWhere('receiver_id', '=', $receiver_id);
                     })

                    ->orderBy("id",'asc')
                    ->get();
        $ads = array();
         if($ads_id){
           $ads = Ads::select('ads.*','ads_image.image_name','customer.first_name')
              ->leftJoin('ads_image', function($join) {
                  $join->on('ads_image.ads_id', '=', 'ads.id');
                })
               ->Join('customer', function($join) {
                  $join->on('customer.id', '=', 'ads.customer_id');
                })
              ->where('ads.id',$ads_id)
              ->where('ads_status',1)
              ->first();
        }
        //        ->orWhere("receiver_id",$customer_id)
        //echo "<pre>";print_r($results);die;
         return view('frontend.chat_history', compact('history','customer_id','ads'));
    }

    public function send_message(Request $request){

        $data = $request->all();

        $ads_id = $request->ads_id;
        $sender_id = $request->sender_id;
        $receiver_id = $request->receiver_id;
        $message = $request->message;

        $data = array(
                    'ads_id'             => $ads_id,
                    'sender_id'          => $sender_id,
                    'receiver_id'        => $receiver_id,
                    'message'            => $message
        );
        $chat = new Chat;
        $chat->create($data);
        $response = ["message" => " Added successfully"];
        return response($response, 200);
    }




    public function change_password()
    {
        $title = "Change Password";

        return view ('frontend.change_password', compact('title'));
    }

    public function change_password_post(Request $request)
    {

        $this->validate($request, [
            'old_password'  => 'required',
            'new_password'  => 'required',
            'cnew_password' => 'required'

        ]);

        $data = $request->all();

        $customer_id = $this->get_id();
        $get_pass = Customer::where('id', $customer_id)->first();
        

        if(Hash::check($request->old_password, $get_pass->password))
        {
            if($data['new_password'] == $data['cnew_password']) 
            {
                //echo "----1"; die;
                Customer::where('id', $customer_id)->update( array('password' => Hash::make($data['new_password'])));
                Session::flash('success', 'Your account Password Canged Successfully.');  
                return redirect('user/profile');       
            }
            else
            {
                //echo "----2";die;
                 Session::flash('error', 'Your account Password Not Matching');
                 return redirect('user/change_password');
            }
        
        }
        else
        {
            Session::flash('wrong', 'Incorrect Current Password');
            return redirect('user/change_password');
        }

     
       
    }

    public function logout()
    {
        Session::flush();
        return redirect('user/login');
    }


    public function get_id(){
       return Session::get('customer_id');
    }
}