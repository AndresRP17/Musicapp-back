<?php

namespace App\Services\Pagos;

use App\Converter\Pagos\PrimitiveToPagosConverter;
use App\Converter\Pagos\PagosToPagosResponseConverter;
use App\Dto\Request\Pagos\PagosRequest;
use App\Dto\Response\Pagos\PagosResponse;
use App\Models\PagosModel;

final class PagosCreatorService {

    private PagosModel $pagosModel;
    private PagosToPagosResponseConverter $converter;
    private PrimitiveToPagosConverter $primitiveConverter;

    public function __construct()
    {
        $this->pagosModel         = new PagosModel();
        $this->converter          = new PagosToPagosResponseConverter();
        $this->primitiveConverter = new PrimitiveToPagosConverter();
    }

    public function create(PagosRequest $request): PagosResponse
{
    // 1. Crear la Entity con los datos del request
    $entity = new \App\Entity\Pagos\Pagos(
        null,                    
        $request->getIdUser(),
        $request->getMonto(),
        date('Y-m-d H:i:s'),    
        'exitoso',               
        $request->getUltimos(),
        $request->getMarca(),
        $request->getPlan(),
        $request->getPeriodo()
    );

    // 2. Insertar y obtener la entity con el ID generado
    $pagosInsertado = $this->pagosModel->insert($entity);

    // 3. Actualizar rol a premium — usamos el token del usuario
$userModel = new \App\Models\MusicUserModel();
$usuario = $userModel->find($request->getIdUser());
$userModel->updateRole($usuario->getToken(), 'premium');

    // 4. Convertir Entity -> Response
    return $this->converter->convert($pagosInsertado);
}
}