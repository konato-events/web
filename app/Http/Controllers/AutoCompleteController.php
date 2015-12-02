<?php namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AutoCompleteController extends Controller {

    public function missingMethod($params = []) {
        $available_objects = [
            'themes' => 'Theme'
        ];

        if (!isset($params[0])) {
            //TODO: verify the correct HTTP code
            return response('Missing object type ['.join(' | ',array_keys($available_objects)).'', 400);
        } else {
            if (array_key_exists($params[0], $available_objects)) {

            } else {
                return response('Wrong object type ['.join(' | ',array_keys($available_objects)).'', 400);
            }
        }

        $class = '\App\Models\\';
        switch ($params[0]) {
            case 'themes': $class .= 'Theme'; break;
            default:
        }

        return JsonResponse::create(
            call_user_func([$class, 'all'])->pluck('name', 'id')
        );
    }

}