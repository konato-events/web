<?php namespace App\Models;
use App\Models\Session;
use Illuminate\Support\Collection;

/**
 * @property int                  id
 * @property string               name
 * @property Collection|Session[] session
 * @property Collection|Event[]   events
 * @property Theme                parent
 * @property Theme                children
 */
class Theme extends Base {

    protected $speakers = [];

    public static $relationsData = [
        'events'   => [self::BELONGS_TO_MANY, Event::class, 'table' => 'event_theme'],
        'sessions' => [self::BELONGS_TO_MANY, Session::class, 'table' => 'session_theme'],
        'parent'   => [self::BELONGS_TO, self::class],
        'children' => [self::HAS_MANY, self::class],
    ];

    public static function mostFrequent($limit = 10) {
        $totals = \DB::select("
              SELECT COUNT(*) as total, theme_id as id
              FROM (
                SELECT theme_id FROM event_theme
                  UNION ALL
                SELECT theme_id FROM session_theme
                  UNION ALL
                SELECT theme_id FROM following_theme
              ) all_themes
              GROUP BY theme_id
              LIMIT $limit");

        $themes = self::whereIn('id', array_column($totals, 'id'))->get()->keyBy('id');

        $totals = array_map(function($stat) use ($themes) {
            $theme = $themes[$stat->id];
            $theme->total = $stat->total;
            return $theme;
        }, $totals);

        usort($totals, function(Theme $a, Theme $b) {
            $total = $b->total <=> $a->total;
            if ($total === 0) {
                return strtolower($a->name) <=> strtolower($b->name);
            } else {
                return $total;
            }

        });

        return $totals;
    }

    //TODO: improve this query
    public function getSpeakersAttribute() {
        if (!$this->speakers) {
            foreach ($this->sessions as $session) {
                $this->speakers += $session->speakers->keyBy('id');
            }
        }
        return $this->speakers;
    }

}
