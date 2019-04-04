<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;

/**
 * Realex Purchase Request
 */
abstract class RemoteAbstractRequest extends AbstractRequest
{
    protected $cardBrandMap = array(
        'mastercard' => 'mc',
        'diners_club' => 'diners'
    );

    /**
     * Override some of the default Omnipay card brand names
     *
     * @return mixed
     */
    protected function getCardBrand()
    {
        $brand = $this->getCard()->getBrand();

        if (isset($this->cardBrandMap[$brand])) {
            $brand = $this->cardBrandMap[$brand];
        }

        return strtoupper($brand);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    public function sendData($data)
    {
        $response = $this->httpClient->request('POST', $this->getEndpoint(), [], $data);

        return $this->createResponse($response->getBody()->getContents());
    }

    abstract public function getEndpoint();

    abstract protected function createResponse($data);
}
