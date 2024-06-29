<?php

namespace PaymentLibrary;

use PaymentLibrary\Observers\ObserverInterface;

abstract class TransactionSubject {
    private $observers = [];

    public function attach(ObserverInterface $observer) {
        $this->observers[] = $observer;
    }

    public function detach(ObserverInterface $observer) {
        if (($key = array_search($observer, $this->observers)) !== false) {
            unset($this->observers[$key]);
        }
    }

    protected function notify($transactionStatus) {
        foreach ($this->observers as $observer) {
            $observer->update($transactionStatus);
        }
    }
}

class Transaction extends TransactionSubject {
    private $status;

    public function setStatus($status) {
        $this->status = $status;
        $this->notify($status);
    }

    public function getStatus() {
        return $this->status;
    }
}
