<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadcrumbComp extends Component
{
    public iterable|string $breadcrumbs;
    public array $routeAction;
    public ?string $current;
    public iterable|string $separate;
    /**
     * Create a new component instance.
     */
    public function __construct(
        iterable|string $breadcrumbs,
        array $routeAction,
        ?string $current = '',
        iterable|string $separate = '/'
    )
    {
        $this->breadcrumbs = $breadcrumbs;
        $this->routeAction = $routeAction;
        $this->current = $current;
        $this->separate = $separate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb-comp');
    }
}
