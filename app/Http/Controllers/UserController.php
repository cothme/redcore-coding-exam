<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function index(){
        try{
            
            return User::all();

        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
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
