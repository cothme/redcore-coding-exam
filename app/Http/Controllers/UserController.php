<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function show_current_user(Request $request){
        return $request->user();
    }
    public function index(){
        try{ 
            $users = User::all();
            if($users){
                return response()->json([
                    'data' => $users 
                ],200);
            }else{
                return response()->json([
                    'error' => 'No users'
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
    public function update(Request $request,$id){
        try {
            $user = User::find($id);
            
            $credentials = $request->validate([
                'full_name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
                'email' => 'required',
                'password' => 'nullable|string|min:8|max:20|confirmed',
            ]);
    
            $input = $request->only(['full_name', 'email']);
    
            $user->update($credentials);
    
            return response()->json(['message' => 'User updated successfully'], 200);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function destroy(Request $request, $id){
        try {
            $user_id = $request->user()->id;
            $user_to_delete = User::find($id)->id;
            if($user_id == $user_to_delete){
                return response()->json(['error' => 'You cannot delete your own profile'], 403);
            }

            User::find($id)->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
