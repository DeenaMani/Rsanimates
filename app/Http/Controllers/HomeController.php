<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Banner;
use App\Models\Futures;
use App\Models\Clients;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\About;
use App\Models\Service;
use App\Models\Servicelist;
use App\Models\Contact;
use Hash;
use Session;
use Auth;
use DB;

class HomeController extends Controller
{
    
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $title ="Home";
        $banner = Banner::first();
        $home="1";
        $futures = Futures::where('futures_status',1)->get();
        $clients = Clients::where('clients_status',1)->get();
        return view('frontend.home',compact('title','banner','home','futures','clients'));
    }
    
    public function contact()
    {
       
        $title = "Contact Us";
        return view('frontend.contact', compact('title'));
    }

    public function post_contact(Request $request)
    {
       // return $request;
       $data['first_name']      = $request->first_name;
       $data['last_name']       = $request->last_name;
       $data['mobile']          = $request->mobile;
       $data['email']           = $request->email;
       $data['service_name']    = $request->service_name;
       $data['company_name']    = $request->company_name;
       $data['contact_message'] = $request->contact_message;
       
        if ($request->file('contact_image')) {
                $image = $request->file('contact_image');
                $contact_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/contact');
                $image->move($destinationPath, $contact_image);
                $data['contact_image'] = $contact_image; 
            }

       $contact = new Contact;
       $contact->create($data);
    
    $setting = Setting::first();
    $email = $data['email'];
    $subject = "Thanks for contacting us";
    $html    =  "<h5>Dear {$data['first_name']}</h5><p>We received your request. We will contact you soon.forget<br>Thanks for Contact Us.</p>";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <'.$setting->company_email.'>' . "\r\n";
    mail($email,$subject,$html,$headers);


    $setting = Setting::first();
    $email = $data['email'];
    $subject = "You got new enquiry";
    $html    =  "<h5>You got new enquiry. <h5><p>Login  in Admin and check</p>";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <'.$setting->company_email.'>' . "\r\n";
    mail($setting->company_email,$subject,$html,$headers);



            Session::flash('success', 'Thanks For Contacting Us');

       return redirect('contact-us'); 
    }



    public function about_us()
    {
        $about = About::first();
        $title = "About Us";
        return view('frontend.about_us', compact('title','about'));
    }

    public function service()
    {
        $service = Service::where('service_status',1)->get();
        $title = "Service";
        return view('frontend.service', compact('title','service'));
    }

    public function service_list($slug)
    { 
        $service = Service::where('service_slug',$slug)->first();
        $service_list = Servicelist::where('service_id',$service->id)->where('service_list_status',1)->get();
        $title = "Service";
        return view('frontend.service_list', compact('title','service','service_list'));
    }
    
    // public function contact_sendmail(Request $request)
    // {
    //         // Email Receiving 
    //         $data = $request->all();
    //         $setting = Setting::first();
    //         $company_mail = $setting->company_email;
            
    //             $name           = $data['fullname'];
    //   			$contact_no     = $data['phone'];
    //   			$email          = $data['email'];
    //   			$messages       = $data['message'];
    //   			$subject = "Email From ".$name;

    //   			$message ="NAME : $name, ";
    //   			$message .="Contact No : $contact_no, ";
    //   			$message .="EMAIL : $email, ";
    //   			$message .="Comments :$messages.";
            
    //         // Always set content-type when sending HTML email
    //         $headers = "MIME-Version: 1.0" . "\r\n";
    //         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    //         // More headers
    //         $headers .= 'From: <'.$email.'>' . "\r\n";
    //         mail($company_mail,$subject, $message);
            
    //         //Reply Mail Sending
            
    //         $cus_email = $data['email'];
    //         $subjects = "Thanks For Contacting GooAds";
    //         $settings = Setting::first();
    //         $htmls =  view('contact_us_mail',compact('setting','data'))->render();

    //         // Always set content-type when sending HTML email
            
    //         $headers_ = "MIME-Version: 1.0" . "\r\n";
    //         $headers_ .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
    //         // More headers
    //         $headers_ .= 'From: <'.$settings->company_email.'>' . "\r\n";
    //         mail($cus_email,$subjects,$htmls,$headers_);
            

    //         Session::flash('mailsent', 'Message has been sent');
    //         return redirect('contact-us');

    //         Session::flash('success', 'Message has been sent');
    //         return redirect('contact-us');
     
    // }
    
    // public function contact_sendmail_reply(Request $request)
    // {
    //     $data = $request->all();
    //     $email = $data['email'];
    //     $subject = "Thanks For Contacting GooAds";
    //     $setting = Setting::first();
    //     $html =  view('contact_us_mail',compact('setting','data'))->render();
        
    //         //echo $html;die;
    //         // Always set content-type when sending HTML email
            
    //         $headers = "MIME-Version: 1.0" . "\r\n";
    //         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
    //         // More headers
    //         $headers .= 'From: <'.$setting->company_email.'>' . "\r\n";
    //         mail($email,$subject,$html,$headers);

    //         Session::flash('success', 'Thanks For Contacting Us.');
    //         return redirect('contact-us');
        
    // }
    
}