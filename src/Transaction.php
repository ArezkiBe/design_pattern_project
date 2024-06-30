<?php

namespace PaymentLibrary;

class Transaction {
    private $status;

    public function __construct() {
        $this->status = PaymentStatus::PENDING;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}
