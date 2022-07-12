<?php

namespace Domain\Sites\Casts;

use Domain\Sites\DataTransferObjects\WordPress\WordPressPropertiesData;
use Domain\Sites\Enums\StackTypeEnum;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PropertiesCast implements Castable
{
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class implements CastsAttributes
        {
            public function get($model, $key, $value, $attributes)
            {
                $data = collect(json_decode($value))->toArray();

                return match (StackTypeEnum::tryFrom($attributes['type'])) {
                    StackTypeEnum::WORDPRESS => new WordPressPropertiesData($data),
                    default => throw new Exception('Unexpected match value'),
                };
            }

            public function set($model, $key, $value, $attributes)
            {
                return json_encode($value);
            }
        };
    }
}
