<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = auth()->user()->find($id);


        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }


        /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function all()
    {

        $user = auth()->user();

        if ($user->isAdmin == true) {
            $resultado = User::all();
            
            return response()->json([
                'success' => true,
                'data' => $resultado
            ], 200);
        }else{      

            return response()->json([
                'success' => false,
                'messate' => 'No tienes permiso para realizar esta acción'
            ], 400);

        }
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $usuario = auth()->user()->find($id);
        
        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 400);
        }

        $updated = $usuario->fill($request->all())->save();
        
        if ($updated)
            return response()->json([
                'success' => true,
                'message' => 'User updated'

            ], 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'User can not be updated'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $userAdmin = auth()->user();
        if($userAdmin->isAdmin == false){
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para realizar esta acción'
            ], 400);
        }
            
        $usuario = auth()->user()->find($id);

        if(!$usuario){
            return response()->json([
                'succes' => false,
                'message' => 'User not found'
            ], 400);
        }

        if ($usuario -> delete()){
            return response()->json([
                'succes' => true,
                'message' => 'The user ' . $usuario->name . ' with the id ' . $usuario->id . ' has been deleted'
            ]);
        }else {
            return response() ->json([
                'success' => false,
                'message' => 'User can not be deleted',
            ], 500);
        }
      
    }


    public function logout(Request $request) {
        $user = auth()->user()->token()->revoke();

        if(!$user){
            return response()->json([
                'succes' => false,
                'message' => 'There was a problem. User not logout'
            ], 400);
        }else {            
            return response()->json([
                'succes' => true,
                'message' => 'See you soon '
            ], 200);
        }
    }
}
