<?php
/**
 * Created by PhpStorm.
 * User: vortgo
 * Date: 26.09.18
 * Time: 14:27
 */

namespace PaymentBundle\Entity;


use PaymentBundle\Exceptions\ApiGetDataException;
use PaymentBundle\Exceptions\ApiGetErrorsDataException;

class ApiResponse
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function isFailed()
    {
        if (isset($this->data['error']) && !empty($this->data)) {
            return true;
        }

        return false;
    }

    public function getErrors()
    {
        if (!isset($this->data['error']['messages'])) {
            throw new ApiGetErrorsDataException('Only failed response has errors');
        }
        return $this->data['error']['messages'];
    }

    public function getErrorCode()
    {
        if (!isset($this->data['error']['code'])) {
            throw new ApiGetErrorsDataException('Only failed response has errors');
        }
        return $this->data['error']['code'];
    }

    public function getFormToken()
    {
        if (!isset($this->data['pay_form']['token'])) {
            throw new ApiGetDataException('Only success response from init-payment request has a form token ');
        }
        return $this->data['pay_form']['token'];
    }
}