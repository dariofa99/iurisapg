<?php 
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\RamaDerecho;
use App\User;
use App\Segmento;
use App\MotivoEstadoCaso;
use App\Estado;
use App\ReqAsistencia;
use App\Periodo;
use App\Role;
use App\RefAsignacionCaso;
use App\MotivoAsigCaso;
use DB;
use App\Sede;
use App\TablaReferencia;



/**
*  
*/
class ConciliacionesComposer
{
	
	public function compose(View $view)
	{

		$types_status = TablaReferencia::where(['categoria'=>'type_status','tabla_ref'=>'conciliaciones'])
		->where('ref_nombre','<>','Sin definir')
		->pluck('ref_nombre','id'); 
		

		$view->with(['types_status'=>$types_status]);
	}

	
}


