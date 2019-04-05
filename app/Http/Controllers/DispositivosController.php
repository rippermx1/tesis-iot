<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dispositivos;

class DispositivosController extends Controller
{
	public function getAll(){
		try{
			return response()->json(['result' => 'success', 'data' => Dispositivos::all()], 200);
		}catch(Exception $e){}
	}

	public function getById($id){
		try{
			return response()->json(['result' => 'success', 'data' => Dispositivos::where('id', $id)->first()]);
		}catch(Exception $e){}
	}

	public function getStatusById($pin){
		try{
			return response()->json(['result' => 'success', 'status' => (boolean)((Dispositivos::where('pin', $pin)->first())->estado)], 200);
		}catch(Exception $e){}
	}

	public function updateDevice($pin, $encendido, $luminosidad){
		try{
			$dispositivo = Dispositivos::where('pin', $pin)->first();
			if(is_null($dispositivo))
				return response()->json(['result' => 'error', 'data' => 'Dispositivo no encontrado'] , 404);
			if(!(boolean)$dispositivo->estado)
				return response()->json(['result' => 'error', 'data' => 'Dispositivo desactivado'], 400);
			$dispositivo->encendido = $encendido;
			$dispositivo->luminosidad = $luminosidad;
			$dispositivo->save();
			return response()->json(['result' => 'success', 'data' => $dispositivo], 200);
		}catch(Exception $e){}
	}

	public function updateStatus($pin, $estado){
		try{
			$dispositivo = Dispositivos::where('pin', $pin)->first();
			if(is_null($dispositivo))
                                return response()->json(['result' => 'error', 'data' => 'Dispositivo no encontrado'] , 404);
			$dispositivo->estado = (boolean)$estado;
			if(!(boolean)$estado)
				$dispositivo->encendido = (integer)false;
			$dispositivo->save();
			return response()->json(['result' => 'success', 'data' => $dispositivo], 200);
		}catch(Exception $e){}
	}

}
