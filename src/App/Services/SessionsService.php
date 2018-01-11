<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 27/12/17
 * Time: 16:47
 */

namespace App\Services;


class SessionsService extends BaseService
{
    public function tokenUpdate($data){
        $email = $data['student_email'];
        $token = md5($data['student_cpf'].date('m/d/Y h:i:s a', time()));

        $this->db->update('student',['student_token' => $token], ['student_email' => $email]);
        return  $token;
    }
    public function signOut($id){
        return  $this->db->update('student',['student_token' => null], ['student_id' => $id]);
        ;
    }
    public function signIn($data){
        $email = $data['student_email'];
        $password = $data['student_password'];
        return $this->db->fetchAssoc("SELECT * FROM student WHERE student_email= '$email' and student_password = '$password'");
    }
}