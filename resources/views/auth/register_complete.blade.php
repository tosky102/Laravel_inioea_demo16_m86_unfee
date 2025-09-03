@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin: 0">
            <div class="col-md-12 marginbottom-2rem">

                <div class="login-title">{{ __('Complete Register') }}</div>

                <div class="card login-card">

                    {{-- <div class="card-header">{{ __('Complete Register') }}</div> --}}

                    <div class="card login-card">
                        <p style="padding: 0.5rem 0.5rem 0 0.5rem;text-align: left;"><?php echo __('Thank you! Completed Register'); ?></p>



                        <a class="nav-link btn-header-login"
                            style="border-radius: 10px;border: 1px solid #333333;color: #333333;text-align: center;margin: 1rem auto;"
                            href="{{ route('login') }}">ログイン画面に戻る</a>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
