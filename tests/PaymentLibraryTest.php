<?php

use PHPUnit\Framework\TestCase;
use PaymentLibrary\PaymentFactory;

class PaymentLibraryTest extends TestCase
{
    protected $stripeConfig;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stripeConfig = require __DIR__ . '/../config.php';
    }

    public function testStripePayment()
    {
        $stripePayment = PaymentFactory::create(
            'stripe',
            $this->stripeConfig['stripe']['secret_key'],
            $this->stripeConfig['stripe']['test_card_token']
        );

        $paymentIntent = $stripePayment->createTransaction(1000, 'usd', 'Test payment');
        echo $paymentIntent->status;
        // Assurez-vous que le PaymentIntent est bien confirmé
        $this->assertEquals('succeeded', $paymentIntent->status);
    }
}
