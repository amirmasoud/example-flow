<?php

namespace Support\WordPress;

use Illuminate\Support\Facades\Http;
use Support\WordPress\DataTransferObjects\PluginsData;
use Support\WordPress\DataTransferObjects\ThemesData;

class ApiWordPress
{
    public static function themes(?string $search = null): array
    {
        try {
            $response = Http::get("https://api.wordpress.org/themes/info/1.2/?action=query_themes&request[page]=1&request[per_page]=20&request[browse]=popular&request[search]=$search")->json();
            $data = new ThemesData($response);

            return $data->all();
        } catch (\Exception $e) {
            return [
                'themes' => [],
            ];
        }
    }

    public static function plugins(?string $search = null): array
    {
        try {
            $response = Http::get("https://api.wordpress.org/plugins/info/1.2/?action=query_plugins&request[page]=1&request[per_page]=20&request[search]=$search")->json();
            $data = new PluginsData($response);

            return $data->all();
        } catch (\Exception $e) {
            return [
                'plugins' => [],
            ];
        }
    }
}
