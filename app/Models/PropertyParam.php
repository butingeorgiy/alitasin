<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

class PropertyParam extends Model
{
    public $timestamps = false;

    # Other methods

    public function getLocaleName(): ?string
    {
        return $this[App::getLocale() . '_name'];
    }
}
