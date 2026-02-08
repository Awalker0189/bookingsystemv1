<?php

namespace App\Models;

class Customer
{
    public int $userid;
    public string $firstname;
    public string $lastname;
    public string $created;
    public string $active;
    public string $lastupdated;
    public string $username;

    public function __construct(int $id, string $firstname = '', string $lastname = '', string $created = '', string $active = '', string $lastupdated = '', string $username = '')
    {
        $this->userid = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->created = $created;
        $this->active = $active;
        $this->lastupdated = $lastupdated;
        $this->username = $username;
    }
}