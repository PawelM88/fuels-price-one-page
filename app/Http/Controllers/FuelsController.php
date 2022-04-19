<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidationRequest;
use Spatie\FlareClient\View;

class FuelsController extends Controller
{
    public function index()
    {
        return view('fuels.index');
    }

    public function calculate(ValidationRequest $request)
    {
        $request->validated();

        $fuelType = $request->input('fuelType');
        $oil = $request->input('oil');
        $pln = $request->input('pln');
        $vat = $request->input('vat');

        if ($fuelType === 'petrol') {
            $rawPetrolPrice = ((($oil / 159 + 0.26) * $pln) + 1.369 + 0.15261 + 0.08 + 0.37 + 0.1) * ($vat / 100 + 1);
            $petrolPrice = number_format($rawPetrolPrice, 2, ',', ' ');
            return view('fuels.index')->with('petrolPrice', $petrolPrice);
        }

        if ($fuelType === 'diesel') {
            $rawDieselPrice = ((($oil / 159 + 0.47) * $pln) + 1.065 + 0.32912 + 0.08 + 0.37 + 0.1) * ($vat / 100 + 1);
            $dieselPrice = number_format($rawDieselPrice, 2, ',', ' ');
            return view('fuels.index')->with('dieselPrice', $dieselPrice);
        }
    }
}
