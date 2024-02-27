<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Setting;
use Session;
use Auth;

class SettingController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $result = Setting::first();

        $title = "Setting";
        
        return view('admin.setting.index', compact('title','result'));
         
    }

    
    public function update(Request $request, $setting)
    {
        $this->validate($request, [
                    'company_name'      =>  'required',
                    'company_address'   =>  'required',  
                    'company_mobile'    =>  'required',  
                    'company_email'     =>  'required',
                    'currency'          =>  'required',
                    'facbook'           =>  'required',
                    'google_plus'       =>  'required',
                    'youtube'           =>  'required',
                    'meta_title'        =>  'required',
                    'meta_description'  =>  'required',  
                    'meta_keyword'      =>  'required',
                    'indeed'            =>  'required',
                    'behance'           =>  'required',
                    'iframe'            =>  'required',
                    //'company_logo'     =>  'required',
        ]);

         $image_name_old = $request->get('company_logo_old');
         $company_logo2_old = $request->get('company_logo2_old');
         $company_fav_old = $request->get('company_fav_old');

        $company_fav =  $company_fav_old;
        if ($request->hasFile('company_fav')) {
                $image = $request->file('company_fav');
                $company_fav = 'fav-icon-'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $company_fav);
        }

          $company_logo = $image_name_old;
        if ($request->hasFile('company_logo')) {
                $image = $request->file('company_logo');
                $company_logo = 'company-logo-'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $company_logo);
        }

          $company_logo2 = $company_logo2_old;
        if ($request->hasFile('company_logo2')) {
                $image = $request->file('company_logo2');
                $company_logo2 = 'company-logo2-'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $company_logo2);
        }        

        $setting = Setting::first();
            $setting->company_name          =   $request->get('company_name');
            $setting->company_address       =   $request->get('company_address');
            $setting->company_mobile        =   $request->get('company_mobile');
            $setting->company_email         =   $request->get('company_email');
            $setting->currency              =   $request->get('currency');
            $setting->facbook               =   $request->get('facbook');
            $setting->indeed                =   $request->get('indeed');
            $setting->youtube               =   $request->get('youtube');
            $setting->behance               =   $request->get('behance');
            $setting->google_plus           =   $request->get('google_plus');
            $setting->instrgram             =   $request->get('instrgram');
            $setting->meta_title            =   $request->get('meta_title');
            $setting->meta_description      =   $request->get('meta_description');
            $setting->meta_keyword          =   $request->get('meta_keyword');
            $setting->iframe                =   $request->get('iframe');
            $setting->company_fav           =   $company_fav;
            $setting->image_name2           =   $company_logo2;
            $setting->image_name            =   $company_logo;

          // print_r($setting);die;
         $setting->save();

        //Project::create($request->all());
         Session::flash('message', 'Successfully created.');
         return redirect('admin/setting');
    }

   
    public function destroy($id)
    {
       
    }



}