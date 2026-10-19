<?php


namespace App\Services\Pagos;

use App\Models\PagosModel;

final class PagosSearcherService{
    private PagosModel $pagosModel;

    public function __construct(){
        $this->pagosModel = new PagosModel();
    }

    public function searchByUserId(int $id_user): array
    {
        return $this->pagosModel->searchByUserId($id_user);
    }

    public function searchAll(): array
    {
        return $this->pagosModel->findAll();
    }
}