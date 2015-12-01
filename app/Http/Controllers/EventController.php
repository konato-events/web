<?php namespace App\Http\Controllers;

use App\Http\Requests\Model as ModelReq;
use App\Models\Event;
use Illuminate\Http\Request;
use LaravelArdent\Ardent\InvalidModelException;

class EventController extends Controller {

	public function __construct() {
        $edits = [
            'getEdit', 'postEdit',
            'getEditThemes', 'postEditThemes',
            'getEditSpeakers', 'postEditSpeakers',
            'getEditSchedule', 'postEditSchedule',
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
		list($id, $theme) = unslug($id_slug);
		$paid  = $req->input('paid', 0);
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

    public function getEdit(int $id) {
        $event = Event::find($id);
        return view('event.forms.edit_general', compact('event'));
    }

    public function postEdit(EventReq $req) {
        $event = Event::find($req->id);
        try {
            $event->fill($req->except('_token'));
            $event->save();
            $id_slug = slugify($event->id, $event->title);
            return redirect()->action('EventController@getDetails', $id_slug);
        }
        catch (InvalidModelException $e) {
            return redirect()->back()
                ->withInput($req->except($req->dontFlash))
                ->withErrors($e->getErrors(), 'default');
        }
    }

    public function getEditThemes(int $id) {

    }

    public function getEditSpeakers(int $id) {

    }

    public function getEditMaterials(int $id) {

    }

    public function getEditSchedule(int $id) {

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
