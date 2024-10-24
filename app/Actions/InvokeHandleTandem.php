<?php

namespace Inmanturbo\Tandem\Actions;

class InvokeHandleTandem
{
    public function __invoke(HandleTandem $action): void
    {
        foreach ($action->handlers as $handler) {
            app(get_class($handler))($action->tandem);
        }
    }
}
