<?php namespace App\Http\Middleware;

use App\Models\Event;
use App\Models\EventStaff;
use Auth;
use Illuminate\Http\Request;

class Staff {

    public function handle(Request $request, callable $next) {
        $forbidden = function($id) use ($request) {
            if ($request->ajax()) {
                return response('Forbidden', 403);
            } else {
                $path = $id? 'event@details' : 'site@index';
                return redirect(act($path, $id))
                    ->with('error', _('Sorry, but it seems you don\'t have permission to edit this event...'));
            }
        };

        $path  = $request->getPathInfo();
        $param = substr($path, strrpos($path, '/')+1, strrpos($path, '-')?: strlen($path)+1);
        if (!$param) { //should never arrive here
            \Log::warning('Tried to search for event ID in Staff middleware, but it was not found: '.$path);
            return $forbidden($param);
        } else {
            if (!Auth::check() || !EventStaff::where('user_id', Auth::user()->id)->where('event_id', $param)->count()) {
                return $forbidden($param);
            }
        }

        return $next($request);
    }

}
