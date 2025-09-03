{{ $data['user'] }}様<br/><br/>

このたびは【{{ env('APP_NAME') }}】にご登録いただき、誠にありがとうございます。<br/>
現在、仮登録の状態です。以下のURLをクリックして、仮登録を完了してください。<br/><br/>

■仮登録用URL（有効期限：{{ $data['expire_time'] }}時間以内）<br/>
<a href="{{ $data['url'] }}">{{ $data['url'] }}</a><br/><br/>

※有効期限を過ぎた場合は、再度仮登録を行ってください。<br/>
※このメールにお心当たりがない場合は、破棄していただいて構いません。<br/><br/>

今後とも【{{ env('APP_NAME') }}】をよろしくお願いいたします。

@include('emails.include.footer')