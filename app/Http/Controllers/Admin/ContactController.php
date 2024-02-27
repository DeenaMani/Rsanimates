<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use File;
use Session;
use Hash;
use Str;
class ContactController extends Controller
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
        $results = Contact::all();
        $title = "Contact";
        return view('admin.contact.index', compact('title','results'));
    }

    public function destroy($contact)
    {
        $res=Contact::find($contact)->delete();
        Session::flash('message', 'Successfully Deleted.');
        return redirect('admin/contact');
    }
    
    public function view($id)
    {
        $result = Contact::find($id);
        $title = "view";
        return view('admin.contact.view', compact('title','result'));
    }
}