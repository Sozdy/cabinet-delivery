<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js'></script>
<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table-locale-all.min.js'></script>
<script src='{{ URL::asset("js/main.js") }}'></script>

<script>
    function clearCreateActionModalErrors()
    {
        document.getElementById('create-action-modal-name-error').innerText = '';
        document.getElementById('create-action-modal-name').className = 'form-control';
    }

    function clearUpdateActionModalErrors()
    {
        document.getElementById('update-action-modal-name-error').innerText = '';
        document.getElementById('update-action-modal-name').className = 'form-control';
    }

    function createAction()
    {
        createEntry('create-action-modal', '{{ route('createAction') }}', clearCreateActionModalErrors, getActionsTable,
            function()
            {
                return {
                    name: $('#create-action-modal').find('.modal-body #create-action-modal-name').val()
                };
            },
            [
                {
                    'name': 'name',
                    'callback': function(response)
                    {
                        document.getElementById('create-action-modal-name-error').innerText = response.errors.name[0];
                        document.getElementById('create-action-modal-name').className = 'form-control is-invalid';
                    }
                }
            ]);
    }

    function deleteSelectedActions()
    {
        deleteSelectedEntries('actions', '{{ route('deleteActions') }}', getActionsTable);
    }

    function getActionsTable()
    {
        getTable('actions', '{{ route('getActions') }}');
    }

    function updateAction()
    {
        updateEntry('update-action-modal', '{{ route('updateAction') }}', clearUpdateActionModalErrors, getActionsTable,
            function()
            {
                let updateModal = $('#update-action-modal');

                return {
                    id: updateModal.find('.modal-body #update-action-modal-id').val(),
                    name: updateModal.find('.modal-body #update-action-modal-name').val()
                };
            },
            [
                {
                    'name': 'id',
                    'callback': function(response)
                    {
                        hideModal('update-action-modal');
                        show_toast('update-error', 'danger', 'Ошибка', 'Внутренняя ошибка');
                    }
                },
                {
                    'name': 'name',
                    'callback': function(response)
                    {
                        document.getElementById('update-action-modal-name-error').innerText = response.errors.name[0];
                        document.getElementById('update-action-modal-name').className = 'form-control is-invalid';
                    }
                }
            ]);
    }
</script>
