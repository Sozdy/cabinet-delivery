@extends('header')

@section('title', 'Менеджеры')

@section('stylesheets')
    @parent
    <link rel='stylesheet' href='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css'>
    <link rel='stylesheet' href='{{ URL::asset("css/daterangepicker.css") }}'>
@endsection

@section('page_content')
    <div id='users-table-toolbar'>
        <strong style='font-size:24px;'>Менеджеры</strong>
    </div>
    <div class='row flex-xl-nowrap'>
        <main class='col py-md-3 bd-content'>
            <div class='table-responsive'>
                <table id='users-table' class='table table-bordered'
                       data-toggle='table'
                       data-locale='ru-RU'
                       data-toolbar='#users-table-toolbar'
                       data-search='true'
                       data-show-columns='true'
                       data-buttons='usersTableButtons'
                       data-pagination-loop='false'
                       data-pagination='true'
                       data-page-size='10'
                       data-click-to-select='true'>
                    <thead class='thead-custom'>
                        <tr>
                            @if ($current_user->is_admin)
                                <th data-checkbox="true"></th>
                                <th data-visible="false"></th>
                            @endif
                            <th scope="col" data-sortable='true'>Имя</th>
                            <th scope="col" data-sortable='true'>Логин</th>
                            <th scope="col" data-sortable='true'>Роль</th>
                            @if ($current_user->is_admin)
                                <th scope="col"><span class='oi oi-pencil'></span></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="users-table-body">
                        @include('users.table')
                    </tbody>
                </table>
                @include('users.create_modal')
                @include('users.delete_modal')
                @include('users.update_modal')
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        $(document).on('show.bs.modal','#update-user-modal', function (event)
        {
            //Если открыли через js, то данные уже есть
            if (!event.hasOwnProperty('relatedTarget'))
            {
                return;
            }

            let button = $(event.relatedTarget);
            let id = button.data('id');
            let name = button.data('name');
            let login = button.data('login');

            let modal = $(this)
            modal.find('.modal-title').text('Редактирование пользователя ' + login);
            modal.find('.modal-body #update-user-modal-name').val(name);
            modal.find('.modal-body #update-user-modal-login').val(login);
            modal.find('.modal-body #update-user-modal-id').val(id);

            updateUserLoginMask.updateValue();
        });

        $(document).on('hide.bs.modal','#update-user-modal', function(event)
        {
            clearUpdateUserModalErrors();
        });

        $(document).on('hide.bs.modal','#create-user-modal', function(event)
        {
            clearCreateUserModalErrors();

            let createUserModal = $('#create-user-modal');
            createUserModal.find('.modal-body #create-user-modal-name').val('');
            createUserModal.find('.modal-body #create-user-modal-login').val('');
            createUserModal.find('.modal-body #create-user-modal-password').val('');
            createUserModal.find('.modal-body #create-user-modal-password-confirmation').val('');
            document.getElementById('create-user-modal-is-admin').checked = false;

            createUserLoginMask.updateValue();
        });

        function usersTableButtons()
        {
            return {
                btnRefreshUsersTable:
                    {
                        icon: 'oi oi-loop-circular',
                        attributes:
                            {
                                'id': 'users-table-refresh-button',
                                'aria-hidden': 'true',
                                'data-toggle': 'tooltip',
                                'data-placement': 'bottom',
                                'title': 'Обновить'
                            },
                        event:
                            {
                                'click': function()
                                {
                                    getUsersTable();
                                }
                            }
                    },
                @if ($current_user->is_admin)
                btnAddUser:
                    {
                        icon: 'oi oi-plus',
                        attributes:
                            {
                                'id': 'users-table-add-button',
                                'aria-hidden': 'true',
                                'data-toggle': 'tooltip',
                                'data-placement': 'bottom',
                                'title': 'Добавить'
                            },
                        event:
                            {
                                'click': function()
                                {
                                    showModal('create-user-modal');
                                }
                            }
                    },
                btnDeleteSelectedUsers:
                    {
                        icon: 'oi oi-trash',
                        attributes:
                            {
                                'id': 'users-table-delete-button',
                                'aria-hidden': 'true',
                                'data-toggle': 'tooltip',
                                'data-placement': 'bottom',
                                'title': 'Удалить'
                            },
                        event:
                            {
                                'click': function()
                                {
                                    if ($('#users-table').bootstrapTable('getSelections').length > 0)
                                    {
                                        showModal('delete-users-modal');
                                    }
                                    else
                                    {
                                        show_toast('delete-error', 'alert', 'Внимание', 'Необходимо выбрать пользователей для удаления');
                                    }
                                }
                            }
                    }
                @endif
            }
        }
    </script>
@endsection
