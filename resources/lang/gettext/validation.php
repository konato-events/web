<?
//here we hand-list the field translations that could be used as :attribute
_('password');

return [
    'required'  => _('Required field'),
    'email'     => _('This does not seem like an email'),
    'confirmed' => _('The :attribute confirmation doesn\'t match'),
    'unique'    => _('This :attribute is already in use'),
    'min'       => [
        'string' => _('Too short')
    ],
    'between'   => [
        'string' => _('This field should have between :min and :max characters')
    ],
    'image'     => _('This field must be a picture file (JPG/JPEG, GIF or PNG)'),

    'custom' => [
//        'password' => ['confirmed' => _('It seems the password fields were not exactly the same')]
        'username' => ['unique' => _('This username is already taken. Try something different! If you already have an account but don\'t remember your password, try to use the Recovery link from the Login page.')],
        'email' => ['unique' => _('This e-mail is already in use. Hmm... Is this you? If you don\'t remember your password, try to use the Recovery link from the Login page.')]
    ]
];
