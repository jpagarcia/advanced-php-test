<?php

require_once('classes/Exporter.php');
require('classes/StatTotal.php');

class PlayerStatsExporter extends Exporter {

    public function export(): Exporter
    {
        $where = $this->rosterFilter();

        $sql = "SELECT roster.name, player_totals.*
                FROM player_totals
                    INNER JOIN roster ON (roster.id = player_totals.player_id)
                WHERE $where";

        $data = query($sql) ?: [];

        $this->calculateStatTotals($data);

        $this->data = collect($data);

        return $this;
    }

    private function calculateStatTotals(&$data) {

        foreach ($data as &$row) {

            unset($row['player_id']);

            $stat = new StatTotal($row);

            $row['total_points']    = $stat->totalPoints();
            $row['field_goals_pct'] = $stat->fieldGoalsPct();
            $row['3pt_pct']         = $stat->threePtPct();
            $row['2pt_pct']         = $stat->twoPtPct();
            $row['free_throws_pct'] = $stat->freeThrowsPct();
            $row['total_rebounds']  = $stat->totalRebounds();
        }
    }
}