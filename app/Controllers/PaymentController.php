<?php

namespace ShellaiDev\Controllers;

use Exception;
use Output;
use ShellaiDev\Config;
use ShellaiDev\Controllers\Parent\Controller;
use ShellaiDev\Interfaces\Models\IPaymentType;
use ShellaiDev\Models\Entity;
use ShellaiDev\Models\Payment;
use ShellaiDev\Models\Qiwi;
use ShellaiDev\Models\System\Base;
use ShellaiDev\Models\System\DB;
use ShellaiDev\Models\System\Request;
use ShellaiDev\Models\System\Security;
use ShellaiDev\Models\YooKassa;

class PaymentController extends Controller {

    private Payment $payment;
    private Entity $entity;
    private IPaymentType $iPayment;

    public function __construct(){
        parent::__construct();

        $this->entity = new Entity();
        $this->entity->setParams($this->request);

        $this->payment = new Payment($this->entity);
        $this->payment->setParams($this->request);
    }

    public function createPayment(){
        if( !Security::checkCsrfToken($this->request) ) Output::printJsonAnswer('error', 'Токен не соответствует. Повторите попытку!');

        if( !isset($this->request['item']) ) Output::printJsonAnswer('error', 'Не выбран товар для оплаты!');
        if( !$this->entity->isItemValid() ) Output::printJsonAnswer('error', 'Текущий предмет не доступен для покупки!');

        if( !isset($this->request['server']) ) Output::printJsonAnswer('error', 'Не выбран сервер для покупки!');
        if( !$this->entity->isServerSupported() ) Output::printJsonAnswer('error', 'Желаемый товар не продаётся на текущем сервере!');

        DB::initServer($this->request['server']);

        //$this->payment->appendParams('yookassa_uuid', uniqid('', true) );

        //Deny privilege's purchasing, if user has custom one
        if( !$this->entity->canBuyPrivilege() ) Output::printJsonAnswer('error', 'На текущий аккаунт нельзя приобрести привилегию!');

        $created = $this->payment->create();

        if($created === false) Output::printJsonAnswer('error', 'Не удалось создать платёж!');

        if( isset($created['status']) && strcmp($created['status'], 'error') === 0) Output::printJsonAnswer('error', $created['answer']);

        switch($this->request['payment_type']){
            case 'qiwi':
                $iPayment = new Qiwi();
                break;
            case 'yookassa':
                $iPayment = new YooKassa();
                break;
            default:
                $iPayment = new Qiwi();
                break;
        }

        $iPayment->setParams($created);
        $redirectURL = $iPayment->redirect();

        Output::printJsonAnswer($redirectURL['status'],  $redirectURL['answer']);
    }

    public function donate(){
        if( !Security::checkCsrfToken($this->request) ) Output::printJsonAnswer('error', 'Токен не соответствует. Повторите попытку!');
        
        $sum = intval($this->request['sum']);
        if( $sum <=0 ) Output::printJsonAnswer('error', 'Сумма должна быть больше 0!');

        switch($this->request['payment_type']){
            case 'qiwi':
                $iPayment = new Qiwi();
                break;
            case 'yookassa':
                $iPayment = new YooKassa();
                break;
            default:
                $iPayment = new Qiwi();
                break;
        }

        $created = $this->payment->createDonation();

        if($created === false) Output::printJsonAnswer('error', 'Не удалось создать платёж!');

        if( isset($created['status']) && strcmp($created['status'], 'error') === 0) Output::printJsonAnswer('error', $created['answer']);

        $iPayment->setParams($created);
        $redirectURL = $iPayment->redirect();

        Output::printJsonAnswer($redirectURL['status'],  $redirectURL['answer']);
    }

    public function processPayment(){
        if( !isset($this->request['payment_type']) ) Request::processAnswer('error', 'Не указан платёжный шлюз!');

        $paymentId = false;
        switch($this->request['payment_type']){
            case 'qiwi':
                $iPayment = new Qiwi();
                break;
            case 'yookassa':
                $iPayment = new YooKassa();
                break;
            default:
                $iPayment = new Qiwi();
                break;
        }

        $iPayment->setParams($this->request);
        $paymentId = $iPayment->process();

        if( !$paymentId ) Request::processAnswer('error', 'Не удалось обработать платёж со стороны платёжного шлюза!');
        if( isset($paymentId['status']) && strcmp($paymentId['status'], 'error') === 0 ) Request::processAnswer($paymentId['status'], $paymentId['answer']);

        $payment = $this->payment->getById($paymentId);

        if($payment === null) Request::processAnswer('error', 'Не удалось найти платёж!');
        if($payment->status != 0) Request::processAnswer('error', 'Платёж уже обработан!');

        $updated = $this->payment->updatePayment($payment, 1);

        if($payment->is_donate == 1) Request::processAnswer('success', 'Ваше пожертвование принято!');

        DB::initServer($payment->server_id);
        if( !$updated ) Request::processAnswer('error', 'Не удалось завершить платёж. Обратитесь к администрации!');

        $this->payment->appendParams('payment', $payment);

        $result = false;
        switch( Config::$configs['items'][$payment->item_id]['driver'] ) {
            case 'rcon':
                $result = $this->payment->processRCON();
                break;
            case 'database':
                $result = $this->payment->processDatabase();
                break;
        }

        if($result) {
            try {
                DB::initServerMysql($payment->server_id);
                $this->entity->setParams([
                    'login' => $payment->login,
                    'item_id' => $payment->item_id
                ]);
                $this->entity->saveCommands();
            } catch (Exception $ex){
                Request::processAnswer('error', $ex->getMessage());
            }
            
            Request::processAnswer('success', 'Вы успешно приобрели товар!');
        }

        Request::processAnswer('error', 'Ошибка при получении предмета. Обратитесь к администрации!');
    }

    public function checkPromo(){
        if( !Security::checkCsrfToken($this->request) ) \Output::printJsonAnswer('error', 'Токен не соответствует. Повторите попытку!');

        if( !isset($this->request['item']) ) \Output::printJsonAnswer('error', 'Не выбран товар для оплаты!');
        if( !$this->entity->isItemValid() ) \Output::printJsonAnswer('error', 'Текущий предмет не доступен для покупки!');

        $sale = $this->entity->calcPrice();

        \Output::printJsonAnswer('success', $sale);
    }

    public function checkPrice(){
        if( !Security::checkCsrfToken($this->request) ) \Output::printJsonAnswer('error', 'Токен не соответствует. Повторите попытку!');

        if( !isset($this->request['item']) ) \Output::printJsonAnswer('error', 'Не выбран товар для оплаты!');
        if( !$this->entity->isItemValid() ) \Output::printJsonAnswer('error', 'Текущий предмет не доступен для покупки!');

        if( !isset($this->request['server']) ) Output::printJsonAnswer('error', 'Не выбран сервер для покупки!');
        if( !$this->entity->isServerSupported() ) Output::printJsonAnswer('error', 'Желаемый товар не продаётся на текущем сервере!');

        DB::initServer($this->request['server']);

        $canSurcharge = false;

        $price = $this->entity->calcPrice();

        if( strpos(Config::$configs['items'][ $this->request['item'] ]['rule'], 'group') === false ){
            \Output::printJsonAnswer('success', ['price' => $price, 'can_surcharge' => $canSurcharge]);
        }

        $surcharge = $this->payment->calcSurcharge();

        if($surcharge == -1) return \Output::printJsonAnswer('error', 'Нельзя приобрести привилегию ниже рангом от Вашей текущей!');
        if( $this->payment->isSurchageAllowed() ) {
            $price = $surcharge;
            $canSurcharge = true;
        }

        \Output::printJsonAnswer('success', ['price' => $price, 'can_surcharge' => $canSurcharge]);
    }

}

?>