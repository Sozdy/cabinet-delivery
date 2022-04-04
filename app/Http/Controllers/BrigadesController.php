<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseHandler;
use App\Http\Requests\CreateBrigadeRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\UpdateBrigadeRequest;
use App\Models\Brigade;
use App\Models\BrigadeType;
use App\Models\Delivery;

class BrigadesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function __invoke()
	{
		return view('brigades', ['brigades' => Brigade::all(), 'brigade_types' => BrigadeType::all()]);
	}

	public function createBrigade(CreateBrigadeRequest $request)
    {
        Brigade::create(
            [
                'phone' => $this->getValueIfNotNull($request->get('phone'), ''),
                'contact_person' => $this->getValueIfNotNull($request->get('contact_person'), ''),
                'car' => $this->getValueIfNotNull($request->get('car'), ''),
                'driver' => $this->getValueIfNotNull($request->get('driver'), ''),
                'brigade_type_id' => $request->get('brigade_type_id')
            ]
        );

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

    public function deleteBrigades(DeleteRequest $request)
    {
        foreach ($request->get('ids') as $id)
        {
            $brigade = Brigade::find($id);

            if (is_null($brigade))
            {
                return ResponseHandler::getJsonResultResponse(false, 'Не удалось удалить бригаду с идентификатором '.$id);
            }

            foreach (Delivery::where('brigade_id', $brigade->id) as $delivery)
            {
                $delivery->brigade_id = null;
                $delivery->order = null;
                $delivery->save();
            }

            $brigade->delete();
        }

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

	public function getBrigades()
    {
        try
        {
            return ResponseHandler::getJsonResultResponse(true, 'Ok', ['view' => view('brigades.table', ['brigades' => Brigade::all()])->render()]);
        } catch (\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла непредвиденная ошибка');
        }
    }

    public function getBrigadeTypes()
    {
        return ResponseHandler::getJsonResultResponse(true, 'Ok', ['brigade_types' => BrigadeType::all()]);
    }

    public function updateBrigade(UpdateBrigadeRequest $request)
    {
        $brigade = Brigade::find($request->get('id'));

        if (is_null($brigade))
        {
            return ResponseHandler::getJsonResultResponse(false, 'Не удалось найти бригаду с идентификатором'.$request->get('id'));
        }

        $brigade->phone = $this->getValueIfNotNull($request->get('phone'), '');
        $brigade->contact_person = $this->getValueIfNotNull($request->get('contact_person'), '');
        $brigade->driver = $this->getValueIfNotNull($request->get('driver'), '');
        $brigade->car = $this->getValueIfNotNull($request->get('car'), '');
        $brigade->brigade_type_id = $request->get('brigade_type_id');
        $brigade->save();

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

    private function getValueIfNotNull($value, $default)
    {
        return is_null($value)
            ? $default
            : $value;
    }
}
