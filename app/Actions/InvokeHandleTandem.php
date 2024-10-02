<?php

namespace Inmanturbo\Tandem\Actions;

class InvokeHandleTandem
{
    public function __invoke(HandleTandem $action): void
    {
        foreach ($action->handlers as $action) {
            app(get_class($action))($action->tandem);
        }
    }
}
