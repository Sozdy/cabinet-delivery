@foreach($deliveries as $delivery)
<tr class='@if($delivery->date != $date) table-secondary text-muted @endif' @if($delivery->is_region) style="background-color:#bddcfb;" @endif>
    <td></td>
    <td data-visible="false">{{ $delivery->id }}</td>
    <td @if($delivery->is_region)@endif>
        <ul class='list-unstyled'>
            <li><strong>{{ $delivery->manager ? $delivery->manager->name : '' }}</strong></li>
            <li><em>{{ $delivery->manager ? $delivery->manager->id : '' }}</em></li>
        </ul>
    </td>
    <td>
        <ul class='list-unstyled'>
            <li><strong>{{ $delivery->organization_name }}</strong></li>

            @if($delivery->date == $date)
                @if ($delivery->previous_date)
                    <li class='text-dark'>
                        <span class='oi oi-media-skip-backward' data-glyph='icon-name'></span>
                        <a class='text-decoration-none align-text-bottom' href='#' onclick="updateTable(moment('{{ $delivery->previous_date->format('Y-m-d') }}'));">{{ $delivery->previous_date->format('d-m-Y') }}</a>
                    </li>
                @endif
            @else
                <li class='text-dark'>
                    <span class='oi oi-media-skip-forward' data-glyph='icon-name'></span>
                    <a class='text-decoration-none align-text-bottom' href='#' onclick="updateTable(moment('{{ $delivery->date->format('Y-m-d') }}'));">{{ $delivery->date->format('d-m-Y') }}</a>
                </li>
            @endif
        </ul>
    </td>
    <td>
        <ul class='list-unstyled'>
            <li><strong>{{ $delivery->organization_address }}</strong></li>
        </ul>
    </td>
    <td>
        <ul class='list-unstyled'>
            <li><strong>{{ $delivery->contact_person }}</strong></li>
            <li><em>{{ $delivery->phone }}</em></li>
        </ul>
    </td>
    <td>

        <ul class='list-unstyled'>
            @if ($delivery->value > 0)
                @foreach($delivery->actions as $action)
                        <li>{{ $action->name }}</li>
                @endforeach
            @else
                <li>Перегруз</li>
            @endif
        </ul>
    </td>

    <td>
        <p>{{ $delivery->value }}</p>
    </td>

    <td>
        <p>{{ $delivery->comment }}</p>
    </td>

    <td>
        @if ($delivery->is_region)
            <span class='oi oi-check' data-glyph='icon-name' aria-hidden='true' data-toggle='tooltip' data-placement='right' title='По краю'></span>
        @else
            <span class='oi oi-x' data-glyph='icon-name' aria-hidden='true' data-toggle='tooltip' data-placement='right' title='Не по краю'></span>
        @endif

    </td>
    <td>
        @if ($delivery->is_paid)
            <span class='oi oi-check' data-glyph='icon-name' aria-hidden='true' data-toggle='tooltip' data-placement='right' title='Оплачено'></span>
        @else
            <span class='oi oi-x' data-glyph='icon-name' aria-hidden='true' data-toggle='tooltip' data-placement='right' title='Не оплачено'></span>
        @endif
    </td>
    <td>
        @if ($delivery->is_available)
            <span class='oi oi-check' data-glyph='icon-name' aria-hidden='true' data-toggle='tooltip' data-placement='right' title='В наличии'></span>
        @else
            <span class='oi oi-x' data-glyph='icon-name' aria-hidden='true' data-toggle='tooltip' data-placement='right' title='Не в наличии'></span>
        @endif
    </td>


    <td>
        <p>{{ $delivery->account }}</p>
    </td>
    <td>
        <p>{{ $delivery->selling }}</p>
    </td>

    <td>
        @if ($user->is_admin || $delivery->manager && $delivery->manager->id == $user->id)
            <a class='oi oi-pencil'
               style="cursor: pointer"
               data-glyph='icon-name'
               aria-hidden='true'
               data-placement='right'
               title='Изменить'
               data-toggle='modal'
               data-target='#update-delivery-modal'
               data-id='{{ $delivery->id }}'
               data-contact-person='{{ $delivery->contact_person }}'
               data-phone='{{ $delivery->phone }}'
               data-date='{{ $delivery->date->format('d.m.Y') }}'
               data-value='{{ $delivery->value }}'
               data-comment='{{ $delivery->comment }}'
               data-organization-name='{{ $delivery->organization_name }}'
               data-organization-address='{{ $delivery->organization_address }}'
               data-selling='{{ $delivery->selling }}'
               data-account='{{ $delivery->account }}'
               data-is-in-region='{{ $delivery->is_region }}'
               data-is-paid='{{ $delivery->is_paid }}'
               data-is-available='{{ $delivery->is_available }}'
               data-delivery-state-id='{{ $delivery->delivery_state_id }}'
               data-actions='{{ '[ '.implode(', ', array_map(function($item) { return $item['id'];}, $delivery->actions->toArray())).' ]' }}'>
            </a>
        @endif
    </td>
</tr>
@endforeach
