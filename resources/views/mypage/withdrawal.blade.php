@extends('layouts.mypage')

@section('content')
    <div class="row mypage_row">
        <div class="col-md-12">

            <form action="{{ route('mypage.withdrawal') }}" method="post">
                @csrf
                <div class="login-title">退会する</div>

                <div class="card login-card">

                    {{-- <div class="card-header">退会する</div> --}}
                    <div class="card-body">
                        {{--                        <p>会員を退会された場合には、現在保存されている購入履歴や、お届け先などの情報は、全て削除されますがよろしいでしょうか？</p> --}}
                        {{--                        <p>退会手続きが完了した時点で、現在保存されている購入履歴や、お届け先等の情報は全てなくなりますのでご注意ください。</p> --}}

                        <p class="text-center">退会手続きが完了した時点で、現在保存されている購入履歴や、<br>
                            お客様情報等の情報は全てなくなりますのでご注意ください。</p>
                        <div class="form-group row mb-0">
                            <div style="margin:1rem auto 0;">
                                <button type="submit" class="btn btn-primary register-button">
                                    {{ __('WithdrawalButton') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>


        </div>

    </div>
@endsection
