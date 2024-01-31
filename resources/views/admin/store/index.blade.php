@extends('layouts.app')
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Stores</h3>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <a href="" class="btn btn-sm btn-primary">Add user</a> -->
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                                        </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Owner</th>
                                <th scope="col">Address</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Banner</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach($getStores as $store)
                                <tr>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ $store->owner }}</td>
                                    <td>{{ $store->address }}</td>
                                    <td><img src="{{ $store->logo ? asset(Storage::url('images/' . $store->logo)) : asset(Storage::url('images/Image_not_available.png')) }}" height="40" width="40"></td>
                                    <td><img src="{{ $store->banner ? asset(Storage::url('images/' . $store->banner)) : asset(Storage::url('images/Image_not_available.png')) }}" height="40" width="40"></td>
                                    <td>{{ $store->phone }}</td>
                                    <td><input type="checkbox" data-id="{{ $store->id }}" {{ $store->status == 1 ? 'checked' : '' }} class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{route('store.edit',$store->id)}}">Edit</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <!-- Bootstrap Toggle JS -->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script>
        $(function() {
            $('.toggle-class').bootstrapToggle();
        });
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0; 
                var id = $(this).data('id'); 
                var route = "";
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/changeStatus', // Your route here
                    data: {'status': status, 'id': id},
                    success: function(data){
                    console.log(data.success)
                    }
                });
            });
        });
    </script>
@endpush