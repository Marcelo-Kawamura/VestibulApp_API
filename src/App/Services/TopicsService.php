<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 27/12/17
 * Time: 22:21
 */

namespace App\Services;


class TopicsService extends BaseService
{
    public function getBySubject($subject_id)
    {
        return $this->db->fetchAll("SELECT * FROM topic WHERE subject_subject_id=?", [(int) $subject_id]);
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM topic ");
    }
    public function getOne($id)
    {
        return $this->db->fetchAssoc("SELECT * FROM topic WHERE topic_id = ?", [(int) $id]);
    }
    function save($date)
    {
        $this->db->insert('topic', $date);
        return $this->db->lastInsertId();
    }

}