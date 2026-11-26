<?php

return [
    'required'  => 'حقل :attribute مطلوب.',
    'email'     => 'يجب أن يكون :attribute بريداً إلكترونياً صحيحاً.',
    'unique'    => ':attribute مستخدم من قبل.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'exists'    => ':attribute المحدد غير صالح.',
    'in'        => ':attribute المحدد غير صالح.',
    'string'    => 'يجب أن يكون :attribute نصاً.',
    'integer'   => 'يجب أن يكون :attribute رقماً صحيحاً.',
    'date'      => ':attribute ليس تاريخاً صالحاً.',
    'after'     => 'يجب أن يكون :attribute تاريخاً بعد :date.',
    'max' => [
        'string'  => 'يجب ألا يزيد :attribute عن :max حرفاً.',
        'numeric' => 'يجب ألا يزيد :attribute عن :max.',
    ],
    'min' => [
        'string'  => 'يجب ألا يقل :attribute عن :min أحرف.',
        'numeric' => 'يجب ألا يقل :attribute عن :min.',
    ],

    // Friendly names shown instead of the field names
    'attributes' => [
        'name'           => 'الاسم',
        'email'          => 'البريد الإلكتروني',
        'password'       => 'كلمة المرور',
        'city'           => 'المدينة',
        'field'          => 'المجال',
        'seats'          => 'المقاعد',
        'student_id'     => 'الطالب',
        'supervisor_id'  => 'المشرف',
        'company_id'     => 'الشركة',
        'start_date'     => 'تاريخ البداية',
        'end_date'       => 'تاريخ النهاية',
        'required_weeks' => 'الأسابيع المطلوبة',
        'status'         => 'الحالة',
    ],

    'custom' => [
        'student_id' => [
            'unique' => 'هذا الطالب لديه تعيين بالفعل.',
        ],
    ],
];