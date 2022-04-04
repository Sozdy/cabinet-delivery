<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseHandler;
use App\Http\Requests\CreateActionRequest;
use App\Http\Requests\DeleteActionsRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\UpdateActionRequest;
use App\Models\Action;
use App\Models\ActionDelivery;

class ActionsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function __invoke()
	{
		return view('actions', ['actions' => Action::all()->sortBy('id')]);
	}

	public function createAction(CreateActionRequest  $request)
    {
        Action::create(
            [
                'name' => $request->get('name'),
            ]
        );

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

	public function deleteActions(DeleteRequest $request)
    {
        foreach ($request->get('ids') as $id)
        {
            $action = Action::find($id);

            if (is_null($action))
            {
                return ResponseHandler::getJsonResultResponse(false, 'Не удалось удалить действие с идентификатором '.$id);
            }

            $action_deliveries = ActionDelivery::where('action_id', $id)->get();

            if (!is_null($action_deliveries))
            {
                foreach ($action_deliveries as $action_delivery)
                {
                    $action_delivery->delete();
                }
            }

            $action->delete();
        }

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

	public function getActions()
    {
        try
        {
            return ResponseHandler::getJsonResultResponse(true, 'Ok',
                [
                    'view' => view('actions.table', ['actions' => Action::all()->sortBy('id')])->render()
                ]);
        } catch (\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла непредвиденная ошибка');
        }
    }

    public function getActionsSelect()
    {
//        $result = [];
//
//        foreach (Action::all()->sortBy('id') as $action)
//        {
//            $result[] =
//            [
//                'text' => $action->name,
//                'value' => $action->id
//            ];
//        }
//
//        return ResponseHandler::getJsonResultResponse(true, 'Ok', ['actions' => $result]);
        try
        {
            return ResponseHandler::getJsonResultResponse(true, 'Ok', ['view' => view('actions.select', ['actions' => Action::all()->sortBy('id')])->render()]);
        } catch (\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла непредвиденная ошибка');
        }
    }

    public function updateAction(UpdateActionRequest $request)
    {
        $action = Action::find($request->get('id'));

        if (is_null($action))
        {
            return ResponseHandler::getJsonResultResponse(false, 'Не удалось найти действие с идентификатором'.$request->get('id'));
        }

        $action->name = $request->get('name');
        $action->save();

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }
}
