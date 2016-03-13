<?php namespace App\Http\Requests;

class UserEdit extends Request {

    public function rules() {
        $rules = \Auth::user()->buildUniqueExclusionRules();
//        $rules['picture'] = 'image';
        return $rules;
    }

}
