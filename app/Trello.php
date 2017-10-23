<?php

namespace App;

use Trello\Client;
use Trello\Manager;

class Trello
{
    private $Client;
    private $Manager;
    private $Member;

    private $Login = 'kelvin.souza@tblmanager.com.br';

    public function  __construct()
    {
        $this->authenticate();
        $this->manager();
        $this->member();
    }

    private function authenticate()
    {
        $this->Client = new Client;
        $this->Client->authenticate(env('TRELLO_API_KEY'), env('TRELLO_TOKEN'), Client::AUTH_URL_CLIENT_ID);
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
        return $this->Member->boards()->all($this->Login);
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
