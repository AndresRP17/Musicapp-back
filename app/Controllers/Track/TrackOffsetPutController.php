<?php

namespace App\Controllers\Track;

use App\Controllers\BaseController;
use App\Models\TrackModel;

class TrackOffsetPutController extends BaseController
{
    public function actualizar()
    {
        $body = $this->request->getJSON();
        $trackModel = new TrackModel();
        $trackModel->actualizarOffset((int)$body->id_track, (float)$body->offset);
        return $this->response->setJSON(['ok' => true]);
    }
}