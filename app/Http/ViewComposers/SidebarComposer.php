<?php 
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use DB;
use App\Sede;




/**
*  
*/
class SidebarComposer
{
	
	public function compose(View $view)
	{
        $sedes = Sede::pluck('nombre','id_sede') ;

		$view->with(['sedes'=>$sedes]);
	}

	
}


