<?php

namespace App\Http\Resources;

use Inertia\Inertia;

class BaseViewResource {

    public function __construct(protected string $view, protected array $data = []){}

    public function __invoke()
    {
        return $this->toView();
    }

    public function toView()
    {
        return Inertia::render($this->view, $this->data);
    }
}