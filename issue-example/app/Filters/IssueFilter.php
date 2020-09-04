<?php

namespace App\Filters;

class IssueFilter extends BaseFilter{
    private $type = 'Order';
    private $resolved = false;
    private $status;

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getResolved() {
        return $this->resolved;
    }

    public function setResolved($resolved) {
        $this->resolved = $resolved;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}
