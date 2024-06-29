<?php

namespace PaymentLibrary;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class StripePayment implements PaymentInterface {
    private $apiKey;
    private $testCardToken;

    public function __construct($apiKey, $testCardToken)
    {
        $this->apiKey = $apiKey;
        $this->testCardToken = $testCardToken;
        Stripe::setApiKey($this->apiKey);
    }

    public function initialize(array $config) {
        Stripe::setApiKey($config['secret_key']);
    }

    public function createTransaction($amount, $currency, $description) {
        try {
            // Step 1: Create a PaymentIntent using a test card token
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'confirm' => true,  // Set confirm to true to require user confirmation
                'payment_method_types' => ['card'],
                'payment_method' => $this->testCardToken, // Use the test card token here
                'return_url' => 'http://localhost:4242/complete', // Update with your return URL
            ]);

            // Step 2: Confirm the PaymentIntent only if not already confirmed
            if ($paymentIntent->status !== 'succeeded') {
                $paymentIntent->confirm();
            }

            return $paymentIntent;
        } catch (ApiErrorException $e) {
            // Handle error
            throw new \Exception("Error creating PaymentIntent: " . $e->getMessage());
        }
    }

    public function executeTransaction($paymentIntentId) {
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
        if ($paymentIntent->status !== 'succeeded') {
            $paymentIntent->confirm();
        }

        return $paymentIntent->status; // Valeur possible: 'requires_payment_method', 'requires_confirmation', 'requires_action', 'processing', 'requires_capture', 'canceled', 'succeeded'
    }

    public function cancelTransaction($paymentIntentId) {
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
        if ($paymentIntent->status !== 'canceled') {
            $paymentIntent->cancel();
        }
        
        
        return $paymentIntent->status; // Valeur possible: 'requires_payment_method', 'requires_confirmation', 'requires_action', 'processing', 'requires_capture', 'canceled', 'succeeded'
    }
}
