<?php

declare(strict_types=1);

// require_once __DIR__ . '/../vendor/autoload.php';

use Nimbbl\Api\NimbblApi;
use PHPUnit\Framework\TestCase;
use Nimbbl\Api\NimbblOrder;

final class TransactionTest extends TestCase
{
    public function testRetrieveOne(): void
    {
        $api = new NimbblApi('access_key_1MwvMkKkweorz0ry', 'access_secret_81x7ByYkRpB4g05N');

        $transactionId = 'order_aKQvPpdLZbmMkv9z-20210707111956';
        $transaction = $api->transaction->retrieveOne($transactionId);
        $this->assertEmpty($transaction->error);
        $this->assertEquals($transaction->transaction_id, $transactionId);
    }

    public function testRetrieveMany(): void
    {
        $api = new NimbblApi('access_key_1MwvMkKkweorz0ry', 'access_secret_81x7ByYkRpB4g05N');
        $manyTransactions = $api->order->retrieveMany();

        $this->assertEquals(sizeof($manyTransactions['items']), 20);
    }

    public function testTransactionEnquiry(): void
    {
        $api = new NimbblApi('access_key_1MwvMkKkweorz0ry', 'access_secret_81x7ByYkRpB4g05N');
        $order_data = array(
            'order_id' => 'order_aKQvPpdLZbmMkv9z',
            'payment_mode' => 'PayTM',
            'transaction_id' => 'order_aKQvPpdLZbmMkv9z-20210707111956'
        );
        $transaction = $api->transaction->transactionEnquiry($order_data);
        $this->assertEmpty($transaction->error);
        $this->assertEquals($transaction->nimbbl_transaction_id, $order_data['transaction_id']);
    }

    public function testRetrieveTransactionByOrderId(): void
    {
        $api = new NimbblApi('access_key_1MwvMkKkweorz0ry', 'access_secret_81x7ByYkRpB4g05N');

        $orderId = 'order_amG06aE46A5a53Nj';
        $transactions = $api->transaction->retrieveTransactionByOrderId($orderId);
        
        $this->assertLessThan(sizeof($transactions['items']),0);
    }

}
