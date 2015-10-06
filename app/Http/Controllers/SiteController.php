<?php
namespace App\Http\Controllers;

class SiteController extends Controller {

    public function getIndex() {
        return view('site.index');
    }

}