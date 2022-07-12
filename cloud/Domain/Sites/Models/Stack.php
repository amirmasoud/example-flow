<?php

namespace Domain\Sites\Models;

use Spatie\Tags\HasTags;
use Domain\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Domain\Sites\Enums\StackTypeEnum;
use Domain\Sites\Casts\PropertiesCast;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Domain\Sites\QueryBuilders\StackQueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property array<Site> $sites
 */
class Stack extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use HasTags;

    protected $fillable = [
        'name',
        'price',
        'properties',
        'type',
    ];

    protected $casts = [
        'price' => 'integer',
        'properties' => PropertiesCast::class,
        'type' => StackTypeEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public function newEloquentBuilder($query): StackQueryBuilder
    {
        return new StackQueryBuilder($query);
    }
}
