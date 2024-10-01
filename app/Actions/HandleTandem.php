<?php

namespace Inmanturbo\Tandem\Actions;

use Inmanturbo\Tandem\HandlesTandem;
use Inmanturbo\Tandem\Tandem;

class HandleTandem
{
    /**
     * @var array<int|string, \Inmanturbo\Tandem\HandlesTandem>
     */
    public $handlers;

    public function __construct(
        public Tandem $tandem,
        HandlesTandem ...$handlers,
    ) {
        $this->handlers = $handlers;
    }
}
