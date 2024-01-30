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
                            <h3 class="mb-0">Edit</h3>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <a href="" class="btn btn-sm btn-primary">Add user</a> -->
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.banner.update',$banner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                       
                        <h6 class="heading-small text-muted mb-4">{{ __('Banner information') }}</h6>
                      
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }} custom-image">
                                <label class="form-control-label" for="input-image">{{ __('Logo') }}</label>
                                <img id="image-preview" src="{{ $banner->name ? asset(Storage::url('images/' . $banner->name)) : asset(Storage::url('images/Image_not_available.png')) }}" height="200" width="200">
                                <input type="file" id="input-image" name="image" class="form-control">
                                @if ($errors->has('image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('store_id') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-store">{{ __('Store') }}</label>
                                <select id="single" name="store" class="js-states form-control">
                                    @foreach( $stores as $store)
                                    <option value="{{ $store->id }}" {{ $store->id == $banner->store_id ? 'selected' : '' }}>{{$store->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('store'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('store') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>
                        <hr class="my-4" />
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
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        document.getElementById('input-image').addEventListener('change', function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });

        jQuery("#single").select2({
          placeholder: "Select a Store",
          allowClear: true
      });
    </script>
@endpush