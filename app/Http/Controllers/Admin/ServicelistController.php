<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Servicelist;
use App\Models\Service;
use File;
use Session;
use Hash;
use Str;
class ServicelistController extends Controller
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
        $results = Servicelist::select('servicelist.*','service.service_name')
                   ->join('service','service.id','servicelist.service_id')
                   ->get();
         // dd($results->toArray());          

        $title = "Service list";
        return view('admin.servicelist.index', compact('title','results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = Service::all();
        $title = "Add Service list";
        return view('admin.servicelist.create', compact('title','service'));
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
            'service_list_name'        => 'required'
        ]);
        $data = $request->all();
        // dd($request->all());
        if ($request->hasFile('service_list_image')) {
                $image = $request->file('service_list_image');
                $service_list_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/servicelist');
                $image->move($destinationPath, $service_list_image);
                $data['service_list_image'] = $service_list_image;
        };
        $data['service_list_slug'] = Str::slug($data['service_list_name'],"-");
        $servicelist = new Servicelist;           
        //value pass above this line in controller
        $servicelist->create($data);
        // 
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/servicelist');
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
    public function edit($servicelist)
    {
        $service = Service::all();
        $result = Servicelist::find($servicelist);
         $title = "Edit Service list";
        return view('admin/servicelist.edit', compact('title','result','service','servicelist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $servicelist)
    {

        
        $this->validate($request, [
            'service_list_name'        => 'required',

        ]);

        $data = $request->all();
        $service_list_image = "";
        if ($request->hasFile('service_list_image')) {
                $image = $request->file('service_list_image');
                $service_list_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/servicelist');
                // dd($destinationPath);
                $image->move($destinationPath, $service_list_image);
                $data['service_list_image'] = $service_list_image;
        }
        $data['service_list_slug'] = Str::slug($data['service_list_name'],"-");
        $servicelist = Servicelist::find($servicelist);          
        $servicelist->update($data);
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/servicelist');
    }

    public function destroy($servicelist)
    {
        $res=Servicelist::find($servicelist)->delete();
        Session::flash('message', 'Successfully Deleted.');
        return redirect('admin/servicelist');
    }
    public function status($id,$status)
        {   
            $servicelist = Servicelist::find($id);
            $servicelist->service_list_status = $status;
            $servicelist->save();

        }

}