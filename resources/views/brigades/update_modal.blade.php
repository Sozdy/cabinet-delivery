@extends('modals.change_attributes', [ 'id_prefix' => 'update-brigade'])

@section('modal-title')
	Изменение бригады
@overwrite

@section('modal-body')
	@include('brigades.input_group_modal', [ 'title' => 'Измените поля', 'id_prefix' => 'update-brigade'])

	<input type="hidden" id="update-brigade-modal-id" name="id">
@overwrite

@section('modal-footer')
	<button type="button" class="btn btn-dark" data-dismiss="modal">Отмена</button>
	<button type="submit" class="btn btn-custom" onclick="updateBrigade();">Изменить</button>
@overwrite
