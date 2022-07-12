<?php

namespace Support\Containers;

use Illuminate\Support\Facades\File;
use Support\Certificates\SelfSigned;
use Support\Containers\Contracts\GenerateSiteContainer;
use Support\Containers\Enums\CertificateEnum;
use Touhidurabir\StubGenerator\Facades\StubGenerator;

class GenerateDockerSiteContainer implements GenerateSiteContainer
{
    public function compose(string $from, string $to, array $replacers = []): void
    {
        StubGenerator::from($from, asFullPath: true)
            ->to($to, createIfNotExist: true, asFullPath: true)
            ->as('docker-compose')->ext('yml')
            ->withReplacers($replacers)
            ->save();
    }

    public function env(string $from, string $to, array $replacers = []): void
    {
        StubGenerator::from($from, asFullPath: true)
            ->to($to, createIfNotExist: true, asFullPath: true)
            ->as('.env')->noExt()
            ->withReplacers($replacers)
            ->save();
    }

    public function config(string $from, string $to): void
    {
        File::copyDirectory($from, $to);
    }

    /**
     * @throws \Support\Certificates\Exceptions\MkcertMissingException
     */
    public function certificate(CertificateEnum $certificate, string $domain): void
    {
        match ($certificate) {
            CertificateEnum::SELF_SIGNED => app(SelfSigned::class)->generate(storage_path('app/proxy'), $domain),
        };
    }
}
