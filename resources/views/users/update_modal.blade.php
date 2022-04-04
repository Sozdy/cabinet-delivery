@extends('modals.change_attributes', ['id_prefix' => 'update-user'])

@section('modal-title')
	Изменение пользователя
@overwrite

@section('modal-body')
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="update-login-input-group">
					<h5 class="mb-3 w-100">Измените поля</h5>

					@include('users.input_group.login', ['id_prefix' => 'update-user'])
				</div>

				<input type="hidden" id="update-user-modal-id" name="id">

				<span class="float-right"><button type="submit" class="btn btn-custom" onclick="updateUser();">Изменить данные</button></span>
			</div>
		</div>

		<hr/>

		<div class="row">
			<div class="col">
				<div class="update-password-input-group">
					<h5 class="mb-3 w-100">Введите новый пароль</h5>

					@include('users.input_group.password', ['id_prefix' => 'update-user'])
				</div>
				<span class="float-right"><button type="submit" class="btn btn-custom" onclick="updateUserPassword();">Изменить пароль</button></span>
			</div>
		</div>
	</div>
@overwrite

@section('modal-footer')
	<button type="button" class="btn btn-dark" data-dismiss="modal">Отмена</button>
@overwrite
