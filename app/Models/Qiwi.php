<?php

namespace ShellaiDev\Models;

use Output;
use ShellaiDev\Config;
use ShellaiDev\Interfaces\Models\IPaymentType;
use ShellaiDev\Models\Parent\Model;

class Qiwi extends Model implements IPaymentType {

    public function redirect(){
        return Output::genAnswer("success", "https://oplata.qiwi.com/create?publicKey=".Config::QIWI['public_key']."&amount={$this->params['sum']}&billId={$this->params['id']}&successUrl=".Config::QIWI['success_url']);
    }

    public function process(){
        if( !isset($_SERVER['HTTP_X_API_SIGNATURE_SHA256']) ) return Output::genAnswer('error', 'Не передана цифровая подпись!');

        $givenSign = $_SERVER['HTTP_X_API_SIGNATURE_SHA256'];
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $implodedParams = $data['bill']['amount']['currency'] . '|' . $data['bill']['amount']['value'] . '|' . $data['bill']['billId'] . '|' . $data['bill']['siteId'] . '|' . $data['bill']['status']['value'];

        $sign = hash_hmac('sha256', $implodedParams, Config::QIWI['secret_key']);

        // OK :)
        if( strcmp($givenSign, $sign) === 0 && strcmp($data['bill']['status']['value'], 'PAID') === 0 ) return $data['bill']['billId'];

        // Bad sign or bill is not payed 
        return Output::genAnswer('error', 'Платёж не валидный. Обратитесь к администрации!');
    }

}

?>