<?php

namespace App\Http\Controllers;

use App\MicroController;
use Illuminate\Http\Request;

use App\Dispositivos;
use App\Logs;

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
            header('Access-Control-Allow-Origin: *');
			return response()->json(Dispositivos::where('id_tipo_dispositivo', 1)->get(), 200);
		}catch(Exception $e){}
	}

    /**
     * Get home device by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById($id){
		try{
            header('Access-Control-Allow-Origin: *');
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
            header('Access-Control-Allow-Origin: *');
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
            header('Access-Control-Allow-Origin: *');
			$dispositivo = Dispositivos::where('pin', $pin)->first();
            if(is_null($dispositivo))
				return response()->json(['result' => 'error', 'data' => 'Dispositivo no encontrado'] , 404);
			if(!(boolean)$dispositivo->estado)
				return response()->json(['result' => 'error', 'data' => 'Dispositivo desactivado'], 400);

			if($encendido == true)
			    $encendido = 1;
			else
			    $encendido = 0;

			$dispositivo->encendido = $encendido;
			$dispositivo->luminosidad = $luminosidad;
            $dispositivo->save();

            $descripcion = ($encendido == 1) ? "ENCENDIDO" : "APAGADO";
            Logs::create([
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
            header('Access-Control-Allow-Origin: *');
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
        header('Access-Control-Allow-Origin: *');
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
            return response()->json(['result' => 'error', 'data' => [], 'message' => 'Este microcontrolador tiene todos los pines ocupados.'], 200);

        $dispositivo = Dispositivos::create([
            'tag' => trim($request->tag),
            'pin' => $pin,
            'id_micro_controlador' => $microcontroller_root_id,
            'id_tipo_dispositivo' => 1
        ]);

        switch ($pin){
            case 1:
                MicroController::where("id", $microcontroller->id)->update(['pin1'] , 1);
                break;
            case 2:
                MicroController::where("id", $microcontroller->id)->update(['pin2'] , 1);
                break;
            case 3:
                MicroController::where("id", $microcontroller->id)->update(['pin3'] , 1);
                break;
            case 4:
                MicroController::where("id", $microcontroller->id)->update(['pin4'] , 1);
                break;
            case 5:
                MicroController::where("id", $microcontroller->id)->update(['pin5'] , 1);
                break;
            case 6:
                MicroController::where("id", $microcontroller->id)->update(['pin6'] , 1);
                break;
            default:
                break;
        }
        return response()->json(['result' => 'success', 'data' => $dispositivo, 'message' => "Dispositivo creado con exito."], 200);
    }

    public function delete($pin){
        header('Access-Control-Allow-Origin: *');
        $dispositivo = Dispositivos::where('pin', $pin)->first();
        if(is_null($dispositivo))
            return response()->json(['result' => 'error', 'data' => 'Dispositivo no encontrado'] , 200);

        switch ($dispositivo->pin){
            case 1:
                MicroController::where("id", $dispositivo->id_micro_controlador)->update(['pin1' => 0]);
                break;
            case 2:
                MicroController::where("id", $dispositivo->id_micro_controlador)->update(['pin2' => 0]);
                break;
            case 3:
                MicroController::where("id", $dispositivo->id_micro_controlador)->update(['pin3' => 0]);
                break;
            case 4:
                MicroController::where("id", $dispositivo->id_micro_controlador)->update(['pin4' => 0]);
                break;
            case 5:
                MicroController::where("id", $dispositivo->id_micro_controlador)->update(['pin5' => 0]);
                break;
            case 6:
                MicroController::where("id", $dispositivo->id_micro_controlador)->update(['pin6' => 0]);
                break;
            default:
                break;
        }
        $dispositivo->id_tipo_dispositivo = 0;
        $dispositivo->save();
        return response()->json(['result' => 'success', 'data' => [], 'message' => "Dispositivo eliminado."], 200);
    }

    public function activarMasivo(){
        $devices = Dispositivos::all();
        $devices->each(function($item){
            $item->id_tipo_dispositivo = 1;
            $item->save();
        });
    }
}
