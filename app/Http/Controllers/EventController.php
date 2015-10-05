<?php
namespace App\Http\Controllers;

class EventController extends Controller {

	public function getSearch() {
		$query = self::getParam('q');
		if (!$query) {
			return redirect()->action('SiteController@getIndex');
		}
		$paid  = self::getParam('paid', 0);

		return view('event.search', compact('query', 'paid'));
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