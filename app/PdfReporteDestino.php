<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdfReporteDestino extends Model
{


   
    protected $table = 'pdf_reportes_destinos';

    protected $fillable = [ 
        'tabla_destino',
        'reporte_id',
        'status_id'
    ];

    public function reporte()
    {
       return $this->belongsTo(PdfReporte::class,'reporte_id');
    } 
    
    public function users()
    {
        return $this->belongsToMany(User::class,'pdf_reportes_users','pdf_reporte_id')
        ->withPivot('pdf_reporte_id','conciliacion_id','tipo_usuario_id','user_id','token','codigo','firmado')
        ->withTimestamps();
    } 
   
}
