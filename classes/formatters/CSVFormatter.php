<?php

require_once('classes/formatters/TableFormatter.php');

class CSVFormatter extends TableFormatter {

    public function output() {

        header('Content-type: text/csv');

        header('Content-Disposition: attachment; filename="export.csv";');

        if ( !$this->data->count() ) {
            return;
        }

        $csv = array_merge($this->getHeaders($this->data), $this->getRows($this->data));

        return implode("\n", $csv);
    }

    protected function getHeaders($data) {

        $headers = $this->formatHeaders($data);

        return [$headers->join(',')];
    }

    protected function getRows($data) {

        $rows = [];

        foreach ($data as $dataRow) {
            $rows[] = implode(',', array_values($dataRow));
        }

        return $rows;
    }
}