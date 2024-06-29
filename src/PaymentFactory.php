<?php

namespace PaymentLibrary;

class PaymentFactory {
    public static function create($method, $apiKey, $testCardToken = null) {
        switch ($method) {
            case 'stripe':
                if (!$apiKey || !$testCardToken) {
                    throw new \InvalidArgumentException("Missing API Key or Test Card Token for Stripe.");
                }
                return new StripePayment($apiKey, $testCardToken);
            default:
                throw new \Exception("Unknown payment type: " . $method);
        }
    }
}
