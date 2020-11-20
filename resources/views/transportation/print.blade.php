@extends('layouts.app')

@php
    $logbook = \Modules\ForestResources\Entities\Logbook::where('Id', $id)
                ->with(['anuualallowablecut', 'items', 'concession', 'developmentunit', 'managementunit'])->first();
@endphp

@section('title', 'Print Carnet d\'abattage')

@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-8 offset-md-2 col-sm-12">
                <table class="table table-sm">
                    <tbody>
                    <tr>
                        <td>Name Concession</td>
                        <td>{{ $logbook->concession->Name }}</td>
                    </tr>
                    <tr>
                        <td>Name UFA</td>
                        <td>{{ $logbook->developmentunit->Name }}</td>
                    </tr>
                    <tr>
                        <td>Name UFG</td>
                        <td>{{ $logbook->managementunit->Name }}</td>
                    </tr>
                    <tr>
                        <td>Name AAC</td>
                        <td>{{ $logbook->concession->Name }}</td>
                    </tr>
                    </tbody>
                </table>

                <hr>
                <p class="lead text-center">
                    Logbook Items
                </p>

                @forelse($logbook->items ?? [] as $item)
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Tree ID</td>
                        <td>{{ $item->TreeId }}</td>
                    </tr>
                    <tr>
                        <td>Abattage ID</td>
                        <td>{{ $item->Logbook }}</td>
                    </tr>
                    <tr>
                        <td>Species</td>
                        <td>{{ $item->Species }}</td>
                    </tr>
                    <tr>
                        <td>Max Diameter</td>
                        <td>{{ $item->MaxDiameter }}</td>
                    </tr>
                    <tr>
                        <td>Min Diameter</td>
                        <td>{{ $item->MinDiameter }}</td>
                    </tr>
                    <tr>
                        <td>Length</td>
                        <td>{{ $item->Length }}</td>
                    </tr>
                    <tr>
                        <td>Volume</td>
                        <td>{{ $item->Volume }}</td>
                    </tr>
                    <tr>
                        <td>Observations</td>
                        <td>{{ $item->Note }}</td>
                    </tr>
                    </tbody>
                </table>
                @empty
                    <p class="text-center">No Items Found</p>
                @endforelse

                <hr>
                <div class="text-center" style="margin-top: 30px; margin-bottom: 30px;">
                    {!! QrCode::size('250')->format('svg')->generate('We have to generate PDF based on this!') !!}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        //window.print();
    </script>
@endsection

