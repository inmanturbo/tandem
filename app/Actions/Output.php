<?php

namespace Inmanturbo\Tandem\Actions;

class Output
{
    public function __construct(
        public string $output,
        public string $type = 'actions.info',
    ) {
        //
    }
}
