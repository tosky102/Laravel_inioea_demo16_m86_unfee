この度は{{ env('APP_NAME') }}に会員登録いただき、<br/>
誠にありがとうございます。<br/><br/>

ご本人様確認のため、下記URLへアクセスし<br/>
アカウントの本登録を完了させて下さい。<br/><br/>

{{ route('verify', $data['token']) }}<br/><br/>

ご本人様確認完了後、下記よりログインできます。<br/><br/>

▼{{ env('APP_NAME') }}ログインページ<br/>
{{ env('APP_URL') }}/login<br/><br/>

・メールアドレス： {{ $data['email'] }}<br/>
・パスワード： {{ $data['password'] }}<br/><br/>

@include('emails.include.footer')