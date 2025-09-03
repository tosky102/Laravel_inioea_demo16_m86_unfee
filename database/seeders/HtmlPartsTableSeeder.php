<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HtmlPartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('html_parts')->insert([
            'name' => '購入者ガイド', 'title' => 'guide_buy',
            'desc' => '<div class="l-main">    <h2 class="tos-title">購入者ガイド</h2>    <div class="l-tos-container">        <h4>1．まずは新規会員登録</h4>        <p>新規会員登録は、必要事項を入力するだけでとても簡単です。<br>            登録したメールアドレスに届く登録認証メールをクリックし、完了します。        </p>        <img src="https://imgur.com/MGswudO.png"/>        <h4>2．サイトにログイン</h4>        <p>会員登録時に入力した登録情報（メールアドレスとパスワード）を入力し、 「ログイン」ボタンをクリックして、ログインして下さい。        </p>        <img src="https://imgur.com/MGswudO.png"/>        <h4>3．購入したい求人をカートに入れて購入手続きを開始</h4>        <p>購入希望求人を1点ずつ「カートに入れる」ボタンをクリックしてショッピングカートに入れます。<br>            購入希望求人全てをカートに入れ終わりましたら、「カートの中」ボタンをクリックし、購入手続きに進みます。        </p>        <img src="https://imgur.com/MGswudO.png"/>        <h4>4．カート内の求人を確認</h4>        <p>カート内の求人を確認して下さい。<br>            もし必要のない求人がある場合はカートから削除して下さい。        </p>        <img src="https://imgur.com/MGswudO.png"/>        <h4>5．ポイントをクレジット決済で追加</h4>        <p>ポイント決済用のポイントをクレジット決済で追加します。 クレジットカードの情報は、入力方法に従って正確に入力して下さい。<br>            最後に「購入完了」ボタンをクリックすると、ポイントは追加されます。        </p>        <img src="https://imgur.com/MGswudO.png"/>        <h4>6．求人をポイント決済</h4>        <p>事前に購入されたポイントを使用して求人のポイント決済を行います。 ご注文のお支払金額合計を確認して下さい。<br>            問題がなければ、「購入手続きに進む」をクリックしてポイント決済ページへ進んで下さい。        </p>        <img src="https://imgur.com/MGswudO.png"/>        <h4>7．購入した求人・サービスをそれぞれダウンロード</h4>        <p>「マイページ」内の「注文履歴・購入求人」ページを開くと、購入求人のリストが表示されます。<br>            ダウンロード求人の場合はダウンロードを行い、サービス求人であれば出品者に購入済みの旨を伝え作業を開始してもらいます。        </p>        <img src="https://imgur.com/MGswudO.png"/>    </div></div>\',1,\'2021-11-23 13:27:08\',\'2021-11-23 23:44:32'
        ]);

        DB::table('html_parts')->insert([
            'name' => '販売者ガイド', 'title' => 'guide_sale',
            'desc' => '<div class="l-main">    <h2 class="tos-title">出品者ガイド</h2>    <div class="l-tos-container">        <h4>1．まずは新規会員登録</h4>        <p>新規会員登録は、必要事項を入力するだけでとても簡単です。<br>登録したメールアドレスに届く登録認証メールをクリックし、完了します。        </p>        <img src="https://imgur.com/UUvLz0T.png"/>        <h4>2．サイトにログイン</h4>        <p>会員登録時に入力した登録情報（メールアドレスとパスワード）を入力し、 「ログイン」ボタンをクリックして、ログインして下さい。        </p>        <img src="https://imgur.com/UUvLz0T.png"/>        <h4>3．出品したい求人やサービスを登録する</h4>        <p>左カラムの「求人を出品する」から求人の登録を開始します。<br>出品したい求人名や詳細情報を記入し誓約事項確認をよく確認しチェック入れ出品を完了します。        </p>        <img src="https://imgur.com/UUvLz0T.png"/>        <h4>4．求人が購入される</h4>        <p>求人が購入された場合、ダウンロード求人はすでに登録済みの場合はそのままでも構いません。スキルシェアなどのサービス求人であれば作業を行ないます。<br>この場合、購入者とヒアリングを行った上でサービス完了を目指してください。<br>        </p>        <img src="https://imgur.com/UUvLz0T.png"/>        <h4>5．換金申請の準備をする</h4>        <p>「マイページ」の「登録情報」から会員登録内容を変更します。<br>振込先口座情報を記入し換金申請へ進みます。        </p>        <img src="https://imgur.com/UUvLz0T.png"/>        <h4>6．換金申請をする</h4>        <p>「マイページ」の「売上管理」から換金申請を行います。<br>売り上げ金額が「換金申請できる金額」に到達している場合、換金申請が行えます。        </p>        <img src="https://imgur.com/UUvLz0T.png"/>    </div></div>'
        ]);
        DB::table('html_parts')->insert([
            'name' => 'プライバシーポリシー', 'title' => 'privacy',
            'desc' => '<div class="l-main">    <h2 class="tos-title">個人情報保護について</h2>    <div class="l-tos-container">        <h4>Mallento デモサイトでは個人情報の重要性を確認し、以下の取り組みを実施いたしており</h4><ol><li>Mallento デモサイトでは、お客様個人に関する情報（以下「個人情報」といいます。」を館</li><li>ユーザーの皆様から個人情報を取得させていただく場合は、利用目的をできる限り</li><li>Mallento デモサイトでは、お客様より取得させていただいた個人情報を適切に管理し、以<ol><li>「※この求人を購入すると、ダウンロード会員の氏名がアップロード会員に開示</li><li>「※この求人を購入すると、ダウンロード会員のEメールアドレスがアップロー</li><li> 求人の購入後、ダウンロード会員の意思で、該求人のアップロード会員にダウン...</li><li>※ 利用規約文章は管理画面のページ・CSS編集より編集いただけます。</li></ol></li></ol>    </div></div>'
        ]);
        DB::table('html_parts')->insert([
            'name' => '特定商法取引に基づく表記', 'title' => 'law',
            'desc' => '<div class="l-main">    <h2 class="tos-title">特定商法取引に基づく表記</h2>    <div class="l-tos-container">        <h4>運営サービス</h4><p>Mallento デモサイト</p><h4>運営統括サービス</h4><p>Mallento デモサイト</p><h4>所在地</h4><p>ここに住所を入れる</p><h4>URL</h4><p><a href="http://demo.mallento.com">http://demo.mallento.com</a></p><h4>メールアドレス</h4><p>ここにメールアドレスを入れる</p><h4>返品・キャンセル等</h4><p>サービスの性質上、返品・返金はお受けしておりません。</p><h4>求人の価格</h4><p>求人ごとに表示された税込み価格に基づく。</p><h4>求人代金以外の必要金額</h4><p>銀行振込手数料、通信料、出品者のみ事務手数料</p><h4>ご注文方法</h4><p>オンラインでのみとさせていただきます。</p><h4>お支払い方法</h4><p>銀行振込、クレジットカード決済<br>銀行振込をご希望のお客様は着金後、即日〜2、3日営業日で反映されます。</p><h4>引渡し時期</h4><p>ご入金確認後、クレジットの場合はシステムにより即時ポイント反映します。<br>(ポイントがアカウントに反映された時点で、ポイント購入対象求人をポイント決済後、すぐにご利用が可能です)<br>ダウンロード可能期間は、購入したその日を含む7日間です。<br>スキル求人はポイント決済が完了した時点で着手可能となります。<br>7日間を過ぎますとダウンロードはできませんので、お早めにダウンロードをお願いします。<br>尚、ポイントの有効期限は無期限です。</p>    </div></div>'
        ]);
        DB::table('html_parts')->insert([
            'name' => '運営会社', 'title' => 'about',
            'desc' => '<div class="l-main">    <h2 class="tos-title">運営会社</h2>    <div class="l-tos-container">        <h4>運営会社</h4><p>テキストが入ります</p>        <h4>運営統括責任者</h4><p>テキストが入ります</p>        <h4>所在地</h4><p>テキストが入ります</p>        <h4>販売価格</h4><p>テキストが入ります</p>        <h4>お支払い方法</h4><p>テキストが入ります</p>        <h4>お届け方法</h4><p>テキストが入ります</p>        <h4>お届け期間</h4><p>テキストが入ります</p>        <h4>有効期限</h4><p>テキストが入ります</p>        <h4>求人の返品</h4><p>テキストが入ります</p>        <h4>メールアドレス</h4><p>テキストが入ります</p>        <h4>電話番号</h4><p>テキストが入ります</p>    </div></div>'
        ]);
        DB::table('html_parts')->insert([
            'name' => 'Q＆A', 'title' => 'faq',
            'desc' => '<div class="l-main">    <h2 class="tos-title">よくある質問</h2>    <div class="l-tos-container">        <h4>Q. ここに質問が入ります</h4><p>A. ここにアンサーが入ります。</p>        <h4>Q. ここに質問が入ります</h4><p>A. ここにアンサーが入ります。</p>        <h4>Q. ここに質問が入ります</h4><p>A. ここにアンサーが入ります。</p>        <h4>Q. ここに質問が入ります</h4><p>A. ここにアンサーが入ります。</p>        <h4>Q. ここに質問が入ります</h4><p>A. ここにアンサーが入ります。</p>        <h4>Q. ここに質問が入ります</h4><p>A. ここにアンサーが入ります。</p>        <h4>Q. ここに質問が入ります</h4><p>A. ここにアンサーが入ります。</p>        <h4>Q. ここに質問が入ります</h4><p>A. ここにアンサーが入ります。</p>    </div></div>'
        ]);
        DB::table('html_parts')->insert([
            'name' => 'ロゴ', 'title' => 'logo',
            'desc' => '<a href="/" class="navbar-brand"><img src="/images/icons/logo.svg"></a>'
        ]);
        DB::table('html_parts')->insert([
            'name' => 'スライダー', 'title' => 'top_slider',
            'desc' => '<img class="top-slider-img" src="https://imgur.com/fVhTTl9.png"><img class="top-slider-img" src="https://imgur.com/iQj6DvC.png"><img class="top-slider-img" src="https://imgur.com/ZOICKzd.png"><img class="top-slider-img" src="https://imgur.com/FhPL6gI.png"><img class="top-slider-img" src="/images/sliders/slider1.png"><img class="top-slider-img" src="/images/sliders/slider2.png"><img class="top-slider-img" src="/images/sliders/slider1.png"><img class="top-slider-img" src="/images/sliders/slider2.png"><img class="top-slider-img" src="/images/sliders/slider1.png">'
        ]);
        DB::table('html_parts')->insert([
            'name' => 'SNSリンク', 'title' => 'sns',
            'desc' => '<div class="footer-service-sns-links">    <a href="#"><img src="/images/icons/sns/facebook.svg"></a>    <a href="#"><img src="/images/icons/sns/youtube.svg"></a>    <a href="https://twitter.com/mallentocom"><img src="/images/icons/sns/twitter.svg"></a>    <a href="https://www.instagram.com/mallentocom"><img src="/images/icons/sns/instagram.svg"></a></div>'
        ]);
    }
}