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
            $petrolPrice = ((($oil / 159 + 0.26) * $pln) + 1.369 + 0.15261 + 0.08 + 0.37 + 0.1) * ($vat / 100 + 1);
        }

        return number_format($petrolPrice, 2, ',', ' ');

        return redirect('/');
    }
}
