<?php

namespace App\Model;

use Adamski\Symfony\ScheduleBundle\Model\ManagerInterface;
use Adamski\Symfony\ScheduleBundle\Model\Schedule;

class ScheduleManager implements ManagerInterface {

    public function schedule(Schedule $schedule) {
        $schedule->command("app:order:cleanup")->everyFiveMinutes();
    }
}