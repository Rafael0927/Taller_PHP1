<?php

class studentController
{
    public $person;


    public function __construct()
    {
        $this->student = new studentDao();
    }

    public function list()
    {
        return $this->student->getAll();
    }

    public function getPerson($id)
    {

        return $this->student->toJson("estudiante", $this->student->getBy("id", $id));
    }

    public function store($data)
    {
        if (
            isset($data['identificacion'])
            && isset($data['nombres'])
            && isset($data["apellidos"])
        ) {
            return $this->student->store($data);
        } else {
            return "No se recibieron los campos necesarios";
        }
    }

    public function update($data)
    {
        if (
            isset($data['identificacion'])
            && isset($data['nombres'])
            && isset($data["apellidos"])
            && isset($data["id"])
        ) {
            return $this->student->update($data);
        } else {
            return "No se recibieron los campos necesarios";
        }
    }

    public function delete($data)
    {
        if (isset($data['id'])) {
            $nequi = new nequiDao();
            $existentnequi = $nequi->getBy('idStudent', $data['id']);
            if($existentnequi!=null){
                $nequi->deleteBystudent($data['id']);
            }
            return $this->student->delete($data['id']);
        } else {
            echo "No se recibió el id";
        }
    }
}