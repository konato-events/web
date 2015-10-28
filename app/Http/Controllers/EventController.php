<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller {

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

}
