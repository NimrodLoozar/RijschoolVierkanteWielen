<?php
return [
    'accepted'        => ':attribute kabul edilmelidir.',
    'active_url'      => ':attribute geçerli bir URL değildir.',
    'after'           => ':attribute :date tarihinden sonraki bir tarih olmalıdır.',
    'after_or_equal'  => ':attribute :date tarihine eşit ya da daha sonraki bir tarih olmalıdır.',
    'alpha'           => ':attribute yalnızca harf içerebilir.',
    'alpha_dash'      => ':attribute yalnızca harf, sayı, tire ve alt çizgi içerebilir.',
    'alpha_num'       => ':attribute yalnızca harf ve sayı içerebilir.',
    'array'           => ':attribute bir dizi olmalıdır.',
    'before'          => ':attribute :date tarihinden önce bir tarih olmalıdır.',
    'before_or_equal' => ':attribute :date tarihine eşit ya da önce bir tarih olmalıdır.',
    'between'         => [
        'numeric' => ':attribute :min ile :max arasında olmalıdır.',
        'file'    => ':attribute :min ile :max kilobayt arasında olmalıdır.',
        'string'  => ':attribute :min ile :max karakter arasında olmalıdır.',
        'array'   => ':attribute en az :min, en fazla :max öğe içermelidir.',
    ],
    'boolean'        => ':attribute alanı doğru ya da yanlış olmalıdır.',
    'confirmed'      => ':attribute onayı eşleşmiyor.',
    'date'           => ':attribute geçerli bir tarih değildir.',
    'date_equals'    => ':attribute :date tarihine eşit bir tarih olmalıdır.',
    'date_format'    => ':attribute, :format biçimiyle eşleşmiyor.',
    'different'      => ':attribute ile :other farklı olmalıdır.',
    'digits'         => ':attribute :digits rakam olmalıdır.',
    'digits_between' => ':attribute :min ile :max rakam arasında olmalıdır.',
    'dimensions'     => ':attribute geçersiz resim boyutlarına sahip.',
    'distinct'       => ':attribute alanı yinelenen bir değere sahip.',
    'email'          => ':attribute geçerli bir e‑posta adresi olmalı.',
    'ends_with'      => ':attribute şunlardan biriyle bitmelidir: :values.',
    'exists'         => 'Seçili :attribute geçersiz.',
    'file'           => ':attribute bir dosya olmalıdır.',
    'filled'         => ':attribute alanı bir değere sahip olmalıdır.',
    'gt'             => [
        'numeric' => ':attribute, :value değerinden büyük olmalıdır.',
        'file'    => ':attribute, :value kilobayttan büyük olmalıdır.',
        'string'  => ':attribute, :value karakterden uzun olmalıdır.',
        'array'   => ':attribute, :value öğeden fazla içermelidir.',
    ],
    'gte'            => [
        'numeric' => ':attribute, :value değerine eşit ya da ondan büyük olmalıdır.',
        'file'    => ':attribute, :value kilobayta eşit ya da daha büyük olmalıdır.',
        'string'  => ':attribute, :value karaktere eşit ya da uzun olmalıdır.',
        'array'   => ':attribute en az :value öğe içermelidir.',
    ],
    'image'    => ':attribute bir resim olmalıdır.',
    'in'       => 'Seçili :attribute geçersiz.',
    'in_array' => ':attribute alanı :other içinde yok.',
    'integer'  => ':attribute bir tam sayı olmalıdır.',
    'ip'       => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4'     => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6'     => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json'     => ':attribute geçerli bir JSON dizesi olmalıdır.',
    'lt'       => [
        'numeric' => ':attribute, :value değerinden küçük olmalıdır.',
        'file'    => ':attribute, :value kilobayttan küçük olmalıdır.',
        'string'  => ':attribute, :value karakterden kısa olmalıdır.',
        'array'   => ':attribute, :value öğeden az içermelidir.',
    ],
    'lte'      => [
        'numeric' => ':attribute, :value değerine eşit ya da daha küçük olmalıdır.',
        'file'    => ':attribute, :value kilobayta eşit ya da daha küçük olmalıdır.',
        'string'  => ':attribute, :value karaktere eşit ya da kısa olmalıdır.',
        'array'   => ':attribute en fazla :value öğe içerebilir.',
    ],
    'max'      => [
        'numeric' => ':attribute :max değerinden büyük olamaz.',
        'file'    => ':attribute :max kilobayttan büyük olamaz.',
        'string'  => ':attribute :max karakterden uzun olamaz.',
        'array'   => ':attribute en fazla :max öğe içerebilir.',
    ],
    'mimes'     => ':attribute şu dosya türlerinden biri olmalıdır: :values.',
    'mimetypes' => ':attribute şu dosya türlerinden biri olmalıdır: :values.',
    'min'       => [
        'numeric' => ':attribute en az :min olmalıdır.',
        'file'    => ':attribute en az :min kilobayt olmalıdır.',
        'string'  => ':attribute en az :min karakter olmalıdır.',
        'array'   => ':attribute en az :min öğe içermelidir.',
    ],
    'not_in'        => 'Seçili :attribute geçersiz.',
    'not_regex'     => ':attribute biçimi geçersiz.',
    'numeric'       => ':attribute bir sayı olmalıdır.',
    'password'      => 'Parola yanlış.',
    'present'       => ':attribute alanı mevcut olmalıdır.',
    'regex'         => ':attribute biçimi geçersiz.',
    'required'      => ':attribute alanı gereklidir.',
    'required_if'   => ':attribute alanı, :other :value olduğunda gereklidir.',
    'required_unless' => ':attribute alanı, :other :values içinde olmadıkça gereklidir.',
    'required_with'     => ':attribute alanı, :values mevcut olduğunda gereklidir.',
    'required_with_all' => ':attribute alanı, :values tümü mevcut olduğunda gereklidir.',
    'required_without'  => ':attribute alanı, :values mevcut olmadığında gereklidir.',
    'required_without_all' => ':attribute alanı, :values hiçbirisi mevcut olmadığında gereklidir.',
    'same'       => ':attribute ile :other eşleşmelidir.',
    'size'       => [
        'numeric' => ':attribute :size olmalıdır.',
        'file'    => ':attribute :size kilobayt olmalıdır.',
        'string'  => ':attribute :size karakter olmalıdır.',
        'array'   => ':attribute :size öğe içermelidir.',
    ],
    'starts_with' => ':attribute şu ifadelerden biriyle başlamalıdır: :values.',
    'string'       => ':attribute bir dize olmalıdır.',
    'timezone'     => ':attribute geçerli bir bölge olmalıdır.',
    'unique'       => ':attribute zaten alınmış.',
    'uploaded'     => ':attribute yüklenemedi.',
    'url'          => ':attribute biçimi geçersiz.',
    'uuid'         => ':attribute geçerli bir UUID olmalıdır.',

    /*
|--------------------------------------------------------------------------
| Özel Doğrulama Mesajları
|--------------------------------------------------------------------------
*/
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
|--------------------------------------------------------------------------
| Özel Doğrulama Özellik İsimleri
|--------------------------------------------------------------------------
*/
    'attributes' => [],
];
