<?php
namespace App\Http\Controllers;

class EventController extends Controller {

	public function getSearch() {
		if (!$_GET) {
			return redirect()->action('SiteController@getIndex');
		}
        $query = self::getParam('q', '');
		$paid  = self::getParam('paid', 0);
		$place = self::getParam('place', 'Rio de Janeiro, Brazil');

		return view('event.search', compact('query', 'paid', 'place'));
	}

	public function getDetails(string $id_slug) {
		$id = strtok($id_slug, '-');
		die('Details about event ID '.$id);
	}

	public function getTheme(string $id_slug) {
		list($id, $theme) = explode('-', $id_slug);
		$paid  = self::getParam('paid', 0);
		return view('event.theme', compact('id', 'theme', 'paid'));
	}

}
