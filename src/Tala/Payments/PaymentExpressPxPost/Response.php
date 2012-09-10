<?php

/*
 * This file is part of the Tala Payments package.
 *
 * (c) Adrian Macneil <adrian.macneil@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tala\Payments\PaymentExpressPxPost;

use Tala\Payments\PaymentExpressPxPost\Exception;
use Tala\Payments\Exception\InvalidResponseException;

/**
 * DPS PaymentExpress PxPost Response
 */
class Response extends \Tala\Payments\Response
{
    public function __construct($data)
    {
        try {
            $this->data = new \SimpleXMLElement($data);
        } catch (\Exception $e) {
            throw new InvalidResponseException($e->getMessage(), $e->getCode(), $e);
        }

        if ((int)$this->data->Success == 1) {
            $this->message = (string)$this->data->HelpText;
            $this->gatewayReference = (string)$this->data->DpsTxnRef;
        } else {
            throw new Exception((string)$this->data->HelpText);
        }
    }
}
