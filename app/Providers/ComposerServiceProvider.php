<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services. 
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'galeria.create',
            'galeria.index',
            'galeria.show_biblioteca_inactiva'
        ],'App\Http\ViewComposers\BibliotecasComposer'); 

        View::composer([
            'myforms.conciliaciones.*',    
        ],'App\Http\ViewComposers\ConciliacionesComposer'); 

        
        View::composer([
            'myforms.notas_ver.*',    
        ],'App\Http\ViewComposers\NotasComposer');
        
        View::composer([
            'myforms.frm_expediente_create',
            'myforms.frm_expediente_edit',
            'myforms.frm_expediente_show',
            'myforms.frm_expediente_list',
            'myforms.frm_requerimiento_list',
            'myforms.components_user.*',
            'myforms.solicitudes.*',   
            'myforms.conciliaciones.*'               
        ],'App\Http\ViewComposers\ExpedientesComposer');

        View::composer([
            'myforms.frm_defensa_oficio_create',
            'myforms.frm_defensa_oficio_edit', 
            'myforms.frm_defensa_oficio_show',                                   
        ],'App\Http\ViewComposers\DefensasOficioComposer'); 


        View::composer([
            'myforms.frm_myusers_edit',
            'myforms.frm_myusers', 
            'myforms.frm_myusers_list', 
            'myforms.frm_mystudents_list',
            'myforms.frm_oficinas_list', 
            'myforms.recepcion.*', 
            'front.solicitudes.*', 
            'myforms.register', 
                                  
        ],'App\Http\ViewComposers\UsersComposer');       
        
        View::composer([
            'myforms.frm_oficinas_ver',                       
        ],'App\Http\ViewComposers\OficinasComposer');

        View::composer([
            'myforms.solicitudes.*',  
            'front.solicitudes.*',                       
        ],'App\Http\ViewComposers\SolicitudesComposer');

        View::composer([
            'myforms.categories.*',   
            'myforms.static_categories.*',                                  
        ],'App\Http\ViewComposers\CategoriasComposer');

        View::composer([
            'layouts.*',                                  
        ],'App\Http\ViewComposers\SidebarComposer');
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
