<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 驗證語言行
    |--------------------------------------------------------------------------
    |
    | 以下語言行包含驗證器類使用的默認錯誤消息。其中一些規則有多個版本，
    | 例如大小規則。您可以在此隨意修改這些消息。
    |
    */

    'accepted' => ':attribute必須被接受。',
    'accepted_if' => '當:other為:value時，:attribute必須被接受。',
    'active_url' => ':attribute必須是有效的網址。',
    'after' => ':attribute必須是:date之後的日期。',
    'after_or_equal' => ':attribute必須是等於或晚於:date的日期。',
    'alpha' => ':attribute只能包含字母。',
    'alpha_dash' => ':attribute只能包含字母、數字、破折號和底線。',
    'alpha_num' => ':attribute只能包含字母和數字。',
    'array' => ':attribute必須是一個數組。',
    'ascii' => ':attribute只能包含單字節的字母數字字符和符號。',
    'before' => ':attribute必須是:date之前的日期。',
    'before_or_equal' => ':attribute必須是等於或早於:date的日期。',
    'between' => [
        'array' => ':attribute必須有:min到:max個項目。',
        'file' => ':attribute必須在:min到:max KB之間。',
        'numeric' => ':attribute必須在:min到:max之間。',
        'string' => ':attribute必須在:min到:max個字符之間。',
    ],
    'boolean' => ':attribute字段必須為true或false。',
    'can' => ':attribute字段包含未經授權的值。',
    'confirmed' => ':attribute確認不匹配。',
    'current_password' => '密碼不正確。',
    'date' => ':attribute必須是有效的日期。',
    'date_equals' => ':attribute必須等於:date。',
    'date_format' => ':attribute必須符合格式:format。',
    'decimal' => ':attribute必須有:decimal位小數。',
    'declined' => ':attribute必須被拒絕。',
    'declined_if' => '當:other為:value時，:attribute必須被拒絕。',
    'different' => ':attribute和:other必須不同。',
    'digits' => ':attribute必須是:digits位數字。',
    'digits_between' => ':attribute必須在:min到:max位之間。',
    'dimensions' => ':attribute具有無效的圖片尺寸。',
    'distinct' => ':attribute字段具有重複值。',
    'doesnt_end_with' => ':attribute不能以下列之一結尾：:values。',
    'doesnt_start_with' => ':attribute不能以下列之一開頭：:values。',
    'email' => ':attribute必須是有效的電子郵件地址。',
    'ends_with' => ':attribute必須以下列之一結尾：:values。',
    'enum' => '所選的:attribute無效。',
    'exists' => '所選的:attribute無效。',
    'extensions' => ':attribute必須具有以下擴展名之一：:values。',
    'file' => ':attribute必須是一個文件。',
    'filled' => ':attribute字段必須有一個值。',
    'gt' => [
        'array' => ':attribute必須有多於:value個項目。',
        'file' => ':attribute必須大於:value KB。',
        'numeric' => ':attribute必須大於:value。',
        'string' => ':attribute必須多於:value個字符。',
    ],
    'gte' => [
        'array' => ':attribute必須有:value個或更多項目。',
        'file' => ':attribute必須大於或等於:value KB。',
        'numeric' => ':attribute必須大於或等於:value。',
        'string' => ':attribute必須多於或等於:value個字符。',
    ],
    'hex_color' => ':attribute必須是有效的十六進制顏色。',
    'image' => ':attribute必須是圖片。',
    'in' => '所選的:attribute無效。',
    'in_array' => ':attribute字段必須存在於:other中。',
    'integer' => ':attribute必須是整數。',
    'ip' => ':attribute必須是有效的IP地址。',
    'ipv4' => ':attribute必須是有效的IPv4地址。',
    'ipv6' => ':attribute必須是有效的IPv6地址。',
    'json' => ':attribute必須是有效的JSON字符串。',
    'lowercase' => ':attribute必須是小寫。',
    'lt' => [
        'array' => ':attribute必須少於:value個項目。',
        'file' => ':attribute必須小於:value KB。',
        'numeric' => ':attribute必須小於:value。',
        'string' => ':attribute必須少於:value個字符。',
    ],
    'lte' => [
        'array' => ':attribute不能有多於:value個項目。',
        'file' => ':attribute必須小於或等於:value KB。',
        'numeric' => ':attribute必須小於或等於:value。',
        'string' => ':attribute必須少於或等於:value個字符。',
    ],
    'mac_address' => ':attribute必須是有效的MAC地址。',
    'max' => [
        'array' => ':attribute不能有多於:max個項目。',
        'file' => ':attribute不能大於:max KB。',
        'numeric' => ':attribute不能大於:max。',
        'string' => ':attribute不能多於:max個字符。',
    ],
    'max_digits' => ':attribute不能超過:max位數字。',
    'mimes' => ':attribute必須是類型為:values的文件。',
    'mimetypes' => ':attribute必須是類型為:values的文件。',
    'min' => [
        'array' => ':attribute必須至少有:min個項目。',
        'file' => ':attribute必須至少為:min KB。',
        'numeric' => ':attribute必須至少為:min。',
        'string' => ':attribute必須至少為:min個字符。',
    ],
    'min_digits' => ':attribute必須至少有:min位數字。',
    'missing' => ':attribute字段必須缺失。',
    'missing_if' => '當:other為:value時，:attribute字段必須缺失。',
    'missing_unless' => ':attribute字段必須缺失，除非:other為:value。',
    'missing_with' => '當:values存在時，:attribute字段必須缺失。',
    'missing_with_all' => '當:values都存在時，:attribute字段必須缺失。',
    'multiple_of' => ':attribute必須是:value的倍數。',
    'not_in' => '所選的:attribute無效。',
    'not_regex' => ':attribute格式無效。',
    'numeric' => ':attribute必須是一個數字。',
    'password' => [
        'letters' => ':attribute必須包含至少一個字母。',
        'mixed' => ':attribute必須包含至少一個大寫字母和一個小寫字母。',
        'numbers' => ':attribute必須包含至少一個數字。',
        'symbols' => ':attribute必須包含至少一個符號。',
        'uncompromised' => '給定的:attribute已出現在數據洩露中。請選擇一個不同的:attribute。',
    ],
    'present' => ':attribute字段必須存在。',
    'present_if' => '當:other為:value時，:attribute字段必須存在。',
    'present_unless' => ':attribute字段必須存在，除非:other為:value。',
    'present_with' => '當:values存在時，:attribute字段必須存在。',
    'present_with_all' => '當:values都存在時，:attribute字段必須存在。',
    'prohibited' => ':attribute字段被禁止。',
    'prohibited_if' => '當:other為:value時，:attribute字段被禁止。',
    'prohibited_unless' => ':attribute字段被禁止，除非:other在:values中。',
    'prohibits' => ':attribute字段禁止:other存在。',
    'regex' => ':attribute格式無效。',
    'required' => ':attribute字段是必需的。',
    'required_array_keys' => ':attribute字段必須包含以下條目：:values。',
    'required_if' => '當:other為:value時，:attribute字段是必需的。',
    'required_if_accepted' => '當:other被接受時，:attribute字段是必需的。',
    'required_unless' => ':attribute字段是必需的，除非:other在:values中。',
    'required_with' => '當:values存在時，:attribute字段是必需的。',
    'required_with_all' => '當:values都存在時，:attribute字段是必需的。',
    'required_without' => '當:values不存在時，:attribute字段是必需的。',
    'required_without_all' => '當:values都不存在時，:attribute字段是必需的。',
    'same' => ':attribute必須與:other相匹配。',
    'size' => [
        'array' => ':attribute必須包含:size個項目。',
        'file' => ':attribute必須為:size KB。',
        'numeric' => ':attribute必須為:size。',
        'string' => ':attribute必須為:size個字符。',
    ],
    'starts_with' => ':attribute必須以下列之一開頭：:values。',
    'string' => ':attribute必須是一個字符串。',
    'timezone' => ':attribute必須是有效的時區。',
    'unique' => ':attribute已經被使用。',
    'uploaded' => ':attribute上傳失敗。',
    'uppercase' => ':attribute必須是大寫。',
    'url' => ':attribute必須是有效的URL。',
    'ulid' => ':attribute必須是有效的ULID。',
    'uuid' => ':attribute必須是有效的UUID。',

    /*
    |--------------------------------------------------------------------------
    | 自定義驗證語言行
    |--------------------------------------------------------------------------
    |
    | 在此處，您可以為屬性使用"attribute.rule"約定來指定自定義驗證消息。
    | 這使得可以快速為給定的屬性規則指定特定的自定義語言行。
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => '自定義消息',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 自定義驗證屬性
    |--------------------------------------------------------------------------
    |
    | 以下語言行用於將屬性佔位符替換為更易讀的內容，例如用"電子郵件地址"
    | 替換"email"。這只是幫助我們使消息更具表現力。
    |
    */

    'attributes' => [
    'username' => '帳號',
    'password' => '密碼',
    'new_password' => '新密碼',
    'new_password_confirmation' => '確認新密碼',
    'email' => '電子郵件',
    'name' => '名字',
    'first_name' => '名字',
    'last_name' => '姓氏',
    'address' => '地址',
    'phone' => '電話',
    'mobile' => '手機',
    'age' => '年齡',
    'sex' => '性別',
    'gender' => '性別',
    'day' => '天',
    'month' => '月',
    'year' => '年',
    'hour' => '小時',
    'minute' => '分鐘',
    'second' => '秒',
    'title' => '標題',
    'content' => '內容',
    'description' => '描述',
    'excerpt' => '摘要',
    'date' => '日期',
    'time' => '時間',
    'available' => '可用的',
    'size' => '大小',
],
];