<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 27/12/17
 * Time: 20:35
 */

namespace App\Services;


class ProblemsService extends BaseService
{
    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM problem ");
    }
    public function getAllSet($subject_id, $topic_id, $problem_type_id )
    {
        return $this->db->fetchAll("SELECT s.subject_id, t.topic_id , p.problem_type_id, q
.sequency, q.true_statement, q.false_statement, q.true_complementary_statement, q.false_complementary_statement FROM problem p  
INNER JOIN true_false_problem q
	on q.true_false_problem_id =p.problem_origin_id 
INNER JOIN topic t 
	on t.topic_id = p.topic_id
INNER JOIN subject s
	on s.subject_id=t.subject_id
where 
	s.subject_id = $subject_id AND 
	t.topic_id = $topic_id AND
    p.problem_type_id = $problem_type_id;");
    }


    public function getOne($id)
    {
        $problem = $this->db->fetchAssoc("SELECT * FROM problem WHERE problem_id=?", [(int) $id]);
        switch ($problem["problem_type"]){
            case 0: //check problems
                $item = $this->db->fetchAll("SELECT * FROM item WHERE check_check_id=?", [(int) $problem["problem_type_id"]]);
                $check = $this->db->fetchAssoc("SELECT * FROM `check` WHERE check_id=?", [(int) $problem["problem_type_id"]]);
                $arrayForJson = array("check" => $check,"item" => $item);
                break;
            case 1: //drag and drop
                $drag_drop = $this->db->fetchAssoc("SELECT * FROM drag_drop WHERE drag_drop_id=?", [(int) $problem["problem_type_id"]]);
                $drag = $this->db->fetchAssoc("SELECT * FROM check WHERE check_id=?", [(int) $problem["problem_type_id"]]);
                $arrayForJson = array();
                break;
        }
        $problem["problem"] = $arrayForJson;
        return $problem;
    }

    function save(array $data)
    {
        switch ($data["problem_type"]){
            case 0: //check problems

                $this->db->insert('`check`',array(
                    "check_description" => $data["check_description"]
                ));
                $check_check_id = $this->db->lastInsertId();
                for($i=0;$i<count($data["item"]);$i++){
                    $this->db->insert('item',array(
                        "item_description" => $data["item"][$i]["item_description"],
                        "item_answer_key" => $data["item"][$i]["item_answer_key"],
                        "check_check_id" => $check_check_id
                    ));
                }

                $this->db->insert('problem', array(
                    "problem_name" => $data["problem_name"],
                    //"problem_difficulty" => $data["problem_difficulty"],
                    "problem_type" => $data["problem_type"],
                    "problem_type_id" => $check_check_id,
                    "topic_topic_id" => $data["topic_topic_id"],
                    "dependency_set_dependency_id" => $data["dependency_set_dependency_id"]
                ));
                break;
            case 1: //drag and drop problems
                $this->db->insert('drag_drop',array(
                    "drag_drop_description" => $data["drag_drop_description"]
                ));
                $drag_drop_drag_drop_id = $this->db->lastInsertId();
                $this->db->insert('drag',array(
                    "drag_description" => $data["drag_description"]
                ));
                $drag_drag_id = $this->db->lastInsertId();
                $this->db->insert('drop',array(
                    "drop_description" => $data["drop_description"]
                ));
                $drop_drop_id = $this->db->lastInsertId();
                $this->db->insert('drag_drop_association',array(
                    "drag_drop_drag_drop_id" => $drag_drop_drag_drop_id,
                    "drag_drag_id" => $drag_drag_id,
                    "drop_drop_id" => $drop_drop_id
                ));
                $problem_type_id = $this->db->lastInsertId();
                $this->db->insert('problem', array(
                    "problem_name" => $data["problem_name"],
                    "problem_difficulty" => $data["problem_difficulty"],
                    "problem_type_id" =>$problem_type_id,
                    "topic_topic_id" => $data["topic_topic_id"],
                    "dependency_set_dependency_id" => $data["dependency_set_dependency_id"]
                ));
                break;
        }

        return $this->db->lastInsertId();
    }

}