<?php
namespace App\Services;


interface UsersService {

    public function getUsersByRoleName(String $role):Array;
    public function getDocentes():Array;
    public function getEstudiantes():Array;

}