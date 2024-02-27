<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Session;
use Hash;
use Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $id = Auth::user()->email;
        $result = Profile::where('email',$id)->first();
        $title = "Profile";
        return view('admin.profile.index', compact('title','result'));
    }
    public function show($id)
    {
        //
    }

    public function update(Request $request, $profile)
    {
        // dd($request);
        
        $this->validate($request, [
            'name'        => 'required',
            'email'             => 'unique:customer,email,'.$profile,
            // 'profile_image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        $profile = Profile::find($profile);          
        $profile->update($data);
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/profile');
    }



}