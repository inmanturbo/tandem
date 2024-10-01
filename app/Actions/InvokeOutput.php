<?php

namespace Inmanturbo\Tandem\Actions;

class InvokeOutput
{
    public function __invoke(Output $output): void
    {
        event($output->type, $output->output);
    }
}
