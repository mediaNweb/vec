<?php
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=plantilla_resultados_racetimer.csv');
header('Pragma: no-cache');
readfile("http://result.entrysystem.live/download/plantilla_resultados_racetimer.csv");
?>