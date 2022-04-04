@extends('header')

@section('title', 'Бригады')

@section('stylesheets')
	@parent
	<link rel='stylesheet' href='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css'>
@endsection

@section('page_content')
	<div id='brigades_table_toolbar'>
		<strong style='font-size:24px;'>Бригады</strong>
	</div>
	<div class='row flex-xl-nowrap'>
		<main class='col py-md-3 bd-content'>
			<div class='table-responsive'>
				<table id='brigades-table' class='table table-bordered'
					data-toggle='table'
					data-locale='ru-RU'
					data-toolbar='#brigades_table_toolbar'
					data-search='true'
					data-show-columns='true'
					data-buttons='brigadesTableButtons'
					data-pagination-loop='false'
					data-pagination='true'
					data-page-size='10'
					data-click-to-select='true'>
					<thead class='thead-custom'>
						<tr>
							<th data-checkbox="true"></th>
                            <th data-visible="false"></th>
							<th scope='col' data-sortable='true'>Контактное лицо, телефон</th>
							<th scope='col' data-sortable='true'>Автомобиль</th>
							<th scope='col' data-sortable='true'>Водитель</th>
							<th scope='col' data-sortable='true'>Тип</th>
                            <th scope="col"><span class='oi oi-pencil'></span></th>
						</tr>
					</thead>
					<tbody id="brigades-table-body">
                        @include('brigades.table')
					</tbody>
				</table>
                @include('brigades.create_modal')
                @include('brigades.delete_modal')
                @include('brigades.update_modal')
			</div>
		</main>
	</div>
@endsection

@section('scripts')
	@parent
    @include('brigades.javascript')

    <script>
        $(document).on('show.bs.modal','#update-brigade-modal', function (event)
        {
            let button = $(event.relatedTarget);
            let id = button.data('id');
            let phone = button.data('phone');
            let contactPerson = button.data('contact-person');
            let driver = button.data('driver');
            let car = button.data('car');
            let brigadeTypeId = button.data('brigade-type-id');

            let modal = $(this)
            modal.find('.modal-title').text('Редактирование бригады');
            modal.find('.modal-body #update-brigade-modal-phone').val(phone);
            modal.find('.modal-body #update-brigade-modal-contact-person').val(contactPerson);
            modal.find('.modal-body #update-brigade-modal-driver').val(driver);
            modal.find('.modal-body #update-brigade-modal-car').val(car);
            modal.find('.modal-body #update-brigade-modal-id').val(id);

            let createBrigadeModalTypeSelect = document.getElementById("update-brigade-modal-type");

            createBrigadeModalTypeSelect.options.forEach(function(item, index)
            {
                if(brigadeTypeId == item.value)
                {
                    createBrigadeModalTypeSelect.selectedIndex = index;
                }
            });
        });

        $(document).on('hide.bs.modal','#update-brigade-modal', function(event)
        {
            clearUpdateBrigadeModalErrors();
        });

        $(document).on('hide.bs.modal','#create-brigade-modal', function(event)
        {
            clearCreateBrigadeModalErrors();

            let createBrigadeModal = $('#create-brigade-modal');
            createBrigadeModal.find('.modal-body #create-brigade-modal-phone').val('');
            createBrigadeModal.find('.modal-body #create-brigade-modal-contact-person').val('');
            createBrigadeModal.find('.modal-body #create-brigade-modal-driver').val('');
            createBrigadeModal.find('.modal-body #create-brigade-modal-car').val('');
            document.getElementById("create-brigade-modal-type").selectedIndex = 0;
        });

        function brigadesTableButtons()
        {
            return {
                btnUpdate: {
                    text: 'Обновить',
                    icon: 'oi oi-loop-circular',
                    attributes: {
                        'id': 'brigades_table_btn_update',
                        'aria-hidden': 'true',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        title: 'Обновить'
                    },
                    event: {
                        'click': function()
                        {
                            getBrigadesTable();
                        },
                        'mouseleave': function() {
                            $('#brigades_table_btn_update').tooltip('hide');
                        }
                    }
                },
                btnAddBrigade: {
                    text: 'Добавить',
                    icon: 'oi oi-plus',
                    attributes: {
                        'id': 'brigades_table_btn_add',
                        'aria-hidden': 'true',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        title: 'Добавить'
                    },
                    event: {
                        'click': function()
                        {
                          showModal('create-brigade-modal');
                        },
                        'mouseleave': function() {
                            $('#brigades_table_btn_add').tooltip('hide');
                        }
                    }
                },
                btnDeleteBrigade: {
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
                            if ($('#brigades-table').bootstrapTable('getSelections').length > 0)
                            {
                                showModal('delete-brigades-modal');
                            }
                            else
                            {
                                show_toast('delete-error', 'alert', 'Внимание', 'Необходимо выбрать бригады для удаления');
                            }
                        },
                        'mouseleave': function()
                        {
                            $('#delivery_table_btn_delete').tooltip('hide');
                        }
                    }
                }
            }
        }
    </script>
@endsection
