<?php

namespace App\Http\Controllers;

use App\MicroController;
use Illuminate\Http\Request;

use App\Dispositivos;
use App\Logs;
use Illuminate\Support\Facades\Log;

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
			return response()->json(Dispositivos::all(), 200);
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
            dd($encendido);
			if(is_null($dispositivo))
				return response()->json(['result' => 'error', 'data' => 'Dispositivo no encontrado'] , 404);
			if(!(boolean)$dispositivo->estado)
				return response()->json(['result' => 'error', 'data' => 'Dispositivo desactivado'], 400);

			$dispositivo->encendido = $encendido;
			$dispositivo->luminosidad = $luminosidad;
			$dispositivo->save();

            $descripcion = ($dispositivo->encendido == 1) ? "ENCENDIDO" : "APAGADO";

            Log::create([
                'id_dispositivo' => $dispositivo->id,
                'descripcion' => $descripcion,
                'encendido' => $dispositivo->encendido,
                'luminosidad' => $dispositivo->luminosidad,
                'fecha' => date('Y-m-d'),
                'hora' => date('H:m:s')
            ]);

			return response()->json(['result' => 'success', 'data' => $dispositivo], 200);
		}catch(Exception $e){
            return response()->json(['result' => 'error', 'data' => [], 'trace' => $e->getMessage()], 500);
        }
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
        $pin = null;
        $microcontroller = null;
        $microcontroller_root_id = 2;
        $microcontroller_pins = ['pin1','pin2','pin3','pin4','pin5','pin6'];
        foreach ($microcontroller_pins as $microcontroller_pin){
            $microcontroller = MicroController::where('id', $microcontroller_root_id)->where("{$microcontroller_pin}", 0)->first();
            $pin = substr($microcontroller_pin, -1, 1);
            if(!is_null($microcontroller))
                break;
        }
        if(is_null($microcontroller))
            return response()->json(['result' => 'error', 'data' => [], 'message' => 'Este microcontrolador tiene todos los pines ocupados.'], 400);

        $dispositivo = Dispositivos::create([
            'tag' => trim($request->tag),
            'pin' => $pin,
            'id_micro_controlador' => $microcontroller->id
        ]);

        switch ($pin){
            case 1:
                $microcontroller->pin1 = (integer)true;
                break;
            case 2:
                $microcontroller->pin2 = (integer)true;
                break;
            case 3:
                $microcontroller->pin3 = (integer)true;
                break;
            case 4:
                $microcontroller->pin4 = (integer)true;
                break;
            case 5:
                $microcontroller->pin5 = (integer)true;
                break;
            case 6:
                $microcontroller->pin6 = (integer)true;
                break;
            default:
                break;
        }
        $microcontroller->save();
        return response()->json(['result' => 'success', 'data' => $dispositivo, 'message' => "Dispositivo creado con exito. <a routerLink=\"/panel\">principal</a>"], 200);
    }

}
