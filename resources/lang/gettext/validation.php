<?
//here we hand-list the field translations that could be used as :attribute
_('password');

return [
    'required'  => _('Required field'),
    'email'     => _('This does not seem like an email'),
    'confirmed' => _('The :attribute confirmation doesn\'t match'),
    'min'       => [
        'string' => _('Too short')
    ],
    'between'   => [
        'string' => _('This field should have between :min and :max characters')
    ],

//    'custom' => [
//        'password' => ['confirmed' => _('It seems the password fields were not exactly the same')]
//    ]
];
