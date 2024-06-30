<?php

namespace PaymentLibrary;

use SplObserver;
use SplSubject;
use SplObjectStorage;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentProcessor implements PaymentInterface, SplSubject
{
    private $secretKey;
    private $testCardToken;
    private $lastPaymentIntentId;
    private $observers;

    public function __construct($secretKey, $testCardToken)
    {
        $this->secretKey = $secretKey;
        $this->testCardToken = $testCardToken;
        $this->observers = new SplObjectStorage();
    }

    public function createTransaction($amount, $currency, $description)
    {
        Stripe::setApiKey($this->secretKey);

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description,
                'payment_method' => $this->testCardToken,
                'confirm' => false,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ]
            ]);

            $this->lastPaymentIntentId = $paymentIntent->id;
            $this->notify();
            return $paymentIntent;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors du paiement Stripe : " . $e->getMessage());
        }
    }

    public function cancelTransaction($transactionId)
    {
        Stripe::setApiKey($this->secretKey);

        try {
            $paymentIntent = PaymentIntent::retrieve($transactionId);
            $canceledIntent = $paymentIntent->cancel();
            return $canceledIntent->status;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'annulation du paiement Stripe : " . $e->getMessage());
        }
    }

    public function confirmPayment($transactionId)
    {
        Stripe::setApiKey($this->secretKey);

        try {
            $paymentIntent = PaymentIntent::retrieve($transactionId);
            $confirmedIntent = $paymentIntent->confirm();
            return $confirmedIntent->status;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la confirmation du paiement Stripe : " . $e->getMessage());
        }
    }

    public function executeTransaction($amount, $currency, $description)
    {
        $paymentIntent = $this->createTransaction($amount, $currency, $description);
        $this->confirmPayment($paymentIntent->id);
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function getLastPaymentIntentId()
    {
        return $this->lastPaymentIntentId;
    }
}
