<?php

namespace Inmanturbo\Tandem\Actions;

class CopyFiles
{
    public function __construct(
        public string $from,
        public string $to,
    ) {
        //
    }
}
