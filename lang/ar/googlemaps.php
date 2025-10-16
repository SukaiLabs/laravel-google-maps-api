<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps Package - Arabic Translations
    |--------------------------------------------------------------------------
    */

    // General Messages
    'messages' => [
        'api_key_not_configured' => 'مفتاح Google Maps API غير مهيأ',
        'failed_to_fetch_suggestions' => 'فشل في جلب اقتراحات الإكمال التلقائي',
        'failed_to_geocode' => 'فشل في تحديد إحداثيات العنوان',
        'failed_to_reverse_geocode' => 'فشل في تحديد العنوان من الإحداثيات',
        'failed_to_fetch_place_details' => 'فشل في جلب تفاصيل المكان',
        'google_api_error' => 'خطأ في Google Places API',
        'address_saved' => 'تم حفظ العنوان بنجاح',
        'address_updated' => 'تم تحديث العنوان بنجاح',
        'address_deleted' => 'تم حذف العنوان بنجاح',
        'unauthorized' => 'غير مصرح لك بتنفيذ هذا الإجراء',
    ],

    // Validation Messages
    'validation' => [
        'input' => [
            'required' => 'مدخل البحث مطلوب',
            'min' => 'يجب أن يحتوي مدخل البحث على :min حرفًا على الأقل',
            'max' => 'يجب ألا يتجاوز مدخل البحث :max حرفًا',
        ],
        'address' => [
            'required' => 'العنوان مطلوب',
            'min' => 'يجب أن يحتوي العنوان على :min حرفًا على الأقل',
            'max' => 'يجب ألا يتجاوز العنوان :max حرفًا',
        ],
        'latitude' => [
            'required' => 'خط العرض مطلوب',
            'numeric' => 'يجب أن يكون خط العرض رقمًا',
            'between' => 'يجب أن يكون خط العرض بين :min و :max',
        ],
        'longitude' => [
            'required' => 'خط الطول مطلوب',
            'numeric' => 'يجب أن يكون خط الطول رقمًا',
            'between' => 'يجب أن يكون خط الطول بين :min و :max',
        ],
        'place_id' => [
            'required' => 'معرف المكان مطلوب',
            'string' => 'يجب أن يكون معرف المكان نصًا',
            'max' => 'يجب ألا يتجاوز معرف المكان :max حرفًا',
        ],
        'language' => [
            'in' => 'يجب أن تكون اللغة واحدة من: :values',
        ],
        'lat' => [
            'required' => 'خط العرض مطلوب',
            'between' => 'يجب أن يكون خط العرض بين :min و :max',
        ],
        'lng' => [
            'required' => 'خط الطول مطلوب',
            'between' => 'يجب أن يكون خط الطول بين :min و :max',
        ],
    ],

    // Field Labels
    'fields' => [
        'address' => 'العنوان',
        'latitude' => 'خط العرض',
        'longitude' => 'خط الطول',
        'place_id' => 'معرف المكان',
        'language' => 'اللغة',
        'input' => 'مدخل البحث',
        'coordinates' => 'الإحداثيات',
        'formatted_address' => 'العنوان المنسق',
    ],

    // Status Messages
    'status' => [
        'ok' => 'تم بنجاح',
        'zero_results' => 'لم يتم العثور على نتائج',
        'over_query_limit' => 'تم تجاوز حد الاستعلامات',
        'request_denied' => 'تم رفض الطلب',
        'invalid_request' => 'طلب غير صالح',
        'unknown_error' => 'حدث خطأ غير معروف',
    ],

    // Address History
    'address_history' => [
        'title' => 'سجل العناوين',
        'empty' => 'لا توجد عناوين محفوظة',
        'limit_reached' => 'تم الوصول إلى الحد الأقصى لعدد العناوين',
        'created' => 'تم إنشاء العنوان بنجاح',
        'updated' => 'تم تحديث العنوان بنجاح',
        'deleted' => 'تم حذف العنوان بنجاح',
        'not_found' => 'العنوان غير موجود',
    ],
];
