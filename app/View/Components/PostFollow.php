<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostFollow extends Component
{
    /**
     * Create a new component instance.
     */

    public  $user;
    public $choice;

    public function __construct($user, $choice = null)
    {
        $this->user = $user;
        $this->choice = $choice;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-follow');
    }
}
