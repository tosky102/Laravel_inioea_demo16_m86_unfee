<?php


namespace App\Http\Traits;

use Illuminate\Http\Request;

trait RequestTrait {

    public function multiSubmitCheck(Request $request)
    {
        // Sessionオブジェクト(Store.php)
        $session = $request->session();
        // Sessionオブジェクトを最新化
        $session->start();
        // csrfトークンと画面パラメータのcsrfトークンの値が異なる場合エラー
        if ($session->token() != $request->input('_token')) {
            return false;
        }
        // csrfトークンの再生成
        // Store #regenerate によるセッションID再生成でもトークンの再生成が行われる
        $session->regenerateToken();
        // Sessionを保存
        $session->save();

        return true;
    }
}