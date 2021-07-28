<?php

abstract class Formatter {

    protected $data;

    abstract public function output();

    public function __construct($data) {
        $this->data = $data;
    }
}