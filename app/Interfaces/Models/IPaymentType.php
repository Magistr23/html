<?php

namespace ShellaiDev\Interfaces\Models;

interface IPaymentType {

    public function redirect(); // Redirect to payment url
    public function process();  // Process payment

}

?>