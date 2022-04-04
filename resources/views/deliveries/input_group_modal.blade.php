<div class="deliveries-input-group" autocomplete="on">

	<h5 class="mb-3 w-100">{{ $title }}</h5>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-pass-addon">Перегруз</span>
		</div>
		<input id="{{ $id_prefix }}-modal-pass" type="checkbox" class="form-control input-group-addon pass-checkbox"  aria-describedby="{{ $id_prefix }}-pass-addon" onclick="changePassMode($(this));"/>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-date-addon">Дата доставки</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-date" type="date" class="form-control" aria-describedby="{{ $id_prefix }}-date-addon">
		<div class="text-danger w-100" role="alert">
			<small id="{{ $id_prefix }}-modal-date-error"></small>
		</div>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-organization-name-addon">Название организации</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-organization-name" name="orgname" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-organization-name-addon">
		<div class="text-danger w-100" role="alert">
			<small id="{{ $id_prefix }}-modal-organization-name-error"></small>
		</div>
	</div>

	<div class="input-group mb-3 disable-when-pass">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-organization-address-addon">Адрес организации</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-organization-address" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-organization-address-addon">
		<div class="text-danger w-100" role="alert">
			<small id="{{ $id_prefix }}-modal-organization-address-error"></small>
		</div>
	</div>

	<div class="input-group mb-3 disable-when-pass">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-is-in-region-addon">По краю</span>
		</div>
		<input id="{{ $id_prefix }}-modal-is-in-region" type="checkbox" class="form-control input-group-addon"  aria-describedby="{{ $id_prefix }}-is-in-region-addon"/>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-contact-person-addon">Контактное лицо</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-contact-person" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-contact-person-addon">
		<div class="text-danger w-100" role="alert">
			<small id="{{ $id_prefix }}-modal-contact-person-error"></small>
		</div>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-phone-addon">Телефон</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-phone" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-phone-addon">
		<div class="text-danger w-100" role="alert">
			<small id="{{ $id_prefix }}-modal-phone-error"></small>
		</div>
	</div>

	<div class="input-group mb-3 disable-when-pass">
		<div class="input-group-prepend">
			<span class="input-group-text" for="{{ $id_prefix }}-modal-actions">Действия</span>
		</div>
		<div class="form-control p-0">
			<select id="{{ $id_prefix }}-modal-actions" multiple="multiple" class="multiple-select h-100">
			</select>
		</div>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-comment-addon">Примечание</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-comment" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-comment-addon">
		<div class="text-danger w-100" role="alert">
			<small id="{{ $id_prefix }}-modal-comment-error"></small>
		</div>
	</div>

	<div class="input-group mb-3 disable-when-pass">
			<div class="input-group-prepend">
				<span class="input-group-text" id="{{ $id_prefix }}-value-addon">Объем</span>
			</div>
			<input autocomplete="on" id="{{ $id_prefix }}-modal-value" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-value-addon">
		<div class="text-danger w-100" role="alert">
			<small id="{{ $id_prefix }}-modal-value-error"></small>
		</div>
	</div>


	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" for="{{ $id_prefix }}-modal-state">Состояние</span>
		</div>
		<select id="{{ $id_prefix }}-modal-state" class="custom-select">
			@foreach($delivery_states as $delivery_state)
				<option value="{{ $delivery_state->id }}">{{ $delivery_state->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-is-paid-addon">Оплачено</span>
		</div>
		<input id="{{ $id_prefix }}-modal-is-paid" type="checkbox" class="form-control input-group-addon"  aria-describedby="{{ $id_prefix }}-is-paid-addon"/>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-is-available-addon">В наличии</span>
		</div>
		<input id="{{ $id_prefix }}-modal-is-available" type="checkbox" class="form-control input-group-addon"  aria-describedby="{{ $id_prefix }}-is-available-addon"/>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-account-addon">Номер счета</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-account" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-account-addon">
		<div class="text-danger w-100" role="alert">
			<small id="{{ $id_prefix }}-modal-account-error"></small>
		</div>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="{{ $id_prefix }}-selling-addon">Реализация</span>
		</div>
		<input autocomplete="on" id="{{ $id_prefix }}-modal-selling" type="text" class="form-control" aria-describedby="{{ $id_prefix }}-selling-addon">
		<div class="text-danger w-100" role="alert">
			<small id="{{ $id_prefix }}-modal-selling-error"></small>
		</div>
	</div>
</div>
