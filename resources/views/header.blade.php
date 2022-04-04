@extends('layouts.main')

@section('body')
	<header id='main-nav-bar' class='navbar navbar-expand navbar-light flex-column flex-md-row bd-navbar'>
		<a class='navbar-brand mr-0 mr-md-4 align-middle' href="#">
            <img src="../images/navbar-brand.png" alt="navbar-brand">
        </a>
		<div class='navbar-nav-scroll mt-2 mb-2'>
			<ul class='navbar-nav bd-navbar-nav nav-pills flex-row'>
				@foreach ($menus as $menu)
					<li class='nav-item'>
						<a class='nav-link{{ strpos(URL::current(), $menu["route"]) === 0 ? " active" : "" }}' href='{{ $menu["route"] }}'>{{ $menu["title"] }}</a>
					</li>
				@endforeach
			</ul>
		</div>
		<ul class='navbar-nav ml-md-auto mt-2 mb-2'>
			<li>
				<div class='dropdown float-right'>
					<button class='btn dropdown-toggle btn-custom' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
						<span class='oi oi-person' data-glyph='icon-name' title='Account' aria-hidden='true'></span>
						Аккаунт
					</button>
					<div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton'>
						<a class='dropdown-item' href='#' onclick="showUpdateUserModalForCurrentUser();">
							<span class='oi oi-cog' data-glyph='icon-name' title='Person' aria-hidden='true'></span>
							Настройки
						</a>

						<a class='dropdown-item' href='#' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<span class='oi oi-account-logout' data-glyph='icon-name' title='Person' aria-hidden='true'></span>
							Выйти
						</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
					</div>
				</div>
			</li>
		</ul>
	</header>
	<div id='page-content' class='container-fluid' style="position:relative;">
        @yield('page_content')
    </div>
@endsection
