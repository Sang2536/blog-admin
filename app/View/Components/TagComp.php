<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Str;

class TagComp extends Component
{
    public string $id;
    public string $color;
    public bool $deletable;
    public int|string|null $tagId;
    public string $tagName;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $tagName,
        int|string|null $tagId = null,
        bool $deletable = false,
    )
    {
        $this->tagName = $tagName;
        $this->tagId = $tagId;
        $this->deletable = $deletable;

        // Tạo ID slug từ tagId hoặc tagName
        $this->id = Str::slug($tagId ?: $tagName);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tag-comp');
    }
}
