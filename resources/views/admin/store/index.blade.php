@extends('layouts.app')
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row store-section">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Stores</h3>
                        </div>
                        <div class="col-4 text-right banner-form">
                        <div align="left">
                       
                       <form action="{{route('admin.stores-search')}}" method="get" role="search">
                         
                           <input type="text" placeholder="Search.." id="search_banners" name="search" class="form-control" value="{{ Request::get('search') }}" onkeyup="myFunction()">
                           <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-sm"></i></button>
                       </form>
                          
                   </div>
                        </div>
                    </div>
                </div>
                
               

                <div class="table-responsive store-table">
                    <table class="table align-items-center table-flush data-table3">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Owner</th>
                                <th scope="col">Address</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Banner</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Featured</th>
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
                                    <td><input type="checkbox" data-id="{{ $store->id }}" {{ $store->is_featured == 1 ? 'checked' : '' }} class="featured-class" data-toggle="toggle" data-on="Featured" data-off="Not Featured" data-onstyle="success" data-offstyle="danger"></td>
                                    <td><input type="checkbox" data-id="{{ $store->id }}" {{ $store->status == 1 ? 'checked' : '' }} class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <!-- <a class="dropdown-item" href="{{route('store.edit',$store->id)}}">Edit</a> -->
                                                    <a class="dropdown-item" href="{{route('store.view',$store->id)}}">View</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $getStores->appends(request()->input())->links() }}
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        
                    </nav>
                </div>
            </div>
        </div>
    </div>

   
    </div>
@endsection

@push('js')
    <!-- Bootstrap Toggle JS -->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function() {
            $('.toggle-class').bootstrapToggle();
        });
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 0 : 1; 
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
        $('.featured-class').change(function(){
            var status = $(this).prop('checked') == true ? 0 : 1; 
            var id = $(this).data('id'); 
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/isFeatured', // Your route here
                data: {'is_featured': status, 'id': id},
                success: function(data){
                console.log(data.success)
                }
            });
        });
        function myFunction() {
            var searchText = $('#search_stores').val();
            if (!searchText) {
                window.location.href = "{{ route('admin.stores') }}";
            }
        }
    </script>
@endpush