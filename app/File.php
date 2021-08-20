<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class File extends Model
{
    protected $table="files"; //el modelo se va a relacionar con la tabla
    protected $fillable=['original_name','encrypt_name','path','size'];//que campos tiene la
    public $disk;
    
    public function setDisk($disk){
      $this->disk = $disk;
      return $this;
    }

   
       
  /*   public function category(){
        return $this->belongsToMany(TablaReferencia::class,'payment_has_files','file_id','type_category_id')
        ->withPivot('id','payment_id','file_id','type_category_id')->withTimestamps(); 
     } */  

}