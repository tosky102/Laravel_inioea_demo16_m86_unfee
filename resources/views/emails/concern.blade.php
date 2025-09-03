いつも{{ env('APP_NAME') }}をご利用いただき、<br/>
誠にありがとうございます。<br/><br/>

気になるを通知が届きました。<br><br>
▼ 求人情報<br>
求人ID : <?php echo $data['item_id']; ?><br>
求人名 : <?php echo $data['item_name']; ?><br>
ユーザー名 : <?php echo $data['nickname']; ?><br><br>

@include('emails.include.footer')
