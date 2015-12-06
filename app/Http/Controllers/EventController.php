<?php namespace App\Http\Controllers;

use App\Http\Requests\Model as ModelReq;
use App\Models\Event;
use App\Models\EventSpeaker;
use App\Models\EventTheme;
use App\Models\Theme;
use Illuminate\Http\Request;
use LaravelArdent\Ardent\InvalidModelException;

class EventController extends Controller {

    public function __construct() {
        $edits = [
            'getEdit', 'postEdit',
            'getEditSchedule', 'postEditSchedule',
            'getEditMaterials', 'postEditMaterials',
            'getEditThemesSpeakers', 'postEditThemesSpeakers',
        ];
        $this->middleware('auth', ['only' => ['getSubmit', 'postSubmit'] + $edits]);
        $this->middleware('staff', ['only' => $edits]);
    }

    public function getSearch(Request $req) {
        if (!$_GET) {
            return redirect()->action('SiteController@getIndex');
        }
        $query = $req->input('q', '');
        $paid  = $req->input('paid', 0);
        $place = $req->input('place', 'Rio de Janeiro, Brazil');

        return view('event.search', compact('query', 'paid', 'place'));
    }

    public function getDetails(string $id_slug) {
        list($id, $name_slug) = unslug($id_slug);
        $event = Event::find($id);
        return view('event.details', compact('id', 'name_slug', 'event'));
    }

    public function getTheme(string $id_slug, Request $req) {
        $id = unslug($id_slug)[0];
        $paid = $req->input('paid', 0);
        $theme = Theme::with('events')->find($id);
        return view('event.theme', compact('id', 'theme', 'paid'));
    }

    public function getSubmit() {
        $event = new Event;
        return view('event.submit', compact('event'));
    }

    public function postSubmit(EventReq $req) {
        $event = new Event;
        $event->save();
        $event->staff()->attach(\Auth::user());
        $id_slug = slugify($event->id, $event->title);
        return redirect()->action('EventController@getDetails', $id_slug);
    }

/**************************************************** EDIT ACTIONS ***************************************************/

    public function getEdit(int $id) {
        return $this->edit('general', $id);
    }

    /**
     * Displays one of the edit forms.
     * @param string    $name  Form name, as in "event.forms.edit_$name"
     * @param int|Event $event Event ID or Event object
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function edit($name, $event) {
        if (is_integer($event)) {
            $event = Event::find($event);
        }
        return view('event.forms.edit_'.$name, compact('event'));
    }

    public function postEdit(EventReq $req) {
        $event = Event::find($req->id);
        try {
            $event->fill($req->except('_token'));
            $event->save();
            return $this->edit('general', $event);
        }
        catch (InvalidModelException $e) {
            return redirect()->back()
                ->withInput($req->except($req->dontFlash))
                ->withErrors($e->getErrors(), 'default');
        }
    }

    public function getEditThemesSpeakers(int $id) {
        return $this->edit('themes_speakers', $id);
    }

    public function postEditThemesSpeakers(Request $req) {
        $event_id = $req->id;
        $speakers = array_filter(explode(',', $req->speaker_ids));
        $themes   = array_filter(explode(',', $req->theme_ids));

        foreach($speakers as $user_id) {
            EventSpeaker::create(compact('event_id', 'user_id'));
        }

        foreach ($themes as $name) {
            $theme_id = Theme::firstOrCreate(compact('name'))->id;
            EventTheme::create(compact('event_id', 'theme_id'));
        }

        return redirect(act('event@editThemesSpeakers', $req->id));
    }

    public function getEditMaterials(int $id) {
        return $this->edit('materials', $id);
    }

    public function getEditSchedule(int $id) {
        return $this->edit('schedule', $id);
    }
}

class EventReq extends ModelReq {

    public function rules() {
        $rules = Event::$rules;
        foreach ($rules as &$constraints) {
            $constraints = array_filter($constraints, function($constraint) {
                return strpos($constraint, 'unique') === false;
            });
        }
        return $rules;
    }

}
