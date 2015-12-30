<?php namespace App\Http\Controllers\Traits;
use App\Models\Base;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\QueryException;

trait Followable {

    abstract protected function followRelation();
    abstract protected function followReturnAction();

    public function getFollow(int $id) {
        /** @var BelongsToMany $relation */
        $relation = \Auth::user()->{$this->followRelation()}();
        try {
            $relation->attach($id);
        }
        catch (QueryException $e) {
            if ($e->getCode() != Base::ERR_UNIQUE_VIOLATION) { //it means the relation already existed, so it's fine
                throw $e;
            }
        }

        /** @var \App\Models\Base $related */
        if ($related = $relation->getRelated()->first()) {
            return redirect()->action($this->followReturnAction(), $related->slug);
        } else {
            return redirect()->back();
        }
    }

    public function getUnfollow(int $id) {
        /** @var BelongsToMany $relation */
        /** @var \App\Models\Base $related */
        $relation = \Auth::user()->{$this->followRelation()}();
        $related  = $relation->getRelated()->first();
        $relation->detach($id);
        return redirect()->action($this->followReturnAction(), $related->slug);
    }

}
