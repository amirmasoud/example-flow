<?php

namespace Support\Containers\Enums;

enum ImageEnum: string
{
    case WORDPRESS_NGINX_MARIADB = 'wordpress-nginx-mariadb';

    public function label(): string
    {
        return match ($this) {
            self::WORDPRESS_NGINX_MARIADB => 'NGINX + MariaDB',
        };
    }

    public function path(string $fileOrDirectory): string
    {
        return match ($this) {
            self::WORDPRESS_NGINX_MARIADB => support_path('Containers/Stubs/'.self::WORDPRESS_NGINX_MARIADB->value.'/'.$fileOrDirectory),
        };
    }
}
