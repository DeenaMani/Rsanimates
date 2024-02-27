<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Session;
use Hash;
class CustomerController extends Controller
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
        $results = Customer::orderBy('id','desc')->get();
        $title = "Customer";
        return view('admin.customer.index', compact('title','results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Customer";
        return view('admin.customer.create', compact('title'));
    }

    /**
     * Store a newly Saved resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        // dd($request);die;
        $this->validate($request, [
            'id'                => '',
            'first_name'        => 'required',
            'email'             => 'unique:customer,email',
            'password'          => 'required|min:5',
            'profile_image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $data = $request->all();
        // dd($request->all());
        $data['password'] = Hash::make($request->password);
        if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $customer_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/customer');
                $image->move($destinationPath, $customer_image);
                $data['profile_image'] = $customer_image;
        }
        // dd($data);
        $customer = new Customer;           
        //value pass above this line in controller
        $customer->create($data);
        // dd($customer);
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/customer');
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
    public function edit($id)
    {
        $result = Customer::find($id);
         $title = "Edit Customer";
        return view('admin/customer.edit', compact('title','result', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        
        $this->validate($request, [
            'first_name'        => 'required',
            'email'             => 'unique:customer,email,'.$id,
            'profile_image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        $customer_image = "";
        if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $customer_image = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/customer');
                $image->move($destinationPath, $customer_image);
                $data['profile_image'] = $customer_image;
        }
        $customer = Customer::find($id);          
        $customer->update($data);
        Session::flash('message', 'Successfully Saved.');
        return redirect('admin/customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res=Customer::find($id)->delete();
        Session::flash('message', 'Successfully Deleted.');
        return redirect('admin/customer');
    }

    public function status($id,$status)
        {
            $customer = Customer::find($id);
            $customer->status =   $status;
            $customer->save();

        }

}