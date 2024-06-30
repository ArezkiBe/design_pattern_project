<?php

require_once 'vendor/autoload.php'; // Charger l'autoload de Composer

use PaymentLibrary\PaymentFactory;

// Menu pour choisir le moyen de paiement
echo "Choisissez votre moyen de paiement :\n";
echo "1. Stripe\n";
echo "2. Paypal\n";
$choice = readline("Entrez votre choix (1 ou 2) : ");

// Déclaration de la variable pour le processeur de paiement
$paymentProcessor = null;
$config = require 'config.php'; // Charger la configuration

// Création du processeur de paiement avec la factory en fonction du choix
if ($choice == 1) {
    // Assurez-vous que $stripeConfig est correctement défini avant d'appeler la factory
    $stripeConfig = $config['stripe'];
    $paymentProcessor = PaymentFactory::createPaymentProcessor('stripe', $stripeConfig);
} elseif ($choice == 2) {
    //$paymentProcessor = PaymentFactory::createPaymentProcessor('paypal', $paypalConfig); // Si vous voulez ajouter d'autres moyens de paiement
    die("Il n'y a pas d'autre moyen de paiement que stripe. Le programme se termine.\n");
} else {
    die("Choix invalide. Le programme se termine.\n");
}

// Saisie du montant, de la devise et de la description
$amount = (float)readline("Entrez le montant (ex: 1000 pour 10.00 euros) : ");
$currency = readline("Entrez la devise (ex: EUR) : ");
$description = readline("Entrez la description : ");

echo "\nRécapitulatif du paiement :\n";
$amount2=$amount/100;
echo "Montant : $amount2 $currency\n";
echo "Description : $description\n";

// Création de la transaction
$paymentProcessor->createTransaction($amount, $currency, $description);
$paymentIntentId = $paymentProcessor->getLastPaymentIntentId();
$paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);


// Confirmation du paiement
$confirm = strtolower(readline("\nConfirmez-vous le paiement ? (oui/non) : "));
if ($confirm === 'oui' || $confirm === 'yes' || $confirm === 'o' || $confirm === 'O') {
    try {
        $Status = $paymentProcessor->confirmPayment($paymentIntentId);
        echo "Paiement confirmé avec succès. Statut : ".$Status."\n";
    } catch (\Exception $e) {
        echo "Erreur lors du paiement : " . $e->getMessage() . "\n";
    }
} else {
    $Status = $paymentProcessor->cancelTransaction($paymentIntentId);
    echo "Paiement annulé. Statut : ".$Status."\n";
}