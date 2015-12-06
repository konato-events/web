<?php namespace App\Http\Controllers\Traits;
use App\Models\Base;
use Illuminate\Database\QueryException;

trait Followable {

    abstract protected function followRelation();

    public function getFollow(int $id) {
        try {
            \Auth::user()->{$this->followRelation()}()->attach($id);
            }
            catch (QueryException $e) {
                if ($e->getCode() != Base::ERR_UNIQUE_VIOLATION) { //it means the relation already existed, so it's fine
                    throw $e;
                }
            }
        return redirect()->back();
    }

    public function getUnfollow(int $id) {
        \Auth::user()->{$this->followRelation()}()->detach($id);
        return redirect()->back();
    }

}
