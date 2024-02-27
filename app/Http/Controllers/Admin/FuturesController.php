<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Futures;
use File;
use Session;
use Hash;
class futuresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $results = Futures::all();
        $title = "futures";
        return view('admin.futures.index', compact('title','results'));
    }

    public function create()
    {
        $title = "Add futures";
        return view('admin.futures.create', compact('title'));
    }

    public function store(Request $request)
    {       
        
        $this->validate($request, [
            'heading'        => 'required'
        ]);
        $data = $request->all();
        // dd($request->all());
        if ($request->hasFile('image_name')) {
                $image = $request->file('image_name');
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/futures');
                $image->move($destinationPath, $image_name);
                $data['image_name'] = $image_name;
        };

        $futures = new Futures;           
        //value pass above this line in controller
        $futures->create($data);
        // 
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/futures');
    }

   
    public function edit($future)
    {
        $result = Futures::find($future);
         $title = "Edit futures";
        return view('admin/futures.edit', compact('title','result', 'future'));
    }

    public function update(Request $request, $future)
    {

        
        $this->validate($request, [
            'heading'        => 'required',

        ]);

        $data = $request->all();
        $image_name = "";
        if ($request->hasFile('futures_image')) {
                $image = $request->file('futures_image');
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/futures');
                // dd($destinationPath);
                $image->move($destinationPath, $image_name);
                 $data['image_name'] = $image_name; 
        }
       
        $futures = Futures::find($future);          
        $futures->update($data);
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/futures');
    }

    public function destroy($future)
    {
        $res=Futures::find($future)->delete();
        Session::flash('message', 'Successfully Deleted.');
        return redirect('admin/futures');
    }
    public function status($id,$status)
    {   
        $futures = Futures::find($id);
        $futures->futures_status = $status;
        $futures->save();

    }

}