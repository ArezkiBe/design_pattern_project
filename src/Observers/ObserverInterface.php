<?php

namespace PaymentLibrary\Observers;

interface ObserverInterface {
    public function update($transactionStatus);
}
