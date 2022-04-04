<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseHandler;
use App\Http\Requests\DateRequest;
use App\Http\Requests\ChangeDayRequest;
use App\Models\Brigade;
use App\Models\Day;
use App\Models\Delivery;
use Illuminate\Support\Carbon;

class DaysController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getDay(DateRequest $request)
    {
        try
        {
            $date = Carbon::parse($request->get('date'));
            return ResponseHandler::getJsonResultResponse(true, 'Ok', ['day' => Day::where('date', $date)->first()]);
        }
        catch (\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла ошибка: '.($e->getMessage()));
        }
    }

    public function addBrigade(ChangeDayRequest $request)
    {
        try
        {
            $brigade = Brigade::find($request->get('value'));

            if (is_null($brigade))
            {
                return ResponseHandler::getJsonResultResponse(false, 'Не удалось найти бригаду с идентификатором: '.($request->get('value')));
            }

            $day = $this->getDayForDate(Carbon::parse($request->get('date')));
            $brigades = $day->brigades;

            if (!in_array($brigade->id, $brigades))
            {
                array_push($brigades, $brigade->id);
                $day->brigades = $brigades;
                $day->save();
            }

            foreach (Delivery::where('date', $day->date)->where('brigade_id', $request->get('value'))->get() as $delivery)
            {
                $delivery->brigade_id = null;
                $delivery->order = null;
                $delivery->save();
            }

            return ResponseHandler::getJsonResultResponse(true, 'Ok');
        }
        catch (\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла ошибка: '.($e->getMessage()));
        }
    }

    public function removeBrigade(ChangeDayRequest $request)
    {
        try
        {
            $day = $this->getDayForDate(Carbon::parse($request->get('date')));
            $brigades = $day->brigades;

            $index = array_search($request->get('value'), $brigades);

            if ($index !== false)
            {
                array_splice($brigades, $index, 1);
                $day->brigades = $brigades;
                $day->save();
            }

            return ResponseHandler::getJsonResultResponse(true, 'Ok');
        }
        catch (\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла ошибка: '.($e->getMessage()));
        }
    }

    public function setDayValue(ChangeDayRequest $request)
    {
        try
        {
            $day = $this->getDayForDate(Carbon::parse($request->get('date')));
            $day->value = $request->get('value');
            $day->save();

            return ResponseHandler::getJsonResultResponse(true, 'Ok');
        }
        catch (\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла ошибка: '.($e->getMessage()));
        }
    }

    private function getDayForDate($date)
    {
        $day = Day::where('date', $date)->first();

        if (is_null($day))
        {
            $day = Day::create(['date' => $date]);
        }

        return $day;
    }
}
