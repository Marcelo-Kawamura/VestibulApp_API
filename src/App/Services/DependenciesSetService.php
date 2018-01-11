<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 29/12/17
 * Time: 17:09
 */

namespace App\Services;


class DependenciesSetService extends BaseService
{
    public function save($data){
        $this->db->insert('dependency_set',$data);
        return $this->db->lastInsertId();
    }
}