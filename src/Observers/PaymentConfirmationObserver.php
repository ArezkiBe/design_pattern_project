<?php

namespace PaymentLibrary\Observers;

use SplObserver;
use SplSubject;

class PaymentConfirmationObserver implements SplObserver
{
    public function update(SplSubject $subject): void
    {
        // Logique de mise à jour lorsqu'un paiement est confirmé
        echo "PaymentConfirmationObserver: OK\n";
    }
}
