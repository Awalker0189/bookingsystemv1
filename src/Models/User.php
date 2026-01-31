<?php

namespace App\Models;

class User
{
    public int $userid;
    public string $firstname;
    public string $created;

    public function __construct(int $id, string $name, string $created)
    {
        $this->userid = $id;
        $this->firstname = $name;
        $this->created = $created;
    }

}