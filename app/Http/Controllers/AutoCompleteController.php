<?php namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AutoCompleteController extends Controller {

    public function missingMethod($params = []) {
        $available_objects = [
            'themes' => 'Theme',
            'users'  => 'User',
        ];

        if (!isset($params[0])) {
            //TODO: verify the correct HTTP code
            return response('Missing object type ['.join(' | ',array_keys($available_objects)).']', 400);
        } else {
            if (array_key_exists($params[0], $available_objects)) {
                $class = '\App\Models\\'.$available_objects[$params[0]];
            } else {
                return response('Wrong object type ['.join(' | ',array_keys($available_objects)).']', 400);
            }
        }

        if (isset($_GET['q'])) {
            $data = call_user_func([$class, 'where'], 'name', 'ILIKE', "%{$_GET['q']}%")->get();
        } else {
            $data = call_user_func([$class, 'all']);
        }

        return JsonResponse::create(
            array_map(
                function($obj) { return [ 'id' => $obj->id, 'text' => $obj->name, 'slug' => $obj->name ]; },
                $data->all()
            )
        );
    }

}