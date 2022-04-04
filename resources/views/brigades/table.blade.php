@foreach($brigades as $brigade)
<tr>
    <th scope='row'></td>
    <td data-visible="false">{{ $brigade->id }}</td>
    <td>
        <ul class='list-unstyled'>
            <li><strong>{{ $brigade->contact_person }}</strong></li>
            <li><em>{{ $brigade->phone }}</em></li>
        </ul>
    </td>
    <td>{{ $brigade->car }}
{{--        <ul class='list-unstyled'>{{ $brigade->car }}--}}
{{--            <li><strong>{{ $brigade->car }}</strong></li>--}}
{{--            <li><em>А578АК 125rus</em></li>--}}
{{--        </ul>--}}
    </td>
    <td>{{ $brigade->driver }}
{{--        <ul class='list-unstyled'>--}}
{{--            <li><strong>{{ $brigade->driver }}</strong></li>--}}
{{--            <li><em>8-999-999-99-99</em></li>--}}
{{--        </ul>--}}
    </td>
    <td>{{ $brigade->brigade_type->name }}
{{--        <p>Мебель</p>--}}
    </td>
    <td>
        <a class='oi oi-pencil'
           style="cursor: pointer"
           data-glyph='icon-name'
           aria-hidden='true'
           data-placement='right'
           title='Изменить'
           data-toggle='modal'
           data-target='#update-brigade-modal'
           data-id="{{ $brigade->id }}",
           data-phone="{{ $brigade->phone }}"
           data-contact-person="{{ $brigade->contact_person }}"
           data-driver="{{ $brigade->driver }}"
           data-car="{{ $brigade->car }}"
           data-brigade-type-id="{{ $brigade->brigade_type->id }}">
        </a>
    </td>
</tr>
@endforeach
