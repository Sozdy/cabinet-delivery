@extends('modals.delete', ['id_prefix' => 'delete-actions'])

@section('title')
	Удаление действий
@overwrite

@section('modal-body')
	<p id="text">Вы уверены, что хотите удалить выбранные действия?</p>
@overwrite

@section('action')
	deleteSelectedActions();
@overwrite
