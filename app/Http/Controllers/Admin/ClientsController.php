<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Clients;
use File;
use Session;
use Hash;
class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $results = Clients::all();
        $title = "Clients";
        return view('admin.clients.index', compact('title','results'));
    }

    public function create()
    {
        $title = "Add Clients";
        return view('admin.clients.create', compact('title'));
    }

    public function store(Request $request)
    {       
        
        $this->validate($request, [
            'clients_image'        => 'required'
        ]);
        $data = $request->all();
        // dd($request->all());
        if ($request->hasFile('clients_image')) {
                $image = $request->file('clients_image');
                $clients_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/clients');
                $image->move($destinationPath, $clients_image);
                $data['clients_image'] = $clients_image;
        };

        $clients = new Clients;           
        //value pass above this line in controller
        $clients->create($data);
        // 
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/clients');
    }

    public function show($id)
    {
        //
    }

    public function edit($client)
    {
        $result = Clients::find($client);
         $title = "Edit Clients";
        return view('admin/clients.edit', compact('title','result', 'client'));
    }

    public function update(Request $request, $client)
    {

        $data = $request->all();
        $clients_image = "";
        if ($request->hasFile('clients_image')) {
                $image = $request->file('clients_image');
                $clients_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/clients');
                // dd($destinationPath);
                $image->move($destinationPath, $clients_image);
                $data['clients_image'] = $clients_image;
        }
        $clients = Clients::find($client);          
        $clients->update($data);
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/clients');
    }

    public function destroy($client)
    {
        $res=Clients::find($client)->delete();
        Session::flash('message', 'Successfully Deleted.');
        return redirect('admin/clients');
    }
    public function status($id,$status)
    {   
        $clients = Clients::find($id);
        $clients->clients_status = $status;
        $clients->save();

    }

}