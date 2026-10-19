<?php

namespace App\Services\Pagos;

use App\Models\PagosModel;

final class PagosDeletorService{
    private PagosModel $pagosModel;
    private PagoFinderService $finder;


    public function __construct(){
        $this->pagosModel = new PagosModel();
        $this->finder = new PagoFinderService();
    }

    public function delete(int $id): void
    {
        $pago = $this->finder->find($id);
        $this->pagosModel->delete($pago->getId());
    }

    }

