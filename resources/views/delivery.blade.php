@extends('header')

@section('title', 'Доставки')

@section('stylesheets')
	@parent
	<link rel='stylesheet' href='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css'>
	<link rel='stylesheet' href='{{ URL::asset("css/daterangepicker.css") }}'>
@endsection

@section('page_content')
	<div id='delivery_table_toolbar'>
		<div class='container-fluid ' style='min-width:1000px;'>
			<div class='row'>
				<div class='col-12 col-lg-6 mb-4 mb-lg-0'>
                    <div class="datepicker-container">
                        <strong>Доставки</strong>
                        <div class="datepicker" id="date-daterangepicker" style="cursor: pointer;"></div>
                        <div id="datepicker-ico" class="datepicker-ico">

                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.4 7.65H5.1V9.35H3.4V7.65ZM3.4 11.05H5.1V12.75H3.4V11.05ZM6.8 7.65H8.5V9.35H6.8V7.65ZM6.8 11.05H8.5V12.75H6.8V11.05ZM10.2 7.65H11.9V9.35H10.2V7.65ZM10.2 11.05H11.9V12.75H10.2V11.05Z" fill="black"/>
                                <path d="M1.7 17H13.6C14.5376 17 15.3 16.2376 15.3 15.3V3.4C15.3 2.46245 14.5376 1.7 13.6 1.7H11.9V0H10.2V1.7H5.1V0H3.4V1.7H1.7C0.76245 1.7 0 2.46245 0 3.4V15.3C0 16.2376 0.76245 17 1.7 17ZM13.6 5.1L13.6009 15.3H1.7V5.1H13.6Z" fill="black"/>
                            </svg>

                        </div>
                    </div>
				</div>
				<div class='col-12 col-lg-6'>
                    <div class="deliveries-table-container">
					<strong>
						Объём <span id="deliveries-table-used-volume"></span> из

                        @if ($current_user->is_admin)
                            <span>
                                <ins id="deliveries-table-total-volume" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"></ins>
                                <div class="dropdown-menu">
                                    <div class="form-group px-3 py-1">
                                        <label for="deliveryDropdownFormVolume" style='font-size: 12px;'>Изменить объём</label>
                                        <input type="text" class="form-control" id="deliveryDropdownFormVolume" style='font-size: 12px;'/>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class='float-right px-3 py-1'>
                                        <button class='btn btn-sm btn-default' style='margin-left: 8px; font-size: 12px; font-weight: bold; padding: 4px 8px;'>Отмена</button>
                                        <button class='btn btn-sm btn-custom' style='margin-left: 8px; font-size: 12px; font-weight: bold; padding: 4px 8px;' onclick='changeVolume($("#deliveryDropdownFormVolume"));'>Применить</button>
                                    </div>
                                </div>
                            </span>
                        @else
                            <span id="deliveries-table-total-volume"></span>
                        @endif

                    </strong>
				</div>
				</div>
			</div>
		</div>
    </div>
	<div class='row flex-xl-nowrap'>
		<main class='col py-md-3 bd-content'>
			<div class='table-responsive'>
				<table id='deliveries-table' class='table table-bordered'
					data-toggle='table'
					data-locale='ru-RU'
					data-toolbar='#delivery_table_toolbar'
					data-search='true'
					data-show-columns='true'
					data-buttons='deliveriesTableButtons'
					data-pagination-loop='false'
					data-pagination='true'
					data-page-size='100000'
					data-click-to-select='true'>
					<thead class='thead-blue'>
						<tr>
                            <th data-checkbox="true"></th>
                            <th data-visible="false"></th>
							<th scope='col' data-sortable='true'>Менеджер</th>
							<th scope='col' data-sortable='true'>Организация</th>
							<th scope='col' data-sortable='true'>Адрес</th>
							<th scope='col' data-sortable='true'>Контактное лицо, телефон</th>
							<th scope='col' data-sortable='true'>Действия</th>
							<th scope='col' data-sortable='true'>Объём</th>
							<th scope='col' data-sortable='true'>Примечание</th>
							<th scope='col'>
								<div class='oi oi-external-link' data-glyph='icon-name' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='По краю'></div>
							</th>
							<th scope='col'>
								<div class='oi ico-ruble' data-glyph='icon-name' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='Оплачено'></div>
							</th>
							<th scope='col'>
								<span class='oi oi-check' data-glyph='icon-name' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='В наличии'></span>
							</th>
							<th scope='col' data-sortable='true'>№ счёта</th>
							<th scope='col' data-sortable='true'>Реализация</th>
                            <!--th scope='col' data-sortable='true'>Состояние</th-->
                            <th scope="col"><span class='oi oi-pencil'></span></th>
						</tr>
					</thead>
					<tbody id="deliveries-table-body">
					</tbody>
				</table>
                @include('deliveries.create_modal')
                @include('deliveries.delete_modal')
                @include('deliveries.update_modal')
			</div>
		</main>
	</div>
@endsection

@section('scripts')
	@parent
    @include('deliveries.javascript')

    <script>
        function getSelectedDate() {
            var currentDate = $("#date-daterangepicker").text();
            currentDate = currentDate.split("-");
            return currentDate[2] + "-" + currentDate[1] + "-" + currentDate[0];
        }
    
        $('#datepicker-ico').on('click', function (event) {
            $('#date-daterangepicker').trigger('click')
        })

        $(document).on('show.bs.modal','#create-delivery-modal', function (event)
        {
            getActionsSelect('create-delivery-modal-actions');
            document.getElementById('create-delivery-modal-organization-address').value = 'Владивосток';
            createDeliveryDateMask.value = getSelectedDate(); //$('#date-daterangepicker').html().replace('-', '.');
        });

        $(document).on('show.bs.modal','#update-delivery-modal', function (event)
        {
            let button = $(event.relatedTarget);
            getActionsSelect('update-delivery-modal-actions', button.data('actions'));
            document.getElementById('update-delivery-modal-id').value = button.data('id');
            document.getElementById('update-delivery-modal-contact-person').value = button.data('contact-person');
            document.getElementById('update-delivery-modal-phone').value = button.data('phone');
            updateDeliveryDateMask.value = getSelectedDate(); //button.data('date');
            updateDeliveryValueMask.value = button.data('value').toString();
            document.getElementById('update-delivery-modal-comment').value = button.data('comment');
            document.getElementById('update-delivery-modal-organization-name').value = button.data('organization-name');
            document.getElementById('update-delivery-modal-organization-address').value = button.data('organization-address');
            document.getElementById('update-delivery-modal-selling').value = button.data('selling');
            document.getElementById('update-delivery-modal-account').value = button.data('account');
            document.getElementById('update-delivery-modal-is-in-region').checked = button.data('is-in-region');
            document.getElementById('update-delivery-modal-is-paid').checked = button.data('is-paid');
            document.getElementById('update-delivery-modal-is-available').checked = button.data('is-available');

            let delivery_state_id = button.data('delivery-state-id');
            let updateDeliveryStateSelect = document.getElementById("update-delivery-modal-state");

            updateDeliveryStateSelect.options.forEach(function(item, index)
            {
                if(delivery_state_id == item.value)
                {
                    updateDeliveryStateSelect.selectedIndex = index;
                }
            });
        });

        $(document).on('hide.bs.modal','#create-delivery-modal', function (event)
        {
            clearCreateDeliveryModalErrors();

            document.getElementById('create-delivery-modal-contact-person').value = '';
            document.getElementById('create-delivery-modal-phone').value = '';
            createDeliveryDateMask.value = '';
            createDeliveryValueMask.value = '';
            document.getElementById('create-delivery-modal-comment').value = '';
            document.getElementById('create-delivery-modal-organization-name').value = '';
            document.getElementById('create-delivery-modal-organization-address').value = '';
            document.getElementById('create-delivery-modal-selling').value = '';
            document.getElementById('create-delivery-modal-account').value = '';
            document.getElementById('create-delivery-modal-is-in-region').checked = false;
            document.getElementById('create-delivery-modal-is-paid').checked = false;
            document.getElementById('create-delivery-modal-is-available').checked = false;
            document.getElementById('create-delivery-modal-state').selectedIndex = 0;
        });

        $(document).on('hide.bs.modal','#update-delivery-modal', function (event)
        {
            clearUpdateDeliveryModalErrors();
        });

        var momentFormat = 'DD.MM.YYYY';
        let createDeliveryDateMask = document.getElementById('create-delivery-modal-date');
/*
        IMask(
            document.getElementById('create-delivery-modal-date'),
            {
                mask: Date,
                pattern: momentFormat,
                min: new Date(1990, 0, 1),
                max: new Date(2060, 0, 1),
                lazy: false,
                format: function (date) {
                    return moment(date).format(momentFormat);
                },
                parse: function (str) {
                    return moment(str, momentFormat);
                },
                blocks: {
                    YYYY: {
                        mask: IMask.MaskedRange,
                        from: 1970,
                        to: 2030
                    },
                    MM: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 12
                    },
                    DD: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 31
                    }
                }
            });
*/

        let createDeliveryValueMask = IMask(
            document.getElementById('create-delivery-modal-value'),
            {
                mask: Number,
                min: 0,
                max: 9999999,
            });

        let updateDeliveryDateMask = document.getElementById('update-delivery-modal-date');
/*
        IMask(
            document.getElementById('update-delivery-modal-date'),
            {
                mask: Date,
                pattern: momentFormat,
                min: new Date(1990, 0, 1),
                max: new Date(2060, 0, 1),
                lazy: false,
                format: function (date) {
                    return moment(date).format(momentFormat);
                },
                parse: function (str) {
                    return moment(str, momentFormat);
                },
                blocks: {
                    YYYY: {
                        mask: IMask.MaskedRange,
                        from: 1970,
                        to: 2030
                    },
                    MM: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 12
                    },
                    DD: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 31
                    }
                }
            });
*/

        let updateDeliveryValueMask = IMask(
            document.getElementById('update-delivery-modal-value'),
            {
                mask: Number,
                min: 0,
                max: 9999999,
            });

    </script>

    @stack('users_scripts')
@endsection
