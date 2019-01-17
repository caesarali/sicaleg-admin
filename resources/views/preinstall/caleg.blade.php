@extends('layouts.setup')

@section('content')
    <div class="container" style="margin: 7% auto">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header bg-white border-0 text-center">
                        Profil Calon Legislatif
                    </h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('setup.profile') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">Nama</label>
                                <div class="col-md-9">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="number" class="col-md-3 col-form-label text-md-right">No. Urut</label>
                                <div class="col-md-9">
                                    <input id="number" type="text" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" value="{{ old('number') }}" required >
                                    @if ($errors->has('number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="locationable_id" class="col-md-3 col-form-label text-md-right">Lokasi Dapil</label>
                                <div class="col-md-9">
                                    <select name="locationable_id" id="locationable_id" class="form-control{{ $errors->has('locationable_id') ? ' is-invalid' : '' }}" required>
                                        <option value="" hidden>Pilih:</option>
                                        @foreach ($locations as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('locationable_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('locationable_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="locationable_name" class="col-md-3 col-form-label text-md-right">Nama Dapil</label>
                                <div class="col-md-9">
                                    <input id="locationable_name" type="text" class="form-control{{ $errors->has('locationable_name') ? ' is-invalid' : '' }}" name="locationable_name" value="{{ old('locationable_name') }}" required placeholder="Contoh: Dapil 1 Sulsel.">
                                    @if ($errors->has('locationable_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('locationable_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group text-right mb-0">
                                <button type="submit" class="btn btn-primary">Next <i class="fas fa-chevron-right ml-1"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
