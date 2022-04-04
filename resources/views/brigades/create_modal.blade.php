@extends('modals.change_attributes', [ 'id_prefix' => 'create-brigade'])

@section('modal-title')
	Создание бригады
@overwrite

@section('modal-body')
	@include('brigades.input_group_modal', [ 'title' => 'Заполните поля', 'id_prefix' => 'create-brigade'])
@overwrite

@section('modal-footer')
	<button type="button" class="btn btn-dark" data-dismiss="modal">Отмена</button>
	<button type="submit" class="btn btn-custom" onclick="createBrigade();">Создать</button>
@overwrite

