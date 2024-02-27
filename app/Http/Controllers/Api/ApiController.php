<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Ads;
use App\Models\Adsimage;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Customer;
use App\Models\City;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\Ads_car;
use App\Models\Ads_property_sale;
use App\Models\Ads_lands;
use App\Models\Ads_jobs;
use App\Models\Ads_electronic;
use App\Models\Attribute;
use App\Models\Attribute_list;
use App\Models\Repairs_servicing;
use App\Models\Reported_item;
use Hash;
use Session;
use Auth;
use DB;

class ApiController extends Controller
{

    public function version(){

        $data = array(
                        'current_version'     => "1.0",
                        'update_status'       => 'yes'
            );
        return response($data,200);
    }

    public function sent_otp(Request $request){
        $mobile_no = $request->mobile_no;
        if($mobile_no == ""){
            $response = ["message" => "Please enter the mobile no"];
            return response($response, 422);
        }
        $check =  $this->validateMobileNumber($mobile_no);
        $user = Customer::where('mobile',$mobile_no)->first();
        if($check){
            $otp  = 1000;
            $data = array(
                        'otp'             => $otp,
                        'mobile_no'       => $mobile_no,
                        'user_id'         => $user ? $user->id : ""
            );
            return response($data,200);
        }else{
            $response = ["message" => "invalid mobile no"];
            return response($response, 422);
        }
    }


    public function save_app_id(Request $request){
           //  echo $this->input->post('mobile_no');      
        $customer_id =  $request->user_id;
        $app_id =  $request->app_id;
        $data = array(
                      'app_id'    => $app_id
        );
        $customer = Customer::find($customer_id);          
        $customer->update($data);
        return response(array("user_id" => $customer_id),200);

  }


    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string|max:255',
            'password' => 'required|string',
        ]);
        if ($validator->fails())
        {
            return response(['message'=>$validator->errors()->all()], 422);
        }

        $customer = Customer::where('email',$request->email)->first();
        if($customer){
            return response(['message'=> "Email id already exits."], 422);
        }
        $mobile_no = $request->mobile_no;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $gender = $request->gender;
        $app_id = $request->app_id ?$request->app_id : "";
        $data = array(
                        'mobile'                => $mobile_no,
                        'first_name'            => $first_name,
                        'last_name'             => $last_name,
                        'email'                 => strtolower($email),
                        'gender'                => $gender,
                        'status'                => 1,
                        'password'              => Hash::make($request->password),
                        'app_id'                => $app_id
        );
        $customer = new Customer; 
        $results = $customer->create($data);
        $user_id = $results->id ;
        return response(array("user_id" => $user_id,'message' => "Register Successfully."),200);
    }


    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
        if ($validator->fails())
        {
            return response(['message'=>$validator->errors()->all()], 422);
        }
        $user = Customer::where('email', $request->email)->orWhere('mobile', $request->email)->first();

         

        if ($user) {

            //echo Hash::make($request->password);die;
            if (Hash::check($request->password, $user->password)) {
                //print_r($user);
                //$token = $user->createToken('Laravel Password Grant Client')->accessToken;

                if(@$request->app_id){
                     Customer::where('id', $user->id)->update(['app_id' => $request->app_id]);
                }
                if($user->profile_image){
                    $profile_image = $user->profile_image;
                }
                else{
                    $profile_image = "user.png";
                }
                if($user->status == 1){
                    $response = [
                        'token'          => "success",
                        'user_id'        => $user->id,
                        'profile_image'  => url('public/images/customer/'.$profile_image),
                        'first_name'     => $user->first_name,
                        'email'          => $user->email,
                        'mobile'         => $user->mobile,
                    ];
                     return response($response, 200);
                }
                else if($user->status == 0){
                    $response = ["message" => "your account is not activated."];
                    return response($response, 422);
                }
                else{
                    $response = ["message" => "your account is de-activated."];
                    return response($response, 422);
                }
               
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function forget_password(Request $request)
    {
        $email =  $request->email;
        if($email){
                $setting = Setting::first();
                $otp = mt_rand(1000,9999);
                Customer::where("email",$email)->update(['otp' => $otp]);

                $user = Customer::where("email",$email)->first();
                if($user){
                    $user_id = $user->id;
                    //echo "<pre>";print_r($setting); die;
                    $subject = "Reset Password - OTP";
                    $html =  view('forget_password_mail',compact('setting','user'))->render();
                    //echo $html;die;
                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    // More headers
                    $headers .= 'From: <'.$setting->company_email.'>' . "\r\n";
                    mail($email,$subject,$html,$headers);
                }
                $response = ["message" => "Email Send Check your Inbox or spam Folder.",'otp' => $otp];
                return response($response, 200);
        }
        else{
             $response = ["message" => "email  is  not exits"];
            return response($response, 422);
        }
    
    }

    public function check_otp(Request $request)
    {
        $email =  $request->email;
        $otp =  $request->otp;
        if($email){
            $user =  Customer::where("email",$email)->where("otp",$otp)->first();
            if($user){
                $response = ["message" => "success"];
                return response($response, 200);
            }
            else{
                $response = ["message" => "invalid otp"];
                return response($response, 422);
            }
        }
        $response = ["message" => "email  is empty"];
        return response($response, 422);
    
    }

     public function new_password(Request $request)
    {
        $email =  $request->email;
        $new_password =  $request->new_password;
        $confrim_password =  $request->confirm_password;
        if($new_password){
             if($new_password == $confrim_password){
                 Customer::where('email', $email)->update(['password' => Hash::make($new_password)]);  
                 $response = ["message" => "Password Changed Successfully.Please Login"];
                 return response($response, 200); 
            }
            else{
                $response = ["message" => "password is not match"];
                return response($response, 422);
            }
        }
        else{
            $response = ["message" => "password is empty"];
            return response($response, 422);
        }
    
    }


    public function category(Request $request){
        $main_category = $request->main_category;
        $results = Category::select('category.id','category.category_name','category.category_image', DB::raw('COUNT(sub_category.id) as subcategory'),'category.category_type')
        ->leftJoin('sub_category', function($join) {
            $join->on('category.id', '=', 'sub_category.category_id');
            $join->where('sub_category.sub_category_status',1);
          })
        ->where("category.main_category" ,$main_category)
        ->where('category.category_status',1)

        ->orderBy('category.category_order',"ASC")
        ->groupBy('category.id')
        ->get();
        if($results){
            foreach ($results as $key => $value) {
                $results[$key]->category_image =  url('public/images/category/'.$value->category_image);
                $results[$key]->subcategory  = $value->subcategory ?  (int) $value->subcategory : 0;
            }
        return response($results,200);
        }else{
              $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }

    public function subcategory(Request $request){
        $category_id = $request->category_id;
        $results = Subcategory::select('sub_category.id','sub_category_name','category_name','sub_category_type')
        ->where('sub_category_status',1)
        ->where('category_id',$category_id)
        ->leftJoin('category', function($join) {
            $join->on('category.id', '=', 'sub_category.category_id');
          })
       ->get();
        //print_r($results);die;
        if($results) {
            return response($results,200);
        }else{
              $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }

    public function attribute_mutiple(Request $request){
        $attribute_id = $request->attribute_id; 
        $where_in = array(); 
        if($attribute_id == "cars"){
            $where_in = array(1,2,3,4,5);
        }
        if($attribute_id == "bike"){
            $where_in = array(6,2,3,4,5);
        }

        if($attribute_id == "sale-property"){
            $where_in = array(7,8,9,10,11,12,13);
        }
        if($attribute_id == "rent-property"){
            $where_in = array(7,8,9,10,11,12,13,14);
        }
        if($attribute_id == "lands-and-plot"){
            $where_in = array(15,13,12);
        }
        if($attribute_id == "rent-shop"){
            $where_in = array(9,13,11);
        }
        if($attribute_id == "sale-shop"){
            $where_in = array(9,13,10,11);
        }
        if($attribute_id == "pg"){
            $where_in = array(16,9,13,11,17);
        }
        if($attribute_id == "jobs"){
            $where_in = array(18,19,20,21,22,23,24);
        }
        if($attribute_id == "mobile"){
            $where_in = array(26);
        }
        if($attribute_id == "commercial-vehicles"){
            $where_in = array(27,2,3,4,5);
        }

       //  pr($where_in);
        $results =  Attribute::whereIn('id',$where_in)->get();
       // pr($results);
        $array = array();
        foreach ($results as $key => $value) {
            $array[$value->attribute_slug] = Attribute_list::select('id','attribute_list_name')
                            ->where('attribute_id',$value->id)
                            ->get();
        }
       // pr($array);die;
        return response($array,200);
    }

    public function attribute_model(Request $request){
        $attribute_list_id = $request->attribute_list_id;
        $results =  Attribute_list::select('id','attribute_list_name')->where('main_id',$attribute_list_id)->get();
        return response($results,200);
    }

    public function price($price){
        return "₹ ".$price;
    }

    public function home(Request $request){
        $customer_id = @$request->customer_id;

        $data['notification'] = Notification::where("customer_id",$customer_id)->where("notification_read_status",0)->count();

        $customer_data = Customer::where('id',$request->customer_id)->where('status',1)->count();
        $data ['customer_data'] = $customer_data ? 1 : 0;

        $data['chats_count'] = Chat::where('receiver_id',$request->customer_id)->where('message_to_read',0)->count();

        if($data)
        {
            return response($data, 200);
        }
        else
        {
            $response = ["message" => "No Data"];
            return response($response, 422);
        } 

    }

    public function ads(Request $request){
        $page = $request->page ? (($request->page - 1) * $request->limit) : 0;
        $limit = $request->limit ?  $request->limit : 10;
        $main_category = @$request->main_category;
        $category_id = @$request->category_id;
        $sub_category_id = @$request->sub_category_id;
        $city_id = @$request->city_id;
        $customer_id = @$request->customer_id;
        $search_text = @$request->search_text;

        $price_range = @$request->price_range;
        $service_type = @$request->service_type;
        $price_type = @$request->price_type;
        $sort_by = @$results->sort_by ; 


        $results = Ads::select('ads.id','ads_name','ads.service_type','ads.ads_image','ads_image.image_name','ads.ads_price','category.category_name','city_name',DB::raw("(CASE WHEN (favorite.ads_id > 0) THEN '1' ELSE '0' END)as favorite_status"))
        ->leftJoin('city', function($join) {
            $join->on('city.id', '=', 'ads.city_id');
          })
        ->leftJoin('category', function($join) {
            $join->on('category.id', '=', 'ads.category_id');
          })
         ->leftJoin('favorite', function($join) use ($customer_id) {
            $join->on('favorite.ads_id', '=', 'ads.id');
             $join->where('favorite.customer_id','=', $customer_id);
          })
         ->leftJoin('ads_image', function($join) {
            $join->on('ads_image.ads_id', '=', 'ads.id');
          })
        ->where('ads.ads_status',1)
        ->groupBy('ads.id')
        ->orderBy('ads.id','desc')
        ->skip($page)->take($limit);
        // if($main_category){
        //       $results->where('category.main_category',$main_category);
        // }



        if($price_range){
            //pr($price_range); 
            $price_range_arr = explode("-", $price_range);
            if($price_range_arr[0] && @$price_range_arr[1]){
                $results->whereBetween('ads_price', [$price_range_arr[0], $price_range_arr[1]]);
            }
            else{
                 $results->where('ads_price',$price_range_arr[0]);
            }
        }


        if($sort_by){
              $results->where('city_id',$city_id);
        }

        if($service_type){
             $service_type_arr = explode(",", $service_type);
              $results->whereIn('service_type',$service_type_arr);
        }

        if($price_type){
             $price_type_arr = explode(",", $price_type);
              $results->whereIn('price_type',$price_type_arr);
        }

        if($category_id){
              $results->where('category_id',$category_id);
        }
        if($sub_category_id){
              $results->where('sub_category_id',$sub_category_id);
        }
        if($city_id){
              $results->where('city_id',$city_id);
        }
        if($search_text){
            $results->where('ads_name', 'like', '%'.$search_text.'%');
        }
        $results = $results->get();
        if($results){
            foreach ($results as $key => $value) {
                if($value->ads_price){
                     $results[$key]->ads_price = $this->price($value->ads_price);
                }
                if($value->image_name){
                    $results[$key]->ads_image =  url('public/images/listing/'.$value->image_name);
                }
                else{
                    $results[$key]->ads_image =  url('public/images/no-image.png');
                }
            }

        }
        return response($results,200);
    }

    public function ads_detail(Request $request){
        $ads_id = $request->id;
        $customer_id = $request->customer_id ? $request->customer_id  : 0 ;

        // $update_ads = Ads::find($ads_id);
        // $data['total_views'] = $update_ads->total_views + 1;  
        // $update_ads->update($data);


        $results = Ads::select('ads.*','ads.id as ids','profile_image','customer.first_name','customer.last_name','city_name','city.id as city_id','customer.created_at as join_date',DB::raw("(CASE WHEN (favorite.ads_id > 0) THEN '1' ELSE '0' END)as favorite_status"))
        ->leftJoin('city', function($join) {
            $join->on('city.id', '=', 'ads.city_id');
          })
        ->leftJoin('customer', function($join) {
            $join->on('customer.id', '=', 'ads.customer_id');
          })
        ->leftJoin('favorite', function($join) use ($customer_id) {
            $join->on('favorite.ads_id', '=', 'ads.id');
             $join->where('favorite.customer_id','=', $customer_id);
          });
        if($ads_id)
        {
            $results->where('ads.id',$ads_id);
        }
        $results = $results->first();


        if(@$results->profile_image){
            $results->profile_image =  url('public/images/customer/'.$results->profile_image);
        }
        else{
            $results->profile_image =  url('public/images/user.png');
        }
        if($results->ads_image){
            $results->ads_image = url('public/images/listing/'.$results->ads_image);
        }
        else{
            $results->ads_image =  url('public/images/no-image.png');
        }

        if($results->join_date){
            $results->join_year = date("Y",strtotime($results->join_date));
        }
       
        $results->ads_price_int = $results->ads_price;
    

        if($results->ads_price){
            $results->ads_price = $this->price($results->ads_price);
        }

       
        if($results->created_at){
            $results->posted_at = time_elapsed_string($results->created_at);
        }
        $results->share_link = url('details/'.$results->ads_slug);

 
        $image_name =  array();
    

        $ads_images = Adsimage::where('ads_id',$results->ids)->get();

        if(count($ads_images)){
            foreach ($ads_images as $key => $value) {
                if($value->image_name){
                    $image_name[] = array('id' => $value->id , 'image_name' => url('public/images/listing/')."/".$value->image_name);
                }
                //$image_implode =  implode(",",$image_name);
            }
        }
        else{
            $image_name[]  =  array('image_name' => url('public/images/no-image.png'));
        }
        $results->images = $image_name;


         if($results->ads_type =="cars"  || $results->ads_type =="bike" ||  $results->ads_type == "commercial-vehicles"){
            $adsextra  = Ads_car::select(
                'vehicle.attribute_list_name as vehicle_type',
                'brand.attribute_list_name as brand_name',
                //'mo.attribute_list_name as model',
                'model',
                'registration_date',
                'fc_valid',
                'insurance_valid',
                'fuel.attribute_list_name as fuel_type',
                'engine_size','transmission.attribute_list_name as transmission',
                'km_driven','no_of_owner.attribute_list_name as no_of_owner',
                'seller_by.attribute_list_name as seller_by','insurance_valid')
                        ->where('ads_id',$results->id)
                        ->leftJoin('attribute_list  as vehicle','vehicle.id','ads_car.vehicle_type')
                        ->leftJoin('attribute_list  as brand','brand.id','ads_car.brand_id')
                        //->leftJoin('attribute_list  as mo','mo.id','ads_car.model')
                        ->leftJoin('attribute_list  as fuel','fuel.id','ads_car.fuel_type')
                        ->leftJoin('attribute_list  as no_of_owner','no_of_owner.id','ads_car.no_of_owner')
                        ->leftJoin('attribute_list  as transmission','transmission.id','ads_car.transmission')
                         ->leftJoin('attribute_list  as seller_by','seller_by.id','ads_car.seller_by')
                    ->first();
            
            $results->extra = $adsextra;
        }
        else{
            $results->extra = $adsextra = array(
                            'brand_name' => "",
                            'model' => "",
                            'registration_date' => "",
            );
        }

        if($results->ads_type =="sale-property"  || $results->ads_type =="rent-property"){
            $adsextra  = Ads_property_sale::select(
                                    'type.attribute_list_name as type_of_property',
                                    'bedrooms.attribute_list_name as bedrooms_type',
                                    'floor',
                                    'furnish.attribute_list_name as furnished',
                                    'construction.attribute_list_name as construction_status',
                                    'listed.attribute_list_name as listed_by',
                                    'super_buildup_area_sq_ft',
                                    'carpet_area_sq_ft',
                                    'car_parking.attribute_list_name as car_parking_space',
                                    'face.attribute_list_name as facing',
                                    'rent_monthly',
                                    'form_wh.attribute_list_name as form_whom')
                        ->where('ads_id',$results->id)
                        ->leftJoin('attribute_list  as type','type.id','ads_property_sale.type_of_property')
                        ->leftJoin('attribute_list  as bedrooms','bedrooms.id','ads_property_sale.bedrooms_type')
                        ->leftJoin('attribute_list  as furnish','furnish.id','ads_property_sale.furnished')
                        ->leftJoin('attribute_list  as construction','construction.id','ads_property_sale.construction_status')
                        ->leftJoin('attribute_list  as car_parking','car_parking.id','ads_property_sale.car_parking_space')
                        ->leftJoin('attribute_list  as face','face.id','ads_property_sale.facing')
                        ->leftJoin('attribute_list  as listed','listed.id','ads_property_sale.listed_by')
                        ->leftJoin('attribute_list  as form_wh','form_wh.id','ads_property_sale.form_whom')
                    ->first();
            
            $results->extra = $adsextra;
        }

        if($results->ads_type =="lands-plots"){
            $adsextra  = Ads_lands::select(
                                        'type.attribute_list_name as property_type',
                                        'listed.attribute_list_name as listed_by',
                                        'plot_area',
                                        'length',
                                        'breadth',
                                        'face.attribute_list_name as facing',
                                    )
                                    ->where('ads_id',$results->id)
                                    ->leftJoin('attribute_list  as type','type.id','ads_lands.property_type')
                                    ->leftJoin('attribute_list  as listed','listed.id','ads_lands.listed_by')
                                    ->leftJoin('attribute_list  as face','face.id','ads_lands.facing')
                        
                    ->first();
                     $results->extra = $adsextra;
        }

        if($results->ads_type =="sale-shop"  || $results->ads_type =="rent-shop"){
            $adsextra  = Ads_property_sale::select(
                'furnish.attribute_list_name as furnished',
                'listed.attribute_list_name as listed_by',
                'super_buildup_area_sq_ft',
                'carpet_area_sq_ft',
                'washrooms',
                'rent_monthly',
                'car_parking.attribute_list_name as car_parking_space')
                        ->where('ads_id',$results->id)
                        ->leftJoin('attribute_list  as furnish','furnish.id','ads_property_sale.furnished')
                        ->leftJoin('attribute_list  as listed','listed.id','ads_property_sale.listed_by')

                        ->leftJoin('attribute_list  as car_parking','car_parking.id','ads_property_sale.car_parking_space')
                        
                    ->first();
            
            $results->extra = $adsextra;
        }

         if($results->ads_type =="pg"  ){
            $adsextra  = Ads_property_sale::select(
                'pg_sub.attribute_list_name as pg_sub_type',
                'furnish.attribute_list_name as furnished',
                'listed.attribute_list_name as listed_by',
                'car_parking.attribute_list_name as car_parking_space',
                'meal.attribute_list_name as meal_included',
            )
                        ->where('ads_id',$results->id)
                        ->leftJoin('attribute_list  as pg_sub','pg_sub.id','ads_property_sale.pg_sub_type')
                        ->leftJoin('attribute_list  as furnish','furnish.id','ads_property_sale.furnished')
                        ->leftJoin('attribute_list  as listed','listed.id','ads_property_sale.listed_by')

                        ->leftJoin('attribute_list  as car_parking','car_parking.id','ads_property_sale.car_parking_space')
                        ->leftJoin('attribute_list  as meal','meal.id','ads_property_sale.meal_included')
                        
                    ->first();
            
            $results->extra = $adsextra;
         }

         if($results->ads_type =="jobs"){
            $adsextra  = Ads_jobs::select(
                                        'category.attribute_list_name as jobs_category',
                                        'company_name',
                                        'salary.attribute_list_name as salary_period',
                                        'type.attribute_list_name as job_type',
                                        'qualif.attribute_list_name as qualification',
                                        'eng.attribute_list_name as english',
                                        'exper.attribute_list_name as experience',
                                        'gend.attribute_list_name as gender',
                                        'salary_from',
                                        'salary_to',
                                    )
                                    ->where('ads_id',$results->id)
                                    ->leftJoin('attribute_list  as category','category.id','ads_jobs.jobs_category')
                                    ->leftJoin('attribute_list  as salary','salary.id','ads_jobs.salary_period')
                                    ->leftJoin('attribute_list  as type','type.id','ads_jobs.job_type')
                                    ->leftJoin('attribute_list  as qualif','qualif.id','ads_jobs.qualification')
                                    ->leftJoin('attribute_list  as eng','eng.id','ads_jobs.english')
                                    ->leftJoin('attribute_list  as exper','exper.id','ads_jobs.experience')
                                    ->leftJoin('attribute_list  as gend','gend.id','ads_jobs.gender')
                        
                    ->first();
            // $adsextra->salary_from  =  $this->price($adsextra->salary_from);
            // $adsextra->salary_to  =  $this->price($adsextra->salary_to);
            $results->extra = $adsextra;

            $results->ads_price = $this->price($adsextra->salary_from)." - ".$this->price($adsextra->salary_to);
        }

    

        if($results->ads_type == "mobile"   || $results->ads_type == "electronics-appliances"){
             $adsextra  = Ads_electronic::select(
                                        'brand',
                                        'model',
                                        'purchased_year',
                                    )
                                    ->where('ads_id',$results->id)
                    ->first();
                    $results->extra = $adsextra;
        }
    

        if($results->ads_type =="repairs-servicing" ||  $results->main_category =="1"  ||  $results->main_category =="2"){
            $adsextra  = Repairs_servicing::select('*')->where('ads_id',$results->id)->first();
            
            $adsextra->working_days_number = $adsextra->working_days;
            if($adsextra->working_days){

                $working_days = explode(",", $adsextra->working_days) ;
                $adsextra->working_days = get_days($working_days,1);
               
            }


            $business_city_id = @$adsextra->business_city_id ? explode(",", $adsextra->business_city_id) : "";
         
                $cities = array();
                if($business_city_id){
                    $cities = City::select(DB::raw('CONCAT(city_name, ", ", state_name) as city_name'))
                            ->whereIn('city.id',$business_city_id)
                            ->join('states', function($join) {
                                $join->on('states.id', '=', 'city.state_id');
                              })
                            ->where('city_status',1)
                            ->get();
                            $cities_name = array();
                            foreach ($cities as $key => $value) {
                                $cities_name[] = $value->city_name;
                            }
                        $adsextra->business_city_names = $cities_name;
                }

            $results->extra = $adsextra;


        }

        return response($results,200);
    }

    public function report_ads(Request $request){
       // echo "<pre>";print_r($request->get('')); die;
       // pr($request->reported_by);die;
        $data = array(
                'reported_by'       => $request->reported_by,
                'ads_id'            => $request->ads_id,
                'issuses_type'      => $request->issuses_type,
                'comments'          => $request->comments
            );
        
        $reported_item = new Reported_item; 
        $reported_item->create($data);
       
        $response = ["message" => " Added successfully"];
        return response($response, 200);
    }


    public function city(Request $request){
        $city_name = $request->city_name;
        $results = City::select('city.id',DB::raw('CONCAT(city_name, ", ", state_name) as city_name'))
        ->where('city_name', 'like', '%'.$city_name.'%')
        ->join('states', function($join) {
            $join->on('states.id', '=', 'city.state_id');
          })
        ->where('city_status',1)
        ->orderBy('features_status','desc')
        ->limit("10")
        ->get();
        if($results){
            return response($results,200);
        }else{
              $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }
    public function banner(Request $request){
        $results = Banner::select('id','banner_name','banner_image')
        ->where('banner_status',1)
        ->orderBy('id',"asc")
        ->get();
        if($results){
            foreach ($results as $key => $value) {
                if($value->banner_image){
                    $results[$key]->banner_image =  url('public/images/banner/'.$value->banner_image);
                }
            }
            return response($results,200);
        }else{
              $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }


    public function  delete_image(Request $request){
        
        $image_id = $request->image_id;
        $ads_id = $request->ads_id;


        $favorite = Adsimage::where('id',$image_id)
        ->where('ads_id',$ads_id)
        ->delete(); 
        if($favorite){
            $response = ["message" => " Remove successfully"];
            return response($response, 200);
        }else{
              $response = ["message" => "Can't Not Remove"];
            return response($response, 422);
        }
    }


    /*  ======================================================================
    ======================================================================*/
    public function save_favorite(Request $request){
        $customer_id = $request->customer_id;
        $ads_id = $request->ads_id;

        $data = array(
                        'customer_id'   => $customer_id,
                        'ads_id'    => $ads_id
        );
        $favorite = new Favorite; 
        $results = $favorite->create($data);
        if($results){
            $response = ["message" => " Added successfully"];
            return response($response, 200);
        }else{
              $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }

    public function  delete_favorite(Request $request){
        $customer_id = $request->customer_id;
        $ads_id = $request->ads_id;


        $favorite = Favorite::where('ads_id',$ads_id)
        ->where('customer_id',$customer_id)
        ->delete(); 
        if($favorite){
            $response = ["message" => " Remove successfully"];
            return response($response, 200);
        }else{
              $response = ["message" => "Favorite Not Remove"];
            return response($response, 422);
        }
    }

    public function my_favroite(Request $request){
        $page = $request->page ? (($request->page - 1) * $request->limit) : 0;
        $limit = $request->limit ?  $request->limit : 10;
        $customer_id = $request->customer_id;  
        $results = Favorite::select('ads.id','ads_name','ads_image.image_name','ads.service_type','city_name','ads_image','ads_price')
        ->join('ads', function($join) {
            $join->on('ads.id', '=', 'favorite.ads_id');
          })
        ->leftJoin('city', function($join) {
            $join->on('city.id', '=', 'ads.city_id');
          })
          ->leftJoin('ads_image', function($join) {
            $join->on('ads_image.ads_id', '=', 'ads.id');
          })
        ->orderBy('favorite.id',"desc")
        ->where("favorite.customer_id", $customer_id)
        ->skip($page)->take($limit);
        $results = $results->get();
        if($results){
            foreach ($results as $key => $value) {
                if($value->image_name){
                    $results[$key]->ads_image =  url('public/images/listing/'.$value->image_name);
                }
                else{
                    $results[$key]->ads_image =  url('public/images/no-image.png');
                }
                if($value->ads_price){
                     $results[$key]->ads_price = $this->price($value->ads_price);
                }
            }
        }
        return response($results,200);
    }


    public function post_ads(Request $request){
       // echo "<pre>";print_r($request->get('')); die;
        $data = array(
                'customer_id'       => $request->get('customer_id'),
                'category_id'       => $request->category_id,
                'sub_category_id'   => $request->sub_category_id,
                'service_type'      => $request->main_category,
                'ads_name'          => $request->ads_name,
                // 'ads_image'      => $request->ads_image,
                'ads_description'   => $request->ads_description,
                'door_step'         => $request->door_step,
                'city_id'           => $request->city_id,
                'type_of_service'   => $request->type_of_service,
                'ads_type'          => $request->sub_category_type,
                'ads_price'         => $request->ads_price,
                'ads_condition'     => $request->ads_condition,
                'ads_status'        => 0
        );
       
        //print_r($data);die;

        $ads = new Ads;
        $id = $ads->create($data)->id;

        $ads = Ads::find($id);          
        
        $new_data['ads_slug'] = Str::slug($data['ads_name'],"-")."-".$id.rand(10000,99999);
        $ads->update($new_data);

        $image_path = $request->ads_image;
        $arr_path = explode(",", $image_path);
       
        if(count($arr_path)){
            for ($i=0; $i < count($arr_path); $i++) { 
              
                $ads_image = "images-".time().rand(10000,200000).'.jpg';
                file_put_contents(public_path().'/images/listing/'.$ads_image, base64_decode($arr_path[$i]));

                $data_image = array(
                                    'ads_id'            => $id,
                                    'image_name'        => $ads_image,
                );
                $ads_image_file = new Adsimage;
                $ads_image_file->create($data_image) ;

            }
             
        }

        if($request->sub_category_type == "cars" ||  $request->sub_category_type == "bike" ||  $request->sub_category_type == "commercial-vehicles"){

            $cars_data = array(
                                "ads_id"                => $id,
                                "brand_id"              => $request->brand_id,
                                'model'                 => $request->model,
                                'registration_date'     => $request->registration_date,
                                'fuel_type'             => $request->fuel_type,
                                'engine_size'           => $request->engine_size,
                                'transmission'          => $request->transmission,
                                'km_driven'             => $request->km_driven,
                                'no_of_owner'           => $request->no_of_owner,
                                'seller_by'             => $request->seller_by,
                                'fc_valid'              => $request->fc_valid,
                                'insurance_valid'       => $request->insurance_valid,
                                );
        Ads_car::create($cars_data);
        }
        
        if($request->sub_category_type == "sale-property" ||  $request->sub_category_type == "rent-property" || $request->sub_category_type =="rent-shop" || $request->sub_category_type =="sale-shop" || $request->sub_category_type =="pg" ){

            $property_data = array(
                                "ads_id"                    => $id,
                                "type_of_property"          => $request->type_of_property,
                                'bedrooms_type'             => $request->bedrooms_type,
                                'floor'                     => $request->floor,
                                'furnished'                 => $request->furnished,
                                'construction_status'       => $request->construction_status,
                                'listed_by'                 => $request->listed_by,
                                'super_buildup_area_sq_ft'  => $request->super_buildup_area_sq_ft,
                                'carpet_area_sq_ft'         => $request->carpet_area_sq_ft,
                                'car_parking_space'         => $request->car_parking_space,
                                'facing'                    => $request->facing,
                                'rent_monthly'              => $request->rent_monthly,
                                'form_whom'                 => $request->form_whom,
                                'washrooms'                 => $request->washrooms,
                                'sale_amount'               => $request->sale_amount,
                                'pg_sub_type'               => $request->pg_sub_type,
                                'meal_included'             => $request->meal_included,
                                );
            Ads_property_sale::create($property_data);
            $extra  =  $property_data;
        }
        

        if($request->sub_category_type == "lands-plots" ){

            $property_data = array(
                                "ads_id"                => $id,
                                "property_type"         => $request->property_type,
                                'listed_by'             => $request->listed_by,
                                'plot_area'             => $request->plot_area,
                                'length'                => $request->length,
                                'breadth'               => $request->breadth,
                                'facing'                => $request->facing,
                                );
            Ads_lands::create($property_data);
            $extra  =  $property_data;
        }

        if($request->sub_category_type == "jobs" ){

            $property_data = array(
                                "ads_id"                => $id,
                                "jobs_category"         => $request->jobs_category,
                                'company_name'          => $request->company_name,
                                'salary_period'         => $request->salary_period,
                                'job_type'              => $request->job_type,
                                'qualification'         => $request->qualification,
                                'salary_from'           => $request->salary_from,
                                'salary_to'             => $request->salary_to,
                                'english'               => $request->english,
                                'experience'            => $request->experience,
                                'gender'                => $request->gender,
                                );
            Ads_jobs::create($property_data);
            $extra  =  $property_data;
        }

        if($request->sub_category_type == "repairs-servicing" || $request->sub_category_type == "business" ){

            $property_data = array(
                                "ads_id"                => $id,
                                "owner_name"            => $request->owner_name,
                                'mobile_number'         => $request->mobile_number,
                                'email'                 => $request->email,
                                'address1'              => $request->address1,
                                'address2'              => $request->address2,
                                'pincode'               => $request->pincode,
                                'business_since'        => $request->business_since,
                                'working_days'          => $request->working_days,
                                'working_hours_from'    => $request->working_hours_from,
                                'working_hours_to'      => $request->working_hours_to,
                                'business_city_id'      => $request->city_ids,
                                );
            Repairs_servicing::create($property_data);
            $extra  =  $property_data;
        }


        if($request->sub_category_type == "mobile" || $request->sub_category_type == "electronics-appliances" ){

            $ads_data = array(
                                "ads_id"        => $id,
                                "brand"         => $request->brand,
                                'model'         => $request->model,
                                'purchased_year'=> $request->purchased_year,
                                );
            Ads_electronic::create($ads_data);
            $extra  =  $ads_data;
        }

        

        // if($request->hasFile('ads_image')) {
        //         $image = $request->file('ads_image');
        //         $ads_image = time().'.'.$image->getClientOriginalExtension();
        //         $destinationPath = public_path('/images/ads');
        //         $image->move($destinationPath, $ads_image);
        //         $data['ads_image'] = $ads_image;
        // }
        //echo "<pre>";print_r($data); die;
        
        if($id){
            $response = ["message" => $data];
            return response($response, 200);
        }else{
              $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }


    public function edit_ads(Request $request){
        $id = $request->id;
        if($id){
            $data = array(
                    'ads_name'          => @$request->ads_name,
                    'ads_condition'     => @$request->ads_condition,
                    'ads_description'   => @$request->ads_description,
                    'door_step'         => @$request->door_step,
                    'city_id'           => @$request->city_id,
                    'type_of_service'   => @$request->type_of_service,
                   
            );
            if(@$request->category_id){
                $data['category_id'] = @$request->category_id;
            }
            if(@$request->sub_category_id){
                $data['sub_category_id'] = @$request->sub_category_id;
            }
            if(@$request->service_type){
                $data['service_type'] = @$request->service_type;
            }


            if(@$request->ads_price){
                $data['ads_price'] = @$request->ads_price;
            }

            // if (@$request->hasFile('ads_image')) {
            //         $image = $request->file('ads_image');
            //         $ads_image = time().'.'.$image->getClientOriginalExtension();
            //         $destinationPath = public_path('/images/ads');
            //         $image->move($destinationPath, $ads_image);
            //         $data['ads_image'] = $ads_image;
            // }


            $ads = Ads::find($id);          
            $ads->update($data);
            //pr($ads);die;

             $image_path = $request->ads_image;

             if($image_path){
                  $arr_path = explode(",", $image_path);
                   
                    if(count($arr_path)){
                        for ($i=0; $i < count($arr_path); $i++) { 
                          
                            $ads_image = "images-".time().rand(10000,200000).'.jpg';
                            file_put_contents(public_path().'/images/listing/'.$ads_image, base64_decode($arr_path[$i]));

                                $data_image = array(
                                                    'ads_id'            => $id,
                                                    'image_name'        => $ads_image,
                                );
                                $ads_image_file = new Adsimage;
                                $ads_image_file->create($data_image) ;

                        }
                         
                }
            }


            if($request->sub_category_type == "repairs-servicing" || $request->sub_category_type == "business" ){

                $property_data = array(
                                    "ads_id"                => $ads->id,
                                    "owner_name"            => $request->owner_name,
                                    'mobile_number'         => $request->mobile_number,
                                    'email'                 => $request->email,
                                    'address1'              => $request->address1,
                                    'address2'              => $request->address2,
                                    'pincode'               => $request->pincode,
                                    'business_since'        => $request->business_since,
                                    'working_days'          => $request->working_days,
                                    'working_hours_from'    => $request->working_hours_from,
                                    'working_hours_to'      => $request->working_hours_to,
                                    'business_city_id'      => $request->city_ids,
                                    );
                //pr($property_data);
                $repair  = Repairs_servicing::where('ads_id',$id)->first();
                $repair->save($property_data);
                $extra  =  $property_data;
        }

            $response = ["message" => " Update successfully"];
            return response($response, 200);
        }else{
              $response = ["message" => "Not Update"];
            return response($response, 422);
        }
    }
    public function destroy_ads(Request $request)
    {
        $customer_id = $request->customer_id;
        $ads_id = $request->ads_id;
        $results=Ads::where('id',$ads_id)->where('customer_id',$customer_id)->delete();
        if($results){
            $response = ["message" => " Delete Ads successfully"];
            return response($response, 200);
        }else{
              $response = ["message" => "Not Delete"];
            return response($response, 422);
        }
    }

    public function user_ads(Request $request){
        $page = $request->page ? (($request->page - 1) * $request->limit) : 0;
        $limit = $request->limit ?  $request->limit : 10;
        $customer_id = @$request->customer_id;
        $active = @$request->active;
        $results = Ads::select('ads.id','ads_name','city_name','ads_image','image_name','ads.created_at','ads_status','ads_description',"service_type","ads_price")
        ->leftJoin('city', function($join) {
            $join->on('city.id', '=', 'ads.city_id');
          })
          ->leftJoin('ads_image', function($join) {
            $join->on('ads_image.ads_id', '=', 'ads.id');
          })
        ->orderBy('ads.id','desc')
        ->groupBy('ads.id')
        ->skip($page)->take($limit);    
        if(@$customer_id){
            $results->where('customer_id',$customer_id);
        }

        if(@$active){
            $results->where('ads_status',$active);
        }

        $results = $results->get();
        if($results){
            foreach ($results as $key => $value) {
                if($value->image_name){
                    $results[$key]->ads_image =  url('public/images/listing/'.$value->image_name);
                }
                else{
                    $results[$key]->ads_image =  url('public/images/no-image.png');
                }
                if($value->ads_price){
                     $results[$key]->ads_price = $this->price($value->ads_price);
                }
                $results[$key]->posted_at = time_elapsed_string($value->created_at);
            }
        }
        return response($results,200);
    }
    
    public function service_type(Request $request){
        $service_type = $request->service_type;
        $page = $request->page ? (($request->page - 1) * $request->limit) : 0;
        $limit = $request->limit ?  $request->limit : 10;
        $results = Ads::select('ads.id','ads_name','city_name','ads_image','ads.created_at','ads_status','ads_description','ads_price')
        ->leftJoin('city', function($join) {
            $join->on('city.id', '=', 'ads.city_id');
          })
        ->skip($page)->take($limit)  
        ->where('service_type',$service_type)
        ->get();
        if($results){
            foreach ($results as $key => $value) {
                $results[$key]->ads_image =  url('public/images/listing/'.$value->ads_image);
            }
        }
        return response($results,200);
    }


    public function customer(Request $request){
        $customer_id = $request->customer_id;
        $results = Customer::select('id','first_name','last_name','email','mobile','gender','dob','city','profile_image')
        ->where("id",$customer_id)
        ->first();
        if($results){
            if($results->profile_image){
                $results->profile_image =  url('public/images/customer/'.$results->profile_image);
            }
            else{
                $results->profile_image =  url('public/images/user.png');
            }
            return response($results,200);
        }else{
            $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }

    public function update_customer(Request $request){
        $customer_id = $request->customer_id;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $gender = $request->gender;

        $data = array(
                        'first_name'            => $first_name,
                        'last_name'             => $last_name,
                        'gender'                => $gender,
        );
        if($request->mobile){
            $data['mobile'] = $request->mobile;
        }
        $customer = Customer::find($customer_id);          
        $customer->update($data);
        $response = ["message" => "Update Successfully"];
        return response($response, 200);
    }

     public function update_profile(Request $request){
        $customer_id = $request->customer_id;

        $profile_image = $request->profile_image;
        $arr_path = explode(",", $profile_image);

       
        if(count($arr_path)){
            for ($i=0; $i < count($arr_path); $i++) { 
              
                $name = "customer-".time().rand(10000,200000).'.jpg';

                file_put_contents(public_path().'/images/customer/'.$name, base64_decode($arr_path[$i]));
            }
             $data['profile_image'] = $name;

             $customer = Customer::find($customer_id);          
             $customer->update($data);
        }


        
        return response(array("Update successfully."),200);
    }

     public function chat_list(Request $request){

        $page = $request->page ? (($request->page - 1) * $request->limit) : 0;
        $limit = $request->limit ?  $request->limit : 10;
        $customer_id = $request->customer_id;
        $results = Chat::select('chat.*','ads.ads_name','ads.ads_image','ads.ads_status','ads_image.image_name','ads.created_at as ads_created_at','s.first_name as sender_name','r.first_name as receiver_name')
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
         
        ->where("chat.sender_id",$customer_id)
        ->orWhere("chat.receiver_id",$customer_id)
        ->orderBy('chat.id','desc')
        ->groupBy('ads.id',DB::raw('if (chat.sender_id = '.$customer_id.', chat.receiver_id, chat.sender_id)'))
        ->skip($page)->take($limit)
        ->get();


        if($results){
            foreach ($results as $key => $value) {

                $count = Chat::select("count(id) as total")
                      ->where("receiver_id",$customer_id)
                      ->where("message_to_read",0)
                      ->where('ads_id',$value->ads_id)
                      ->groupBy('ads_id')
                      ->count();


                $results[$key]->unread_count = $count;
        
                if($value->sender_id != $customer_id){
                    $results[$key]->display_name =  $value->sender_name;
                }     
                else{
                     $results[$key]->display_name =  $value->receiver_name;
                }

                 if($value->created_at){
                    $results[$key]->display_time =  date("d M Y",strtotime($value->created_at));
                }

                if($value->image_name){
                    $results[$key]->ads_image =  url('public/images/listing/'.$value->image_name);
                }
                else{
                    $results[$key]->ads_image =  url('public/images/no-image.png');
                }
            }
            return response($results,200);
        }else{
              $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }


    public function chat_history(Request $request){

        $page = $request->page ? (($request->page - 1) * $request->limit) : 0;
        $limit = $request->limit ?  $request->limit : 100;

        $ads_id = $request->ads_id;
        $customer_id = $request->customer_id;
        $receiver_id = $request->receiver_id;


        $results = Chat::select('chat.*')
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
        ->skip($page)->take($limit)
        ->get();
        //        ->orWhere("receiver_id",$customer_id)
       // echo "<pre>";print_r($results);die;
        $ads = Ads::
        select('ads.id','customer_id','ads_name','ads_image','ads_image.image_name','service_type','ads_price')
        ->leftJoin('ads_image', function($join) {
            $join->on('ads_image.ads_id', '=', 'ads.id');
          })
        ->where("ads.id",$ads_id)->first();
        if($ads){
      

             if($ads->image_name){
                     $ads->ads_image  =  url('public/images/listing/'.$ads->image_name);
                }
                else{
                     $ads->ads_image  =  url('public/images/no-image.png');
                }

        }

        if($ads){
           

            if(count($results)){
               // echo "------";die;
                 foreach ($results as $key => $value) {
               
                        $results[$key]->date = date("Y-m-d H:i");
                        $sender_id  = $value->sender_id;
                        $receiver_id  = $value->receiver_id;

                    }

                if($customer_id == $sender_id){
                    $ads->from_id = $sender_id;
                    $ads->to_id = $receiver_id;
                } 
                else{
                    $ads->from_id = $receiver_id   ;
                    $ads->to_id = $sender_id;

                }
            }
            else{
                $ads->from_id = $customer_id   ;
                $ads->to_id = $ads->customer_id;
                //$ads->customer_id = $ads->customer_id;
            }

            if($customer_id){
              Chat::where("receiver_id",$customer_id)->where('message_to_read',0)->update(['message_to_read' => 1]);
            }
            

            return response(["ads" => $ads,"chats" =>$results ],200);
        }else{
              $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }

    public function chat_status(Request $request){

        $ads_id = $request->ads_id;
        $customer_id = $request->customer_id;
        $receiver_id = $request->receiver_id;
        
        $results = Chat::select('chat.*')
                        ->where("ads_id",$ads_id)
                        ->Where(function($query) use ($customer_id){
                                     $query->where('sender_id', '=', $customer_id);
                                     $query->orWhere('receiver_id', '=', $customer_id); 

                                 })
                        ->Where(function($query) use ($receiver_id){
                            $query->where('sender_id', '=', $receiver_id);
                             $query->orWhere('receiver_id', '=', $receiver_id);
                         })
                        ->where("receiver_id",$customer_id)
                        ->where("message_to_read",0)
                        ->orderBy("id",'asc')
                        ->get();
            if(count($results)){
               // echo "------";die;
                 foreach ($results as $key => $value) {
               
                        $results[$key]->date = date("Y-m-d H:i");
                        $sender_id  = $value->sender_id;
                        $receiver_id  = $value->receiver_id;

                    }
                //Chat::where("receiver_id",$customer_id)->where('message_to_read',0)->update(['message_to_read' => 1]);


              Chat::where("receiver_id",$customer_id)->where('message_to_read',0)->update(['message_to_read' => 1]);
          
                return response(["chats" =>$results ],200);
             
            }
            else{
              $response = ["message" => "No New message"];
            return response($response, 422);
        }
    }

    public function send_message(Request $request){
        $page = $request->page ? (($request->page - 1) * $request->limit) : 0;
        $limit = $request->limit ?  $request->limit : 10;

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

        $customer = Customer::find($receiver_id);
        $sender = Customer::find($sender_id);
        if($customer->app_id){
            $notification_title = $sender->first_name." sent message";
            $notification_description = $message;
            // $data = array(
            //             'customer_id'               => $ads->customer_id,
            //             'notification_type'         => 1,
            //             'notification_title'        => $notification_title,
            //             'notification_description'  => $notification_description,

            // );
            // $notification = new Notification; 
            // $notification::create($data);

            $not_data = array(
                'title'             => $notification_title,
                'description'       => $notification_description,
                'device_id'         => $customer->app_id,
                'notification_page' => "Chat"
            );
            send_notification($not_data);
        }


        $response = ["message" => " Added successfully"];
        return response($response, 200);
    }
    
    
    // public function service_type(Request $request){
    //     $service_type = $request->service_type;
    //     $page = $request->page ? (($request->page - 1) * $request->limit) : 0;
    //     $limit = $request->limit ?  $request->limit : 10;
    //     $results = Ads::select('ads.id','ads_name','city_name','ads_image','ads.created_at','ads_status','ads_description','ads_price')
    //     ->leftJoin('city', function($join) {
    //         $join->on('city.id', '=', 'ads.city_id');
    //       })
    //     ->skip($page)->take($limit)  
    //     ->where('service_type',$service_type)
    //     ->get();
    //     if($results){
    //         foreach ($results as $key => $value) {
    //             $results[$key]->ads_image =  url('public/images/listing/'.$value->ads_image);
    //         }
    //     }
    //     return response($results,200);
    // }


    public function notification(Request $request){
        $customer_id = $request->customer_id;
        //echo "ssssssss";die;
        Notification::where('customer_id', $customer_id)->update(['notification_read_status' => 1]);

        $results = Notification::select('*')
        ->where("customer_id",$customer_id)
        ->orderBy('id','desc')
        ->get();
        if($results){
            return response($results,200);
        }else{
              $response = ["message" => "Not Added"];
            return response($response, 422);
        }
    }


    // Validation for the mobile field.
   function validateMobileNumber($mobile) {
      if (!empty($mobile)) {
        $isMobileNmberValid = TRUE;
        $mobileDigitsLength = strlen($mobile);
        if ($mobileDigitsLength != 10) {
          $isMobileNmberValid = FALSE;
        } else {
          if (!preg_match("/^[+]?[1-9][0-9]{9,14}$/", $mobile)) {
            $isMobileNmberValid = FALSE;
          }
        }
        return $isMobileNmberValid;
      } else {
        return false;
      }
    }

}   