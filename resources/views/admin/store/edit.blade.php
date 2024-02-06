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
                    <form action="{{ route('store.update',$store->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                       
                        <h6 class="heading-small text-muted mb-4">{{ __('Store information') }}</h6>
                      
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif


                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', $store->name) }}"  autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('owner') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-owner">{{ __('Owner') }}</label>
                                <input type="text" name="owner" id="input-owner" class="form-control form-control-alternative{{ $errors->has('owner') ? ' is-invalid' : '' }}" placeholder="{{ __('Owner') }}" value="{{ old('owner', $store->owner) }}" required>

                                @if ($errors->has('owner'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('owner') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                <input type="text" name="address" id="input-address" class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Address') }}" value="{{ old('owner', $store->address) }}" required>

                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('latitude') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-latitude">{{ __('Latitude') }}</label>
                                <input type="text" name="latitude" id="input-latitude" class="form-control form-control-alternative{{ $errors->has('latitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Latitude') }}" value="{{ old('latitude', $store->latitude) }}" required>

                                @if ($errors->has('latitude'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('longitude') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-longitude">{{ __('Longitude') }}</label>
                                <input type="text" name="longitude" id="input-longitude" class="form-control form-control-alternative{{ $errors->has('longitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Longitude') }}" value="{{ old('logitude', $store->longitude) }}" required>

                                @if ($errors->has('longitude'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-group{{ $errors->has('logo') ? ' has-danger' : '' }} custom-image">
                                <label class="form-control-label" for="input-image">{{ __('Logo') }}</label>
                                <img id="logo-preview" src="{{ $store->logo ? asset(Storage::url('images/' . $store->logo)) : asset(Storage::url('images/Image_not_available.png')) }}" height="200" width="200">
                                <input type="file" id="input-logo" name="logo" class="form-control">
                                @if ($errors->has('logo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('banner') ? ' has-danger' : '' }} custom-image">
                                <label class="form-control-label" for="input-banner">{{ __('Banner') }}</label>
                                <img id="banner-preview" src="{{ $store->banner ? asset(Storage::url('images/' . $store->banner)) : asset(Storage::url('images/Image_not_available.png')) }}" height="200" width="200">
                                <input type="file" id="input-banner" name="banner" class="form-control">
                                @if ($errors->has('banner'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('banner') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('phone') }}" value="{{ old('phone', $store->phone) }}" required>

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
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
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script>
        document.getElementById('input-logo').addEventListener('change', function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logo-preview').setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('input-banner').addEventListener('change', function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('banner-preview').setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush