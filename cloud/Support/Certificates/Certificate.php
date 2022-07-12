<?php

namespace Support\Certificates;

interface Certificate
{
    public function generate(string $path, string $domain): void;
}
