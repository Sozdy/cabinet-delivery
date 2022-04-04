@extends('modals.change_attributes', ['id_prefix' => 'create-user'])

@section('modal-title')
	Создание пользователя
@overwrite

@section('modal-body')
	<div class="users-input-group">
		<h5 class="mb-3 w-100">Заполните поля</h5>

		@include('users.input_group.login', ['id_prefix' => 'create-user'])
		@include('users.input_group.password', ['id_prefix' => 'create-user'])
		@include('users.input_group.admin_checkbox', ['id_prefix' => 'create-user'])
	</div>
@overwrite

@section('modal-footer')
	<button type="button" class="btn btn-dark" data-dismiss="modal">Отмена</button>
	<button type="submit" class="btn btn-custom" onclick="createUser();">Создать</button>
@overwrite
