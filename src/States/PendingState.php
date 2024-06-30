<?php

namespace PaymentLibrary\States;

use PaymentLibrary\Transaction;
use PaymentLibrary\TransactionState;

class PendingState implements TransactionState {
    public function applyState(Transaction $transaction) {
        $transaction->setState(new ConfirmedState());
    }

    public function getState() {
        return 'pending';
    }
}
