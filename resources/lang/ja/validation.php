<?php

return [
    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行はバリデタークラスにより使用されるデフォルトのエラー
    | メッセージです。サイズルールのようにいくつかのバリデーションを
    | 持っているものもあります。メッセージはご自由に調整してください。
    |
    */

    'accepted' => ':attributeを承認してください。',
    'active_url' => ':attributeが有効なURLではありません。',
    'after' => ':attributeには、:dateより後の日付を指定してください。',
    'after_or_equal' => ':attributeには、:date以前の日付を指定してください。',
    'alpha' => ':attributeはアルファベットのみがご利用できます。',
    'alpha_dash' => ':attributeはアルファベットとダッシュ(-)及び下線(_)がご利用できます。',
    'alpha_num' => ':attributeはアルファベット数字がご利用できます。',
    'array' => ':attributeは配列でなくてはなりません。',
    'before' => ':attributeには、:dateより前の日付をご利用ください。',
    'before_or_equal' => ':attributeには、:date以前の日付をご利用ください。',
    'between' => [
        'numeric' => ':attributeは、:minから:maxの間で指定してください。',
        'file' => ':attributeは、:min kBから、:max kBの間で指定してください。',
        'string' => ':attributeは、:min文字から、:max文字の間で指定してください。',
        'array' => ':attributeは、:min個から:max個の間で指定してください。',
    ],
    'boolean' => ':attributeは、trueかfalseを指定してください。',
    'confirmed' => ':attributeと、確認フィールドとが、一致していません。',
    'date' => ':attributeには有効な日付を指定してください。',
    'date_format' => ':attributeは:format形式で指定してください。',
    'different' => ':attributeと:otherには、異なった内容を指定してください。',
    'digits' => ':attributeは:digits桁で指定してください。',
    'digits_between' => ':attributeは:min桁から:max桁の間で指定してください。',
    'dimensions' => ':attributeの図形サイズが正しくありません。',
    'distinct' => ':attributeには異なった値を指定してください。',
    'email' => ':attributeには、有効なメールアドレスを指定してください。',
    'exists' => '選択された:attributeは正しくありません。',
    'file' => ':attributeにはファイルを指定してください。',
    'filled' => ':attributeに値を指定してください。',
    'gt' => [
        'numeric' => ':attributeには、:valueより大きな値を指定してください。',
        'file' => ':attributeには、:value kBより大きなファイルを指定してください。',
        'string' => ':attributeは、:value文字より長く指定してください。',
        'array' => ':attributeには、:value個より多くのアイテムを指定してください。',
    ],
    'gte' => [
        'numeric' => ':attributeには、:value以上の値を指定してください。',
        'file' => ':attributeには、:value kB以上のファイルを指定してください。',
        'string' => ':attributeは、:value文字以上で指定してください。',
        'array' => ':attributeには、:value個以上のアイテムを指定してください。',
    ],
    'image' => ':attributeには画像ファイルを指定してください。',
    'in' => '選択された:attributeは正しくありません。',
    'in_array' => ':attributeには:otherの値を指定してください。',
    'integer' => ':attributeは整数で指定してください。',
    'ip' => ':attributeには、有効なIPアドレスを指定してください。',
    'ipv4' => ':attributeには、有効なIPv4アドレスを指定してください。',
    'ipv6' => ':attributeには、有効なIPv6アドレスを指定してください。',
    'json' => ':attributeには、有効なJSON文字列を指定してください。',
    'lt' => [
        'numeric' => ':attributeには、:valueより小さな値を指定してください。',
        'file' => ':attributeには、:value kBより小さなファイルを指定してください。',
        'string' => ':attributeは、:value文字より短く指定してください。',
        'array' => ':attributeには、:value個より少ないアイテムを指定してください。',
    ],
    'lte' => [
        'numeric' => ':attributeには、:value以下の値を指定してください。',
        'file' => ':attributeには、:value kB以下のファイルを指定してください。',
        'string' => ':attributeは、:valueつ以下で指定してください。',
        'array' => ':attributeには、:value個以下のアイテムを指定してください。',
    ],
    'max' => [
        'numeric' => ':attributeには、:max以下の数字を指定してください。',
        'file' => ':attributeには、:max kB以下のファイルを指定してください。',
        'string' => ':attributeは、:max文字以下で指定してください。',
        'array' => ':attributeは:max個以下指定してください。',
    ],
    'mimes' => ':attributeには:valuesタイプのファイルを指定してください。',
    'mimetypes' => ':attributeには:valuesタイプのファイルを指定してください。',
    'min' => [
        'numeric' => ':attributeには、:min以上の数字を指定してください。',
        'file' => ':attributeには、:min kB以上のファイルを指定してください。',
        'string' => ':attributeは、:min文字以上で指定してください。',
        'array' => ':attributeは:min個以上指定してください。',
    ],
    'not_in' => '選択された:attributeは正しくありません。',
    'not_regex' => ':attributeの形式が正しくありません。',
    'numeric' => ':attributeには、数字を指定してください。',
    'present' => ':attributeが存在していません。',
    'regex' => ':attributeに正しい形式を指定してください。',
    'required' => ':attributeは必ず指定してください。',
    'required_if' => ':otherが:valueの場合、:attributeも指定してください。',
    'required_unless' => ':otherが:valuesでない場合、:attributeを指定してください。',
    'required_with' => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_with_all' => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_without' => ':valuesを指定しない場合は、:attributeを指定してください。',
    'required_without_all' => ':valuesのどれも指定しない場合は、:attributeを指定してください。',
    'same' => ':attributeと:otherには同じ値を指定してください。',
    'size' => [
        'numeric' => ':attributeは:sizeを指定してください。',
        'file' => ':attributeのファイルは、:sizeキロバイトでなくてはなりません。',
        'string' => ':attributeは:size文字で指定してください。',
        'array' => ':attributeは:size個指定してください。',
    ],
    'string' => ':attributeは文字列を指定してください。',
    'timezone' => ':attributeには、有効なゾーンを指定してください。',
    'unique' => ':attributeの値は既に存在しています。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'url' => ':attributeに正しい形式を指定してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | "属性.ルール"の規約でキーを指定することでカスタムバリデーション
    | メッセージを定義できます。指定した属性ルールに対する特定の
    | カスタム言語行を手早く指定できます。
    |
    */

    'custom' => [
        '属性名' => [
            'ルール名' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、例えば"email"の代わりに「メールアドレス」のように、
    | 読み手にフレンドリーな表現でプレースホルダーを置き換えるために指定する
    | 言語行です。これはメッセージをよりきれいに表示するために役に立ちます。
    |
    */

    'attributes' => [
        'name' => '氏名',
        'name_kana' => '氏名（フリガナ）',
        'company' => '運営会社または屋号',
        'facility_name' => '施設名',
        'main_category' => 'カテゴリー',
        'sub_category' => 'サブカテゴリー',
        'language' => '話せる言語',
        'other_language' => 'その他の言語',
        'postcode' => '郵便番号',
        'pref' => '都道府県',
        'city' => '市区町村',
        'address' => '住所',
        'phone' => '電話番号',
        'birthday' => '生年月日',
        'nickname' => 'ニックネーム',
        'manager_name' => '担当者名',
        'manager_position' => '担当者役職',
        'manager_phone' => '担当者電話番号',
        'employee_count' => '従業員数 ',
        'earning' => '年商',
        'company_qualification' => '得意分野',
        'specialty' => '得意分野',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'profile_img' => 'プロフィール画像',
        'profile_img_tmp' => 'プロフィール画像',
        'univ' => '学校名',
        'tel' => '電話番号',
        'hobby' => '趣味',
        'graduate_year' => '卒業年度',
        'gender' => '性別',
        'major' => '専攻',
        'area' => '活動エリア',
        'other_area' => '海外の活動エリア',
        'interest' => '興味のある業界',
        'personal' => '得意なことタグ',
        'auth01' => '学生証',
        'auth02' => '学生証',
        'auth01_tmp' => '学生証',
        'auth02_tmp' => '学生証',
        'valid_flag' => 'ステータス', // dragon_valid_flag
        'type' => 'タイプ',  // dragon valid_flag
        'near_station' => '最寄駅',
        'site' => 'コーポレートサイトリンク',
        'ticket' => 'チケット',
        'amount' => '金額',
        'bank_name' => '銀行名',
        'account_type' => '口座種別',
        'branch_name' => '支店',
        'account_number' => '口座番号',
        'account_name' => '名前',
        'major_id' => '専攻',
        'job_hunting' => '就活意思',
        'intern' => 'インターン',
        'interest_tags' => '興味のある業界',
        'personal_tags' => '得意なことタグ',
        'unique_tags' => 'ユニークタグ',
        'areas' => '希望エリア',
        'areas' => '希望エリア',
        'areas' => '希望エリア',
        'areas' => '希望エリア',

        'title' => 'タイトル',
        'is_offering' => '同伴者への提供',
        'business_name' => '企業名',
        'address3' => '勤務先住所（それ以降）',
        'price' => '価格',
        'description' => '採用担当者へのメッセージ・自己PR',
        'images.0.url' => '少なくとも１つの画像',
        'agree' => '契約事項確認',
        'money' => '換金申請する金額',
        'content' => '内容',
        'comment' => 'プロフィール紹介文',
        'station' => '住所（最寄駅）',
        'wage' => '希望時給',
        'timetable' => '勤務可能な時間帯・曜日',
        'qualification' => '免許・資格',
        'employment' => '募集する雇用形態',
        'career' => '募集する職務経験',
        'duration' => '希望する開く時間',
        'message' => '購入者へメッセージ',
        'image' => 'イメージ',
        'feature' => '待遇',
        'feature' => '待遇',
        'appeal_point' => 'お店のPR',
        'website' => '参考URL',
        'post_type' => '投稿形式',
        'hash_tag' => 'ハッシュタグ',
        'pr_account' => 'PR投稿に載せる指定アカウント',
        'pr_flow' => 'PR投稿の流れ',
        'pr_rule' => 'PR投稿ルール',
        'condition' => '使用条件',
        'entry_follower' => 'フォロワー数',
        'entry_method' => '応募方法',
        'genre' => 'お仕事ジャンル',
        'genre_other' => 'その他のお仕事ジャンル',
    ],
];
