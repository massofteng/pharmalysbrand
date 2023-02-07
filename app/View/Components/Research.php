<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Research extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $stories;

    public function __construct($stories)
    {
        $this->stories = $stories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $stories = $this->stories;
        return view('components.research', compact('stories'));
    }
}
