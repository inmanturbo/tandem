<?php

namespace Inmanturbo\Tandem\Actions;

use Illuminate\Contracts\Process\ProcessResult;
use Illuminate\Support\Facades\Process;

class InvokeInstallLaravel
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(InstallLaravel $action): ProcessResult
    {
        return match (is_null($action->output)) {
            true => Process::path($action->path)->run([...$action->laravel, ...$action->args]),
            default => Process::path($action->path)->run([...$action->laravel, ...$action->args], $action->output),
        };
    }
}
