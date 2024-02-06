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
                            <h3 class="mb-0">View</h3>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <a href="" class="btn btn-sm btn-primary">Add user</a> -->
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                </div>

                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                       
                        <h6 class="heading-small text-muted mb-4">{{ __('Contribution information') }}</h6>
                
                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', $contribution->getTranslation('name', app()->getLocale(),$contribution->name)) }}"  autofocus>

                            </div>
                            
                            <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                <input type="text" name="price" id="input-price" class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="{{ __('Price') }}" value="{{ old('price', $contribution->price) }}" required>

                            </div>

                            <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }} custom-image">
                                <label class="form-control-label" for="input-image">{{ __('Image') }}</label>
                                <img id="image-preview" src="{{ $contribution->image ? asset(Storage::url('images/' . $contribution->image)) : asset(Storage::url('images/Image_not_available.png')) }}" height="200" width="200">
                              
                            </div>

                            <div class="form-group{{ $errors->has('user') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-user">{{ __('User') }}</label>
                                <input type="text" name="user" id="input-user" class="form-control form-control-alternative{{ $errors->has('user') ? ' is-invalid' : '' }}" placeholder="{{ __('User') }}" value="{{ old('user', $contribution->user->name) }}" required>
                            </div>

                            <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-category">{{ __('Category') }}</label>
                                <input type="text" name="category" id="input-category" class="form-control form-control-alternative{{ $errors->has('category') ? ' is-invalid' : '' }}" placeholder="{{ __('Category') }}" value="{{ old('category', $contribution->category->name) }}" required>
                            </div>

                            <div class="form-group{{ $errors->has('store') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-store">{{ __('Store') }}</label>
                                <input type="text" name="store" id="input-store" class="form-control form-control-alternative{{ $errors->has('store') ? ' is-invalid' : '' }}" placeholder="{{ __('Store') }}" value="{{ old('store', $contribution->store->name) }}" required>
                            </div>

                            <div class="form-group{{ $errors->has('availability') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-availability">{{ __('Store') }}</label>
                                <input type="text" name="availability" id="input-availability" class="form-control form-control-alternative{{ $errors->has('availability') ? ' is-invalid' : '' }}" placeholder="{{ __('Availability') }}" value="{{ old('availability', $contribution->availability) }}" required>
                            </div>

                            <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-stock">{{ __('Stock') }}</label>
                                <input type="text" name="stock" id="input-stock" class="form-control form-control-alternative{{ $errors->has('stock') ? ' is-invalid' : '' }}" placeholder="{{ __('Stock') }}" value="{{ old('stock', $contribution->stock) }}" required>
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
    
@endpush