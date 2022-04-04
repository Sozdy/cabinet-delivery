<tr class='brigade-attributes-row bg-custom text-light'>
    <th scope="row">
		<div class='container-fluid'>
			<div class='row flex-nowrap'>
				<div class='col p-0'>
					<strong>Неназначенные доставки</strong>
				</div>
				<div class="col text-right" style="max-width:150px; min-width:120px;">
					<strong>Баллы: <span class="brigade-points">0</span></strong>
				</div>
			</div>
		</div>
    </th>
</tr>
<tr class='not-splittable'>
    <th class='p-0'>
		@include('schedule.brigade_deliveries_container', [ 'id' => 'unused-deliveries-container', 'deliveries' => $deliveries ])
    </th>
</tr>

@foreach ($brigadesByTypes as $brigadeByType)
    @if ($i = 1)
    @endif

		<tr class='brigade-attributes-row bg-custom text-light'>
			<th scope="row">
				<h6>{{ $brigadeByType['name'] }}</h6>
			</th>
		</tr>

	@if (count($brigadeByType['brigades']) === 0)
		<tr class='brigade-attributes-row'>
			<th scope="row">
				Нет работающих бригад
			</th>
		</tr>
	@else
		@foreach($brigadeByType['brigades'] as $brigade)
			<tr class='brigade-attributes-row bg-custom-blue'>
				<th scope="row">
					@include('schedule.brigade_attributes_row', [ 'index' => $i++, 'brigade' => $brigade, 'dayoff' => false ])
				</th>
			</tr>

			<tr class='not-splittable'>
				<th class='p-0'>
					@include('schedule.brigade_deliveries_container', [ 'brigade_id' => $brigade->id, 'deliveries' => $deliveries ])
				</th>
			</tr>
		@endforeach

	@endif
@endforeach

@if (count($freeBrigades) != 0)

	<tr class='brigade-attributes-row'>
		<th scope="row" class='bg-custom text-light'>
			<h6>Свободные бригады</h6>
		</th>
	</tr>

	@foreach($freeBrigades as $brigade)

			<tr class='brigade-attributes-row bg-custom-blue'>
				<th scope="row">
					@include('schedule.brigade_attributes_row', [ 'index' => $i, 'brigade' => $brigade, 'dayoff' => true ])
				</th>
			</tr>
	@endforeach

@endif
