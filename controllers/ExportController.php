<?php

require_once('controllers/Controller.php');

require('classes/exporters/PlayerStatsExporter.php');
require('classes/exporters/PlayersExporter.php');

class ExportController extends Controller {

    private $type, $format;

    protected function parseArgs() {
        $this->type   = $this->args->pull('type');
        $this->format = $this->args->pull('format', 'html');
    }

    protected function validateArgs() {

        if ( is_null($this->type) ) {
            // todo: make into an exception
            exit('Please specify a type');
        }
    }

    public function output() {

        switch ($this->type)
        {
            case 'playerstats':
                $exporter = new PlayerStatsExporter($this->args, $this->format);
                break;

            case 'players':
                $exporter = new PlayersExporter($this->args, $this->format);
                break;
        }

        return $exporter->export()->output();
    }
}