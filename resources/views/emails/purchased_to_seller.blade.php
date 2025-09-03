いつも{{ env('APP_NAME') }}をご利用いただき、<br/>
誠にありがとうございます。<br/><br/>

あなたが出品した下記の求人が購入されました。<br><br>
▼ 求人情報<br>
求人ID : {{ $data['id'] }}<br>
求人名 : {{ $data['title'] }}<br><br>

@include('emails.include.footer')