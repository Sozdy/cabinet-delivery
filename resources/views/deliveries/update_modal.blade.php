@extends('modals.change_attributes', [ 'id_prefix' => 'update-delivery'])

@section('modal-title')
	Изменение доставки
@overwrite

@section('modal-body')
	@include('deliveries.input_group_modal', [ 'title' => 'Измените поля', 'id_prefix' => 'update-delivery'])
	<input type="hidden" id="update-delivery-modal-id" name="id">
@overwrite

@section('modal-footer')
	<button type="button" class="btn btn-dark" data-dismiss="modal">Отмена</button>
	<button type="submit" class="btn btn-custom" onclick="updateDelivery();">Изменить</button>
@overwrite
