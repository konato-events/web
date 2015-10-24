<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller {

    public function getIndex(string $id_slug) {
        list($id, $name_slug) = unslug($id_slug);
        return view('speaker.profile', compact('id', 'name_slug'));
    }

}
