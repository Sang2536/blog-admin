<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IconComp extends Component
{
    public string $name;
    public string $set;        // Bộ icon (svg/fa/hero)
    public string $class;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $set = 'svg',
        string $class = ''
    )
    {
        $this->name = $name;
        $this->set = $set;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.icon-comp');
    }
}
