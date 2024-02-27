<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\About;
use Session;
use Auth;

class AboutController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $result = About::first();

        $title = "About";
        return view('admin.about.index', compact('title','result'));
         
    }
 
    public function update(Request $request, $about)
    {
        $this->validate($request, [
                    'about_content'      =>  'required',
        ]);

        $about = About::first();
            $about->about_content          =   $request->get('about_content');
         $about->save();

        //Project::create($request->all());
         Session::flash('message', 'Successfully created.');
         return redirect('admin/about');
    }

   
    public function destroy($id)
    {
       
    }



}