<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller {

	public function __construct() {
		$this->middleware('guest', ['except' => ['getSubmit', 'postSubmit']]);
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
		$event = new Event();
		return view('event.submit', compact('event'));
	}

	public function postSubmit(EventReq $req) {
		$event = new Event();
		$event->save();
		$id_slug = slugify($event->id, $event->name);
		return redirect()->action('EventController@getDetails', $id_slug);
	}
}
