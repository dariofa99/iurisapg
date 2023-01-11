<?php
namespace App\Services;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Collection;

interface UsersService {

    public function getUsersByRoleName(String $role):Array;
    public function getDocentes():Array;
    public function getEstudiantes():Array;
    public function getDocentesByRama($rama):Array;
    public function getUsersByPermissionName($permission):Collection; 

}