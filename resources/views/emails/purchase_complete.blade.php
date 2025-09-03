いつも{{ env('APP_NAME') }}をご利用いただき、<br/>
誠にありがとうございます。<br/><br/>

下記の求人の購入が完了しました。<br><br>
<?php $pointTotal = null; ?>
<?php foreach ($data['items'] as $value) : ?>
▼ 求人情報<br>
求人ID : <?php echo $value['item_id']; ?><br>
求人名 : <?php echo $value['item_name']; ?><br>
出品者 : <?php echo $value['nickname'] ?><br>
▼ 支払い金額<br>
決済方法 : ポイント<br>
決済ポイント : P <?php echo $value['total']; ?><br><br>
<?php $pointTotal += $value['total']; ?>
--------------------------<br>
<?php endforeach; ?>
支払い合計金額（ポイント） : ￥<?php echo $pointTotal; ?><br><br>

@include('emails.include.footer')