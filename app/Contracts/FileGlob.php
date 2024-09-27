<?php

namespace Inmanturbo\Tandem\Contracts;

use Inmanturbo\Tandem\FilepathPattern;

interface FileGlob
{
    public function files(FilepathPattern $pattern): array;
}
