<?php

namespace Inmanturbo\Tandem\Actions;

class InvokeHandleTandem
{
    public function __invoke(HandleTandem $handleTandem): void
    {
        foreach ($handleTandem->handlers as $handler) {
            app(get_class($handler))($handleTandem->tandem);
        }
    }
}
