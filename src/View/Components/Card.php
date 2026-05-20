<?php

namespace Greeate\Greeate\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $subtitle = null
    ) {}

    public function render()
    {
        return view('greeate::components.card');
    }
}
