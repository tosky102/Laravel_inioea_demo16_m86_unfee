@extends('layouts.app')

@section('content')
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Report') }}</div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-info" role="alert">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('user.report.post') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $auth_user_id }}" />
                            <input type="hidden" name="id" value="{{ $user->id }}" />
                            <input type="hidden" name="title" value="{{ $user->nickname . 'さんを報告する' }}" />

                            <div class="form-group row">
                                <label class="col-md-12 text-center">
                                    <a href="{{ route('user.show', ['id' => $user->id]) }}">{{ $user->nickname }}</a>さんを報告する
                                </label>

                            </div>

                            <div class="form-group row">
                                <label for="content" class="col-md-4 col-form-label text-md-right">{{ __('Report Content') }}</label>

                                <div class="col-md-6">
                                    <textarea id="content" rows="4" class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content') }}</textarea>

                                    @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Report Button') }}
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