<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('courses:send-notifications')->everyMinute();

