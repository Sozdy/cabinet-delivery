<div class="brigades-input-group">
	<h5 class="mb-3 w-100">{{ $title }}</h5>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-contact-person-addon">Контактное лицо</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-contact-person" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-contact-person-addon">
		<div class="text-danger" role="alert">
			<small id="{{ $id_prefix }}-modal-contact-person-error"></small>
		</div>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-phone-addon">Номер телефона</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-phone" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-phone-addon">
		<div class="text-danger" role="alert">
			<small id="{{ $id_prefix }}-modal-phone-error"></small>
		</div>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-driver-addon">Водитель</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-driver" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-driver-addon">
		<div class="text-danger" role="alert">
			<small id="{{ $id_prefix }}-modal-driver-error"></small>
		</div>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-car-addon">Автомобиль</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-car" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-car-addon">
		<div class="text-danger" role="alert">
			<small id="{{ $id_prefix }}-modal-car-error"></small>
		</div>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" for="{{ $id_prefix }}-modal-type">Тип</span>
		</div>
		<select id="{{ $id_prefix }}-modal-type" class="custom-select">
			@foreach($brigade_types as $brigade_type)
				<option value="{{ $brigade_type->id }}">{{ $brigade_type->name }}</option>
			@endforeach
		</select>
	</div>

</div>
