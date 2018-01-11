<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 28/12/17
 * Time: 14:19
 */

namespace App\Services;


class UsersService extends BaseService

{
    public function save($data){
        $this->db->insert('student', $data);
        return $this->db->lastInsertId();
    }
}