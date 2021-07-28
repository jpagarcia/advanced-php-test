<?php

require_once('classes/Exporter.php');

class PlayersExporter extends Exporter {

    public function export(): Exporter
    {
        $where = $this->rosterFilter();

        $sql = "SELECT roster.*
                FROM roster
                WHERE $where";

        $_unsetIds = function ($item, $key) {
            unset($item['id']);
            return $item;
        };

        $this->data = collect(query($sql))->map($_unsetIds);

        return $this;
    }
}