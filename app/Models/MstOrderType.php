<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LIBRESSLtd\LBForm\Traits\LBDatatableTrait;
use Auth;

class MstOrderType extends Model
{
    use LBDatatableTrait;

    static public function boot()
    {
        MstOrderType::saving(function ($type) {
        	if (Auth::user())
        	{
	            if ($type->id)
	            {
	            	$type->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$type->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
