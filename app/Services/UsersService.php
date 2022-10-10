<?php
namespace App\Services;

use App\Http\Requests\Request;

interface UsersService {

    public function getUsersByRoleName(String $role):Array;
    public function getDocentes():Array;
    public function getEstudiantes():Array;
    public function getDocentesByRama($rama):Array;

}