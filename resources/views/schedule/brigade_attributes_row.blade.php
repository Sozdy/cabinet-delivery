<div class="container-fluid">
	<div class="row flex-xl-nowrap" style="min-width:700px;">
		<div class="col pr-0" style="max-width:150px; min-width:100px;">
			<strong>Бригада {{ $index }}</strong>
		</div>
		<div class="col">
			<span class="oi oi-phone"></span><strong>{{ $brigade->phone }}</strong>
		</div>
		<div class="col">
			<strong>Отв. {{ $brigade->contact_person }}</strong>
		</div>
		<div class="col">
			<strong>{{ $brigade->car }}	</strong>
		</div>
		<div class="col">
			<strong>Водитель: {{ $brigade->driver }}</strong>
		</div>
		<div class="col delivery-value p-0" style="max-width:150px; min-width:100px;">
			<span>
				<label><strong>Выходной</strong></label>
				<input type="checkbox" onclick="onClickBrigadeDayoff($(this), {{ $brigade->id }});" @if($dayoff) checked @endif/>
			</span>
		</div>
		<div class="col text-right pl-0" style="max-width:150px; min-width:100px;">
			<strong>Баллы: <span class="brigade-points">0</span></strong>
		</div>
	</div>
</div>