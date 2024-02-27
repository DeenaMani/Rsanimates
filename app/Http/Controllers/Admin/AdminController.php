<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Hash;
use Session;
use Auth;
use DB;


class AdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if(Auth::check()) {
            return redirect('admin/dashboard');
        }

        return view('admin.login');
    }


    public function login()
    {
        if(Auth::check()) {
            return redirect('admin/dashboard');
        }

        return view('admin.login');
    }

    public function check_login(Request $request)
    {
         $this->validate($request, [
          'email'   => 'required|email',
          'password'  => 'required|min:3'
         ]);
         
         $user_data = array(
              'email'  => $request->get('email'),
              'password' => $request->get('password')
         );

         if(Auth::attempt($user_data))
         {
          return redirect('admin/dashboard');
         }
         else
         {
          return back()->with('error', 'Wrong Login Details');
         }

    }

    public function dashboard()
    {
        if(Auth::check() == "") {
            return redirect('admin/login');
        }
        $title = "Dashboard";
        $a_name = Auth::user()->name;
        
        Session::put('admin_name', $a_name);

            $month['January'] = 0;
            $month['February'] = 0;
            $month['March'] = 0;
            $month['April'] = 0;
            $month['May'] = 0;
            $month['June'] = 0;
            $month['July'] = 0;
            $month['August'] = 0;
            $month['September'] = 0;
            $month['October'] = 0;
            $month['November'] = 0;
            $month['December'] = 0;


         $customers = Customer::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as month"))
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('month')
                        ->get();

                        if($customers){
        foreach ($customers as $key => $customer) {
            if($customer->month == "January") {
                        $month['January'] = $customer->count;            
            }

            if ($customer->month == "February" ) {
                       $month['February']  = $customer->count;            
            }

             if ($customer->month == "March") {
                        $month['March'] = $customer->count;            
            }
            
             if ($customer->month == "April") {
                       $month['April'] = $customer->count;            
            }

             if ($customer->month == "May") {
                     $month['May']  = $customer->count;            
            }

             if ($customer->month == "June") {
                       $month['June'] = $customer->count;            
            }

             if ($customer->month == "July") {
                       $month['July'] = $customer->count;            
            }

             if ($customer->month == "August") {
                       $month['August'] = $customer->count;            
            }

             if ($customer->month == "September") {
                       $month['September'] = $customer->count;            
            }

            if ($customer->month == "October") {
                       $month['October'] = $customer->count;            
            }

            if ($customer->month == "November") {
                       $month['November'] = $customer->count;            
            }

            if ($customer->month == "December") {
                       $month['December'] = $customer->count;            
            }     
        }
    }
        //Items report monthwise

            $months['January'] = 0;
            $months['February'] = 0;
            $months['March'] = 0;
            $months['April'] = 0;
            $months['May'] = 0;
            $months['June'] = 0;
            $months['July'] = 0;
            $months['August'] = 0;
            $months['September'] = 0;
            $months['October'] = 0;
            $months['November'] = 0;
            $months['December'] = 0;


        return view('admin.dashboard', compact('title', 'month', 'months'));
    }

    public function change_password()
    {
        $this->middleware('auth');
        $token = Auth::user()->email;
        $title = "Change Password";
        return view('admin/change_password', compact('title'));
    }
    public function update(Request $request)
    {
        $this->middleware('auth');
         $token = Auth::user()->email;
           $this->validate($request, [
             'email'      =>  'email','E-Mail','trim|required',
            'password'      =>  'password','Password','trim|xss_clean|required|min_length[4]|max_length[32]',
        ]);
          $title = "Change Password";
          if($request->password !== $request->password_confirmation){
            Session::flash('message',  "Something Went Wrong, Password Not Changed");
            return view('account/account/change_password', compact('title'));
          }
            $email = Auth::user()->email;
            $users = User::where('email',$request->email)->first();
            if($users){
            $users->password = Hash::make($request->get('password'));
            $users->save();
            }
            else {
        Session::flash('message',  "Something Went Wrong, Password Not Changed");
            }
            return view('account/account/change_password', compact('title'));
    }
    public function destory(){
        // echo 'ddd';die;
        Auth::logout();
        Session::flush();
        return redirect('admin/login');
    }

    public function show($value='')
    {
      # code...
    }



}
