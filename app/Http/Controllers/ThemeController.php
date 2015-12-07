<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller {

    use Traits\Followable;

    protected function followRelation() { return 'following_themes'; }

    public function __construct() {
        $this->middleware('auth', ['only' => ['getFollow', 'getUnfollow']]);
    }

    public function getEvents(string $id_slug, Request $req) {
        $id = unslug($id_slug)[0];
        $paid = $req->input('paid', 0);
        $theme = Theme::with('events')->find($id);
        $types = \App\Models\EventType::toTransList();
        return view('theme.events', compact('theme', 'paid', 'types'));
    }

    public function getSpeakers(string $id_slug) {
        if (!$id_slug) {
            return redirect(act('speaker'));
        }

        list($id, $theme) = explode('-', $id_slug);
        $themes = explode(' ', 'PHP MySQL JavaScript Design WebDesign WebDevelopment UserExperience Agile WebOperations SinglePageApps');
        return view('user.speakers', compact('theme', 'themes'));
    }

}
