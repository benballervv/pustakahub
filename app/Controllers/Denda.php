<?php

namespace App\Controllers;

use App\Models\DendaModel;

class Denda extends BaseController
{
    public function index()
    {
        $dendaModel = new DendaModel();

        $data['denda'] = $dendaModel->getSemuaDenda();

        return view('v_denda/index', $data);
    }
}