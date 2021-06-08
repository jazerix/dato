<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Player
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Beverage[] $beverages
 * @property-read int|null $beverages_count
 * @method static \Database\Factories\PlayerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Player extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $appends = ['total_score'];

    protected $fillable = ['name'];

    public function beverages()
    {
        return $this->hasMany(Beverage::class);
    }

    public function getTotalScoreAttribute()
    {
        return $this->beverages->sum('score');
    }

    public function getCurrentlyDrinkingAttribute()
    {
        if ($this->beverages->last() == null)
            return null;
        return $this->beverages->last()->completed_at == null ? $this->beverages->last() : null;
    }
}
