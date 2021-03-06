<?php

//TODO refactor usage of static methods
require_once('php-amqplib/PhpAmqpLib/Channel/AbstractChannel.php');
require_once('php-amqplib/PhpAmqpLib/Helper/MiscHelper.php');

class AMQPException extends Exception
{
    public function __construct($reply_code, $reply_text, $method_sig)
    {
        parent::__construct($reply_text,$reply_code);

        $this->amqp_reply_code = $reply_code; // redundant, but kept for BC
        $this->amqp_reply_text = $reply_text; // redundant, but kept for BC
        $this->amqp_method_sig = $method_sig;

        $ms = MiscHelper::methodSig($method_sig);

        $mn = isset(AbstractChannel::$GLOBAL_METHOD_NAMES[$ms])
                ? AbstractChannel::$GLOBAL_METHOD_NAMES[$ms]
                : $mn = "";

        $this->args = array(
            $reply_code,
            $reply_text,
            $method_sig,
            $mn
        );
    }
}