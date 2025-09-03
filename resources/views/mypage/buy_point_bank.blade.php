@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">銀行振込申請完了</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3"></label>
                        <div class="col-md-9">
                            下記の口座へお振込みをお願いいたします。<br>
                            お振込み完了後、運営事務局確認後反映いたします。
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-md-4 col-form-label text-md-right strong-label">銀行</label>

                        <div class="col-md-6 pt-2">
                            ○○○○銀行　銀行コード0000
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right strong-label">支店名</label>

                        <div class="col-md-6 pt-2">
                            ○○○○支店　支店コード0000
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right strong-label">口座番号</label>

                        <div class="col-md-6 pt-2">
                            普通口座　0000000
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right strong-label">口座名</label>

                        <div class="col-md-6 pt-2">
                            ○○○○株式会社
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right strong-label">合計金額　{{ number_format($data['price']) }}円</label>

                        <div class="col-md-6 pt-2">
                            （{{ number_format($data['point']) }}ポイント分）
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
