<?php

namespace Greeate\Greeate\View\Components;

use Illuminate\View\Component;

class Datatable extends Component
{
    public function __construct(
        public $items,
        public array $columns = [],
        public bool $actions = true,
        public bool $bulkActions = false
    ) {}

    public function render()
    {
        return view('greeate::components.datatable');
    }
}
