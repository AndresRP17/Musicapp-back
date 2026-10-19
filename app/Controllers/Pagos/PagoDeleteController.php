<?php


namespace App\Controllers\Pagos;

use App\Services\Pagos\PagosDeletorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PagoDeleteController extends ResourceController{

    private PagosDeletorService $deleter;

    public function __construct(){
        $this->deleter = new PagosDeletorService();
    }

    public function do($id): ResponseInterface
    {
        $id = (int) $id;

        $this->deleter->delete($id);

        return $this->response->setJSON([
            "id" => $id
        ]);
    }







    }