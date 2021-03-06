<?php namespace App\Http\Controllers;

use App\Http\Requests\Model as ModelReq;
use App\Models\Event;
use App\Models\EventSpeaker;
use App\Models\EventTheme;
use App\Models\EventType;
use App\Models\Session;
use App\Models\Theme;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LaravelArdent\Ardent\InvalidModelException;

class EventController extends Controller {

    use Traits\Followable;

    public function __construct() {
        $edits = [
            'getEdit', 'postEdit',
            'getEditSchedule', 'postEditSchedule',
            'getEditMaterials', 'postEditMaterials',
            'getEditThemesSpeakers', 'postEditThemesSpeakers',
        ];
        $this->middleware('auth', ['only' => ['getSubmit', 'postSubmit', 'getFollow', 'getUnfollow', 'getParticipate', 'getUnparticipate'] + $edits]);
        $this->middleware('staff', ['only' => $edits]);
    }

    public function getSearch(Request $req) {
        if (!$_GET) {
            return redirect()->action('SiteController@getIndex');
        }
        $query = $req->input('q', '');
        $paid  = $req->input('paid', 0);
        $place = $req->input('place', '');
        $all_types = EventType::toTransList();
        $types = $req->input('types', []);
        $ilikey = function(string $str) { return strtr(" $str ", ' ', '%'); };

        /** @var Builder $db_query */
        $db_query = Event::where('hidden', 0);
        if ($query) { $db_query->where('title', 'ilike', $ilikey($query)); } //FIXME: improve this text search
        if ($paid)  { $db_query->where('free', ($paid == -1)); }
        if ($place) { $db_query->where('location', 'ilike', $ilikey($place)); }
        if ($types) { $db_query->whereIn('event_type_id', $types); }
        $events = $db_query->orderBy('begin', 'desc')->get();

        if (sizeof($events) == 1 && $query) {
            return redirect()->to(act('event@details', $events[0]->slug));
        }

        return view('event.search', compact('query', 'paid', 'place', 'all_types', 'types', 'events'));
    }

    public function getDetails(string $id_slug) {
        list($id, $name_slug) = unslug($id_slug);
        $event = Event::findOrFail($id);
        return view('event.details', compact('id', 'name_slug', 'event'));
    }

    public function getSubmit() {
        $event = new Event;
        return view('event.forms.submit', compact('event'));
    }

    public function postSubmit(EventReq $req) {
        $event = new Event;
        $event->save();
        $event->staff()->attach(\Auth::user(), [
            'created_at' => $event->created_at,
            'updated_at' => $event->updated_at,
        ]);
        $id_slug = slugify($event->id, $event->title);
        return redirect()->action('EventController@getDetails', $id_slug);
    }


/* ************************************************* FOLLOW ACTIONS ************************************************* */

    protected $followRelation = 'following_events';
    protected function followRelation() { return $this->followRelation; }
    protected function followReturnAction() { return 'EventController@getDetails'; }

    public function getParticipate(string $slug) {
        $this->followRelation = 'participated';
        return $this->getFollow($slug);
    }

    public function getUnparticipate(string $slug) {
        $this->followRelation = 'participated';
        return $this->getUnfollow($slug);
    }

/* *************************************************** EDIT ACTIONS ************************************************* */

    /**
     * Displays one of the edit forms.
     * @param string    $name  Form name, as in "event.forms.edit_$name"
     * @param int|Event $event Event ID or Event object
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function edit($name, $event) {
        if (is_integer($event)) {
            $event = Event::find($event);
        }
        return view('event.forms.edit_'.$name, compact('event'));
    }

    public function getEdit(int $id) {
        return $this->edit('general', $id);
    }

    public function postEdit(EventReq $req) {
        $event = Event::find($req->id);
        try {
            $event->fill($req->except('_token'));
            $event->save();
            return $this->edit('general', $event);
        }
        catch (InvalidModelException $e) {
            return redirect()->back()
                ->withInput($req->except($req->dontFlash))
                ->withErrors($e->getErrors(), 'default');
        }
    }

    public function getEditThemesSpeakers(int $id) {
        return $this->edit('themes_speakers', $id);
    }

    public function postEditThemesSpeakers(Request $req) {
        $event_id = $req->id;
        $speakers = array_filter(explode(',', $req->speaker_ids));
        $themes   = array_filter(explode(',', $req->theme_ids));

        foreach($speakers as $user_id) {
            EventSpeaker::create(compact('event_id', 'user_id'));
        }

        foreach ($themes as $theme) {
            $theme_id = Theme::firstOrCreate(['name' => ['ilike', $theme]])->id; //TODO: usar ilike
            try {
                EventTheme::create(compact('event_id', 'theme_id'));
            }
            catch (QueryException $e) {
                if ($e->getCode() != EventTheme::ERR_UNIQUE_VIOLATION) { //the relation already existed, so it's fine
                    throw $e;
                }
            }
        }

        return redirect(act('event@editThemesSpeakers', $req->id));
    }

    public function getEditMaterials(int $id) {
        return $this->edit('materials', $id);
    }

    public function postEditMaterials(int $id) {
        //TODO: implement
    }

    public function getScheduleTemplateFile() {
        $template_file = storage_path(_('template').'_'.LOCALE.'.csv');
        if (!file_exists($template_file)) {
            $file  = fopen($template_file, 'c');
            $lines = [
                [_('Title'), _('Description'), _('Begin'), _('End')],
                [_('SAMPLE TALK (remove this line): Abnormalities on Catalysis'), _('This talk will walk us through some common abnormalities seen in some catalysis processes.'), _('Format: YYYY-MM-DD HH:mm'), _('Format: YYYY-MM-DD HH:mm')]
            ];
            foreach ($lines as $line) {
                array_walk($line, function(&$v) { $v = Str::ascii($v); });
                fputcsv($file, $line);
            }
            fclose($file);
        }

        $download = response()->download($template_file);
        $download->headers->set('Content-Type', 'text/csv');
        return $download;
    }

    public function getEditSchedule(int $id) {
        return $this->edit('schedule', $id);
    }


    //TODO: verify dates before inserting
    //TODO: verify validation of the session and how it should behave on errors
    //TODO: verify file format before processing
    public function postEditSchedule(int $id) {
        $file = fopen(request()->file('schedule_file')->getRealPath(), 'r');

        $l = 0;
        while($line = fgetcsv($file)) {
            if ($l++ === 0) continue; //skipping headers
            Session::create([
                'title'       => $line[0],
                'description' => $line[1],
                'begin'       => $line[2],
                'end'         => $line[3],
                'event_id'    => $id
            ]);
        }
        $total = $l - 1; //skipping header

        if ($total > 0) {
            \Session::flash('success', __('One activity was imported.', 'A total of %d activities were imported.', $total));
        } else {
            \Session::flash('warning', _('No activity was found in the file.'));
        }
        return $this->edit('schedule', $id);
    }
}

class EventReq extends ModelReq {

    public function rules() {
        $model = new Event;
        $model->id = $this->get('id');
        return $model->buildUniqueExclusionRules();
    }

}
