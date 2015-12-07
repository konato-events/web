<?php
namespace App\Http\Controllers;

use App\Models\EventType;

class SiteController extends Controller {

    public function getIndex() {
        $types = array_flip(EventType::toList());
        return view('site.index', compact('types'));
    }

    public function getPrivacyPolicy() {
        return view('site.privacy');
    }

    public function getValidation(string $rule) {
        return 'true';
        //FIXME: unique validations are only working for new resources!
        return app('laravalid')->remoteValidation($rule);
    }

}
