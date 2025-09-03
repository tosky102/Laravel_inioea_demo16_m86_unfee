いつも{{ env('APP_NAME') }}をご利用いただき、<br/>
誠にありがとうございます。<br/><br/>

下記の口座へお振込みをお願いいたします。<br>
お振込み完了後、運営事務局確認後反映いたします。<br><br>

銀行<br>
○○○○銀行　銀行コード0000<br>
支店名<br>
○○○○支店　支店コード0000<bR>
口座番号<br>
普通口座　0000000<br>
口座名<br><br>

▼ 購入ポイント情報<br>
今回購入ポイント：{{ $data['purchasePoint'] }} <br>
お支払い金額：{{ $data['paymentAmount'] }}<br><br>

@include('emails.include.footer')