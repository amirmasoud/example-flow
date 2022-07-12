<?php

namespace Domain\Sites\Models;

use Spatie\Tags\HasTags;
use Domain\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Domain\Sites\Enums\RamUnitEnum;
use Domain\Sites\Enums\DiskTypeEnum;
use Domain\Sites\Enums\DiskUnitEnum;
use Domain\Sites\Enums\OsFlavorEnum;
use Illuminate\Database\Eloquent\Model;
use Domain\Sites\Enums\ServerStatusEnum;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Server extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use HasTags;

    protected $fillable = [
        'name',
        'price',
        'ip',
        'port',
        'ram',
        'ram_unit',
        'cpu',
        'disk',
        'disk_type',
        'disk_unit',
        'os',
        'os_version',
        'status',
        'notes',
    ];

    protected $casts = [
        'price' => 'integer',
        'port' => 'integer',
        'ram_unit' => RamUnitEnum::class,
        'disk_type' => DiskTypeEnum::class,
        'disk_unit' => DiskUnitEnum::class,
        'os' => OsFlavorEnum::class,
        'status' => ServerStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }
}
