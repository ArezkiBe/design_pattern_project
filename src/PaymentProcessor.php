<?php

namespace PaymentLibrary;

abstract class PaymentProcessor implements PaymentInterface
{
    protected $apiKey;
    
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    abstract public function createTransaction($amount, $currency, $description);

    abstract public function cancelTransaction($transactionId);
    
    abstract public function confirmPayment($transactionId);
}
