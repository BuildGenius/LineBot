<?php

namespace App\Exceptions;

use Exception;


class Code_Exception extends \Exception
{
    private $_options;

    public function __construct($_Code = null, $_message = null,)
    {
        $this->_Code = $_Code;
        $this->_message = $_message;
    }

    public function Get_MessageError()
    {

        $MsgError = [
            "1000" => [
                'status' => 'Invalid Data',
            ],
            "2000" => [
                'status' => 'Invalid Condition',
            ],
            "9000" => [
                'status' => 'System Error',
            ],
        ];

        // $this->err_Code = (string)$this->_Code ?: '9000';
        // $this->err_status = $MsgError[(string)$this->_Code]['status'] ?? 'System Error';
        // $this->err_message = $this->_message ?: 'System Error';

        // return $this;

        return response()->json(array(
            'Code' => (string)$this->_Code ?: '9000',
            'status' => $MsgError[(string)$this->_Code]['status'] ?? 'System Error',
            'message' => $this->_message ?: 'System Error'
        ));

    }
}
