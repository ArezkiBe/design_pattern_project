<?php

namespace PaymentLibrary;

class PaymentContext {
    private $paymentStrategy;

    public function setPaymentStrategy(PaymentInterface $paymentStrategy) {
        $this->paymentStrategy = $paymentStrategy;
    }

    public function initialize(array $config) {
        $this->paymentStrategy->initialize($config);
    }

    public function createTransaction($amount, $currency, $description) {
        return $this->paymentStrategy->createTransaction($amount, $currency, $description);
    }

    public function executeTransaction($transactionId) {
        return $this->paymentStrategy->executeTransaction($transactionId);
    }

    public function cancelTransaction($transactionId) {
        return $this->paymentStrategy->cancelTransaction($transactionId);
    }
}
