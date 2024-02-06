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
                            <h3 class="mb-0">Products</h3>
                        </div>
                        <div class="col-4 text-right banner-form">
                        <div align="left">
                       
                       <form action="{{ route('admin.products.search') }}" method="get" role="search">
                         
                           <input type="text" placeholder="Search.." id="search_products" name="search" class="form-control" value="{{ Request::get('search') }}" onkeyup="myFunction()">
                           <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-sm"></i></button>
                        
                       </form>
                          
                   </div>
                        </div>
                    </div>
                </div>


                <div class="table-responsive store-table">
                  
                    <table class="table align-items-center table-flush data-table4" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Image</th>
                                <th scope="col">Store</th>
                                <th scope="col">Category</th>
                                <th scope="col">Availability</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($getProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td><img src="{{ $product->image ? asset(Storage::url('images/' . $product->image)) : asset(Storage::url('images/Image_not_available.png')) }}" height="40" width="40"></td>
                                    <td>{{ $product->store->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->availability }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td><input type="checkbox" data-id="{{ $product->id }}" {{ $product->status == 1 ? 'checked' : '' }} class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{route('product.view',$product->id)}}">View</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- {{ $getProducts->links() }} -->
                    {{ $getProducts->appends(request()->input())->links() }}
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
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 0 : 1; 
                var id = $(this).data('id'); 
                var route = "";
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/changeProductStatus', // Your route here
                    data: {'status': status, 'id': id},
                    success: function(data){
                    console.log(data.success)
                    }
                });
            });
        });

      

        function myFunction() {
            var searchText = $('#search_products').val();
            if (!searchText) {
                window.location.href = "{{ route('admin.products') }}";
            }
        }
    </script>
@endpush