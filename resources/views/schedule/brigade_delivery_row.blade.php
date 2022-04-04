<div class='not-splittable row flex-xl-nowrap sortable-element'>
	<input type='hidden' name='delivery-id' value='{{ $delivery->id }}'/>
	<div class='col p-0'>
		<table class='table table-bordered bg-white'>
			<tbody>
			<tr>
				<td class='delivery-order' scope="row" style="width: 5%">
					{{ $delivery->order }}
				</td>
				<td style="width: 10%">
					<strong>{{ $delivery->manager->name }}</strong>
				</td>
				<td style="width: 10%">
					<strong>{{ $delivery->organization_name }}</strong>
				</td>
				<td style="width: 20%">
					{{ $delivery->organization_address }}
				</td>
				<td style="width: 20%">
					{{ implode(' | ', array_map(function($item) { return $item['name'];}, $delivery->actions->toArray())) }}
				</td>
				<td style="width: 15%">
					{{ $delivery->contact_person }} ({{ $delivery->phone }})
				</td>
				<td style="width: 15%">
					{{ $delivery->comment }}
				</td>
				<td class="delivery-value" style="width: 5%">
					{{ $delivery->value }}
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
