<?php

namespace PaymentLibrary\States;

use PaymentLibrary\Transaction;
use PaymentLibrary\TransactionState;

class ConfirmedState implements TransactionState {
    public function applyState(Transaction $transaction) {
        // Logique pour appliquer l'état confirmé
    }

    public function getState() {
        return 'confirmed';
    }
}
