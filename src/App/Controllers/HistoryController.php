<?php
/**
 * Created by PhpStorm.
 * User: marcelo
 * Date: 09/01/18
 * Time: 13:35
 */

namespace App\Controllers;


class HistoryController
{
    protected  $service;
    public function __construct(HistoryService $service)
    {
        $this->service = $service;
    }

    public function getDataFromRequest(Request $request)
    {
        return $data = array(
            "student_id" => $request->request->get("student_id"),
            "problem_id" => $request->request->get("problem_id"),
            "problem_type_id" => $request->request->get("problem_id"),
        );
    }
}