<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $table = 'setting';
    protected $fillable = [ 
							 'company_name'   
							 ,'company_address' 
							 ,'company_mobile'  
							 ,'company_email'   
							 ,'currency'        
							 ,'facbook'         
							 ,'indeed'
							 ,'youtube'
							 ,'behance'         
							 ,'google_plus'     
							 ,'instrgram'       
							 ,'meta_title'      
							 ,'meta_description'
							 ,'meta_keyword'    
							 ,'company_fav'     
							 ,'company_logo2'   
							 ,'company_logo'
							 ,'iframe'    


    ];
}
