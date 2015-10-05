<?php
namespace App\Http\Controllers;

class EventController extends Controller {

	public function getSearch() {
		if (!isset($_GET['q']) || empty($_GET['q'])) {
			return redirect()->action('SiteController@getIndex');
		} else {
			$query = $_GET['q'];
		}

		$paid = self::getParam('paid', 0);

		$types = [
			_('Congresses'),
			_('Meetings'),
			_('Talks & discussions'),
			_('University meetings'),
			_('Cultural'),
		];
		$selected_types = array_rand($types, 2);

		$themes = explode(' ', 'php databases mysql webdesign api');
		$selected_themes = array_rand($themes, 2);

		return view('event.search', compact('query', 'paid', 'types', 'selected_types', 'themes', 'selected_themes'));
	}

	public function getDetails($id_slug) {
		$id = strtok($id_slug, '-');
		die('Details about event ID '.$id);
	}

}