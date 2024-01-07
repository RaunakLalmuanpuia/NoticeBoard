<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ModelStore
{
  public function modelStore(Request $request, $model, $relationshipToLoad = [])
  {
    return $model->firstOrCreate(
      $request->only($model->getFillable())
    )->load($relationshipToLoad);
  }
}