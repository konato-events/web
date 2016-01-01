<?php namespace App\Http\Controllers\Traits;
use App\Models\Base;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\QueryException;

trait Followable {

    abstract protected function followRelation();
    abstract protected function followReturnAction();

    public function getFollow(string $slug) {
        try {
            list($id) = unslug($slug);
            \Auth::user()->{$this->followRelation()}()->attach($id);
        }
        catch (QueryException $e) {
            if ($e->getCode() != Base::ERR_UNIQUE_VIOLATION) { //it means the relation already existed, so it's fine
                throw $e;
            }
        }

        return redirect()->action($this->followReturnAction(), $slug);
    }

    public function getUnfollow(string $slug) {
        list($id) = unslug($slug);
        \Auth::user()->{$this->followRelation()}()->detach($id);
        return redirect()->action($this->followReturnAction(), $slug);
    }

}
