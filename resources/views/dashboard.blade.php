@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1"></h6>
                                <h2 class="text-white mb-0">Products</h2>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                        <div class="">
                            <table class="table align-items-center table-flush">
                                <thead class="">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Availability</th>
                                        <th scope="col">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                            
                                    @foreach($getProducts as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td><img src="{{asset(Storage::url('images/' . $product->image))}}" height="40" width="40"></td>
                                            <td>{{ $product->availability }}</td>
                                            <td>{{ $product->stock }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Stores</h6>
                                <h2 class="mb-0">Total Stores</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <div class="">
                                <table class="table align-items-center table-flush">
                                    <thead class="">
                                        <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Logo</th>
                                       
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($getStores as $store)
                                            <tr>
                                                <td>{{ $store->name }}</td>
                                                <td>{{ $store->address }}</td>
                                                <td><img src="{{asset(Storage::url('images/' . $store->logo))}}" height="40" width="40"></td>
                                              
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush