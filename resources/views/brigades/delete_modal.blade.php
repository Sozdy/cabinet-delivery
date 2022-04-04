@extends('modals.delete', ['id_prefix' => 'delete-brigades'])

@section('title')
	Удаление бригад
@overwrite

@section('modal-body')
	<p id="text">Вы уверены, что хотите удалить выбранные бригады?</p>
@overwrite

@section('action')
	deleteSelectedBrigades();
@overwrite

