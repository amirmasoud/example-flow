<?php

namespace Domain\Users\Casts;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Domain\Users\DataTransferObjects\UserSettingsData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SettingsCast implements Castable
{
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class implements CastsAttributes {
            public function get($model, $key, $value, $attributes): UserSettingsData
            {
                return new UserSettingsData(json_decode($value));
            }

            public function set($model, $key, $value, $attributes): bool|string
            {
                return json_encode($value);
            }
        };
    }
}
