<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Services\Leads\LeadsInterface;
use Illuminate\Http\Request;

class InteractionHistoryController extends Controller
{
    protected $leads_interface;
    public function __construct(LeadsInterface $leads_interface)
    {
        $this->leads_interface = $leads_interface;
    }

    public function listHistory(){
        return view('crm.content.interactionHistory.interaction_history');
    }
}
