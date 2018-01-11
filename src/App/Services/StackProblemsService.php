<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 28/12/17
 * Time: 21:01
 */

namespace App\Services;


class StackProblemsService extends BaseService
{
    function save($data)
    {
        $this->db->insert('stack_problem', $data);
        return $this->db->lastInsertId();
    }

    public function getOne($id)
    {
        return $this->db->fetchAssoc("SELECT * FROM stack_problem WHERE stack_id=? ORDER BY stack_id DESC", [(int) $id]);
    }
    public function getFirst($student_id){
        $sql = "SELECT * FROM stack_problem WHERE  done = 0 AND student_id = $student_id order by stack_problem_id limit 1";
        $data = $this->db->fetchAll($sql);
        if(sizeof($data) ===0){
            $this->db->delete("stack_problem", array("student_id"=>$student_id));
            return 0;
        }
        else{
            return $data;
        }
    }

    public function getByUser($user_id)
    {
        return $this->db->fetchAll("SELECT * FROM  problem
                  INNER JOIN stack_problem ON problem_id=problem_problem_id
                  INNER JOIN topic ON topic_topic_id = topic_id
                  INNER JOIN knowledge ON knowledge.student_student_id = $user_id 
                  WHERE stack_problem.student_student_id='$user_id' 
                  ORDER BY stack_id DESC");
    }
    public function getBySubject($user_id,$subject_id)
    {
        return $this->db->fetchAll("SELECT * FROM problem 
                  INNER JOIN stack_problem ON problem_id=problem_problem_id
                  INNER JOIN topic ON topic_topic_id = topic_id
                  INNER JOIN knowledge ON knowledge.student_student_id = $user_id
                  WHERE   stack_problem.student_student_id = $user_id 
                  AND     subject_subject_id = $subject_id
                  ORDER BY stack_id DESC");
    }
    public function getByTopic($user_id,$subject_id,$topic_id)
    {
        return $this->db->fetchAll("SELECT * FROM problem 
                  INNER JOIN stack_problem ON problem_id=problem_problem_id
                  INNER JOIN topic ON topic_topic_id = topic_id
                  INNER JOIN knowledge ON knowledge.student_student_id = $user_id
                  WHERE   stack_problem.student_student_id = $user_id 
                  AND     subject_subject_id = $subject_id
                  AND     topic_id = $topic_id
                  ORDER BY stack_id DESC");
        }
    public function validateToken($id,$token)
    {
        return $this->db->fetchAssoc("SELECT * FROM student 
                  INNER JOIN stack_problem ON student_id = student_student_id
                  INNER JOIN topic ON topic_topic_id = topic_id
                  WHERE   stack_id = $id 
                  AND     student_token = $token");
    }
    public function addHistory($history)
    {
        $this->db->insert('history',$history);
        return $this->db->lastInsertId();
    }
    public function addKnowledge($knowledge)
    {
        $this->db->insert('knowledge',$knowledge);
    }

    public function createStack($problemStack)
    {        $sql_check = "SELECT * FROM stack_problem";
        if(sizeof( $this->db->fetchAll($sql_check))===0){

            $sql = "SELECT {$problemStack["student_id"]} as student_id , problem_id, 0 as done, 0 as correct 
                      FROM problem p 
	                  INNER JOIN true_false_problem t 	
		                ON p.problem_origin_id = t.true_false_problem_id 
	                  WHERE	
		                problem_type_id = {$problemStack["problem_type_id"]} AND
		                topic_id = {$problemStack["topic_id"]}";
            $data = $this->db->fetchAll($sql);
            foreach ($data as $datum) {
                $this->db->insert('stack_problem',$datum);
            }
            return $data;
        } else{
            return "já existe dado";
        }
    }
    public function addToStackEnd($problem){
        $this->db->insert('stack_problem',$problem);
    }

    public function updateStackDone($update){
        $sql ="UPDATE stack_problem 
                SET 
                  done = :done, 
                  correct = :correct 
                WHERE 
                  student_id = :student_id AND
                  problem_id = :problem_id AND
                  done = 0";
        $this->db->executeUpdate($sql,$update );
    }


}