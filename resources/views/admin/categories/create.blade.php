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
                            <h3 class="mb-0">Create</h3>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <a href="" class="btn btn-sm btn-primary">Add user</a> -->
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                       
                        <h6 class="heading-small text-muted mb-4">{{ __('Category information') }}</h6>
                      
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
                                <label class="form-control-label" for="input-english-name">{{ __('English Name') }}</label>
                                <input type="text" name="english_name" id="input-english-name" class="form-control form-control-alternative{{ $errors->has('english_name') ? ' is-invalid' : '' }}" placeholder="{{ __('English Name') }}" value="" required autofocus>

                                @if ($errors->has('english_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('english_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-french-name">{{ __('French Name') }}</label>
                                <input type="text" name="french_name" id="input-french-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('French Name') }}" value="" required autofocus>

                                @if ($errors->has('french_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('french_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-lingala-name">{{ __('Lingala Name') }}</label>
                                <input type="text" name="lingala_name" id="input-english-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Lingala Name') }}" value="" required autofocus>

                                @if ($errors->has('lingala_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lingala_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }} custom-image">
                                <label class="form-control-label" for="input-image">{{ __('Image') }}</label>
                                <img id="image-preview" src="{{asset(Storage::url('images/Image_not_available.png')) }}" height="200" width="200">
                                <input type="file" id="input-image" name="image" class="form-control">
                                @if ($errors->has('image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('english_description') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-english-description">{{ __('English Description') }}</label>
                                <textarea type="text" name="english_description" id="input-english-description" class="form-control form-control-alternative{{ $errors->has('english_description') ? ' is-invalid' : '' }}" placeholder="{{ __('English Description') }}" value="" required></textarea>

                                @if ($errors->has('english_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('english_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('french_description') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-french-description">{{ __('French Description') }}</label>
                                <textarea type="text" name="french_description" id="input-french-description" class="form-control form-control-alternative{{ $errors->has('french_description') ? ' is-invalid' : '' }}" placeholder="{{ __('French Description') }}" value="" required></textarea>

                                @if ($errors->has('french_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('french_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('lingala_description') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-lingala-description">{{ __('Lingala Description') }}</label>
                                <textarea type="text" name="lingala_description" id="input-lingala-description" class="form-control form-control-alternative{{ $errors->has('lingala_description') ? ' is-invalid' : '' }}" placeholder="{{ __('Lingala Description') }}" value="" required></textarea>

                                @if ($errors->has('lingala_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lingala_description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
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