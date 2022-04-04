<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseHandler;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Delivery;
use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function __invoke()
    {
        return view('users',
            [
                'users' => User::all()->sortBy('name'),
                'current_user' => Auth::user()
            ]);
    }

    public function index()
    {
        return $this->getUsersView();
    }

    public function getCurrentUser()
    {
        return ResponseHandler::getJsonResultResponse(true, 'Ok',
            [
                'user' =>
                [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'login' => Auth::user()->login
                ]
            ]
        );
    }

    public function getUsers()
    {
        try
        {
            return ResponseHandler::getJsonResultResponse(true, 'Ok',
                [
                    'view' => view('users.table', ['users' => User::all()->sortBy('name'), 'current_user' => Auth::user()])->render()
                ]);
        } catch (\Throwable $e)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Произошла непредвиденная ошибка', ['exception' => $e->getMessage()]);
        }
    }

    public function updateUserPassword(UpdateUserPasswordRequest $request)
    {
        $user = User::find($request->get('id'));
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

    public function createUser(CreateUserRequest $request)
    {
        if (count(User::where('login', $request->get('login'))->get()) > 0)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Не удалось создать пользователя',
            [
                'errors' =>
                [
                    'login' =>
                    [
                        'Пользователь с указаным логином уже существует'
                    ]
                ]
            ]);
        }

        User::create(
            [
                'name' => $request->get('name'),
                'login' => $request->get('login'),
                'password' => Hash::make($request->get('password')),
                'is_admin' => $request->get('is_admin') == 1
            ]
        );

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

    public function deleteUsers(DeleteRequest $request)
    {
        if (in_array(Auth::user()->id, $request->get('ids')))
        {
            return ResponseHandler::getJsonResultResponse
            (
                false,
                'Пользователь не может удалить сам себя'
            );
        }

        foreach ($request->get('ids') as $id)
        {
            $user = User::find($id);

            if (is_null($user))
            {
                return ResponseHandler::getJsonResultResponse(false, 'Не удалось удалить пользователя с идентификатором'.$id);
            }

            $deliveries = Delivery::where('user_id', $id)->get();

            if (!is_null($deliveries) && count($deliveries) > 0)
            {
                return ResponseHandler::getJsonResultResponse(false, 'Нельзя удалить менеджера, отвечающего за доставки');
            }

            $user->delete();
        }

        return ResponseHandler::getJsonResultResponse(true, 'Ok');
    }

    public function updateUser(UpdateUserRequest $request)
    {
        $user = User::find($request->get('id'));

        if (is_null($user))
        {
            return ResponseHandler::getJsonResultResponse
            (
                false,
                'Не удалось найти пользователя с идентификатором'.$request->get('id')
            );
        }

        if ($user->login != $request->get('login') && count(User::where('login', $request->get('login'))->get()) > 0)
        {
            return ResponseHandler::getJsonResultResponse(false, 'Не удалось изменить пользователя',
                [
                    'errors' =>
                        [
                            'login' =>
                                [
                                    'Пользователь с указаным логином уже существует'
                                ]
                        ]
                ]);
        }

        $user->name = $request->get('name');
        $user->login = $request->get('login');
        $user->save();

        return ResponseHandler::getJsonResultResponse
        (
            true,
            'Ok'
        );
    }

    private function getUsersView()
    {
        return view('users.users_table',
            [
                'users' => User::all()->sortBy('name'),
                'current_user' => Auth::user()
            ]);
    }
}
