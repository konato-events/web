<?php
namespace App\Http\Controllers;

class SpeakerController extends Controller {

    public function getIndex(int $id = null, string $theme = null) {
        $themes = explode(' ', 'PHP MySQL JavaScript Design WebDesign WebDevelopment UserExperience Agile WebOperations SinglePageApps');
        return view('speaker.index', compact('theme', 'themes'));
    }

    public function missingMethod($parameters = []) {
        if (preg_match('/(\d*)-(\w*)/', $parameters, $matches)) {
            return $this->getIndex($matches[1], $matches[2]);
        } else {
            parent::missingMethod($parameters);
        }
    }
}
