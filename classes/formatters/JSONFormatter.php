<?php

require_once('classes/Formatter.php');

class JSONFormatter extends Formatter {

    public function output() {

        header('Content-type: application/json');

        return json_encode($this->data->all());
    }
}