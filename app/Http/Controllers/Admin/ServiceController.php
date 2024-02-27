<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Service;
use File;
use Session;
use Hash;
use Str;
class ServiceController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Service::all();
        $title = "Service";
        return view('admin.service.index', compact('title','results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Service";
        return view('admin.service.create', compact('title'));
    }

    /**
     * Store a newly Saved resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        
        $this->validate($request, [
            'service_name'        => 'required'
        ]);
        $data = $request->all();
        // dd($request->all());
        if ($request->hasFile('service_image')) {
                $image = $request->file('service_image');
                $service_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/service');
                $image->move($destinationPath, $service_image);
                $data['service_image'] = $service_image;
        };
        $data['service_slug'] = Str::slug($data['service_name'],"-");
        $service = new Service;           
        //value pass above this line in controller
        $service->create($data);
        // 
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/service');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($service)
    {
        $result = Service::find($service);
         $title = "Edit Service";
        return view('admin/service.edit', compact('title','result', 'service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $service)
    {

        
        $this->validate($request, [
            'service_name'        => 'required',

        ]);

        $data = $request->all();
        $service_image = "";
        if ($request->hasFile('service_image')) {
                $image = $request->file('service_image');
                $service_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/service');
                // dd($destinationPath);
                $image->move($destinationPath, $service_image);
                $data['service_image'] = $service_image;
        }
        $data['service_slug'] = Str::slug($data['service_name'],"-");
        $service = Service::find($service);          
        $service->update($data);
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/service');
    }

    public function destroy($service)
    {
        $res=Service::find($service)->delete();
        Session::flash('message', 'Successfully Deleted.');
        return redirect('admin/service');
    }
    public function status($id,$status)
        {   
            $service = Service::find($id);
            $service->service_status = $status;
            $service->save();

        }

}