<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Services\Voip24h\Voip24hInterface;
use Illuminate\Http\Request;

class Voip24hController extends Controller
{
    protected $voip24h_interface;

    public function __construct(Voip24hInterface $voip24h_interface)
    {
        $this->voip24h_interface = $voip24h_interface;
    }

    public function listVoip24h(Request $request)
    {
        $response = $this->voip24h_interface->index($request);
        $data = $response['data'];
        return view('crm.content.voip24h.voip24h_list', compact('data'));
    }
}
