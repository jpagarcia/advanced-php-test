<?php

use LSS\Array2Xml;

require_once('classes/Formatter.php');

class XMLFormatter extends Formatter {

    public function output() {

        header('Content-type: text/xml');

        $xml = Array2XML::createXML('data', [
            'entry' => $this->parseEntryData($this->data->all()),
        ]);

        return $xml->saveXML();
    }

    private function parseEntryData($data) {

        $xmlData = [];

        foreach ($data as $row) {

            $xmlRow = [];

            foreach ($row as $key => $value) {

                $this->fixKeyNumbers($key);

                $xmlRow[$key] = $value;
            }

            $xmlData[] = $xmlRow;
        }

        return $xmlData;
    }

    private function fixKeyNumbers(&$key) {

        $keyMap = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

        $key = preg_replace_callback('(\d)', function($matches) use ($keyMap) {
            return $keyMap[$matches[0]] . '_';
        }, $key);
    }
}