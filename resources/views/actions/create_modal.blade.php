@extends('modals.change_attributes', [ 'id_prefix' => 'create-action'])

@section('modal-title')
	Создание действия
@overwrite

@section('modal-body')
	@include('actions.input_group_modal', [ 'title' => 'Заполните поля', 'id_prefix' => 'create-action'])
@overwrite

@section('modal-footer')
	<button type="button" class="btn btn-dark" data-dismiss="modal">Отмена</button>
	<button type="submit" class="btn btn-custom" onclick="createAction();">Создать</button>
@overwrite

