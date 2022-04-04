@foreach($actions as $action)
    <tr>
        <td scope='row'></td>
        <td data-visible="false">{{ $action->id }}</td>
        <td>
            <strong>{{ $action->name }}</strong>
        </td>
        <td>
            <a class='oi oi-pencil'
               style="cursor: pointer"
               data-glyph='icon-name'
               aria-hidden='true'
               data-placement='right'
               title='Изменить'
               data-toggle='modal'
               data-target='#update-action-modal'
               data-id='{{ $action->id }}'
               data-name='{{ $action->name }}'>
            </a>
        </td>
    </tr>
@endforeach
