<?php namespace App\Http\Controllers;
use App\Models\User;

class UserController extends Controller {

    use Traits\Followable;

    const TYPE_SPEAKER  = 1;
    const TYPE_USER     = 2;

    protected function followRelation() { return 'follows'; }

    public function __construct() {
        $this->middleware('auth', ['only' => ['getFollow', 'getUnfollow']]);
    }

    //FIXME: Yet another Laravel router "bug". If we define the user/{id_slug} route before the controller route, we get wrong paths, but if we define later, the paths work fine but the actual route, don't. Fixing paths is harder, so we implemented this missingMethod to override the not found route issue.
    public function missingMethod($id_slug = []) {
        $id_slug = is_array($id_slug)? current($id_slug) : $id_slug;
        if (preg_match(app('router')->getPatterns()['id_slug'], $id_slug)) {
            view()->share('action', app()['action'] = 'profile');
            return $this->getProfile($id_slug);
        } else {
            return parent::missingMethod($id_slug);
        }
    }

    //TODO: needs a redirect between user and speaker profiles. The user object should be verified to understand its type
    protected function profile(int $type, string $id_slug) {
        $id     = unslug($id_slug)[0];
        $user   = User::with('location', 'links.network', 'links')->findOrFail($id);
        $myself = (\Auth::user() && \Auth::user()->id == $user->id);

        return view('user.profile', compact('id', 'type', 'user', 'myself'));
    }

    public function getProfile($id_slug) {
        return $this->profile(self::TYPE_USER, $id_slug);
    }

    public function getSpeaker(string $id_slug) {
        return $this->profile(self::TYPE_SPEAKER, $id_slug);
    }

}
