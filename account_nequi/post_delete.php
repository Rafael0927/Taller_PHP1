<?php
include '../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
try {
    $id = $data['id'];

    $statement = $mbd->prepare("SELECT * from estudiante WHERE id = ?");
    $statement -> bindParam(1, $id);
    $statement -> execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $mbd->prepare("DELETE FROM estudiante WHERE id = ?");
    $statement->bindParam(1, $id);
    $statement->execute();

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'mensaje' => "Registro eliminado correctamente",
        'estudiante' => $results
    ]);
} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}
