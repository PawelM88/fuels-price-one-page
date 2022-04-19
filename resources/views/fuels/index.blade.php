@extends('layouts.app')

@section('content')



    <body>
        {{-- Page Title --}}
        <h1>
            Fuels Costs
        </h1>

        {{-- A brief introduction to what influences the price of fuels --}}
        <p class="description">
            The price of fuels is made up of many factors. They include:
        </p>

        {{-- Factors influencing the price of fuels --}}
        <ul id="factors-left">
            <li>
                Crude Oil Price
            </li>
            <li>
                Zloty Exchange Rate
            </li>
            <li>
                Transport Cost
            </li>
            <li>
                Refinery Margin
            </li>
            <li>
                Station Margin
            </li>
        </ul>

        <ul id="factors-right">
            <li>
                VAT Tax
            </li>
            <li>
                Excise Tax
            </li>
            <li>
                Fuel Surcharge
            </li>
            <li>
                Emission Fee
            </li>
        </ul>

        {{-- Continuation of introduction to what influences the price of fuels and ask to fill in the form --}}
        <p class="description">
            Some of these factors are constant, such as taxes, but some are variable (mainly the price per barrel of oil
            and
            the exchange rate of the Polish zloty). Please fill in the three factors in the form below.
        </p>

        {{-- The form in which user should choose fuel type and enter three changing factors affecting the price of fuels --}}
        <form action="/" method="POST">
            @csrf
            <div class="input-group mb-3" id="fuel-type">
                <span class="input-group-text">Fuel Type</span>
                <select class="form-control" name="fuelType">
                    <option value="petrol">
                        Petrol
                    </option>
                    <option value="diesel">
                        Diesel
                    </option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Crude Oil Price</span>
                <input type="number" step=".01" name="oil" placeholder="Price per barrel of oil" min="0" max="1000"
                    class="form-control">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">PLN rate</span>
                <input type="number" step=".0001" name="pln"
                    placeholder="Exchange rate of the Polish zloty against the US dollar" min="0" max="100"
                    class="form-control">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Value of VAT</span>
                <input type="number" step=".1" name="vat" placeholder="Amount of VAT Tax" min="0" max="100"
                    class="form-control">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Calculate</button>
            </div>
        </form>

        {{-- The message that will appear when the fuel price is calculated. First one for petrol and second for diesel --}}
        @if (isset($petrolPrice))
            <div class="price-place">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        Estimated Price
                    </span>
                    <span class="price">
                        {{ $petrolPrice }} zł
                    </span>
                </div>
            </div>
            <div>
                <p class="result-description">
                    The presented price may differ from the actual one. This is due to the fuel margin, which is different
                    for
                    individual gas stations, the costs of transport and gas station placement. The actual price will usually
                    be
                    higher by a few groszy.
                </p>
            </div>
        @endif

        @if (isset($dieselPrice))
            <div class="price-place">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        Estimated Price
                    </span>
                    <span class="price">
                        {{ $dieselPrice }} zł
                    </span>
                </div>
            </div>
            <div>
                <p class="result-description">
                    The presented price may differ from the actual one. This is due to the fuel margin, which is different
                    for
                    individual gas stations, the costs of transport and gas station placement. The actual price will usually
                    be
                    higher by a few groszy.
                </p>
            </div>
        @endif

        {{-- Show Errors if inputs in forms aren't filled --}}
        @if ($errors->any())
            <div class="valid-error">
                @foreach ($errors->all() as $error)
                    <li class="valid-error-list">
                        {{ $error }}
                    </li>
                @endforeach
            </div>
        @endif

        <p id="question">
            You don't know where to get the data you need?
        </p>

        {{-- Links to pages with required information to be entered --}}
        <ul id="links-ul">
            <li>
                <a href="https://www.bankier.pl/inwestowanie/profile/quote.html?symbol=ROPA" target="blank"
                    class="links-li">
                    Crude Oil Price
                </a>
            </li>
            <li>
                <a href="https://www.bankier.pl/waluty/kursy-walut/forex/USDPLN" target="blank" class="links-li">
                    PLN rate
                </a>
            </li>
            <li>
                <a href="https://www.gov.pl/web/finanse/tarcza-antyinflacyjna-20-zlagodzi-skutki-inflacji-i-zmniejszy-jej-koszty-dla-polakow"
                    target="blank" class="links-li">
                    Value of VAT
                </a>
            </li>
        </ul>

        <h1>Cost Details</h1>

        {{-- Table with specified types of fuel costs and their amount --}}
        <table>
            <tr>
                <th>Name of factor</th>
                <th>Decripion</th>
                <th>Value for Petrol</th>
                <th>Value for Diesel</th>
            </tr>
            <tr>
                <td>
                    Transport Cost
                </td>
                <td>
                    The cost of Transport varies for each petrol station, which is understandable. For calculations, its
                    amount was arbitrarily averaged
                </td>
                <td>0.37 zł</td>
                <td>0.37 zł</td>
            </tr>
            <tr>
                <td>
                    Refinery Margin
                </td>
                <td>
                    For calculations, its amount was arbitrarily averaged. The refineries also benefit from the price
                    difference between Russian Ural and Brent crude oil
                </td>
                <td>0.26 zł</td>
                <td>0.47 zł</td>
            </tr>
            <tr>
                <td>
                    Station Margin
                </td>
                <td>
                    It depends on many factors, such as location and affiliation to a concern. For calculations, its amount
                    was arbitrarily averaged
                </td>
                <td>0.1 zł</td>
                <td>0.1 zł</td>
            </tr>
            <tr>
            <tr>
                <td>
                    The Excise Tax
                </td>
                <td>
                    Varies depending on the type of fuel. In addition, its rate is changed by law, and for LPG it is
                    calculated in kilograms. Excise Tax is included in the VAT base, so the State orders citizens to pay tax
                    on the tax
                </td>
                <td>1.369 zł</td>
                <td>1.065 zł</td>
            </tr>
            <tr>
                <td>
                    Fuel Surcharge
                </td>
                <td>
                    The fee collected in Poland as a result of introducing motor fuels and LPG( for which the rate is
                    calculated in kilograms) to the domestic market. 80% of the proceeds from the fuel surcharge go to the
                    National Road Fund and 20% to the Railway Fund
                </td>
                <td>0.15261 zł</td>
                <td>0.32912 zł</td>
            </tr>
            <tr>
                <td>
                    Emission Fee
                </td>
                <td>
                    Another tax that the ruling party is trying not to call a tax. 95% of this tax is the income of the
                    National Fund for Environmental Protection and Water Management, and 5% - the Public Utility Bus
                    Transport Development Fund
                </td>
                <td>0.08 zł</td>
                <td>0.08 zł</td>
            </tr>
        </table>

        {{-- Name and surname of the person who developed the mathematical formula for this application --}}
        <p id="formula-developer">
            For the purposes of this application, the mathematical formula for the price of petrol and diesel was developed
            by Łukasz
            Ługowski, MA, University of Economics in Katowice
        </p>

    </body>
@endsection
