<?php

require_once('classes/formatters/XMLFormatter.php');
require_once('classes/formatters/JSONFormatter.php');
require_once('classes/formatters/CSVFormatter.php');
require_once('classes/formatters/HTMLFormatter.php');

abstract class Exporter
{
    const SEARCH_ROSTER_MAPPING = [
        'playerId' => 'roster.id',
        'player'   => 'roster.name',
        'team'     => 'roster.team_code',
        'position' => 'roster.pos',
        'country'  => 'roster.nationality',
    ];

    protected $data, $queryParams, $format;

    public function __construct($queryParams, $format)
    {
        $this->queryParams = $queryParams;
        $this->format      = $format;
    }

    abstract public function export(): Exporter;

    public function output()
    {
        if ( empty($this->data) ) {
            exit("Error: No data found!");
        }

        switch ($this->format) {
            case 'xml':  $formatter = new XMLFormatter($this->data); break;
            case 'json': $formatter = new JSONFormatter($this->data); break;
            case 'csv':  $formatter = new CSVFormatter($this->data); break;
            default:     $formatter = new HTMLFormatter($this->data); break;
        }

        return $formatter->output();
    }

    protected function rosterFilter() {

        $filter = [];

        foreach(self::SEARCH_ROSTER_MAPPING as $param => $field) {

            if ( !$this->queryParams->has($param) ) continue;

            $filter[]  = "$field = '{$this->queryParams[$param]}'";
        }

        $filter = implode(' AND ', $filter);

        return $filter;
    }
}
