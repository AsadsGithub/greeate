<?php

namespace Greeate\Greeate\Console;

use Greeate\Greeate\Services\BroadcastService;
use Illuminate\Console\Command;

class ProcessScheduledBroadcastsCommand extends Command
{
    protected $signature = 'greeate:process-scheduled-broadcasts';

    protected $description = 'Send scheduled broadcast notifications';

    public function handle(BroadcastService $service): int
    {
        $count = $service->processScheduled();
        $this->info("Processed {$count} broadcast(s).");

        return self::SUCCESS;
    }
}
