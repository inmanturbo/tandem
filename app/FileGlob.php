<?php

namespace Inmanturbo\Tandem;

use Inmanturbo\Tandem\Concerns\FindsFilesByGlobPattern;
use Inmanturbo\Tandem\Contracts\FileGlob as FileGlobContract;

class FileGlob implements FileGlobContract
{
    Use FindsFilesByGlobPattern;
}
