<?php

namespace App\Http\View\Composers;

use App\Models\Menu;
use App\Repositories\UserRepository;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;

class HeaderComposer
{
	/**
     * Menus to show.
     *
     * @var array
     */
	protected $menus;
	
    /**
     * Create a new header composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menus = [
			[
				'title' => 'Доставки',
				'route' => URL::route('delivery')
			],
			[
				'title' => 'Бригады',
				'route' => URL::route('brigades')
			],
			[
				'title' => 'График',
				'route' => URL::route('schedule')
			],
			[
				'title' => 'Менеджеры',
				'route' => URL::route('users')
			],
			[
				'title' => 'Действия',
				'route' => URL::route('actions')
			]
		];
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('menus', $this->menus);
    }
}