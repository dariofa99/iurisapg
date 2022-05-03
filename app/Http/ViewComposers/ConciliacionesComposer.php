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

		$types_status = TablaReferencia::where(['categoria'=>'type_status',
		'tabla_ref'=>'conciliaciones'])
		->where('ref_nombre','<>','Sin definir')
		->pluck('ref_nombre','id'); 
		$types_users = TablaReferencia::where(['categoria'=>'type_user_conciliacion',
		'tabla_ref'=>'conciliaciones_has_user'])
		->where('ref_nombre','<>','Sin definir')
		->pluck('ref_nombre','id');

		$types_status_pretension = TablaReferencia::where([
			'categoria'=>'type_status',
			'tabla_ref'=>'conc_hechos_preten'])
		->where('ref_nombre','<>','Sin definir')
		->pluck('ref_nombre','id'); 
		$types_firma_users = TablaReferencia::where(['categoria'=>'type_user_firm_conciliacion',
		'tabla_ref'=>'pdf_reportes_users'])
		->where('ref_nombre','<>','Sin definir')
		->pluck('ref_nombre','id');

//dd("s");
		$view->with([
			'types_firma_users'=>	$types_firma_users ,
			'types_status'=>$types_status,
			'types_users'=>$types_users,
			'types_status_pretension'=>$types_status_pretension
		]);
	}

	
}


