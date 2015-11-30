<?php
namespace App\Http\Controllers;

class SiteController extends Controller {

    public function getIndex() {
        return view('site.index');
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
