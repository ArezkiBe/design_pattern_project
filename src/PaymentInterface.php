<?php

namespace PaymentLibrary;

interface PaymentInterface {
    public function initialize(array $config);
    public function createTransaction($amount, $currency, $description);
    public function executeTransaction($transactionId);
    public function cancelTransaction($transactionId);
}
