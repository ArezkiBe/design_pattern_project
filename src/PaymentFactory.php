<?php

namespace PaymentLibrary;

class PaymentFactory {
    public static function createPaymentProcessor($method, $config) {
        switch ($method) {
            case 'stripe':
                if (!$config) {
                    throw new \InvalidArgumentException("Missing config for Stripe.");
                }
                return new StripePaymentProcessor($config['secret_key'], $config['test_card_token']);
                break;
            // Ajouter d'autres méthodes de paiement ici
            default:
                throw new \Exception("Unknown payment type: " . $method);
        }
    }
}