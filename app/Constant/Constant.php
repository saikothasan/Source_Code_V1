<?php

namespace App\Constant;

abstract class Constant
{
    public const PAYMENT_TYPE_ACCOUNT = [
        'Bank' => '2507370100008113',
        'COD' => '1547204260299001',
        'Card' => '17811011001',
    ];

    public const DELIVERY_STATUS = [
        0 => 'Pending',
        1 => 'Delivered',
        2 => 'Returned',
        3 => 'Cancelled',
    ];

    public const CASH_TYPE = [
        0 => 'Cash In',
        1 => 'Payment',
        2 => 'Transfer',
        3 => 'Sale',
        4 => 'Sale Return',
        5 => 'Payment Method',
        6 => 'Cost',
        7 => 'Bank to Cash'
    ];

    public const CASH_STATUS = [
        0 => 'Pending',
        1 => 'Received',
        2 => 'Transfer',
        3 => 'Received',
        4 => 'Reject',
        5 => 'Bank Transfer'
    ];
    public const BANK_STATUS = [
        0 => 'Pending',
        1 => 'Receive',
        2 => 'Reject',
        3 => 'D. Returned',
    ];

    public const MONEY_TRANSFER_STATUS = [
        0 => 'Pending',
        1 => 'Receive',
        2 => 'Reject',
    ];

    public const SALE_RETURN_TYPE = [
        1 => 'Return',
        2 => 'Exchange Return',
    ];

    public const PURCHASES_RETURN_STATUS = [
        0 => 'Pending',
        1 => 'Received',
        2 => 'Reject',
    ];

    public const SALE_STATUS_LABEL = [
        'Sale' => '<span class="label label-primary">Sale</span>',
        'Pending' => '<span class="label label-warning">Pending</span>',
        'Returned' => '<span class="label label-danger">D. Returned</span>',
        'Sale Returned' => '<span class="label label-black" style="background: black;">Sale Returned</span>',
        'Delivered' => '<span class="label label-success">Delivered</span>',
        'Cancelled' => '<span class="label label-danger">Cancelled</span>',
    ];

    public const REPORT_TYPE_NAME = [
        1 => 'Sales Report',
        2 => 'Stock Report',
        3 => 'C.R Master Report',
        4 => 'Product Report',
    ];


    public const OFFER_TYPE = [
        1 => 'FLAT DISCOUNT',
        2 => 'COUPON',
        3 => 'BUY TO GET',
        4 => 'UP TO',
        5 => 'COMBO',
    ];

    public const OFFER_STATUS = [
        1 => '<span class="label label-warning">Inactive</span>',
        2 => '<span class="label label-success">Active</span>',
        3 => '<span class="label label-info">Accepted</span>',
        4 => '<span class="label label-danger">Cancelled</span>',
    ];

}
