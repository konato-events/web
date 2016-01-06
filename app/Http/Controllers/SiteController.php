<?php namespace App\Http\Controllers;

use App\Models\EventType;

//TODO: use a "missingMethod" to render static views such as Privacy Policy or About
class SiteController extends Controller {

    public function getIndex() {
        $types = array_flip(EventType::toList());
        return view('site.index', compact('types'));
    }

    public function getPrivacyPolicy() {
        return view('site.privacy');
    }

    public function getAbout() {
        return view('site.about');
    }

    public function getValidation(string $rule) {
        return 'true';
        //FIXME: unique validations are only working for new resources!
        return app('laravalid')->remoteValidation($rule);
    }

}
