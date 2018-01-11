<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 28/12/17
 * Time: 21:01
 */

namespace App\Controllers;
use App\Services\StackProblemsService;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class StackProblemsController
{
    protected  $service;
    public function __construct(StackProblemsService $service)
    {
        $this->service = $service;
    }
    public function getOne($id)
    {
        return $this->myJsonResponse($this->service->getOne($id));
    }
    #Called when topic is choosen
    public function initialize(Request $request)
    {
        return $this->myJsonResponse($this->service->createStack($problemStack = array(
            "student_id" => $request->request->get("student_id"),
            "topic_id" => $request->request->get("topic_id"),
            "problem_type_id" => $request->request->get("problem_type_id"))));
    }


    public function updateHistory(Request $request){
        $this->service->addHistory($history = array(
            "problem_id" => $request->request->get("problem_id"),
            "student_id" => $request->request->get("student_id"),
            "history_answer" => $request->request->get("correct")));
        return $this->myJsonResponse("success");
    }
    public function updateStack(Request $request){
        $update = array(
            "student_id" => $request->request->get("student_id"),
            "problem_id" => $request->request->get("problem_id"),
            "done" => 1,
            "correct" => $request->request->get("correct")
        );
        $this->service->updateStackDone($update);
        $update2 = array(
            "student_id" => $request->request->get("student_id"),
            "problem_id" => $request->request->get("problem_id")
        );
        if($request->request->get("correct") === "0"){
            $this->service->addToStackEnd($update2);
            return 0;
        }else{

            return 0;
        }
    }

    public function getNextFromStack(Request $request){
        $this->updateHistory($request);
        $this->updateStack($request);
        $student_id = $request->request->get("student_id");
        return $this->myJsonResponse($this->service->getFirst($student_id));
    }



    public function getByUser($user_id)
    {

        return $this->myJsonResponse($this->service->getByUser($user_id));
    }
    public function getBysubject($user_id,$subject_id)
    {

        return $this->myJsonResponse(($this->service->getBySubject($user_id,$subject_id)));
    }
    public function getByTopic($user_id,$subject_id,$topic_id)
    {

        return $this->myJsonResponse(($this->service->getByTopic($user_id,$subject_id,$topic_id)));
    }
    public function save(Request $request)
    {
        $data = $this->getDataFromRequest($request);
        return $this->myJsonResponse(array("stack_problem_id" => $this->service->save($data)));
    }
    public function processAnswer($id,$request){
        if($this->service->validateToken($id,$request->request->get("student_token"))){
            $this->service->addHistory($history = array(
                        "problem_id" => $request->request->get("problem_id"),
                        "student_id" => $request->request->get("student_id"),
                        "history_answer" => $request->request->get("history_answer")));
            $this->service->addKnowledge($knowledge = array(
                        "dependency_set_dependency_id" => $request->request->get("dependency_id"),
                        "student_id"=>$request->request->get("student_id"),
                        "knowledge_point"=>$request->request->get("knowledge_point")));
            return $this->myJsonResponse("success");
        }else{
            return $this->myJsonResponseFail(null);
        }
    }




    public function getDataFromRequest(Request $request)
    {
        return $data = array(
            "student_id" => $request->request->get("student_id"),
            "problem_id" => $request->request->get("problem_id"),
        );
    }
    public function myJsonResponseFail($dataJson)
    {
        $data = array(
            "status" => 0,
            "data" => $dataJson
        );
        return new JsonResponse($data);
    }
    public function myJsonResponse($dataJson)
    {
        $data = array(
            "status" => 1,
            "data" => $dataJson
        );
        return new JsonResponse($data);
    }

}