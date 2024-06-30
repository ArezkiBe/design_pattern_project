<?php

use PHPUnit\Framework\TestCase;
use PaymentLibrary\PaymentFactory;
use PaymentLibrary\StripePaymentProcessor;
use PaymentLibrary\Observers\PaymentConfirmationObserver;
use PaymentLibrary\Observers\BillingService;

class PaymentLibraryTest extends TestCase
{
    protected $paymentProcessor;

    protected function setUp(): void
    {
        // Initialisation du processeur de paiement Stripe via la fabrique de paiement
        $config = require 'config.php'; // Charger la configuration
        $stripeConfig = $config['stripe'];
        $this->paymentProcessor = PaymentFactory::createPaymentProcessor('stripe', $stripeConfig);
        
        // Création d'un observateur pour la confirmation du paiement
        $paymentConfirmationObserver = new PaymentConfirmationObserver();
        $billingService = new BillingService();

        // Attachement des observateurs au processeur de paiement
        $this->paymentProcessor->attach($paymentConfirmationObserver);
        $this->paymentProcessor->attach($billingService);
    }

    public function testStripePayment()
    {
        // Créer et exécuter une transaction avec Stripe
        $amount = 1000; // Montant en centimes (10.00 euros)
        $currency = 'eur';
        $description = 'Test de paiement avec Stripe';

        $this->paymentProcessor->createTransaction($amount, $currency, $description);

        // Vérifier l'ID de la dernière transaction
        $paymentIntentId = $this->paymentProcessor->getLastPaymentIntentId();
        $this->assertNotNull($paymentIntentId);

        // Confirmation du paiment

        //$this->paymentProcessor->confirmPayment($paymentIntentId);



        // Assurez-vous que le paiement a réussi (par exemple, vérifiez le statut ou l'ID du paiement)

        //$paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
        //$this->assertEquals('succeeded', $paymentIntent->status);


        // Annuler le PaymentIntent si le paiment n'est pas confirmer
        $cancelledIntentStatus = $this->paymentProcessor->cancelTransaction($paymentIntentId);

        // Assurez-vous que l'annulation a réussi
        $this->assertEquals('canceled', $cancelledIntentStatus);
    }
}
