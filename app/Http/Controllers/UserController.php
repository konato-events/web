<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller {

    const TYPE_SPEAKER  = 1;
    const TYPE_USER     = 2;

    public function getProfile(string $id_slug) {
        list($id, $name_slug) = unslug($id_slug);
        return view('user.profile', compact('id', 'name_slug'));
    }

    public function getSpeaker(string $id_slug) {
        list($id, $name_slug) = unslug($id_slug);
        $type = self::TYPE_SPEAKER;
        return view('user.profile', compact('id', 'name_slug', 'type'));
    }

}
