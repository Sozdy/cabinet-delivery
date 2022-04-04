@extends('header')

@section('title', 'График')

@section('stylesheets')
	@parent
	<link rel='stylesheet' href='https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css'>
	<link rel='stylesheet' href='{{ URL::asset("css/daterangepicker.css") }}'>
@endsection

@section('page_content')
	<div id='schedule_table_toolbar'>
        <div class="datepicker-container">
            <strong>График на </strong>
            <div class="datepicker" id="date-daterangepicker" style="cursor: pointer;"></div>
            <div id="datepicker-ico" class="datepicker-ico">

                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.4 7.65H5.1V9.35H3.4V7.65ZM3.4 11.05H5.1V12.75H3.4V11.05ZM6.8 7.65H8.5V9.35H6.8V7.65ZM6.8 11.05H8.5V12.75H6.8V11.05ZM10.2 7.65H11.9V9.35H10.2V7.65ZM10.2 11.05H11.9V12.75H10.2V11.05Z" fill="black"/>
                    <path d="M1.7 17H13.6C14.5376 17 15.3 16.2376 15.3 15.3V3.4C15.3 2.46245 14.5376 1.7 13.6 1.7H11.9V0H10.2V1.7H5.1V0H3.4V1.7H1.7C0.76245 1.7 0 2.46245 0 3.4V15.3C0 16.2376 0.76245 17 1.7 17ZM13.6 5.1L13.6009 15.3H1.7V5.1H13.6Z" fill="black"/>
                </svg>

            </div>
        </div>

	</div>
	<div class='row flex-xl-nowrap'>
		<main class='col py-md-3 bd-content'>
			<div class='table-responsive'>
				<table id='schedule-table' class='table'
					data-toggle='table'
					data-locale='ru-RU'
					data-toolbar='#schedule_table_toolbar'
					data-buttons='scheduleTableButtons'
					data-show-header='false'>
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
                            <th></th>
						</tr>
					</thead>
					<tbody id='schedule-table-body'>
{{--                        @include('schedule.table')--}}
					</tbody>
				</table>
            </div>
			<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
		</main>
	</div>
@endsection

@section('scripts')
	@parent
	@include('schedule.javascript')

    <script>
        $('#datepicker-ico').on('click', function (event) {
            $('#date-daterangepicker').trigger('click')
        })

        function scheduleTableButtons(){
            return {
                btnUpdate: {
                    icon: 'oi oi-loop-circular',
                    attributes: {
                        'id' : 'schedule_table_btn_update',
                        'aria-hidden': 'true',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'title': 'Обновить'
                    },
                    event: {
                        'click': function() {
                            getSchedule();
                        },
                        'mouseleave': function() {
                            $('#schedule_table_btn_update').tooltip('hide');
                        }
                    }
                },
				btnPrint: {
					icon: 'oi oi-print',
					attributes: {
						'id' : 'schedule_table_btn_print',
						'aria-hidden': 'true',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'title': 'Распечатать'
					},
					event: {
						'click': function() {
                            printSchedule($('#page-content'));
                        },
                        'mouseleave': function() {
                            $('#schedule_table_btn_print').tooltip('hide');
                        }
					}
				}
            }
        }
    </script>
@endsection
