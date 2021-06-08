<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Beverage
 *
 * @property int $id
 * @property int $player_id
 * @property int $cost
 * @property string $started_at
 * @property string $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\BeverageFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage query()
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beverage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Beverage extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $appends = ['score'];

    protected $fillable = ['cost', 'started_at', 'completed_at'];

    public function getScoreAttribute()
    {
        if ($this->completed_at == null)
            return 0;

        $greenLimit = $this->cost * 60 * 15;
        $yellowLimit = $this->cost * 60 * 20;
        $elapsed = (strtotime($this->completed_at) - strtotime($this->started_at));
        if ($elapsed <= $greenLimit)
           return 10002 * $this->cost;

        if ($elapsed <= $yellowLimit)
            return 10001 * $this->cost;

        return 10000 * $this->cost;
    }
}
