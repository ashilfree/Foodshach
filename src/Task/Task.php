<?php

namespace App\Task;

use Rewieer\TaskSchedulerBundle\Task\AbstractScheduledTask;
use Rewieer\TaskSchedulerBundle\Task\Schedule;
use Symfony\Component\Process\Process;

class Task extends AbstractScheduledTask{

    protected function initialize(Schedule $schedule)
    {
        $schedule->everyMinutes(5);
    }

    public function run()
    {
        $process = new Process(['php bin/console  app:order:cleanup']);
        $process->run();
    }
}