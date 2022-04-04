<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js'></script>
<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table-locale-all.min.js'></script>
<script src="https://unpkg.com/imask"></script>
<script src='{{ URL::asset("js/main.js") }}'></script>

<script>
    function clearCreateBrigadeModalErrors()
    {
        document.getElementById('create-brigade-modal-contact-person-error').innerText = '';
        document.getElementById('create-brigade-modal-contact-person').className = 'form-control';

        document.getElementById('create-brigade-modal-phone-error').innerText = '';
        document.getElementById('create-brigade-modal-phone').className = 'form-control';

        document.getElementById('create-brigade-modal-driver-error').innerText = '';
        document.getElementById('create-brigade-modal-driver').className = 'form-control';

        document.getElementById('create-brigade-modal-car-error').innerText = '';
        document.getElementById('create-brigade-modal-car').className = 'form-control';
    }

    function clearUpdateBrigadeModalErrors()
    {
        document.getElementById('update-brigade-modal-contact-person-error').innerText = '';
        document.getElementById('update-brigade-modal-contact-person').className = 'form-control';

        document.getElementById('update-brigade-modal-phone-error').innerText = '';
        document.getElementById('update-brigade-modal-phone').className = 'form-control';

        document.getElementById('update-brigade-modal-driver-error').innerText = '';
        document.getElementById('update-brigade-modal-driver').className = 'form-control';

        document.getElementById('update-brigade-modal-car-error').innerText = '';
        document.getElementById('update-brigade-modal-car').className = 'form-control';
    }

    function createBrigade()
    {
        createEntry('create-brigade-modal', '{{ route('createBrigade') }}', clearCreateBrigadeModalErrors, getBrigadesTable,
            function()
            {
                let createBrigadeModal = $('#create-brigade-modal');
                let createBrigadeModalTypeSelect = document.getElementById("create-brigade-modal-type");

                return {
                    phone: createBrigadeModal.find('.modal-body #create-brigade-modal-phone').val(),
                    contact_person: createBrigadeModal.find('.modal-body #create-brigade-modal-contact-person').val(),
                    car: createBrigadeModal.find('.modal-body #create-brigade-modal-car').val(),
                    driver: createBrigadeModal.find('.modal-body #create-brigade-modal-driver').val(),
                    brigade_type_id: createBrigadeModalTypeSelect.options[createBrigadeModalTypeSelect.selectedIndex].value
                }
            },
            [
                {
                    'name': 'phone',
                    'callback': function(response)
                    {
                        document.getElementById('create-brigade-modal-phone-error').innerText = response.errors.phone[0];
                        document.getElementById('create-brigade-modal-phone').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'contact_person',
                    'callback': function(response)
                    {
                        document.getElementById('create-brigade-modal-contact-person-error').innerText = response.errors.contact_person[0];
                        document.getElementById('create-brigade-modal-contact-person').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'car',
                    'callback': function(response)
                    {
                        document.getElementById('create-brigade-modal-car-error').innerText = response.errors.car[0];
                        document.getElementById('create-brigade-modal-car').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'driver',
                    'callback': function(response)
                    {
                        document.getElementById('create-brigade-modal-driver-error').innerText = response.errors.driver[0];
                        document.getElementById('create-brigade-modal-driver').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'brigade_type_id',
                    'callback': function(response)
                    {
                        hideModal('create-brigade-modal');
                        show_toast('Неизвестная ошибка');
                    }
                }
            ]);

    }

    function deleteSelectedBrigades()
    {
        deleteSelectedEntries('brigades', '{{ route('deleteBrigades') }}', getBrigadesTable);
    }

    function getBrigadesTable()
    {
        getTable('brigades', '{{ route('getBrigades') }}');
    }

    function updateBrigade()
    {
        updateEntry('update-brigade-modal', '{{ route('updateBrigade') }}', clearUpdateBrigadeModalErrors, getBrigadesTable,
            function()
            {
                let updateBrigadeModal = $('#update-brigade-modal');
                let updateBrigadeModalTypeSelect = document.getElementById("update-brigade-modal-type");

                return {
                    id: updateBrigadeModal.find('.modal-body #update-brigade-modal-id').val(),
                    phone: updateBrigadeModal.find('.modal-body #update-brigade-modal-phone').val(),
                    contact_person: updateBrigadeModal.find('.modal-body #update-brigade-modal-contact-person').val(),
                    car: updateBrigadeModal.find('.modal-body #update-brigade-modal-car').val(),
                    driver: updateBrigadeModal.find('.modal-body #update-brigade-modal-driver').val(),
                    brigade_type_id: updateBrigadeModalTypeSelect.options[updateBrigadeModalTypeSelect.selectedIndex].value
                }
            },
            [
                {
                    'name': 'phone',
                    'callback': function(response)
                    {
                        document.getElementById('update-brigade-modal-phone-error').innerText = response.errors.phone[0];
                        document.getElementById('update-brigade-modal-phone').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'contact_person',
                    'callback': function(response)
                    {
                        document.getElementById('update-brigade-modal-contact-person-error').innerText = response.errors.contact_person[0];
                        document.getElementById('update-brigade-modal-contact-person').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'car',
                    'callback': function(response)
                    {
                        document.getElementById('update-brigade-modal-car-error').innerText = response.errors.car[0];
                        document.getElementById('update-brigade-modal-car').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'driver',
                    'callback': function(response)
                    {
                        document.getElementById('update-brigade-modal-driver-error').innerText = response.errors.driver[0];
                        document.getElementById('update-brigade-modal-driver').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'brigade_type_id',
                    'callback': function(response)
                    {
                        hideModal('update-brigade-modal');
                        show_toast('update-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время обновления бригады');
                    }
                },
                {
                    'name': 'id',
                    'callback': function(response)
                    {
                        hideModal('update-brigade-modal');
                        show_toast('update-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время обновления бригады');
                    }
                }
            ]);
    }
</script>
