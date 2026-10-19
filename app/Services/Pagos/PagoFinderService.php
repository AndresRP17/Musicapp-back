<?php

namespace App\Services\Pagos;

use App\Models\PagosModel;
use App\Exception\Pagos\PagosNotFoundException;

final class PagoFinderService{
    private PagosModel $pagosModel;

    public function __construct()
    {
        $this->pagosModel = new PagosModel();
    }

    public function find(int $id): object
    {
        $pago = $this->pagosModel->find($id);

        if (empty($pago)) {
            throw new PagosNotFoundException($id);
        } 
        return $pago;
    }
}