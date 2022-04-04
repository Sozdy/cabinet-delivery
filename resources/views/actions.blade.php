@extends('header')

@section('title', 'Действия')

@section('stylesheets')
	@parent
	<link rel='stylesheet' href='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css'>
@endsection

@section('page_content')
	<div id='actions_table_toolbar'>
		<strong style='font-size:24px;'>Действия</strong>
	</div>
	<div class='row flex-xl-nowrap'>
		<main class='col py-md-3 bd-content'>
			<div class='table-responsive'>
				<table id='actions-table' class='table table-bordered'
					data-toggle='table'
					data-locale='ru-RU'
					data-toolbar='#actions_table_toolbar'
					data-search='true'
					data-show-columns='true'
					data-buttons='actionsTableButtons'
					data-pagination-loop='false'
					data-pagination='true'
					data-page-size='10'
					data-click-to-select='true'>
					<thead class='thead-custom'>
						<tr>
							<th data-checkbox="true"></th>
                            <th data-visible="false"></th>
							<th scope='col' data-sortable="true">Наименование</th>
                            <th scope='col'><span class='oi oi-pencil'></span></th>
						</tr>
					</thead>
					<tbody id="actions-table-body">
                        @include('actions.table')
					</tbody>
				</table>
			</div>
		</main>
	</div>

    @include('actions.update_modal')
    @include('actions.create_modal')
    @include('actions.delete_modal')

@endsection

@section('scripts')
	@parent
    @include('actions.javascript')

    <script>
        $(document).on('show.bs.modal','#update-action-modal', function(event)
        {
            let button = $(event.relatedTarget);
            let id = button.data('id');
            let name = button.data('name');

            let modal = $(this)
            modal.find('.modal-title').text('Изменение действия "' + name +'"');
            modal.find('.modal-body #update-action-modal-id').val(id)
            modal.find('.modal-body #update-action-modal-name').val(name)
        });

        $(document).on('hide.bs.modal','#update-action-modal', function(event)
        {
            clearUpdateActionModalErrors();
        });

        $(document).on('hide.bs.modal','#create-action-modal', function(event)
        {
            clearCreateActionModalErrors();

            $('#create-action-modal').find('.modal-body #create-action-modal-name').val('');
        });

        function actionsTableButtons()
        {
            return {
                btnUpdateActionsTable: {
                    icon: 'oi oi-loop-circular',
                    attributes: {
                        'id': 'actions-table-update-button',
                        'aria-hidden': 'true',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        title: 'Обновить'
                    },
                    event: {
                        'click': function()
                        {
                            getActionsTable();
                        }
                    }
                },
                btnAddAction: {
                    icon: 'oi oi-plus',
                    attributes: {
                        'id': 'actions-table-add-button',
                        'aria-hidden': 'true',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        title: 'Добавить'
                    },
                    event: {
                        'click': function()
                        {
                            showModal('create-action-modal');
                        }
                    }
                },
                btnDeleteSelectedActions: {
                    icon: 'oi oi-trash',
                    attributes: {
                        'id': 'actions-table-delete-button',
                        'aria-hidden': 'true',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'title': 'Удалить'
                    },
                    event: {
                        'click': function()
                        {
                            if ($('#actions-table').bootstrapTable('getSelections').length > 0)
                            {
                                showModal('delete-actions-modal');
                            }
                            else
                            {
                                show_toast('delete-error', 'alert', 'Внимание', 'Необходимо выбрать действия для удаления');
                            }
                        }
                    }
                }
            }
        }
    </script>
@endsection
