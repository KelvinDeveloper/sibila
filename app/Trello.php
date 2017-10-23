<?php

namespace App;

use Trello\Client;
use Trello\Manager;

class Trello
{
    private $Client;
    public $Manager;
    public $Member;
    public $Board;
    public $Card;

    private $Setup;

    public function  __construct()
    {
        $this->Setup = User::getSetup();

        $this->authenticate();
        $this->manager();
        $this->member();

        $this->Board = $this->Client->api('board');
        $this->Card = $this->Client->api('card');
    }

    private function authenticate()
    {
        $this->Client = new Client;
        $this->Client->authenticate($this->Setup->api_key, $this->Setup->token, Client::AUTH_URL_CLIENT_ID);
    }

    private function manager()
    {
        $this->Manager = new Manager($this->Client);
    }

    private function member()
    {
        $this->Member = $this->Client->api('member');
    }

    /**
     * Return all boards
     *
     * @return array
     * */
    public function getBoards()
    {
        return $this->Member->boards()->all($this->Setup->username);
    }

    /**
     * Return details card
     *
     * @param $id int
     *
     * @return array
     * */
    public function getCard($id)
    {
        return $this->Manager->getCard($id);
    }
}
