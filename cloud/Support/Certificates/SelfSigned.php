<?php

namespace Support\Certificates;

use Illuminate\Support\Facades\Storage;
use Support\Certificates\Exceptions\MkcertMissingException;
use Support\Shell;

class SelfSigned implements Certificate
{
    /**
     * @throws MkcertMissingException
     */
    public function generate(string $host, ?string $path = null): void
    {
        if (! $this->isMkcertInstalled()) {
            throw new MkcertMissingException();
        }

        if (! $path) {
            $path = $this->getDefaultPath();
        }

        // mkcert -install # needs sudo
        app(Shell::class)->execQuietly(
            'cd '.$path
            ." && mkcert -cert-file {$host}-cert.pem -key-file {$host}-key.pem \"{$host}.test\" \"*.{$host}.test\""
        );
    }

    protected function isMkcertInstalled(): bool
    {
        return app(Shell::class)->execQuietly('mkcert --version 2>&1')->isSuccessful();
    }

    protected function getDefaultPath(): string
    {
        return Storage::disk('proxy')->path('/certificates');
    }
}
