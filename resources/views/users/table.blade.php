@foreach($users as $user)
    <tr>
        @if ($current_user->is_admin)
            <td></td>
            <td data-visible="false">{{ $user->id }}</td>
        @endif
        <td>{{ $user->name }}</td>
        <td>{{ $user->login }}</td>
        <td>{{ $user->type }}</td>
        @if ($current_user->is_admin)
            @if($current_user->id != $user->id)
                <td>
                    <a class='oi oi-pencil'
                       data-glyph='icon-name'
                       aria-hidden='true'
                       data-placement='right'
                       title='Изменить'
                       data-toggle='modal'
                       data-target='#update-user-modal'
                       data-id='{{ $user->id }}'
                       data-name='{{ $user->name }}'
                       data-login='{{ $user->login }}'
                       style="cursor: pointer">
                    </a>
                </td>
            @else
                <td></td>
            @endif
        @endif
    </tr>
@endforeach
