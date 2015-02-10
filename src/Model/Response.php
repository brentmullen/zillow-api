<?php

namespace ZillowApi\Model;

/**
 * @author Brent Mullen <brent@quizzle.com>
 */
class Response
{
    /** @var string */
    private $method;

    /** @var int */
    private $code;

    /** @var string */
    private $message;

    /** @var array */
    private $data;

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getCode() === 0;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}