@extends('modals.change_attributes', [ 'id_prefix' => 'update-action'])

@section('modal-title', 'Изменение действия')

@section('modal-body')
	@include('actions.input_group_modal', [ 'title' => 'Измените поля', 'id_prefix' => 'update-action'])

	<input type="hidden" id="update-action-modal-id" name="id">
@overwrite

@section('modal-footer')
	<button type="button" class="btn btn-dark" data-dismiss="modal">Отмена</button>
	<button type="submit" class="btn btn-custom" onclick="updateAction();">Изменить</button>
@overwrite

