<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text" id="{{ $id_prefix }}-name-addon">Имя</span>
	</div>
	<input id="{{ $id_prefix }}-modal-name" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-name-addon"/>
	<div class="text-danger" role="alert">
		<small id="{{ $id_prefix }}-modal-name-error"></small>
	</div>
</div>

<div class="input-group mb-3">
	<div class="input-group-prepend  text-right">
		<span class="input-group-text" id="{{ $id_prefix }}-login-addon">Логин</span>
	</div>
	<input id="{{ $id_prefix }}-modal-login" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-login-addon"/>
	<div class="text-danger" role="alert">
		<small id="{{ $id_prefix }}-modal-login-error"></small>
	</div>
</div>