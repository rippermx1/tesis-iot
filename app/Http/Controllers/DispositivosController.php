<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dispositivos;

/**
 * Class DispositivosController
 * @package App\Http\Controllers
 */
class DispositivosController extends Controller
{
    /**
     * Get all home's devices
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(){
		try{
			return response()->json(['result' => 'success', 'data' => Dispositivos::all()], 200);
		}catch(Exception $e){}
	}

    /**
     * Get home device by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById($id){
		try{
			return response()->json(['result' => 'success', 'data' => Dispositivos::where('id', $id)->first()]);
		}catch(Exception $e){}
	}

    /**
     * Get current device status
     * @param $pin
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMicroControllerPinStatus($pin){
		try{
            $device = Dispositivos::where('pin', $pin)->first();
            if(is_null($device))
                return response()->json(['result' => 'error', 'data' => null]);
			return response()->json(['result' => 'success', 'status' => (boolean)$device->estado], 200);
		}catch(Exception $e){}
	}

    /**
     * Update a home device by Microcontroller pin
     * @param $pin
     * @param $encendido
     * @param $luminosidad
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncDevice($pin, $encendido, $luminosidad){
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

    /**
     * Enable or disable a home device by  Microcontroller pin
     * @param $pin
     * @param $estado
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDevice($pin, $estado){
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

    /**
     * Crate a new device in home
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $dispositivo = Dispositivos::where('pin', $request->pin)->firts();
        if(is_null($dispositivo))
            return response()->json(['result' => 'error', 'data' => 'Dispositivo no encontrado'] , 404);

        if($dispositivo->estado)
            return response()->json(['result' => 'error', 'data' => 'Dispositivo en uso'], 400);

        $dispositivo = Dispositivos::create([
           'tag' => $request->tag,
           'pin' => $request->pin
        ]);
        return response()->json(['result' => 'success', 'data' => 'Dispositivo '.$dispositivo->tag.' creado'], 200);
    }

}
