<?php

namespace PaymentLibrary\Observers;

use SplObserver;
use SplSubject;

class BillingService implements SplObserver
{
    public function update(SplSubject $subject): void
    {
        // Logique de mise à jour pour le service de facturation
        echo "BillingService: OK\n";
    }
}
