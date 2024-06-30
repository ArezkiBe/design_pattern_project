<?php

namespace PaymentLibrary;

interface PaymentInterface
{
    public function createTransaction($amount, $currency, $description);
    public function cancelTransaction($transactionId);
    public function confirmPayment($transactionId);
}
