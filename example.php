<?php

require_once 'vendor/autoload.php';

use PaymentLibrary\PaymentFactory;

// Chargement de la configuration
$config = require 'config.php';

// Créez une instance de StripePayment via PaymentFactory avec les arguments requis
$stripePayment = PaymentFactory::createPaymentMethod(
    'stripe',
    $config['stripe']['secret_key'],
    $config['stripe']['test_card_token']
);

// Utilisation de $stripePayment pour effectuer une transaction
$paymentIntent = $stripePayment->createPaymentIntent(1000, 'usd', 'Example payment');

// Affichage ou traitement du résultat de la transaction
echo "Payment Intent ID: " . $paymentIntent->id . "\n";
echo "Payment Status: " . $paymentIntent->status . "\n";
