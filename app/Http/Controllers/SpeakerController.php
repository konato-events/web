<?php
namespace App\Http\Controllers;

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
        return redirect()->route('user', $id_slug);
    }

}
