<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonComp extends Component
{
    public ?string $href;
    public string $tag;
    public ?string $type;
    public ?string $id;
    public ?string $class;
    public ?string $iconLeft;
    public ?string $iconRight;
    public ?string $nameBtn;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $nameBtn = null,
        ?string $href = null,
        string $type = 'button',
        string $id = null,
        string $class = null,
        string $iconLeft = null,
        string $iconRight = null
    )
    {
        $this->nameBtn = $nameBtn;
        $this->href = $href;
        $this->tag = $href ? 'a' : 'button';
        $this->type = $this->tag === 'button' ? $type : null;
        $this->id = $id;
        $this->class = $class;
        $this->iconLeft = $iconLeft;
        $this->iconRight = $iconRight;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button-comp');
    }
}
