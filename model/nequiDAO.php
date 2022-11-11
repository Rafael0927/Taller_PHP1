<?php

require_once 'model/nequiDAO.php';
require_once 'model/conexion.php';


class nequiDAO {
    private $table = "bancolombia";
    private $conexion;
    public $student;

    public function __construct()
    {
        $this->conection = Conexion::getconect();
        $this->person = new studentDao();
    }

    private function validateData($data)
    {
        $NCuenta = $data['NCuenta'];
        $codigo = $data['codigo'];
        $Saldo = $data['Saldo'];

        $numeros = "123456789";
        $Saldo = "123456789.,";

        if ($codigo < 0) {
            return "El codigo de seguridad no puede ser negativo";
        }

        for ($i = 0; $i < strlen($NCuenta); $i++) {
            if (strpos($numeros, substr($NCuenta, $i, 1)) === false) {
                return "El campo numero de cuenta debe ser de tipo numérico y sin puntos ni comas";
            }
        }
        for ($i = 0; $i < strlen($codigo); $i++) {
            if (strpos($numeros, substr($codigo, $i, 1)) === false) {
                return "el campo codigo de seguridad debe ser de tipo numérico y sin puntos ni comas";
            }
        }
        for ($i = 0; $i < strlen($Saldo); $i++) {
            if (strpos($Saldo, substr($Saldo, $i, 1)) === false) {
                return "el campo saldo disponible contiene caracteres invalidos";
            }
        }

        return "ok";
    }

    public function toJson($name, $data)
    {
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            $name => $data
        ]);
    }

    public function getPerson($id)
    {
        return $this->person->getBy("id", $id);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM bancolombia";
        $statement = $this->conection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->conection = null;
        for ($i = 0; $i < count($result); $i++) {
            $idPersona = $result[$i]['idstudent'];
            $result[$i]['data_fk'] = $this->getPerson($idPersona);
        }

        return $this->toJson("bancolombia", $result);
    }


    public function getBy($colum, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$colum} = {$value}";
        $statement = $this->conection->prepare($sql);
        $statement->execute();

        $result = $statement->fetch();
        $idPersona = $result[0]['idstudent'];
        $result[0]['data_fk'] = $this->getPerson($idPersona);

        if ($result == false) {
            return null;
        }

        return $this->toJson("bancolombia", $result);
    }


    public function store($data)
    {
        $validateMessage = $this->validateData($data);
        if (hash_equals($validateMessage, "ok")) {
            $persona = $this->person->getBy("id", $data['idstudent']);
            if ($persona != null) {
                $statement = $this->conection->prepare("INSERT INTO bancolombia (idstudent, Cuenta, NCuenta, codigo, Saldo, email) VALUES (?,?,?,?,?,?)");

                $statement->bindParam(1, $data['idstudent']);
                $statement->bindParam(2, $data['Cuenta']);
                $statement->bindParam(3, $data['NCuenta']);
                $statement->bindParam(4, $data['codigo']);
                $statement->bindParam(5, $data['Saldo']);
                $statement->bindParam(6, $data['email']);
                $statement->execute();

                $persona = $this->person->getBy("id", $data['idstudent']);
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $result[0]["Titular"] = $persona[0];

                return $this->toJson("Datos ingresados", $result);
            }
            return $this->toJson("Error", "No existe una persona registrada con el id indicado");
        }
        return $this->toJson("Error", $validateMessage);
    }

    public function update($id, $data)
    {
        $validateMessage = $this->validateData($data);
        if (hash_equals($validateMessage, "ok")) {
            $statement = $this->conection->prepare("UPDATE bancolombia SET Cuenta = ?, NCuenta = ?, codigo = ?, Saldo = ?, email = ? WHERE id = ?");

            $statement->bindParam(1, $data['Cuenta']);
            $statement->bindParam(2, $data['NCuenta']);
            $statement->bindParam(3, $data['codigo']);
            $statement->bindParam(4, $data['Saldo']);
            $statement->bindParam(5, $data['email']);
            $statement->bindParam(6, $id);

            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $persona = $this->person->getBy("id", $result[0]['idstudent']);
            $result[0]["Titular"] = $persona[0];
            return $this->toJson("Registro actualizado", $result);
        }
        return $this->toJson("Error", $validateMessage);
    }

    public function delete($id)
    {
        $result = $this->getBy("id", $id);
        $persona = $this->person->getBy("id", $result[0]['idstudent']);
        $result[0]["Titular"] = $persona[0];

        $statement = $this->conection->prepare("DELETE FROM bancolombia WHERE id = ?");
        $statement->bindParam(1, $id);

        $statement->execute();
        return $this->toJson("Registro eliminado", $result);
    }
    public function deleteBystudent($idPerson)
    {
        $statement = $this->conection->prepare("DELETE FROM cuenta WHERE idstudent = ?");
        $statement->bindParam(1, $idPerson);

        $statement->execute();
    }
}
