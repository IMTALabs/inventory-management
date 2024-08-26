<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $unit
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $chart_key
 */
class Metric extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit'];

    public function chartKey(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::camel($this->name) . $this->id
        );
    }
}
