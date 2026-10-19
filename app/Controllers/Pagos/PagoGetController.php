<?php

namespace App\Controllers\Pagos;

use App\Services\Pagos\PagoFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PagoGetController extends ResourceController {
    private PagoFinderService $finder;

    public function __construct(){
        $this->finder = new PagoFinderService();
    }

    public function find(int $id): ResponseInterface
    {
        $pago = $this->finder->find($id);
        return $this->response->setJSON($pago);
    }
}