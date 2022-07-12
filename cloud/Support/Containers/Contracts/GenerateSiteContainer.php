<?php

namespace Support\Containers\Contracts;

use Support\Containers\Enums\CertificateEnum;

interface GenerateSiteContainer
{
    public function compose(string $from, string $to, array $replacers = []): void;

    public function env(string $from, string $to, array $replacers = []): void;

    public function config(string $from, string $to): void;

    public function certificate(CertificateEnum $certificate, string $domain): void;
}
