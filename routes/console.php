<?php

declare(strict_types=1);

use App\Jobs\EraseExpiredAudio;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new EraseExpiredAudio)->everyMinute();
