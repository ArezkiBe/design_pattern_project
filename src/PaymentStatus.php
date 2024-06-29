<?php

namespace PaymentLibrary;

interface TransactionState {
    public function proceed(Transaction $transaction);
}

class PendingState implements TransactionState {
    public function proceed(Transaction $transaction) {
        // Logique pour passer de l'état pending à un autre état
        $transaction->setState(new SuccessState());
    }
}

class SuccessState implements TransactionState {
    public function proceed(Transaction $transaction) {
        // Logique pour l'état success
    }
}
