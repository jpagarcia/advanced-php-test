<?php

use Tightenco\Collect\Support\Collection;

class Request {

    private $args;

    public function __construct(Array $request) {
        $this->args = collect($request);
    }

    public function getArgs(): Collection {
        return $this->args;
    }
}