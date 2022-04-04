$(function () {
	reinitilizeTooltips();
})

function reinitilizeTooltips(){
	$('.tooltip').remove();
	$('[data-toggle="tooltip"]').tooltip();
}

function initialize_date_range_picker($dateRangePicker, date, callback){
	$dateRangePicker.daterangepicker({
		startDate: date,
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 1901,
		maxYear: 2800,
		locale: {
			format: 'DD-MM-YYYY',
			daysOfWeek: [
				'Вс',
				'Пн',
				'Вт',
				'Ср',
				'Чт',
				'Пт',
				'Сб'
			],
			firstDay: 1,
			monthNames: [
				'Январь',
				'Февраль',
				'Март',
				'Апрель',
				'Май',
				'Июнь',
				'Июль',
				'Август',
				'Сентябрь',
				'Октябрь',
				'Ноябрь',
				'Декабрь'
			],
			'applyLabel': 'Применить',
			'cancelLabel': 'Отмена',
		}
	},
	callback);
}

function show_toast(id, type, title, message){
	$('#page-content').append(' \
	<div id="'+id+'" class="toast" style="position: absolute; top: 0; right: 0; z-index:1070;" data-delay="30000"> \
		<div class="toast-header bg-'+type+' text-body"> \
			  <strong class="mr-auto">' + title + '</strong> \
			  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> \
					<span aria-hidden="true">&times;</span> \
			  </button> \
		</div> \
		<div class="toast-body bg-white"> \
			' + message + ' \
            ' + (type == 'danger' ? '<br/><br/>&raquo; Попробуйте <a href="#" onclick="document.location.reload()">перезагрузить</a> страницу' : '') + ' \
		</div> \
	</div> \
	');
	  $('#'+id).on('hidden.bs.toast', function(){
		  $(this).remove();
	  });
	$('#'+id).toast('show');
}

//Функции, связанные с таблицами и модальными окнами
function createEntry(modalName, route, clearErrorsCallback, getTableCallback, getDataCallback, errorHandlers)
{
    $.ajax(
        {
            url: route,
            method: 'POST',
            data: getDataCallback()
        }).done(function(response)
    {
        clearErrorsCallback();

        if (response.status)
        {
            getTableCallback();
            hideModal(modalName);

            return;
        }

        processInputErrors(response, errorHandlers);
    }).fail(function(error)
    {
        hideModal(modalName);
        show_toast('create-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время создания объекта ' + error.status);
    });
}

function deleteSelectedEntries(tableName, route, getTableCallback)
{
    let table = $('#' + tableName + '-table');

    let ids = []
    table.bootstrapTable('getSelections').forEach(function(item) { ids.push(item[1]) });

    $.ajax(
        {
            url: route,
            method: 'DELETE',
            data: { 'ids': ids }
        }).done(function(response)
    {
        if (response.status)
        {
            getTableCallback();
            hideModal('delete-' + tableName + '-modal');

            return;
        }

        hideModal('delete-' + tableName + '-modal');
        show_toast('delete-error', 'danger', 'Ошибка во время удаления', response.message);
    }).fail(function(error)
    {
        hideModal('delete-' + tableName + '-modal');
        show_toast('delete-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время удаления объекта ' + error.status);
    });
}

function getTable(tableName, route, method = 'GET', getDataCallback = function(){}, onSuccessCallback = function(){})
{
    let table = $('#' + tableName + '-table');
    table.bootstrapTable('showLoading');

    $.ajax(
        {
            url: route,
            method: method,
            data: getDataCallback()
        }).done(function(response)
    {
        if (!response.status)
        {
            $('#' + tableName + '-table').bootstrapTable('hideLoading');
            show_toast('get-error', 'danger', 'Ошибка', response.message);

            return;
        }

        table.bootstrapTable('destroy');
        document.getElementById(tableName + '-table-body').innerHTML = response.view;
        table.bootstrapTable();
		reinitilizeTooltips();

		onSuccessCallback();
    }).fail(function(error)
    {
        table.bootstrapTable('hideLoading');
        show_toast('get-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время получения данных ' + error.status);
    });
}

function updateEntry(modalName, route, clearErrorsCallback, getTableCallback, getDataCallback, errorHandlers)
{
    $.ajax(
        {
            url: route,
            method: 'POST',
            data: getDataCallback()
        }).done(function(response)
    {
        clearErrorsCallback();

        if (response.status)
        {
            getTableCallback();
            hideModal(modalName);

            return;
        }

        processInputErrors(response, errorHandlers);
    }).fail(function(error)
    {
        hideModal(modalName);
        show_toast('update-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время обновления объекта ' + error.status);
    });
}

//Корректно закрывает модальное окно (с учетом приколов от бутстрапа)
function hideModal(name)
{
    $('#' + name).modal('hide');
    $('.modal-backdrop').hide();
}

//Показывает модальное окно (на будущее с учетом возможных приколов от бустрапа)
function showModal(name)
{
    $('#' + name).modal('show');
}

//Обрабатывает возникшие ошибки ввода с помощью колбэков (для показа ошибок)
function processInputErrors(response, errorHandlers)
{
    errorHandlers.forEach(function(item)
    {
        if (response.errors.hasOwnProperty(item.name))
        {
            item.callback(response);
        }
    });
}
