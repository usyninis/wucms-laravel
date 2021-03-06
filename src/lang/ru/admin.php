<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Последующие языковые строки содержат сообщения по-умолчанию, используемые
    | классом, проверяющим значения (валидатором).Некоторые из правил имеют
    | несколько версий, например, size. Вы можете поменять их на любые
    | другие, которые лучше подходят для вашего приложения.
    |
    */

    "accepted"             => "Вы должны принять :attribute.",   
    "fields"  => array(
        "name"		=> "Имя элемента",
        "code"		=> "Код элемента",
        "string"  => "Количество символов в поле :attribute должно быть равным :size.",
        "array"   => "Количество элементов в поле :attribute должно быть равным :size."
    )
);
