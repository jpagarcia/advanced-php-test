<?php

require_once('classes/Formatter.php');

abstract class TableFormatter extends Formatter {

    abstract protected function getHeaders($data);
    abstract protected function getRows($data);

    public function formatHeaders($data) {

        $headers = collect($data->get(0))->keys();

        $_upperCaseFirstLetter = function ($word, $key) {
            return ucfirst($word);
        };

        $_replaceUnderscores = function ($item, $key) use ($_upperCaseFirstLetter) {

            return collect(explode('_', $item))
                ->map($_upperCaseFirstLetter)
                ->join(' ');
        };

        return $headers->map($_replaceUnderscores);
    }

}