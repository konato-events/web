<?php
namespace App\Http\Controllers;

class EventController extends Controller {

	public function getSearch() {
		if (!isset($_GET['q']) || empty($_GET['q'])) {
			return redirect()->action('SiteController@getIndex');
		} else {
			$query = $_GET['q'];
		}

		return view('event.search', compact('query'));
	}

	public function getDetails($id_slug) {
		$id = strtok($id_slug, '-');
		die('Details about event ID '.$id);
	}

}