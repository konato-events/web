<?php
namespace App\Http\Controllers;

use App\Models\Event as Model;
use Illuminate\Http\Request;

class EventController extends Controller {

	public function __construct() {
		$this->middleware('auth', ['only' => ['getSubmit', 'postSubmit']]);
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
        return view('event.details', compact('id', 'name_slug'));
	}

	public function getTheme(string $id_slug, Request $req) {
		list($id, $theme) = unslug($id_slug);
		$paid  = $req->input('paid', 0);
		return view('event.theme', compact('id', 'theme', 'paid'));
	}

	public function getSubmit() {
		$event = new Model();
		return view('event.submit', compact('event'));
	}

	public function postSubmit(Event $req) {
		$event = new Model();
		$event->save();
		$id_slug = slugify($event->id, $event->title);
		return redirect()->action('EventController@getDetails', $id_slug);
	}
}

class Event extends \App\Http\Requests\Model {}
