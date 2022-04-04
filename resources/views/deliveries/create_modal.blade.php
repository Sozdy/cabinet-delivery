@extends('modals.change_attributes', [ 'id_prefix' => 'create-delivery'])

@section('modal-title')
	Создание доставки
@overwrite

@section('modal-body')
	@include('deliveries.input_group_modal', [ 'title' => 'Заполните поля', 'id_prefix' => 'create-delivery'])
@overwrite

@section('modal-footer')
	<button type="button" class="btn btn-dark" data-dismiss="modal">Отмена</button>
	<button type="submit" class="btn btn-custom" onclick="createDelivery();">Создать</button>
@overwrite
