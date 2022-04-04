<?php

namespace App\Http\Controllers;

use App\Http\Helpers\DeliveryManager;
use App\Http\Helpers\ResponseHandler;
use App\Http\Requests\GetScheduleRequest;
use App\Http\Requests\SetBrigadeToDeliveryRequest;
use App\Models\Brigade;
use App\Models\BrigadeType;
use App\Models\Day;
use App\Models\Delivery;
use Illuminate\Support\Carbon;

class ScheduleController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function __invoke()
	{
		return view('schedule');
	}

	public function getSchedule(GetScheduleRequest $request)
    {
        try
        {
            $date = Carbon::parse($request->get('date'));
            $brigadesByTypes = [];

            foreach (BrigadeType::all() as $brigadeType)
            {
                $brigadesByTypes[$brigadeType->id] =
                    [
                        'name' => $brigadeType->name,
                        'brigades' => []
                    ];
            }

            $day = Day::where('date', $date)->first();
            $freeBrigadesIds = is_null($day) ? [] : $day->brigades;
            $freeBrigades = [];

            foreach (Brigade::all()->sortBy('id') as $brigade)
            {
                if (in_array($brigade->id, $freeBrigadesIds))
                {
                    $freeBrigades[] = $brigade;
                }
                else
                {
                    array_push($brigadesByTypes[$brigade->brigade_type->id]['brigades'], $brigade);
                }
            }

            error_log(json_encode($brigadesByTypes));
            error_log(json_encode($freeBrigades));

            return ResponseHandler::getJsonResultResponse(true, 'Ok', ['view' => view('schedule.table', ['deliveries' => Delivery::where('date', $date)->orderBy('order')->get(), 'brigadesByTypes' => $brigadesByTypes, 'freeBrigades' => $freeBrigades])->render()]);
        } catch(\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла непредвиденная ошибка: '.$e->getMessage());
        }
    }

    public function setBrigadeToDelivery(SetBrigadeToDeliveryRequest $request)
    {
        $delivery = Delivery::find($request->get('delivery_id'));

        if (is_null($delivery))
        {
            return ResponseHandler::getJsonResultResponse(false,'Не удалось найти доставку с идентификатором '.($request->get('delivery_id')));
        }

        if (is_null($request->get('brigade_id')) || is_null($request->get('order')))
        {
            DeliveryManager::removeDeliveryFromBrigade($delivery);
        }
        else
        {
            DeliveryManager::addDeliveryToBrigade($delivery, $request->get('brigade_id'), $request->get('order'));
        }

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }
}
