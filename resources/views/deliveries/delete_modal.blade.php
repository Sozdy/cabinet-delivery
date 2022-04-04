@extends('modals.delete', ['id_prefix' => 'delete-deliveries'])

@section('title')
	Удаление доставок
@overwrite

@section('modal-body') 
	<p id="text">Вы уверены, что хотите удалить выбранные доставки?</p>
@overwrite

@section('action')
	deleteSelectedDeliveries();
@overwrite

