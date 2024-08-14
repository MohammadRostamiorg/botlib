<?php

namespace App;

use Core\Bot;

class Controller
{
    public $input;
    public $chatId;
    public $UserMessage;
    public $messageId;
    public function __construct($input)
    {
       $this->input = $input;
        $this->chatId = $input['message']['chat']['id'];
        $this->messageId = $input['message']['message_id'];
        $this->UserMessage = $input['message']['text'];

        Bot::sendMsg($this->chatId,'hi');
    }
}