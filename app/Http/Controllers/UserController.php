<?php
namespace App\Http\Controllers;

use App\Http\Requests\User as UserReq;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {

    const TYPE_SPEAKER  = 1;
    const TYPE_USER     = 2;

    //FIXME: Yet another Laravel router "bug". If we define the user/{id_slug} route before the controller route, we get wrong paths, but if we define later, the paths work fine but the actual route, don't. Fixing paths is harder, so we implemented this missingMethod to override the not found route issue.
    public function missingMethod($id_slug = []) {
        if (preg_match(app('router')->getPatterns()['id_slug'], $id_slug)) {
            view()->share('action_name', 'profile');
            return $this->getProfile($id_slug);
        } else {
            return parent::missingMethod($id_slug);
        }
    }

    public function getProfile($id_slug) {
        list($id, $name_slug) = unslug($id_slug);
        return view('user.profile', compact('id', 'name_slug'));
    }

    public function getSpeaker(string $id_slug) {
        list($id, $name_slug) = unslug($id_slug);
        $type = self::TYPE_SPEAKER;
        return view('user.profile', compact('id', 'name_slug', 'type'));
    }

    public function getSignUp() {
        $user = new User;
        return view('user.signUp', compact('user'));
    }

    public function postSignUp(UserReq $req) {
        !ddd($_POST);
    }

}
