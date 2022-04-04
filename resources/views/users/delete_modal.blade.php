@extends('modals.delete', ['id_prefix' => 'delete-users'])

@section('title')
	Удаление пользователей
@overwrite

@section('modal-body')
	<p id="text">Вы уверены, что хотите удалить выбранных пользователей?</p>
@overwrite

@section('action')
	deleteSelectedUsers();
@overwrite
