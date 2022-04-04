<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js'></script>
<script src='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table-locale-all.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.11/lib/sortable.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.11/lib/plugins/resize-mirror.js"></script>
<script src='{{ URL::asset("js/moment.min.js") }}'></script>
<script src='{{ URL::asset("js/daterangepicker.js") }}'></script>
<script src='{{ URL::asset("js/main.js") }}'></script>
<script src='{{ URL::asset("js/printThis.js") }}'></script>

<script>
	function onClickBrigadeDayoff($checkbox, brigadeId){
		if ($checkbox.prop('checked'))
			addBrigadeToDay(brigadeId);
		else
			removeBrigadeFromDay(brigadeId);
	}

    function addBrigadeToDay(brigadeId)
    {
        let date = $('#date-daterangepicker').html();

        $.ajax(
            {
                url: '{{ route('addBrigade') }}',
                method: 'POST',
                data: {date: date, value: brigadeId}
            }).done(function(response)
        {
            if (!response.status)
            {
                show_toast('get-error', 'danger', 'Ошибка', response.message);
            }
            else
            {
                getSchedule();
            }
        }).fail(function()
        {
            show_toast('get-error', 'danger', 'Произошла непредвиденная ошибка');
        });
    }

    function removeBrigadeFromDay(brigadeId)
    {
        let date = $('#date-daterangepicker').html();

        $.ajax(
            {
                url: '{{ route('removeBrigade') }}',
                method: 'POST',
                data: {date: date, value: brigadeId}
            }).done(function(response)
        {
            if (!response.status)
            {
                show_toast('get-error', 'danger', 'Ошибка', response.message);
            }
            else
            {
                getSchedule();
            }
        }).fail(function()
        {
            show_toast('get-error', 'danger', 'Произошла непредвиденная ошибка');
        });
    }

    function getSchedule()
    {
        var date = $('#date-daterangepicker').html();

        getTable('schedule', '{{ route('getSchedule') }}', 'POST', function()
        {
            return {
                date: date
            }
        }, makeTableMovable);
    }

    function makeTableMovable()
    {
        const sortable = new Sortable.default($('.sortable').toArray(), {
            draggable: '.sortable-element',
            mirror: {
                constrainDimensions: true,
            },
            plugins: [ResizeMirror.default],
			classes: [ "dragging" ]
        });

		let lastOverContainer;
		let draggableDeliveryOrder;

		// Запоминаем над чем летим
		sortable.on('drag:start', (evt) => {
			 lastOverContainer = evt.sourceContainer;
		});

		sortable.on('mirror:move', (evt) => {
			$(evt.mirror).find('.delivery-order').html(draggableDeliveryOrder);
		});

		// Меняем значения баллов на лету
		sortable.on('sortable:sorted', (evt) => {

			changeDeliveriesOrdersInContainer(evt.dragEvent.overContainer);

			draggableDeliveryOrder = $(evt.dragEvent.source).find('.delivery-order').html();
			$(evt.dragEvent.originalSource).find('.delivery-order').html(draggableDeliveryOrder);

			if (lastOverContainer === evt.dragEvent.overContainer)
				return;

			changeDeliveriesOrdersInContainer(lastOverContainer);
			lastOverContainer = evt.dragEvent.overContainer;

			calculatePoints(lastOverContainer);
			calculatePoints(evt.oldContainer);
		});

		// "Пушим" изменения на сервер
		sortable.on('sortable:stop', (evt) => {
			var deliveryId = $(evt.dragEvent.source).find('input[name="delivery-id"]').val();
			var brigadeId = $(lastOverContainer).find('input[name="brigade-id"]').val();
			var order = evt.newIndex + 1;

			$.ajax({
				url: '{{ route('setBrigadeToDelivery') }}',
				method: 'POST',
				data: {
					'delivery_id' : deliveryId,
					'brigade_id' : brigadeId,
					'order' : order
				}
			}).done(function(response){

				if (!response.status)
					show_toast('get-error', 'danger', 'Ошибка', response.message);

			}).fail(function(){
				show_toast('get-error', 'danger', 'Ошибка', 'Произошла непредвиденная ошибка во время привзки доставки к новой бригаде');
			});
		});

		changeDeliveriesOrdersInContainer(document.getElementById('unused-deliveries-container'));
		calculatePointsForEveryContainer();
    }

	function calculatePointsForEveryContainer(){
		$('.sortable').each(function(){
			calculatePoints(this);
		});
	}

	function calculatePoints(container){
		var sum = 0;

		var $container = $(container);
		$container.find('.row').each(function(){
			if (!$(this).hasClass('draggable--original') && !$(this).hasClass('draggable-mirror'))
				sum += parseInt($(this).find('.delivery-value').html().trim());
		});

		$container.parents('tr').prev('.brigade-attributes-row').find('.brigade-points').html(sum);
	}

	function changeDeliveriesOrdersInContainer(container){
		
		if ($(container).attr('id') === 'unused-deliveries-container'){
			
			$(container).find('.row').each(function(){
				if ($(this).hasClass('draggable--original') || $(this).hasClass('draggable-mirror'))
					return;
			
				$(this).find('.delivery-order').html('');
			});
			
			return;
		}
		
		var deliveryOrder = 1;

		$(container).find('.row').each(function(){

			if ($(this).hasClass('draggable--original') || $(this).hasClass('draggable-mirror'))
				return;

			$(this).find('.delivery-order').html(deliveryOrder++);
		});
	}

    function updateTable(date){
        print_date(date, 'DD-MM-YYYY');
        getSchedule();
    }

    function print_date(date, dateFormat){
        $('#date-daterangepicker').html(date.format(dateFormat));
        
        var normalDate = date.format(dateFormat).replace( /(\d{2})-(\d{2})-(\d{4})/, "$3-$2-$1");
        var url = new URL('http://tk.kabinet-vl.ru/deliveries');
        url.searchParams.set('date', normalDate);
        $("a[href*='http://tk.kabinet-vl.ru/deliveries']").attr("href", url);
        history.pushState(null, null, '/schedule?date=' + normalDate);
    }

    $(function() {
        var selectedDate = new URLSearchParams(window.location.search).get('date');
		var currentDate = selectedDate ? moment(selectedDate) : moment();

        updateTable(currentDate);

        initialize_date_range_picker($('#date-daterangepicker'), currentDate, function(date){
            updateTable(date);
        });
    });
	
	function printSchedule($table){
		$table.printThis({
			'removeInline': true,
			'removeInlineSelector': '.btn-group',
			'importStyle': true,
			'importCSS': true,
			'loadCSS' : [
				'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css',
				'http://tk.kabinet-vl.ru/css/main.css',
				'https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css'
			]
		});
	}
</script>
