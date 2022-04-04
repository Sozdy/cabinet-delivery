<div @isset($id) id='{{ $id }}' @endisset class='container-fluid sortable' style='min-height: 100px;'>
	@isset($brigade_id)
		<input type='hidden' name='brigade-id' value='{{ $brigade_id }}'/>
	@endisset
	@foreach($deliveries as $delivery)
		@isset($brigade_id)
			@if ($delivery->brigade_id == $brigade_id)
				@include('schedule.brigade_delivery_row', [ 'delivery' => $delivery ])
			@endif
		@else
			@if (!isset($delivery->brigade_id))
				@include('schedule.brigade_delivery_row', [ 'delivery' => $delivery ])
			@endif
		@endisset
	@endforeach
</div>