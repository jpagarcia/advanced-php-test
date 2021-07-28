<?php

class StatTotal {

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function totalPoints() {
        return ($this->data['3pt'] * 3) + ($this->data['2pt'] * 2) + $this->data['free_throws'];
    }

    public function fieldGoalsPct() {
        return $this->computeAttempted('field_goals');
    }

    public function threePtPct() {
        return $this->computeAttempted('3pt');
    }

    public function twoPtPct() {
        return $this->computeAttempted('2pt');
    }

    public function freeThrowsPct() {
        return $this->computeAttempted('free_throws');
    }

    public function totalRebounds() {
        return $this->data['offensive_rebounds'] + $this->data['defensive_rebounds'];
    }

    private function computeAttempted($type) {
        return $this->data["{$type}_attempted"] ? (round($this->data[$type] / $this->data["{$type}_attempted"], 2) * 100) . '%' : 0;
    }
}