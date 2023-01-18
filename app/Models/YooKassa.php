<?php

namespace ShellaiDev\Models;

use Output;
use ShellaiDev\Config;
use ShellaiDev\Interfaces\Models\IPaymentType;
use ShellaiDev\Models\Parent\Model;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;

class YooKassa extends Model implements IPaymentType {

    private $client;

    public function __construct(){
        $this->client = new \YooKassa\Client();
        $this->client->setAuth(Config::YOOKASSA['id'], Config::YOOKASSA['secret_key']);
    }

    public function redirect(){

        $confirmationUrl = '';

        if( isset($this->params['is_donate']) && $this->params['is_donate'] == 1 ) {
            $description = 'Пожертвование';
        } else {
            $description = "Покупка товара: " . Config::$configs['items'][$this->params['item_id']]['name'];
        }

        try {
            $response = $this->client->createPayment(
                [
                    'amount' => [
                        'value' => "{$this->params['sum']}",
                        'currency' => 'RUB',
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'locale' => 'ru_RU',
                        'return_url' => Config::YOOKASSA['success_url'],
                    ],
                    'capture' => true,
                    'description' => $description,
                    'metadata' => [
                        'order_id' => "{$this->params['id']}"
                    ],
                ],
                $this->params['id']
            );

            $confirmationUrl = $response->getConfirmation()->getConfirmationUrl();
        } catch (\Exception $e) {
            return Output::genAnswer('error', $e->getMessage() ); 
        }

        return Output::genAnswer('success', $confirmationUrl);
    }

    public function process(){
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        //file_put_contents(APP_DIR . '/test.txt', print_r($requestBody, true).PHP_EOL , FILE_APPEND | LOCK_EX);

        try {
            $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
              ? new NotificationSucceeded($requestBody)
              : new NotificationWaitingForCapture($requestBody);
        } catch (\Exception $e) {
            file_put_contents(APP_DIR . '/test.txt', print_r($e->getMessage(), true).PHP_EOL , FILE_APPEND | LOCK_EX);
            return Output::genAnswer('error', $e->getMessage());
        }

        $payment = $notification->getObject();
        //file_put_contents(APP_DIR . '/test.txt', print_r($payment, true).PHP_EOL , FILE_APPEND | LOCK_EX);

        if($payment == null) {
            return Output::genAnswer('error', 'Не передан идентификатор платежа!');
        }

        switch($payment->status){
            case 'succeeded':
                return $payment->metadata->order_id;
                break;
            case 'waiting_for_capture':

                try {
                    $this->client->capturePayment(
                        [
                            'amount' => [
                                'value' => $payment->amount->value,
                                'currency' => $payment->amount->currency,
                            ],
                        ],
                        $payment->id,
                        uniqid('', true)
                    );
    
                    return $payment->metadata->order_id;
                } catch(\Exception $ex){
                    file_put_contents(APP_DIR . '/test.txt', $ex->getMessage().PHP_EOL , FILE_APPEND | LOCK_EX);
                    return Output::genAnswer('error', $ex->getMessage());
                }
                
                break;
            case 'canceled':
                return Output::genAnswer('error', 'Платёж был отменён!');
                break;
        }

        return Output::genAnswer('error', 'Платёж не валидный или ожидает оплаты со стороны клиента!');

    }

}

?>