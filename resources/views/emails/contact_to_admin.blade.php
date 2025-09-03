{{$data['name']}}さんからお問い合わせがありました。<br/><br/>

問い合わせ内容<br>
<?php echo $data['title']; ?><br>
<?php echo $data['content']; ?><br><br>

@include('emails.include.footer')
