<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropdownComp extends Component
{
    public string $buttonTitle;
    public bool $buttonIcon;
    public string $type; // menu | form | docs | custom
    public array $items; // chỉ dùng khi type = 'menu'
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $buttonTitle = 'Dropdown Menu',
        bool $buttonIcon = true,
        string $type = 'menu',
        array $items = []
    )
    {
        $this->buttonTitle = $buttonTitle;
        $this->buttonIcon = $buttonIcon;
        $this->type = $type;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown-comp');
    }
}
