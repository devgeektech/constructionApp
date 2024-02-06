@extends('layouts.app')
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
       
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row banner-section">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-2 col-12">
                            <h3 class="mb-0">Banners</h3>
                        </div>


                        <div class="col-lg-8 col-md-8 col-12 banner-form">
                      <div align="left" class="search-form">
                       
                       <form action="{{route('admin.banners-search')}}" method="get" role="search">
                         
                           <input type="text" placeholder="Search.." id="search_banners" name="search" class="form-control" value="{{ Request::get('search') }}" onkeyup="myFunction()">
                           <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-sm"></i></button>
                       </form>
                          
                   </div>
                </div>






                        <div class="col-lg-2 col-md-2 col-12 text-right add-bnner">
                            <a href="{{ route('admin.banner.add')}}" class="btn btn-sm btn-primary">Add Banner</a>
                        </div>
                        
                    </div>
                </div>
                
                

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Store</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($banners as $banner)
                                <tr>
                                    <td><img src="{{ $banner->name ? asset(Storage::url('images/' . $banner->name)) : asset(Storage::url('images/Image_not_available.png')) }}" height="40" width="40"></td>
                                    <td>{{ $banner->store->name }}</td>
                                    <td><input type="checkbox" data-id="{{ $banner->id }}" {{ $banner->status == 1 ? 'checked' : '' }} class="toggle-class" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{route('admin.banner.edit',$banner->id)}}">Edit</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $banners->appends(request()->input())->links() }}
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
                    url: '/changeBannerStatus', // Your route here
                    data: {'status': status, 'id': id},
                    success: function(data){
                    console.log(data.success)
                    }
                });
            });
        });

        function myFunction() {
            var searchText = $('#search_banners').val();
            if (!searchText) {
                window.location.href = "{{ route('admin.banners') }}";
            }
        }
    </script>

@endpush