<?php

use Common\Rule\Rule;

return [
    /*
      |--------------------------------------------------------------------------
      | Validation Language Linesخطوط لغة التحقق
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | such as the size rules. Feel free to tweak each of these messages.

      |تحتوي سطور اللغة التالية على رسائل الخطأ الافتراضية التي يستخدمها
      | فئة المدقق. بعض هذه القواعد لها إصدارات متعددة مثل
      | .مثل قواعد الحجم. لا تتردد في تعديل كل من هذه الرسائل
     */
    'accepted' => 'يجب قبول السمة:.',
    'active_url' => 'السمة: ليست عنوان URL صالحًا.',
    'after' => 'The :يجب أن تكون السمة تاريخًا بعد: التاريخ.',
    'after_or_equal' => 'يجب أن تكون السمة تاريخًا بعد: التاريخ أو مساويًا له.',
    'alpha' => 'لا يجوز أن تحتوي السمة: إلا على أحرف.',
    'alpha_dash' => 'لا يجوز أن تحتوي السمة: إلا على أحرف وأرقام وشرطات.',
    'alpha_num' => 'لا يجوز أن تحتوي السمة: إلا على أحرف وأرقام.',
    'array' => 'يجب أن تكون السمة مصفوفة.',
    'before' => 'يجب أن تكون السمة تاريخًا قبل: التاريخ.',
    'before_or_equal' => 'يجب أن تكون السمة تاريخًا يسبق: التاريخ أو مساويًا له.',
    'between' => [
        'numeric' => 'يجب أن تكون السمة: بين: min و: max.',
        'file' => 'يجب أن تكون السمة: بين: min و: max كيلوبايت.',
        'string' => 'يجب أن تكون السمة: بين: min و: max حرفًا.',
        'array' => 'يجب أن تحتوي السمة: على ما بين: min و: max من العناصر.',
    ],
    'boolean' => 'يجب أن يكون حقل السمة صحيحًا أو خطأً.',
    'confirmed' => 'تأكيد السمة غير مطابق.',
    'date' => 'السمة: ليست تاريخًا صالحًا.',
    'date_format' => 'السمة: لا تطابق التنسيق: format.',
    'different' => 'يجب أن يكون: السمة و: الآخر مختلفين.',
    'digits' => 'يجب أن تكون السمة: أرقامًا.',
    'digits_between' => 'يجب أن تكون السمة: بين: min و: max أرقام.',
    'dimensions' => 'السمة لها أبعاد صورة غير صالحة.',
    'distinct' => 'يحتوي حقل السمة على قيمة مكررة.',
    'email' => 'يجب أن تكون السمة عنوان بريد إلكتروني صالحًا.',
    'exists' => 'السمة المحددة: غير صالحة.',
    'file' => 'يجب أن تكون السمة: ملفًا.',
    'filled' => 'يجب أن يحتوي حقل السمة على قيمة.',
    'image' => 'يجب أن تكون السمة صورة.',
    'in' => 'السمة المحددة: غير صالحة.',
    'in_array' => 'حقل السمة: غير موجود في: أخرى.',
    'integer' => 'يجب أن تكون السمة عددًا صحيحًا.',
    'ip' => 'يجب أن تكون السمة: عنوان IP صالحًا.',
    'ipv4' => 'يجب أن تكون السمة: عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن تكون السمة عنوان IPv6 صالحًا.',
    'json' => 'يجب أن تكون السمة: سلسلة JSON صالحة.',
    'max' => [
        'numeric' => 'لا يجوز أن تكون السمة: أكبر من: max.',
        'file' => 'لا يجوز أن تكون السمة: أكبر من: أقصى كيلوبايت.',
        'string' => 'لا يجوز أن تكون السمة: أكبر من: الحد الأقصى من الأحرف.',
        'array' => 'لا يجوز أن تحتوي السمة: على أكثر من: max items.',
    ],
    'mimes' => 'يجب أن تكون السمة: ملفًا من النوع: القيم.',
    'mimetypes' => 'يجب أن تكون السمة: ملفًا من النوع: القيم.',
    'min' => [
        'numeric' => 'يجب أن تكون السمة: min.',
        'file' => 'يجب أن تكون السمة: على الأقل: دقيقة كيلوبايت.',
        'string' => 'يجب ألا تقل السمة: عن: min حرفًا.',
        'array' => 'يجب أن تحتوي السمة: على الأقل على: min من العناصر.',
    ],
    'not_in' => 'السمة المحددة: غير صالحة.',
    'not_regex' => 'تنسيق السمة: غير صالح.',
    'numeric' => 'يجب أن تكون السمة رقمًا.',
    'present' => 'يجب أن يكون حقل السمة موجودًا.',
    'regex' => 'تنسيق السمة: غير صالح.',
    'required' => ': حقل السمة مطلوب.',
    'required_if' => 'يكون حقل السمة مطلوبًا عندما: الآخر هو: القيمة.',
    'required_unless' => 'حقل السمة مطلوب إلا إذا كان الآخر في: قيم.',
    'required_with' => 'يكون حقل السمة مطلوبًا عندما تكون: القيم موجودة.',
    'required_with_all' => 'يكون حقل السمة مطلوبًا عندما تكون: القيم موجودة.',
    'required_without' => 'يكون حقل السمة مطلوبًا عندما: القيم غير موجودة.',
    'required_without_all' => 'يكون حقل السمة مطلوبًا في حالة عدم وجود أي من: القيم.',
    'same' => 'يجب أن يتطابق السمة: و: الآخر.',
    'size' => [
        'numeric' => 'يجب أن تكون السمة: الحجم.',
        'file' => 'يجب أن تكون السمة: الحجم كيلوبايت.',
        'string' => 'يجب أن تكون السمة: أحرف الحجم.',
        'array' => 'يجب أن تحتوي السمة: على عناصر الحجم.',
    ],
    'string' => 'يجب أن تكون السمة: سلسلة.',
    'timezone' => 'يجب أن تكون السمة: منطقة صالحة.',
    'unique' => 'تم استخدام السمة: بالفعل.',
    'uploaded' => 'فشل تحميل السمة:.',
    'url' => 'تنسيق السمة: غير صالح.',
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines خطوط لغة التحقق المخصصة
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention 'attribute.rule' to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributesسمات التحقق المخصصة
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of 'email'. This simply helps us make messages a little cleaner.
      |
     */
    'attributes' => array_merge([
            ], Rule::$attributes),
];
