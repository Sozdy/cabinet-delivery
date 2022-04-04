<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js'></script>
<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table-locale-all.min.js'></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src='{{ URL::asset("js/moment.min.js") }}'></script>
<script src='{{ URL::asset("js/daterangepicker.js") }}'></script>
<script src='{{ URL::asset("js/main.js") }}'></script>

<script>
	function changeVolume($input){
		var newVolume = $input.val();
		
		$.ajax({
			'url' : '{{ route('setDayValue') }}',
			'method' : 'POST',
			'data' : {
				'date' : $('#date-daterangepicker').html(),
				'value' : newVolume
			}
		}).done(function(response){
			
			if (!response.status){
                show_toast('get-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время обновления объёма перевозок');
                return;
			}
			
			$('#deliveries-table-total-volume').html(newVolume);
		}).fail(function()
        {
            show_toast('get-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время обновления объёма перевозок');
        });
	}

	function changePassMode($checkBox){
		var $inputGroup = $checkBox.parents('.deliveries-input-group');
		console.log($checkBox.prop('checked'));
		$inputGroup.find('.disable-when-pass').each(function(){
			console.log($(this));
			$(this).prop('hidden', $checkBox.prop('checked'));
		});
	}

    function clearCreateDeliveryModalErrors()
    {
        document.getElementById('create-delivery-modal-contact-person-error').innerText = '';
        document.getElementById('create-delivery-modal-contact-person').className = 'form-control';

        document.getElementById('create-delivery-modal-phone-error').innerText = '';
        document.getElementById('create-delivery-modal-phone').className = 'form-control';

        document.getElementById('create-delivery-modal-date-error').innerText = '';
        document.getElementById('create-delivery-modal-date').className = 'form-control';

        document.getElementById('create-delivery-modal-value-error').innerText = '';
        document.getElementById('create-delivery-modal-value').className = 'form-control';

        document.getElementById('create-delivery-modal-comment-error').innerText = '';
        document.getElementById('create-delivery-modal-comment').className = 'form-control';

        document.getElementById('create-delivery-modal-organization-name-error').innerText = '';
        document.getElementById('create-delivery-modal-organization-name').className = 'form-control';

        document.getElementById('create-delivery-modal-organization-address-error').innerText = '';
        document.getElementById('create-delivery-modal-organization-address').className = 'form-control';

        document.getElementById('create-delivery-modal-selling-error').innerText = '';
        document.getElementById('create-delivery-modal-selling').className = 'form-control';

        document.getElementById('create-delivery-modal-account-error').innerText = '';
        document.getElementById('create-delivery-modal-account').className = 'form-control';
    }

    function clearUpdateDeliveryModalErrors()
    {
        document.getElementById('update-delivery-modal-contact-person-error').innerText = '';
        document.getElementById('update-delivery-modal-contact-person').className = 'form-control';

        document.getElementById('update-delivery-modal-phone-error').innerText = '';
        document.getElementById('update-delivery-modal-phone').className = 'form-control';

        document.getElementById('update-delivery-modal-date-error').innerText = '';
        document.getElementById('update-delivery-modal-date').className = 'form-control';

        document.getElementById('update-delivery-modal-value-error').innerText = '';
        document.getElementById('update-delivery-modal-value').className = 'form-control';

        document.getElementById('update-delivery-modal-comment-error').innerText = '';
        document.getElementById('update-delivery-modal-comment').className = 'form-control';

        document.getElementById('update-delivery-modal-organization-name-error').innerText = '';
        document.getElementById('update-delivery-modal-organization-name').className = 'form-control';

        document.getElementById('update-delivery-modal-organization-address-error').innerText = '';
        document.getElementById('update-delivery-modal-organization-address').className = 'form-control';

        document.getElementById('update-delivery-modal-selling-error').innerText = '';
        document.getElementById('update-delivery-modal-selling').className = 'form-control';

        document.getElementById('update-delivery-modal-account-error').innerText = '';
        document.getElementById('update-delivery-modal-account').className = 'form-control';
    }

	function setDefaultValuesIfPass($modal){
		var isChecked = $modal.find('.pass-checkbox').prop('checked');
		
		if (!isChecked)
			return;
		
		$modal.find('.disable-when-pass').each(function(){
			$(this).find('input[type="checkbox"]').prop('checked', false);
			$(this).find('input[type="text"]').val('');
			$(this).find('.multiple-select').find('option').prop('selected', false);
		});
	}
	
    function createDelivery()
    {
		setDefaultValuesIfPass($('#create-delivery-modal'));
		
        createEntry('create-delivery-modal', '{{ route('createDelivery') }}', clearCreateDeliveryModalErrors, getDeliveriesTable,
            function()
            {
                let createDeliveryModal = $('#create-delivery-modal');
                let createDeliveryStateSelect = document.getElementById("create-delivery-modal-state");

                return {
                    contact_person: createDeliveryModal.find('.modal-body #create-delivery-modal-contact-person').val(),
                    phone: createDeliveryModal.find('.modal-body #create-delivery-modal-phone').val(),
                    date: createDeliveryModal.find('.modal-body #create-delivery-modal-date').val(),
                    value: createDeliveryModal.find('.modal-body #create-delivery-modal-value').val(),
                    comment: createDeliveryModal.find('.modal-body #create-delivery-modal-comment').val(),
                    organization_name: createDeliveryModal.find('.modal-body #create-delivery-modal-organization-name').val(),
                    organization_address: createDeliveryModal.find('.modal-body #create-delivery-modal-organization-address').val(),
                    selling: createDeliveryModal.find('.modal-body #create-delivery-modal-selling').val(),
                    account: createDeliveryModal.find('.modal-body #create-delivery-modal-account').val(),
                    is_in_region: document.getElementById('create-delivery-modal-is-in-region').checked ? 1 : 0,
                    is_paid: document.getElementById('create-delivery-modal-is-paid').checked ? 1 : 0,
                    is_available: document.getElementById('create-delivery-modal-is-available').checked ? 1 : 0,
                    actions: $('#create-delivery-modal-actions').multipleSelect('getSelects'),
                    delivery_state_id: createDeliveryStateSelect.options[createDeliveryStateSelect.selectedIndex].value
                }
            },
            [
                {
                    'name': 'contact_person',
                    'callback': function(response)
                    {
                        document.getElementById('create-delivery-modal-contact-person-error').innerText = response.errors.contact_person[0];
                        document.getElementById('create-delivery-modal-contact-person').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'phone',
                    'callback': function(response)
                    {
                        document.getElementById('create-delivery-modal-phone-error').innerText = response.errors.phone[0];
                        document.getElementById('create-delivery-modal-phone').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'date',
                    'callback': function(response)
                    {
                        document.getElementById('create-delivery-modal-date-error').innerText = response.errors.date[0];
                        document.getElementById('create-delivery-modal-date').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'value',
                    'callback': function(response)
                    {
                        document.getElementById('create-delivery-modal-value-error').innerText = response.errors.value[0];
                        document.getElementById('create-delivery-modal-value').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'comment',
                    'callback': function(response)
                    {
                        document.getElementById('create-delivery-modal-comment-error').innerText = response.errors.comment[0];
                        document.getElementById('create-delivery-modal-comment').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'organization_name',
                    'callback': function(response)
                    {
                        document.getElementById('create-delivery-modal-organization-name-error').innerText = response.errors.organization_name[0];
                        document.getElementById('create-delivery-modal-organization-name').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'organization_address',
                    'callback': function(response)
                    {
                        document.getElementById('create-delivery-modal-organization-address-error').innerText = response.errors.organization_address[0];
                        document.getElementById('create-delivery-modal-organization-address').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'selling',
                    'callback': function(response)
                    {
                        document.getElementById('create-delivery-modal-selling-error').innerText = response.errors.selling[0];
                        document.getElementById('create-delivery-modal-selling').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'account',
                    'callback': function(response)
                    {
                        document.getElementById('create-delivery-modal-account-error').innerText = response.errors.account[0];
                        document.getElementById('create-delivery-modal-account').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'is_in_region',
                    'callback': function(response)
                    {
                        hideModal('create-delivery-modal');
                        show_toast(response.errors.is_in_region[0]);
                    }
                },
                {
                    'name': 'is_paid',
                    'callback': function(response)
                    {
                        hideModal('create-delivery-modal');
                        show_toast(response.errors.is_paid[0]);
                    }
                },
                {
                    'name': 'is_available',
                    'callback': function(response)
                    {
                        hideModal('create-delivery-modal');
                        show_toast(response.errors.is_available[0]);
                    }
                },
                {
                    'name': 'actions',
                    'callback': function(response)
                    {
                        hideModal('create-delivery-modal');
                        show_toast(response.errors.actions[0]);
                    }
                },
                {
                    'name': 'delivery_state_id',
                    'callback': function(response)
                    {
                        hideModal('create-delivery-modal');
                        show_toast(response.errors.delivery_state_id[0]);
                    }
                },
            ]);
    }

    function getActionsSelect(selectName, selectedValues = null)
    {
        $.ajax(
            {
                url: '{{ route('getActionsSelect') }}',
                method: 'GET',
            }).done(function(response)
        {
            if (!response.status)
            {
                hideModal('create-delivery-modal');
                show_toast('get-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время получения данных');
                return;
            }

            let select =  $('#' + selectName)

            select.multipleSelect('destroy');
            document.getElementById(selectName).innerHTML = response.view;
            select.multipleSelect('refresh');

            if (selectedValues)
            {
                select.multipleSelect('setSelects', selectedValues);
            }
        }).fail(function()
        {
            hideModal('create-delivery-modal');
            show_toast('get-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время получения данных');
        });
    }

	function deleteSelectedDeliveries()
	{
		deleteSelectedEntries('deliveries', '{{ route('deleteDeliveries') }}', getDeliveriesTable);
	}

	function getDeliveriesTable()
	{
		var date = $('#date-daterangepicker').html();

		getTable('deliveries', '{{ route('getDeliveries') }}', 'POST', function()
			{
				return {
					date: date
				}
			},
            function()
            {
                getValues(date);
            });
    }

	function getDeliveriesTableForDate(date)
	{
		getTable('deliveries', '{{ route('getDeliveries') }}', 'POST', function()
		{
			return {
				'date': date
			}
		});
    }

	function getValues(date)
    {
        $.ajax(
            {
                url: '{{ route('getValues') }}',
                method: 'POST',
                data: {date: date}
            }).done(function(response)
        {
            if (!response.status)
            {
                show_toast('get-error', 'danger', 'Ошибка', response.message);
            }
            else
            {
				var usedVolume = response.used_value !== null
					? response.used_value
					: 0;
				var totalVolume = response.value !== null
					? response.value
					: 0;
				$('#deliveries-table-used-volume').html(usedVolume);
				$('#deliveries-table-total-volume').html(totalVolume);
            }
        }).fail(function()
        {
            show_toast('get-error', 'danger', 'Произошла непредвиденная ошибка');
        });
    }

	function updateDelivery()
    {
		setDefaultValuesIfPass($('#create-delivery-modal'));
		
        updateEntry('update-delivery-modal', '{{ route('updateDelivery') }}', clearUpdateDeliveryModalErrors, getDeliveriesTable,
            function()
            {
                let updateDeliveryModal = $('#update-delivery-modal');
                let updateDeliveryStateSelect = document.getElementById("update-delivery-modal-state");

                return {
                    contact_person: updateDeliveryModal.find('.modal-body #update-delivery-modal-contact-person').val(),
                    phone: updateDeliveryModal.find('.modal-body #update-delivery-modal-phone').val(),
                    date: updateDeliveryModal.find('.modal-body #update-delivery-modal-date').val(),
                    value: updateDeliveryModal.find('.modal-body #update-delivery-modal-value').val(),
                    comment: updateDeliveryModal.find('.modal-body #update-delivery-modal-comment').val(),
                    organization_name: updateDeliveryModal.find('.modal-body #update-delivery-modal-organization-name').val(),
                    organization_address: updateDeliveryModal.find('.modal-body #update-delivery-modal-organization-address').val(),
                    selling: updateDeliveryModal.find('.modal-body #update-delivery-modal-selling').val(),
                    account: updateDeliveryModal.find('.modal-body #update-delivery-modal-account').val(),
                    is_in_region: document.getElementById('update-delivery-modal-is-in-region').checked ? 1 : 0,
                    is_paid: document.getElementById('update-delivery-modal-is-paid').checked ? 1 : 0,
                    is_available: document.getElementById('update-delivery-modal-is-available').checked ? 1 : 0,
                    actions: $('#update-delivery-modal-actions').multipleSelect('getSelects'),
                    delivery_state_id: updateDeliveryStateSelect.options[updateDeliveryStateSelect.selectedIndex].value,
                    id: document.getElementById('update-delivery-modal-id').value
                }
            },
            [
                {
                    'name': 'contact_person',
                    'callback': function(response)
                    {
                        document.getElementById('update-delivery-modal-contact-person-error').innerText = response.errors.contact_person[0];
                        document.getElementById('update-delivery-modal-contact-person').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'phone',
                    'callback': function(response)
                    {
                        document.getElementById('update-delivery-modal-phone-error').innerText = response.errors.phone[0];
                        document.getElementById('update-delivery-modal-phone').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'date',
                    'callback': function(response)
                    {
                        document.getElementById('update-delivery-modal-date-error').innerText = response.errors.date[0];
                        document.getElementById('update-delivery-modal-date').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'value',
                    'callback': function(response)
                    {
                        document.getElementById('update-delivery-modal-value-error').innerText = response.errors.value[0];
                        document.getElementById('update-delivery-modal-value').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'comment',
                    'callback': function(response)
                    {
                        document.getElementById('update-delivery-modal-comment-error').innerText = response.errors.comment[0];
                        document.getElementById('update-delivery-modal-comment').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'organization_name',
                    'callback': function(response)
                    {
                        document.getElementById('update-delivery-modal-organization-name-error').innerText = response.errors.organization_name[0];
                        document.getElementById('update-delivery-modal-organization-name').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'organization_address',
                    'callback': function(response)
                    {
                        document.getElementById('update-delivery-modal-organization-address-error').innerText = response.errors.organization_address[0];
                        document.getElementById('update-delivery-modal-organization-address').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'selling',
                    'callback': function(response)
                    {
                        document.getElementById('update-delivery-modal-selling-error').innerText = response.errors.selling[0];
                        document.getElementById('update-delivery-modal-selling').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'account',
                    'callback': function(response)
                    {
                        document.getElementById('update-delivery-modal-account-error').innerText = response.errors.account[0];
                        document.getElementById('update-delivery-modal-account').className = 'form-control is-invalid';
                    }
                },
                {
                    'name': 'is_in_region',
                    'callback': function(response)
                    {
                        hideModal('update-delivery-modal');
                        show_toast(response.errors.is_in_region[0]);
                    }
                },
                {
                    'name': 'is_paid',
                    'callback': function(response)
                    {
                        hideModal('update-delivery-modal');
                        show_toast(response.errors.is_paid[0]);
                    }
                },
                {
                    'name': 'is_available',
                    'callback': function(response)
                    {
                        hideModal('update-delivery-modal');
                        show_toast(response.errors.is_available[0]);
                    }
                },
                {
                    'name': 'actions',
                    'callback': function(response)
                    {
                        hideModal('update-delivery-modal');
                        show_toast(response.errors.actions[0]);
                    }
                },
                {
                    'name': 'delivery_state_id',
                    'callback': function(response)
                    {
                        hideModal('update-delivery-modal');
                        show_toast(response.errors.delivery_state_id[0]);
                    }
                },
                {
                    'name': 'id',
                    'callback': function(response)
                    {
                        hideModal('update-delivery-modal');
                        show_toast(response.errors.id[0]);
                    }
                }
            ]);
    }

	function deliveriesTableButtons(){
		return {
			btnUpdate: {
				icon: 'oi oi-loop-circular',
				attributes: {
					'id' : 'delivery_table_btn_update',
					'aria-hidden': 'true',
					'data-toggle': 'tooltip',
					'data-placement': 'bottom',
					'title': 'Обновить'
				},
				event: {
					'click': function()
					{
						getDeliveriesTable();
					},
					'mouseleave': function() {
						$('#delivery_table_btn_update').tooltip('hide');
					}
				}
			},
			btnAddDelivery: {
				icon: 'oi oi-plus',
				attributes: {
					'id': 'delivery_table_btn_add',
					'aria-hidden': 'true',
					'data-toggle': 'tooltip',
					'data-placement': 'bottom',
					'title': 'Добавить'
				},
				event: {
                    'click': function()
                    {
                        showModal('create-delivery-modal');
                    },
					'mouseleave': function() {
						$('#delivery_table_btn_add').tooltip('hide');
					}
				}
			},
			btnDeleteDelivery: {
				icon: 'oi oi-trash',
				attributes: {
					'id': 'delivery_table_btn_delete',
					'aria-hidden': 'true',
					'data-toggle': 'tooltip',
					'data-placement': 'bottom',
					'title': 'Удалить'
				},
				event: {
					'click': function()
					{
						if ($('#deliveries-table').bootstrapTable('getSelections').length > 0)
						{
							showModal('delete-deliveries-modal');
						}
						else
						{
							show_toast('delete-error', 'alert', 'Внимание', 'Необходимо выбрать доставки для удаления');
						}
					},
					'mouseleave': function() {
						$(delivery_table_btn_delete).tooltip('hide');
					}
				}
			}
		}
	}
</script>


<!-- Date selector script -->
<script>
	function updateTable(date){
		print_date(date, 'DD-MM-YYYY');
		getDeliveriesTable();

		//TODO: костыль???
        initialize_date_range_picker($('#date-daterangepicker'), date, function(date){
            updateTable(date);
        });
	}

	function print_date(date, dateFormat){
		$('#date-daterangepicker').html(date.format(dateFormat));
        
        var normalDate = date.format(dateFormat).replace( /(\d{2})-(\d{2})-(\d{4})/, "$3-$2-$1");
        var url = new URL('http://tk.kabinet-vl.ru/schedule');
        url.searchParams.set('date', normalDate);
        $("a[href*='http://tk.kabinet-vl.ru/schedule']").attr("href", url);
        history.pushState(null, null, '/deliveries?date=' + normalDate);
	}

	$(function() {
        var selectedDate = new URLSearchParams(window.location.search).get('date');
		var currentDate = selectedDate ? moment(selectedDate) : moment();

		updateTable(currentDate);

		initialize_date_range_picker($('#date-daterangepicker'), currentDate, function(date){
			updateTable(date);
		});
	});
</script>
