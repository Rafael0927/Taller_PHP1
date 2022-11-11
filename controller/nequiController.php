<?php

require_once 'model/nequiDAO.php';

class  nequiController{

    private $nequi;

    public function __construct(){
        $this->nequi = new nequiController();
    }

    public function list() {
 //     return $data = $this->nequi->getAll();
    }

    public function getnequi($id)
    {
        return $this->nequi->toJson("Bancolombia", $this->nequi->getBy("id", $id));
    }

    public function store($data)
    {
        if (
            isset($data['tipoCuenta'])
            && isset($data['NCuenta'])
            && isset($data['codigo'])
            && isset($data['saldo'])
            && isset($data['email'])
        ) {
            return $this->nequi->store($data);
        } else {
            return "No se recibieron los campos necesarios";
        }
    }

    public function update($data)
    {
        if (
            isset($data['Cuenta'])
            && isset($data['NCuenta'])
            && isset($data['codigo'])
            && isset($data['saldo'])
            && isset($data['email'])
            && isset($data['id'])
        ) {
            return $this->nequi->update($data);
        } else {
            return "No se recibieron los campos necesarios";
        }
    }

    public function delete($data)
    {
        if (isset($data['id'])) {
            return $this->nequi->delete($data['id']);
        } else {
            return "No se recibió el id";
        }
    }
}
