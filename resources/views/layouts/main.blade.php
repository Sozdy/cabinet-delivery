<!DOCTYPE html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>
<head>
	<meta charset='utf-8'>

    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

	@section('stylesheets')
		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'>
        <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css">
        <link rel='stylesheet' href='{{ URL::asset("icon/open-iconic/font/css/open-iconic-bootstrap.css") }}'>
		<link rel='stylesheet' href='{{ URL::asset("css/main.css") }}?v=13414'>
		<link rel='stylesheet' href='{{ URL::asset("css/app.css") }}?v=13414'>
	@show

	<title>{{ config('app.name', 'Cabinet Delivery') }} | @yield('title')</title>
</head>
<body>
	@yield('body')

	@section('scripts')
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
		<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
		<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js'></script>

		<script src={{URL::asset('js/main.js')}}></script>
        <script>
            $.ajaxSetup(
                {
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                });
        </script>


	@show

    @include('users.update_modal')
    @include('users.javascript')
</body>
</html>
