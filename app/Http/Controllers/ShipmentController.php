<?php

namespace App\Http\Controllers;

use App\Traits\ShipmentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShipmentController extends Controller
{
    use ShipmentTrait;
    public function create_shipment()
    {
        $packageResults = $this->createShipment();
        // To see how to view label image of each packages visit the view file. Lable images are also downloadable
        return view('trackingNumber', compact('packageResults'));
    }
}
