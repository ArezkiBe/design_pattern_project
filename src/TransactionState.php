<?php

namespace PaymentLibrary;

interface TransactionState {
    public function applyState(Transaction $transaction);
    public function getState();
}
