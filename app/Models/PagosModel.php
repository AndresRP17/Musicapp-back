<?php

namespace App\Models;

use App\Entity\Pagos\Pagos;
use App\Converter\Pagos\PrimitiveToPagosConverter;
use CodeIgniter\Database\BaseConnection;
use Config\Database;

final class PagosModel{
    private BaseConnection $database;
    private PrimitiveToPagosConverter $converter;


    public function __construct()
    {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToPagosConverter();
    }

    public function insert(Pagos $pagos): Pagos
    {
        $query = "INSERT INTO pagos (id, id_user, monto, fecha, estado, ultimos, marca, plan, periodo) VALUES (?,?,?,?,?,?,?,?,?)";
    
        $this->database->query($query, [
            $pagos->getId(),
            $pagos->getIdUser(),
            $pagos->getMonto(),
            $pagos->getFecha(),
            $pagos->getEstado(),
            $pagos->getUltimos(),
            $pagos->getMarca(),
            $pagos->getPlan(),
            $pagos->getPeriodo()

        ]);
    
        $id = $this->database->insertID();

        return new Pagos(
            $id,
            $pagos->getIdUser(),
            $pagos->getMonto(),
            $pagos->getFecha(),
            $pagos->getEstado(),
            $pagos->getUltimos(),
            $pagos->getMarca(),
            $pagos->getPlan(),
            $pagos->getPeriodo()
        );
    }


    public function find(int $id): ?Pagos
    {
        $query = "SELECT P.id, P.id_user, P.monto, P.fecha, P.estado, P.ultimos, P.marca, P.plan, P.periodo
        FROM pagos P
        WHERE P.id = ?";

        $result = $this->database->query($query,[$id]);
        $primitive = $result->getRow();

        if (empty($primitive)) {
        return null;
    }

    return $this->converter->convert($primitive);
    }

    public function searchByUserId(int $id_user): array
    {
         $query = "SELECT P.id, P.id_user, P.monto, P.fecha, P.estado, P.ultimos, P.marca, P.plan, P.periodo
        FROM pagos P 
        WHERE P.id_user = ?
        ORDER BY id DESC";

        $result = $this->database->query($query, [$id_user]);


        return array_map(
        fn($primitive) => $this->converter->convert($primitive),
        $result->getResult()
        );
    }

   
    public function findAll(): array
    {
        $query = "SELECT P.id, P.id_user, P.monto, P.fecha, P.estado, P.ultimos, P.marca, P.plan, P.periodo
        FROM pagos P
        ORDER BY P.fecha ASC";

        $result = $this->database->query($query);

        return array_map(
            fn($primitive) => $this->converter->convert($primitive),
            $result->getResult()
        );
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM pagos WHERE id = ?";
        $this->database->query($query,[$id]);
    }

}