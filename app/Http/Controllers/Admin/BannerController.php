<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use File;
use Session;
use Hash;
class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $results = Banner::all();
        $title = "Banner";
        return view('admin.banner.index', compact('title','results'));
    }

    public function create()
    {
        $title = "Add Banner";
        return view('admin.banner.create', compact('title'));
    }

    public function store(Request $request)
    {       
        
        $this->validate($request, [
            'banner_name'        => 'required'
        ]);
        $data = $request->all();
        // dd($request->all());
        if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');
                $banner_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/banner');
                $image->move($destinationPath, $banner_image);
                $data['banner_image'] = $banner_image;
        };

        $banner = new Banner;           
        //value pass above this line in controller
        $banner->create($data);
        // 
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/banner');
    }

    public function show($id)
    {
        //
    }

    public function edit($banner)
    {
        $result = Banner::find($banner);
         $title = "Edit Banner";
        return view('admin/banner.edit', compact('title','result', 'banner'));
    }

    public function update(Request $request, $banner)
    {

        
        $this->validate($request, [
            'banner_name'        => 'required',

        ]);

        $data = $request->all();
        $banner_image = "";
        if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');
                $banner_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/banner');
                // dd($destinationPath);
                $image->move($destinationPath, $banner_image);
                $data['banner_image'] = $banner_image;
        }
        $banner = Banner::find($banner);          
        $banner->update($data);
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/banner');
    }

    public function destroy($banner)
    {
        $res=Banner::find($banner)->delete();
        Session::flash('message', 'Successfully Deleted.');
        return redirect('admin/banner');
    }
    public function status($id,$status)
    {   
        $banner = Banner::find($id);
        $banner->banner_status = $status;
        $banner->save();

    }

}