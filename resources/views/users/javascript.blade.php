<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js'></script>
<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table-locale-all.min.js'></script>
<script src="https://unpkg.com/imask"></script>
<script src='{{ URL::asset("js/main.js") }}'></script>

<script>
    function clearCreateUserModalErrors()
    {
        document.getElementById('create-user-modal-name-error').innerText = '';
        document.getElementById('create-user-modal-name').className = 'form-control';

        document.getElementById('create-user-modal-login-error').innerText = '';
        document.getElementById('create-user-modal-login').className = 'form-control';

        document.getElementById('create-user-modal-password-error').innerText = '';
        document.getElementById('create-user-modal-password').className = 'form-control';

        //Нужно ли удалять введенные пароли при ошибках?
        let createUserModal = $('#create-user-modal');
        createUserModal.find('.modal-body #create-user-modal-password').val('');
        createUserModal.find('.modal-body #create-user-modal-password-confirmation').val('');
    }

    function clearUpdateUserModalErrors()
    {
        document.getElementById('update-user-modal-name-error').innerText = '';
        document.getElementById('update-user-modal-name').className = 'form-control';
        document.getElementById('update-user-modal-login-error').innerText = '';
        document.getElementById('update-user-modal-login').className = 'form-control';
        document.getElementById('update-user-modal-password-error').innerText = '';
        document.getElementById('update-user-modal-password').className = 'form-control';

        //Нужно ли удалять введенные пароли при ошибках?
        let updateUserModal = $('#update-user-modal');
        updateUserModal.find('.modal-body #update-user-modal-password').val('');
        updateUserModal.find('.modal-body #update-user-modal-password-confirmation').val('');
    }

    function showUpdateUserModalForCurrentUser()
    {
        $.ajax(
            {
                url: '{{ route('getCurrentUser') }}',
                method: 'GET'
            }).done(function(response)
        {
            if (!response.status)
            {
                show_toast('update-error', 'danger', 'Ошибка', 'Внутренняя ошибка');
                return;
            }

            let updateUserModal = $('#update-user-modal');
            updateUserModal.find('.modal-title').text('Пользователь ' + response.user.login);
            updateUserModal.find('.modal-body #update-user-modal-name').val(response.user.name);
            updateUserModal.find('.modal-body #update-user-modal-login').val(response.user.login);
            updateUserModal.find('.modal-body #update-user-modal-id').val(response.user.id);

            showModal('update-user-modal');
        }).fail(function()
        {
            show_toast('update-error', 'danger', 'Ошибка', 'Внутренняя ошибка');
        });
    }

    function createUser()
    {
        createEntry('create-user-modal', '{{ route('createUser') }}', clearCreateUserModalErrors, getUsersTable,
            function()
            {
                let createUserModal = $('#create-user-modal');

                return {
                    name: createUserModal.find('.modal-body #create-user-modal-name').val(),
                    login: createUserModal.find('.modal-body #create-user-modal-login').val(),
                    password: createUserModal.find('.modal-body #create-user-modal-password').val(),
                    password_confirmation: createUserModal.find('.modal-body #create-user-modal-password-confirmation').val(),
                    is_admin: document.getElementById('create-user-modal-is-admin').checked ? 1 : 0
                }
            },
            [
                {
                    'name': 'name',
                    'callback': function(response)
                    {
                        document.getElementById('create-user-modal-name-error').innerText = response.errors.name[0];
                        document.getElementById('create-user-modal-name').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'login',
                    'callback': function(response)
                    {
                        document.getElementById('create-user-modal-login-error').innerText = response.errors.login[0];
                        document.getElementById('create-user-modal-login').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'password',
                    'callback': function(response)
                    {
                        document.getElementById('create-user-modal-password-error').innerText = response.errors.password[0];
                        document.getElementById('create-user-modal-password').className = 'form-control is-invalid';
                    }
                }
            ]);
    }

    function deleteSelectedUsers()
    {
        return deleteSelectedEntries('users', '{{ route('deleteUsers') }}', getUsersTable);
    }

    function getUsersTable()
    {
        if (document.getElementById('users-table') != null)
        {
            getTable('users', '{{ route('getUsers') }}');
        }
    }

    function updateUser()
    {
        updateEntry('update-user-modal', '{{ route('updateUser') }}', clearUpdateUserModalErrors, getUsersTable,
            function()
            {
                let updateUserModal = $('#update-user-modal');

                return {
                    id: updateUserModal.find('.modal-body #update-user-modal-id').val(),
                    name: updateUserModal.find('.modal-body #update-user-modal-name').val(),
                    login: updateUserModal.find('.modal-body #update-user-modal-login').val(),
                }
            },
            [
                {
                    'name': 'id',
                    'callback': function(response)
                    {
                        hideModal('update-user-modal');
                        show_toast('update-error', 'danger', 'Ошибка', 'Внутренняя ошибка');
                    }
                },
                {
                    'name': 'name',
                    'callback': function(response)
                    {
                        document.getElementById('update-user-modal-name-error').innerText = response.errors.name[0];
                        document.getElementById('update-user-modal-name').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'login',
                    'callback': function(response)
                    {
                        document.getElementById('update-user-modal-login-error').innerText = response.errors.login[0];
                        document.getElementById('update-user-modal-login').className = 'form-control is-invalid';
                    }
                }
            ]);
    }

    function updateUserPassword()
    {
        updateEntry('update-user-modal', '{{ route('updateUserPassword') }}', clearUpdateUserModalErrors, getUsersTable,
            function()
            {
                let updateUserModal = $('#update-user-modal');

                return {
                    id: updateUserModal.find('.modal-body #update-user-modal-id').val(),
                    password: updateUserModal.find('.modal-body #update-user-modal-password').val(),
                    password_confirmation: updateUserModal.find('.modal-body #update-user-modal-password-confirmation').val(),
                }
            },
            [
                {
                    'name': 'id',
                    'callback': function(response)
                    {
                        hideModal('update-user-modal');
                        show_toast('update-error', 'danger', 'Ошибка', 'Внутренняя ошибка');
                    }
                },
                {
                    'name': 'password',
                    'callback': function(response)
                    {
                        document.getElementById('update-user-modal-password-error').innerText = response.errors.password[0];
                        document.getElementById('update-user-modal-password').className = 'form-control is-invalid';
                    }
                }
            ]);
    }
</script>

<script>
    let createUserLoginMask;

    if (document.getElementById('create-user-modal-login'))
    {
        createUserLoginMask = IMask(
            document.getElementById('create-user-modal-login'), {
                mask: /^[a-zA-Z]+[0-9a-zA-Z.]{0,32}$/i
            });
    }

    let updateUserLoginMask = IMask(
        document.getElementById('update-user-modal-login'), {
            mask: /^[a-zA-Z]+[0-9a-zA-Z.]{0,32}$/i
        });
</script>
