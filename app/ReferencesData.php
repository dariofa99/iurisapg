<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferencesData extends Model 
{ 
    protected $table="references_data"; //el modelo se va a relacionar con la tabla
    protected $fillable=['name','categories','table','section','is_visible','type_data_id'];//que campos tiene la


    public function getCategory(){
        if($this->categories=='users'){
            return 'Usuarios';
        }else{
            return "Sin categoría";
        }  
    }
 
    public function options(){
        return $this->hasMany(ReferenceDataOptions::class,'references_data_id','id'); 
    } 

}
