<?php

namespace PaymentLibrary\Observers;

use SplSubject;

interface ObserverInterface
{
    public function update(SplSubject $subject);
}
