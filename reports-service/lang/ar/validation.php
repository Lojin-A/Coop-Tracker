<?php
// lang/ar/validation.php — only the rules I use; anything missing falls back to English

return [
    'required' => 'حقل :attribute مطلوب.',
    'integer'  => 'يجب أن يكون :attribute رقمًا صحيحًا.',
    'string'   => 'يجب أن يكون :attribute نصًا.',
    'file'     => 'يجب أن يكون :attribute ملفًا.',
    'mimes'    => 'يجب أن يكون :attribute ملفًا من نوع: :values.',
    'unique'   => 'قيمة :attribute مستخدمة من قبل.',
    'in'       => 'القيمة المختارة في :attribute غير صحيحة.',
    'min' => [
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
    ],
    'max' => [
        'numeric' => 'يجب ألا يزيد :attribute عن :max.',
        'file'    => 'يجب ألا يزيد حجم :attribute عن :max كيلوبايت.',
    ],

    // Arabic names for the fields, instead of "week no" and "placement id"
    'attributes' => [
        'week_no'          => 'الأسبوع',
        'content'          => 'الملاحظات',
        'attachment'       => 'المرفق',
        'feedback'         => 'ملاحظات المشرف',
        'decision'         => 'القرار',
        'placement_id'     => 'التدريب',
        'technical_skills' => 'المهارات التقنية',
        'teamwork'         => 'العمل الجماعي',
        'communication'    => 'التواصل',
        'punctuality'      => 'الالتزام بالوقت',
        'initiative'       => 'المبادرة',
        'comments'         => 'الملاحظات',
    ],
];
