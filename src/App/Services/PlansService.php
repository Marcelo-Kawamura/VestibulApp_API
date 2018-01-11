<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 26/12/17
 * Time: 22:13
 */

namespace App\Services;


class PlansService extends BaseService
{
    public function getOne($id)
    {
        return $this->db->fetchAssoc("SELECT * FROM plan WHERE plan_id=?", [(int) $id]);
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM plan ");
    }

    function save($data)
    {
        $this->db->insert('plan', $data);
        return $this->db->lastInsertId();
    }

    function update($id, $data)
    {
        return $this->db->update('plan', $data, ['plan_id' => $id]);
    }

    function delete($id)
    {
        return $this->db->delete('plan', array("plan_id" => $id));
    }
}