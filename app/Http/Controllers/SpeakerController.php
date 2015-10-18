<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;

class SpeakerController extends Controller {

    public function getIndex() {
        $themes = explode(' ', 'PHP MySQL JavaScript Design WebDesign WebDevelopment UserExperience Agile WebOperations SinglePageApps');
        return view('speaker.index', compact('themes'));
    }

    public function getTheme(string $id_slug = null) {
        if (!$id_slug) {
            return redirect(act('speaker'));
        }

        list($id, $theme) = explode('-', $id_slug);
        $themes = explode(' ', 'PHP MySQL JavaScript Design WebDesign WebDevelopment UserExperience Agile WebOperations SinglePageApps');
        return view('speaker.index', compact('theme', 'themes'));
    }

    public function getProfile(string $id_slug) {
        list($id, $name_slug) = unslug($id_slug);
        return view('speaker.profile', compact('id', 'name_slug'));
    }

}
