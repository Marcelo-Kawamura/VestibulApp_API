<?php

namespace App\Services;


abstract class BaseService
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

}
