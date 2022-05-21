<?php

namespace Model;

class Model
{
    protected $gateway;
    public function __construct(\DataGateway\TableDataGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function findUserByUserName($username)
    {
        $return = $this->gateway->findUserByUsername($username);
        if (!is_null($return)) {
            return $return;
        }
    }
    public function findUserByEmail($email)
    {
        $return = $this->gateway->findUserByEmail($email);
        if (!is_null($return)) {
            return $return;
        }
    }
}
