<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CarTag extends Pivot
{
    protected $table = 'car_tag';
}
