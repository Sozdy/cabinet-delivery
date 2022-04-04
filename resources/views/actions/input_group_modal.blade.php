<div class="input-group mb-3">
	<h5 class="mb-3 w-100">{{ $title }}</h5>
	<div class="input-group-prepend">
		<span class="input-group-text" id="{{ $id_prefix }}-name-addon">Название</span>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-name" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-name-addon">
		<div class="text-danger" role="alert">
			<small id="{{ $id_prefix }}-modal-name-error"></small>
		</div>
	</div>
</div>
