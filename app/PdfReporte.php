<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UploadFile;
class PdfReporte extends Model
{
    use UploadFile;

    public $disk = 'pdf_reporte_files';
    protected $table = 'pdf_reportes';

    protected $fillable = [
        'reporte',
        'report_keys',
        'nombre_reporte',
        'configuraciones'
    ];

    public function destino()
    {
       return $this->belongsTo(PdfReporteDestino::class,'id','reporte_id');
    } 
    
    public function getConfig()
    {
        $configuraciones = json_decode($this->configuraciones);
       return $configuraciones;
    } 

    public function getPdfConfig($seccion)
    {
        $configuraciones = $this->files()->where('seccion',$seccion)->first();
        if($configuraciones){
            $configuracion =  json_decode($configuraciones->pivot->configuracion);    
            $configuracion->imagen = "/storage/".$configuraciones->path;   
          // dd($configuracion) ;
           return $configuracion;
        }        
       return null;
    } 

    public function files(){
        return $this->belongsToMany(File::class,'pdf_reportes_has_files','pdf_reporte_id')
        ->withPivot('id','pdf_reporte_id','seccion','file_id','configuracion')->withTimestamps(); 
     } 
   
}
