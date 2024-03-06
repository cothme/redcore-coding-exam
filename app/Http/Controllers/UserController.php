<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(){
        return User::all();
    }
    public function store(){
        return 'dsafasfg';
    }
    public function update(){
        return 'dsafasfg';
    }
    public function delete(){
        return 'dsafasfg';
    }
}
