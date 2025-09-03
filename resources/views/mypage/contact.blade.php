@extends('layouts.app')

@section('content')
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-title">{{ __('Contact') }}</div>

                <div class="card login-card" style="margin: 0;">

                    {{-- <div class="card-header">{{ __('Contact') }}</div> --}}
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-info" role="alert">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('contact') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Contact Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control login-input @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') }}">

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="content"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Contact Content') }}</label>

                                <div class="col-md-6">
                                    <textarea id="content" rows="4" class="form-control login-input @error('content') is-invalid @enderror"
                                        name="content">{{ old('content') }}</textarea>

                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary register-button"
                                        style="min-width: 200px; margin-left: 0.2rem; margin:0.5rem;">
                                        {{ __('Contact Button') }}
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
