<?php
namespace rutgerkirkels\domoticzphp;


class Actor extends Device
{

    public function switch($state) {
        try {
            if (ucfirst($state) != 'On' && ucfirst($state) != 'Off') {
                throw new \Exception('Switch state can be On or Off, ' . $state . ' given.', E_USER_WARNING);
            }

            $connector = Connector::getInstance();

            $connector->setUrlVars([
                'type' => 'command',
                'param' => 'switchlight',
                'idx' => $this->idx,
                'switchcmd' => $state
            ]);

            $connector->execute();
            $response = $connector->getResponse();
            return true;

        } catch (\Exception $e) {
            $this->errorHandler($e->getMessage(), $e->getCode());
            return false;
        }


    }
}