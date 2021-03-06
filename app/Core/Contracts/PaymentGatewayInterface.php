<?php

namespace App\Core\Contracts;

use App\Core\Models\Cart;
use App\Core\Models\Orders;

interface PaymentGatewayInterface
{
    /**
     * Constructor.
     */
    public function __construct($id = '');

    /**
     * @param Cart $cart
     *
     * @return mixed
     */
    public function onCheckout($cart);

    /**
     * Called by shop to charge order's amount.
     *
     * @param Order $order Order.
     *
     * @return bool
     */
    public function onCharge($order);

    /**
     * Returns the transaction ID generated by the gateway.
     * i.e. PayPal's transaction ID.
     *
     * @return mixed
     */
    public function getTransactionId();

    /**
     * Returns a 1024 length string with extra detail of transaction.
     *
     * @return string
     */
    public function getTransactionDetail();

    /**
     * Returns token.
     *
     * @return string
     */
    public function getTransactionToken();

    /**
     * Called by shop when payment gateway calls callback url.
     * Success result.
     *
     * @param Orders $order Order.
     * @param mixed  $data  Request input from callback.
     */
    public function onCallbackSuccess($order, $data = null);

    /**
     * Called by shop when payment gateway calls callback url.
     * Failed result.
     *
     * @param Orders $order.
     * @param mixed  $data   Request input from callback.
     */
    public function onCallbackFail($order, $data = null);

    /**
     * Sets callback urls.
     *
     * @param Orders $order.
     */
    public function setCallbacks($order);

    /**
     * Returns transaction status code.
     *
     * @return string
     */
    public function getTransactionStatusCode();
}
