<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Membership;
use Illuminate\Http\Request;

class MessageController extends Controller
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

        $this->validate($request, [
            'party_id',
            'user_id',
            'text'
        ]);

        $user = auth()->user();

        $resultado = Membership::where('party_id', '=', $request->party_id)->where('user_id', '=', $user->id)->get();

        if($resultado->isEmpty()){
        
            return response()->json([
                'success' => false,
                'message' => "Tienes que entrar en la party para poder mandar mensages"   . "Party ID : " . $request->party_id . "|| user id: " . $user->id
            ], 400);
        }else {
            try{
                Message::create([
                    'party_id' => $request->party_id,
                    'user_id' => $user->id,
                    'text' => $request->text
                ]);

                return response()->json([
                    'success' => true,
                    'messate' => "Mensaje enviado correctamente."
                ], 200); 

            }catch(QueryException $err){
                return response()->json([
                    'success' => false,
                    'data' => $err
                ], 400); 
            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($messageId)
    {
        //

        //Comprobamos que el ID del mensaje existe en la base de datos.
        $message = Message::where('id', '=', $messageId)->get();

 
        //Si no hay resultado, devolvemos un mensaje de que no existe ese id.
        if($message->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => "Hubo un error. El mensaje no existe en la base de datos."
            ], 400);
        }

        $user = auth()->user();

        //Comprobamos que el usuario esté dentro de esa party para poder eliminar el mensaje.
        $resultado = Membership::where('party_id', '=', $message[0]->party_id)->where('user_id', '=', $user->id)->get();

        //Si no está dentro de la party devolvemos el mensaje de que tiene que entrar en la party.
        if($resultado->isEmpty()){
        
            return response()->json([
                'success' => false,
                'message' => "Tienes que entrar en la party para poder eliminar tus mensajes"
            ], 400);
        }else {
            try{
                //Buscamos el id del mensaje dado y lo eliminamos
                Message::all()->find($messageId)->delete();                

                return response()->json([
                    'success' => true,
                    'messate' => "Mensaje eliminado correctamente."
                ], 200); 

            }catch(QueryException $err){
                return response()->json([
                    'success' => false,
                    'data' => $err
                ], 400); 
            }
        }
    }
}
