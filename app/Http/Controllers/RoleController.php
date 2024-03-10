<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends Controller
{
    //
    public function index(){
        try{ 
            $roles = Role::all();
            if($roles){
                return response()->json([
                    'data' => $roles 
                ],200);
            }else{
                return response()->json([
                    'error' => 'No roles'
                ],204);
            }     
        }catch(ValidationException $e){
            return response()->json([
                'errors' => $e->validator->errors()->all()
            ], 422);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function store(Request $request){
        try{
            $data = $request->validate([
                'role_name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
                'description' => 'required',
            ]);

            $role = Role::create([
                'role_name' => $request->role_name,
                'description' => $request->description,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Role created successfully!'
            ],200);

        }catch(ValidationException $e){
            return response()->json([
                'errors' => $e->validator->errors()->all()
            ], 422);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function update(Request $request,$id){
        try {
            $role = Role::find($id);
            
            $data = $request->validate([
                'role_name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
                'description' => 'required',
            ]);
            $role->role_name = $data['role_name'];
            $role->description = $data['description'];
    
            $role->save();
            return response()->json(['message' => 'Role updated successfully'], 200);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'dsadsad'], 500);
        }
    }
    public function destroy($id){
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json(['message' => 'Role deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Role not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
