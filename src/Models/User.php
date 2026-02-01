<?php

namespace App\Models;

class User
{
    public int $userid;
    public string $firstname;
    public string $lastname;
    public string $created;
    public string $role;
    public string $lastupdated;
    public string $username;

    public function __construct(int $id, string $firstname = '', string $lastname = '', string $created = '', string $role = '', string $lastupdated = '', string $username = '')
    {
        $this->userid = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->created = $created;
        $this->role = $role;
        $this->lastupdated = $lastupdated;
        $this->username = $username;
    }

}