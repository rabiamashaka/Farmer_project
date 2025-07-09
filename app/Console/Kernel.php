<?php
$schedule->command('weather:fetch')->everyTenMinutes()->withoutOverlapping();
