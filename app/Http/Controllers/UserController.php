<?php namespace App\Http\Controllers;
use App\Http\Requests\UserEdit;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use LaravelArdent\Ardent\InvalidModelException;

class UserController extends Controller {

    use Traits\Followable;

    const TYPE_SPEAKER  = 1;
    const TYPE_USER     = 2;

    protected function followRelation() { return 'follows'; }
    protected function followReturnAction() { return 'UserController@getProfile'; }

    public function __construct() {
        $this->middleware('auth', ['only' => ['getFollow', 'getUnfollow', 'getEdit', 'postEdit', 'getEditLinks','postEditLinks', 'deleteLink']]);
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

    public function getSpeaker($id_slug) {
        return $this->profile(self::TYPE_SPEAKER, $id_slug);
    }

    public function getSpeakers(string $id_slug = null) {
        $single_theme = isset($id_slug);

        if (!$id_slug) {
            /** @var Theme[] $themes */
            $theme = null;
            if (\Auth::check()) {
                $themes = \Auth::user()->all_themes;
            } else {
                $themes = Theme::mostFrequent();
            }
        } else {
            $id = unslug($id_slug)[0];
            $theme  = Theme::find($id);
            $themes = [$theme]; //FIXME: find a way to create a list of "related" themes
        }

        $speakers = [];
        foreach ($themes as $t) { //take care to not override $theme
            foreach ($t->sessions as $session) { /** @var \App\Models\Session $session */
                $speakers += $session->speakers->all();
            }
        }

        $themed_speakers = (bool)sizeof($speakers);
        if (!$speakers) {
            $speakers = User::findSpeakers();
        }

        return view('user.speakers', compact('theme', 'themes', 'speakers', 'themed_speakers', 'single_theme'));
    }

    public function getEdit() {
        return view('user.edit', ['user' => \Auth::user()]);
    }

    public function postEdit(UserEdit $req) {
        try {
            $user = \Auth::user();
            $user->fill(\Input::except('_token'));
            $user->save();
            return redirect(act('user@profile', $user->slug));
        }
        catch (InvalidModelException $e) {
            return redirect()->back()->withErrors($e->getErrors());
        }
    }

    public function getEditLinks() {
        \Session::set('url.intended', act('user@getEdit')); //used in case the user tries to associate to a network
        return view('user.edit_links', ['user' => \Auth::user()]);
    }

    public function postEditLinks(Request $req) {
        \Auth::user()->addLink($req->get('link'), 'personal website');
        return redirect(act('user@editLinks'));
    }

    public function getLink(int $id) {
        return redirect(\Auth::user()->links()->where('id', $id)->firstOrFail()->url);
    }

    public function deleteLink(int $id) {
        $user = \Auth::user();
        if ($user->links()->where('id', $id)->delete()) {
            return redirect(act('user@editLinks'));
        } else {
            //TODO: log error and warn someone
            return redirect()->back()->with('error', _('We were unable to delete this link... Would you try again, or contact us?'));
        }
    }

}
