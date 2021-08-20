<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('webservice','WebServicesController@index');

Route::post('webservice','WebServicesController@index');
Route::get('pruebasocket','WebServicesController@pruebaSocket');
Route::get('autorizacion', 'AutorizacionesController@verificar');
Route::post('autorizacion/verificar', 'AutorizacionesController@verificarPdf');



Route::resource('logout', 'LogoutController'); 

Route::get('terminosycondiciones', function () {
  return view('auth.terminosycondiciones');
});







///rutas que requieren atenticación
Route::group(['middleware' => ['auth']], function() {

Route::post('mail', 'MailController@store')->name('mail.store');


//Citaciones estudiante
Route::resource('citaciones/estudiante', 'CitacionEstudiantesController');
Route::post('/citaciones/search/forday', 'CitacionEstudiantesController@searchCitasForDay');



Route::resource('notifications', 'NotificationsController');

Route::resource('users', 'MyusersController');
Route::get('users/confirm/email/{token}', 'MyusersController@confirm_email');
Route::get('users/find/us', 'MyusersController@findUser');
Route::post('users/store', 'MyusersController@userStore');

Route::group(['middleware' => ['confirm_email','perfil']], function() {

Route::get('pruebas/mail',function(){
  return view('myforms.admin.frm_mail');
});

Route::get('home',function(){
  return view('myforms.frm_bienvenida');
});
/* Route::get('/dashboard', function () {
  if(auth()->user()->hasRole("solicitante")){
    return Redirect::to('oficina/solicitante');
  }
    return view('myforms.frm_bienvenida');
}); */
Route::get('/dashboard',"SedesController@selectSede");
Route::get('/change/sedes',"SedesController@changeSede");
//Route::get('/change/sedes/cambiar/{sede_id}',"SedesController@changeSede");//->name('change.sede');
 
//Rutas bibliotecas
Route::resource('bibliotecas', 'BibliotecaController');
Route::get('bibliotecas/inactivas/view', 'BibliotecaController@showBibliotecaOff')->name('biblioteca.inactivas');
Route::get('bibliotecas/pdf/{id}', 'BibliotecaController@bibliodowpdf')->name('biblioteca.pdf');
Route::get('bibliotecas/change/{id}', 'BibliotecaController@change')->name('biblioteca.change');
Route::post('bibliotecas/update', 'BibliotecaController@update')->name('biblioteca.update');


 
//Usuarios
Route::get('usuarios', function () {
    return view('myforms.frm_myusers');
});
Route::get('usuarios/index/page','MyusersController@index_page');
Route::get('students/', 'MyusersController@indexEst')->name('students.index');
Route::get('curso/empty', 'MyusersController@cursoEmpty')->name('curso.empty');
Route::post('students/get', 'MyusersController@getEstudiantes');
Route::post('docentes/get', 'MyusersController@getDocentes');
Route::post('solicitantes/get', 'MyusersController@getSolicitantes');
Route::get('users/get/{id}', 'MyusersController@getAllusers');

//rutas para el manejo de roles y permisos
Route::group(['prefix' => 'admin'], function() {
  Route::resource('/permisos','PermissionsController');
	Route::resource('/roles','RolesController');
	Route::get('/asig','RolesController@admin')->name('roles.admin');
	Route::post('/sync/permission','RolesController@syncPermissionRole');
	Route::post('/get/sync/permissions','RolesController@getPermissionsRole');
	Route::post('/permissions/change','RolesController@change_permissions'); 

});

Route::post('users/change/state','MyusersController@changeStateUser');

Route::get('users/destroy/{id}',[
    'uses'=>'MyusersController@destroy',
    'as'=>'users.destroy' 
]);

Route::get('turnos/docentes', 'TurnosDocentesController@index');
Route::get('turnos/docentes/{id}', 'TurnosDocentesController@store');
Route::get('turnos/docentes/reporte/asis', 'TurnosDocentesController@show');
Route::post('turnos/acdocentes', 'TurnosDocentesController@updateinfo');

//Graficas
Route::resource('graficas','GraficasController');
Route::post('graficas/search','GraficasController@search_data');   

//Asignaciones Estudiantes Docente
Route::resource('docentes/asigest','AsigDocentEstController');
Route::post('docentes/asigest/confirm','AsigDocentEstController@confAsigDoc');

//Asignaciones casos Docente
Route::resource('docentes/casos','AsigDocenteCasoController');
//Route::post('docentes/asigest/confirm','AsigDocenteCaso@confAsigDoc');

 //Horario docente
 Route::resource('docentes/horario','HorarioDocenteController'); 
 Route::post('docentes/search/horario','HorarioDocenteController@searchHorasDocente');   
 Route::post('docentes/horario/delete/all','HorarioDocenteController@deleteAllHorarioDocentes');
//Route::get('docentes/horario/search/estudiante','HorarioDocenteController@searchEstud');

//Turnos
Route::get('turnos/asistencia', 'TurnosController@reporasistencia');
Route::get('turnos/asistencia/detalles/{idnum}', 'TurnosController@reporAsistenciaDetalles');
Route::resource('turnos','TurnosController');
Route::post('turnos/delete/all','TurnosController@deleteAllTurnos');


//Excel usuarios
Route::get('usuarios/importar', 'ExcelusuariosController@getImport');
Route::post('usuarios/importar/iniciar', 'ExcelusuariosController@postImport');

//Excel 
Route::resource('excel', 'ExcelController');
Route::post('excel/search', 'ExcelController@search_data');
Route::post('excel/download', 'ExcelController@generate_data');
Route::post('excel/search/options', 'ExcelController@search_options');
Route::get('excel/notas/download', 'ExcelController@notas_download'); 

//Asignaciones
Route::resource('asignaciones', 'AsignacionesController');
Route::post('asignaciones/update/{id}', 'AsignacionesController@updateDocenteAsignado');



//Expedientes
Route::resource('expedientes', 'ExpedienteController');
Route::get('expedientes/historial/{exp}/{tipo}', 'ExpedienteController@historialDatosCaso');
Route::get('expedientes/selectconest/{texcon}', 'ExpedienteController@selectest');
Route::post('expedientes/coordinador/update/{id}', 'ExpedienteController@update');
Route::get('expedientes/index/', 'ExpedienteController@index');
Route::get('expediactuacion/', 'ExpedienteController@listarActuaciones');
Route::post('expedientes/reasigcaso/', 'ExpedienteController@reasigcaso');
Route::post('expedientes/sustituircasos/', 'ExpedienteController@sustcasos')->name('expedientes.sustcasos');
Route::get('expediente/replacecaso/', 'ExpedienteController@replacecaso');
Route::post('expedientes/getestudiantes/', 'ExpedienteController@getEstudiantes');
Route::get('expediente/casos/reasignados', 'ExpedienteController@casosreasig');
Route::post('expedientes/anteriorestudiante/', 'ExpedienteController@anteriorEstudiante');
Route::post('expedientes/buscarexpasig/', 'ExpedienteController@searchExpAsig'); 

Route::get('expediente/createstream/{id}', 'ExpedienteController@createStream'); 
Route::get('expediente/sharestream/{id}', 'ExpedienteController@shareStream');  



//Ediar usuarios desde Expedientes
Route::resource('expuser', 'ExpedienteUserController');

//cierre de caso/expedientes
Route::resource('expcierrecaso', 'ExpedienteCierreController');

//estados caso
Route::resource('estados/caso', 'EstadosCasoController');
Route::post('/estado/search/', 'EstadosCasoController@search');


//Defensas de Oficio
Route::resource('defensas/oficio', 'DefensaOficioController');

//Autorizaciones
Route::resource('autorizaciones', 'AutorizacionesController');
Route::get('autorizaciones/descargar/{id}', 'AutorizacionesController@descargarPdf');

//Oficinas
Route::resource('oficinas', 'OficinaController');
Route::get('oficinas/users', 'OficinaController@getUsers');
Route::get('oficinas/ver/{id}', 'OficinaController@ver');
Route::get('oficinas/user/delete', 'OficinaController@deleteUser');

//Notas ext
Route::resource('notasext', 'NotaExtController');
//Route::get('notasext/find', 'NotaExtController@find');

//Sedes
Route::resource('sedes', 'SedesController');


//Actuaciones
Route::get('listaractuaciones', 'ExpedienteController@listarActuaciones');

Route::resource('actuaciones', 'ActuacionController');
Route::post('/actuaciones/update/doc/{id}', 'ActuacionController@updoc');
Route::post('/actuaciones/store/revision', 'ActuacionController@storeRevision');
Route::post('/actuaciones/update/{id}', 'ActuacionController@update');
Route::post('/actuaciones/revisar/{id}', 'ActuacionController@revisiones');
Route::get('/actuaciones/search/previous', 'ActuacionController@get_act_ant');
Route::post('/actuaciones/set/notas', 'ActuacionController@set_notas');

Route::get('/actuaciones/create/pru', 'ActuacionController@create');

Route::get('actpdfdownload/{id}/{user_doc}' , 'ActuacionController@actpdfdownload');


//requerimientos
Route::resource('requerimientos', 'RequerimientoController');
Route::get('reqpdfgen/{id}',  'RequerimientoController@reqpdfgen');
Route::post('requerimientos/update/{id}',  'RequerimientoController@updateReq');




//notas // Calificaciones
Route::resource('notas', 'NotaController');
Route::post('/notas/update', 'NotaController@updateNota');
Route::post('/notas/delete', 'NotaController@delete'); 
Route::post('/notas/search', 'NotaController@searchNotas');
//Route::get('/notas/search/get', 'NotaController@searchNotas');

//Asesorias
Route::resource('asesorias', 'AsesoriasDocenteController');
Route::post('asesorias/change/shared', 'AsesoriasDocenteController@changeShared');

//Segmentos
Route::resource('segmentos', 'SegmentosController');
Route::get('segmentos/change/state/{id}','SegmentosController@changeState');
Route::get('segmentos/change/fc','SegmentosController@change_state_segfc');
Route::get('segmentos/close/{id}','SegmentosController@closeSegmento');
//Periodos
Route::resource('periodos', 'PeriodosController');
Route::get('periodos/change/state/{id}','PeriodosController@changeState');
Route::post('periodos/buscar/segmentos/{id}','PeriodosController@searchSegmentos');

//Auditoria
Route::resource('auditoria', 'AuditoriaController');

//Documentos
Route::resource('documentos', 'CaseLogController');
Route::get('documentos/get', 'CaseLogController@getDocuments');
Route::post('documentos/{id}', 'CaseLogController@update');
Route::get('/descargar/documento/{id}','CaseLogController@downloadFileLog');

//Conciliaciones
Route::resource('conciliaciones', 'ConciliacionesController');
Route::post('conciliaciones/insert/data', 'ConciliacionesController@insertData');
Route::post('conciliaciones/insert/estado', 'ConciliacionesController@insertEstado'); 
Route::post('conciliaciones/insert/comentario', 'ConciliacionesController@insertComentario'); 
Route::get('conciliaciones/delete/comentario', 'ConciliacionesController@deleteComentario'); 
Route::get('conciliaciones/edit/comentario', 'ConciliacionesController@editComentario');
Route::post('conciliaciones/update/comentario', 'ConciliacionesController@updateComentario'); 
Route::post('conciliaciones/store/anexo', 'ConciliacionesController@storeAnexo');
Route::get('conciliaciones/delete/anexo', 'ConciliacionesController@deleteAnexo');
Route::post('conciliaciones/update/anexo', 'ConciliacionesController@updateAnexo');
Route::get('conciliaciones/download/file/{file_id}', 'ConciliacionesController@downloadFile'); 
Route::get('conciliaciones/delete/estado', 'ConciliacionesController@deleteEstado');
Route::get('conciliaciones/edit/estado', 'ConciliacionesController@editEstado');
Route::post('conciliaciones/update/estado', 'ConciliacionesController@updateEstado');

//imagen perfil
Route::resource('thumbnail', 'ThumbnailController');


//configuración
Route::resource('config_roles', 'ConfigRoleController');


//////////////Calendario

//Calendario
Route::get('horarios/{id}', 'HorarioController@calendario');
Route::resource('horarios', 'HorarioController');

//ReferencesData
Route::resource('categorias', 'ReferencesDataController');  

 
 
//ReferencesStaticData
Route::resource('categories', 'ReferencesStaticDataController'); 


//consulta calendario
Route::get('consultahor/{clbd}/{hrbd}/{datev}','HorarioController@consultach');
Route::get('consultahordoc/{clbd}/{hrbd}/{datev}','HorarioController@consultahordoc');
Route::get('consultahordocasis/{clbd}/{hrbd}/{datev}','HorarioController@consultahordocasis');
Route::post('horario/updatehordocasis','HorarioController@updatehordocasis');
Route::post('horario/regishordocasis','HorarioController@regishordocasis');



//prueba
Route::get('prueba/expedienteasig','ExpedienteController@pruebaasig');
Route::get('prueba/citas','CitacionEstudiantesController@citasAutomatic');
Route::get('prueba/citas/correo','CitacionEstudiantesController@listCorreoCitasGen');
Route::get('/mail/html', function () {
  return view('myforms.mails.frm_citacion_estudiante_gen');

});


});//fin middleware perfil
Route::group(['middleware' =>'front'], function() { 

Route::group(['prefix' =>'oficina'], function() { 
  Route::resource('solicitante','FrontController');
  Route::get('solicitante/solicitud/{id}','FrontController@solicitud_show');

});


//solicitudes
Route::post('solicitudes/store/documento','SolicitudesController@storeDocument');
Route::get('solicitudes/files/{id}/edit','SolicitudesController@editDocumento');
Route::post('solicitudes/update/documento','SolicitudesController@updateDocument');
Route::get('solicitudes/files/delete/{id}','SolicitudesController@deleteDocumento');
});
Route::get('/', function () {
  return redirect('/dashboard');
});

});//fin middleware auth
Route::resource('solicitudes','SolicitudesController');
Route::get('solicitudes/view/{token}','SolicitudesController@waitRoom');
Route::post('solicitudes/user/register','SolicitudesController@userRegister');
Route::get('solicitudes/find/e','SolicitudesController@find');
Route::get('login',array('as'=>'login',function(){
    return view('myforms.login');
}));
Route::get('recepcion',"SolicitudesController@recepcion");
/* 
Route::get('recepcion',function(){
 
  return view('myforms.recepcion.frm_solicitud');
});  */










/*
//mantenimiento

Route::get('/', function () {
   return view('mantenimiento');
  //  return view('welcome');
});
Route::get('/login', function () {
   return view('mantenimiento');
  //  return view('welcome');
});


//fin mantenimiento//
*/


Auth::routes();

Route::post('/login', 'LoginController@store')->name('login'); 
Route::get('/login', function () {
       return view('myforms.login');
});
/* Route::get('/', function () {
  return redirect('/dashboard');
}); */

Route::get('/prueba', function () {
  dd(currentUser()->oficinas);
 // NotaExt::message();
  // dd(N
}
);
