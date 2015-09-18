<?php
namespace App\Http\Controllers;

class SiteController extends Controller {

    public function getIndex() {
        $view_data = [];
        $view_data['name'] = isset($_GET['name'])? $_GET['name'] : null;

        //...

        return view('site.index', $view_data);
    }

    public function getThemeDemo() {
        return view('site.theme');
    }

}