<?php

namespace PaymentLibrary;

class PaymentContext {
    private $paymentProcessor;

    public function __construct(PaymentInterface $paymentProcessor) {
        $this->paymentProcessor = $paymentProcessor;
    }

    public function initialize(array $config) {
        $this->paymentProcessor->initialize($config);
    }

    public function createTransaction($amount, $currency, $description) {
        return $this->paymentProcessor->createTransaction($amount, $currency, $description);
    }

    public function executeTransaction($paymentIntentId) {
        return $this->paymentProcessor->executeTransaction($paymentIntentId);
    }

    public function cancelTransaction($paymentIntentId) {
        return $this->paymentProcessor->cancelTransaction($paymentIntentId);
    }
}
