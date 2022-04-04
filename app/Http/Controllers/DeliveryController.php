<?php

namespace App\Http\Controllers;

use App\Http\Helpers\DeliveryManager;
use App\Http\Helpers\ResponseHandler;
use App\Http\Requests\CreateDeliveryRequest;
use App\Http\Requests\DateRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\GetDeliveriesRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Models\Action;
use App\Models\ActionDelivery;
use App\Models\Day;
use App\Models\Delivery;
use App\Models\DeliveryState;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function __invoke()
	{
		return view('delivery', ['delivery_states' => DeliveryState::all(), 'current_user' => Auth::user()]);
	}

	public function createDelivery(CreateDeliveryRequest $request)
    {
        try
        {
            $date = Carbon::parse($request->get('date'))->toDateString();
        } catch(\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Переданы некорректные данные', ['errors' => ['date' => ['Некорректный формат даты']]]);
        }

        $value = is_null($request->get('value')) ? 0 : $request->get('value');
        $usedValue = $this->getUsedValueForDate($date);
        $totalValue = $this->getValueForDate($date);
        $maxValue = $usedValue + $value;

        if ($maxValue > $totalValue)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Переданы некорректные данные', ['errors' => ['value' => [(($totalValue - $usedValue) == 0 ? 'На сегодня достигнут лимит объема' : 'Свободный объем: '.($totalValue - $usedValue))]]]);
        }

        $delivery = Delivery::create(
            [
                'date' => $date,
                'previous_date' => null,
                'user_id' => Auth::user()->id,
                'brigade_id' => null,
                'order' => null,
                'organization_name' => is_null($request->get('organization_name')) ? '' : $request->get('organization_name'),
                'organization_address' => is_null($request->get('organization_address')) ? '' : $request->get('organization_address'),
                'is_region' => $request->get('is_in_region'),
                'contact_person' => $this->getValueIfNotNull($request->get('contact_person'), ''),
                'phone' => $this->getValueIfNotNull($request->get('phone'), ''),
                'comment' => !is_null($request->get('comment')) ? $request->get('comment') : '',
                'is_paid' => $request->get('is_paid'),
                'is_available' => $request->get('is_available'),
                'account' => $this->getValueIfNotNull($request->get('account'), ''),
                'selling' => $this->getValueIfNotNull($request->get('selling'), ''),
                'value' => $value,
                'delivery_state_id' => $request->get('delivery_state_id')
            ]
        );

        $actions = $request->get('actions');

        if (!is_null($actions))
        {
            foreach ($actions as $action)
            {
                if (Action::find($action) != null)
                {
                    ActionDelivery::create(
                        [
                            'delivery_id' => $delivery->id,
                            'action_id' => $action
                        ]
                    );
                }
            }
        }

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

	public function deleteDeliveries(DeleteRequest $request)
    {
        foreach ($request->get('ids') as $id)
        {
            $delivery = Delivery::find($id);

            if (is_null($delivery))
            {
                return ResponseHandler::getJsonResultResponse(false, 'Не удалось удалить доставку с идентификатором '.$id);
            }

            foreach (ActionDelivery::where('delivery_id', $id)->get() as $action_delivery)
            {
                $action_delivery->delete();
            }

            DeliveryManager::removeDeliveryFromBrigade($delivery);

            $delivery->delete();
        }

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

	public function getDeliveries(GetDeliveriesRequest $request)
    {
        try
        {
            $date = Carbon::parse($request->get('date'));
            $deliveries = Delivery::where('date', $date)->orWhere('previous_date', $date)->orderBy('date', 'desc')->orderBy('previous_date')->orderBy('id')->get();
            return ResponseHandler::getJsonResultResponse(true, 'Ok', ['view' => view('deliveries.table', ['deliveries' => $deliveries, 'date' => $date, 'user' => Auth::user()])->render()]);
        } catch(\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла непредвиденная ошибка: '.$e->getMessage());
        }
    }

    public function getValues(DateRequest $request)
    {
        try
        {
            $date = Carbon::parse($request->get('date'));
            return ResponseHandler::getJsonResultResponse(true, 'Ok', ['used_value' => $this->getUsedValueForDate($date), 'value' => $this->getValueForDate($date)]);
        } catch(\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла непредвиденная ошибка: '.$e->getMessage());
        }
    }

    public function updateDelivery(UpdateDeliveryRequest $request)
    {
        try
        {
            $date = Carbon::parse($request->get('date'))->toDateString();
        } catch(\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Переданы некорректные данные', ['errors' => ['date' => ['Некорректный формат даты']]]);
        }

        $delivery = Delivery::find($request->get('id'));

        if (is_null($delivery))
        {
            return ResponseHandler::getJsonResultResponse(false, 'Не удалось найти доставку с идентификатором'.$request->get('id'));
        }

        $value = is_null($request->get('value')) ? 0 : $request->get('value');
        $usedValue = $this->getUsedValueForDate($date);
        $totalValue = $this->getValueForDate($date);
        $maxValue = $usedValue - ($date == Carbon::parse($delivery->date)->toDateString() ? $delivery->value : 0) + $value; // Если та же дата - вычитаем старый объем. Если другая дата - не вычитаем.

        if ($maxValue > $totalValue)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Переданы некорректные данные', ['errors' => ['value' => [(($totalValue - $usedValue) == 0 ? 'На сегодня достигнут лимит объема' : 'Свободный объем: '.($totalValue - $usedValue))]]]);
        }

        if ($date != Carbon::parse($delivery->date)->toDateString())
        {
            $delivery->previous_date = $delivery->date;
            $delivery->date = $date;

            $delivery->brigade_id = null;
            $delivery->order = null;
        }

        $delivery->organization_name = is_null($request->get('organization_name')) ? '' : $request->get('organization_name');
        $delivery->organization_address = is_null($request->get('organization_address')) ? '' : $request->get('organization_address');
        $delivery->is_region = $request->get('is_in_region');
        $delivery->contact_person = $this->getValueIfNotNull($request->get('contact_person'), '');
        $delivery->phone = $this->getValueIfNotNull($request->get('phone'), '');
        $delivery->comment = !is_null($request->get('comment')) ? $request->get('comment') : '';
        $delivery->is_paid = $request->get('is_paid');
        $delivery->is_available = $request->get('is_available');
        $delivery->account = $this->getValueIfNotNull($request->get('account'), '');
        $delivery->selling = $this->getValueIfNotNull($request->get('selling'), '');
        $delivery->value = $value;
        $delivery->delivery_state_id = $request->get('delivery_state_id');

        $delivery->save();

        //Удаление предыдующих действий
        $action_deliveries = ActionDelivery::where('delivery_id', $delivery->id)->get();

        if (!is_null($action_deliveries))
        {
            foreach ($action_deliveries as $action_delivery)
            {
                $action_delivery->delete();
            }
        }

        //Добавление новых действий
        $actions = $request->get('actions');

        if (!is_null($actions))
        {
            foreach ($actions as $action)
            {
                if (Action::find($action) != null)
                {
                    ActionDelivery::create(
                        [
                            'delivery_id' => $delivery->id,
                            'action_id' => $action
                        ]
                    );
                }
            }
        }

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

    private function getValueForDate($date)
    {
        $day = Day::where('date', $date)->first();

        return is_null($day) || is_null($day->value)
            ? 250
            : $day->value;
    }

    private function getUsedValueForDate($date)
    {
        $used_value = 0;

        foreach (Delivery::where('date', $date)->get() as $delivery)
        {
            $used_value += is_null($delivery->value) ? 0 : $delivery->value;
        }

        return $used_value;
    }

    private function getValueIfNotNull($value, $default)
    {
        return is_null($value)
            ? $default
            : $value;
    }
}
