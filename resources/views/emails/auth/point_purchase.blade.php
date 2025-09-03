この度は{{ env('APP_NAME') }}に会員登録いただき、<br/>
誠にありがとうございます。<br/><br/>

下記の決済が完了しました。<br><br>
▼ 購入ポイント情報<br>
今回購入ポイント：{{ $data['purchasePoint'] }} <br>
お支払い金額：{{ $data['paymentAmount'] }}<br><br>
▼ お問い合わせ先<br>

@include('emails.include.footer')