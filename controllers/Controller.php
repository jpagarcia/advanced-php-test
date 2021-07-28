<?php
use Illuminate\Support;  // https://laravel.com/docs/5.8/collections - provides the collect methods & collections class

abstract class Controller {

    protected $request, $args;

    public function __construct(Request $request) {

        $this->request = $request;
        $this->args    = $request->getArgs();

        $this->parseArgs();
        $this->validateArgs();
    }

    abstract protected function validateArgs();
    abstract protected function parseArgs();
}