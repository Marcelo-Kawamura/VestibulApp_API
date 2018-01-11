<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 27/12/17
 * Time: 16:29
 */

namespace App\Services;


class SubjectsService extends BaseService
{
    public function getOne($id)
    {
        return $this->db->fetchAssoc("SELECT * FROM subject WHERE subject_id=?", [(int) $id]);
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM subject ");
    }

    function save($date)
    {
        $this->db->insert('subject', $date);
        return $this->db->lastInsertId();
    }

    function update($id, $data)
    {
        return $this->db->update('subject', $data, ['subject_id' => $id]);
    }

    function delete($id)
    {
        return $this->db->delete('subject', array("subject_id" => $id));
    }
}