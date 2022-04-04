<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text" id="{{ $id_prefix }}-login-addon">Пароль</span>
	</div>
	<input id="{{ $id_prefix }}-modal-password" type="password" class="form-control" aria-describedby="{{ $id_prefix }}-password-addon"/>
	<div class="text-danger" role="alert">
		<small id="{{ $id_prefix }}-modal-password-error"></small>
	</div>
</div>

<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text" id="{{ $id_prefix }}-login-addon">Повторите пароль</span>
	</div>
	<input id="{{ $id_prefix }}-modal-password-confirmation" type="password" class="form-control" aria-describedby="{{ $id_prefix }}-password-confirmation-addon"/>
</div>
