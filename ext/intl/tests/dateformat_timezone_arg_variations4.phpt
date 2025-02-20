--TEST--
IntlDateFormatter: several forms of the timezone arg
--EXTENSIONS--
intl
--FILE--
<?php
ini_set("intl.error_level", E_WARNING);
ini_set("date.timezone", 'Atlantic/Azores');

$ts = strtotime('2012-01-01 00:00:00 UTC');

//should use Atlantic/Azores
$df = new IntlDateFormatter('es_ES', 0, 0, NULL);
echo $df->format($ts), "\n";

$df = new IntlDateFormatter('es_ES', 0, 0, 'Europe/Amsterdam');
echo $df->format($ts), "\n";

$df = new IntlDateFormatter('es_ES', 0, 0, new DateTimeZone('Europe/Lisbon'));
echo $df->format($ts), "\n";

$df = new IntlDateFormatter('es_ES', 0, 0, IntlTimeZone::createTimeZone('America/New_York'));
echo $df->format($ts), "\n";

//time zone has priority
$df = new IntlDateFormatter('es_ES', 0, 0, 'Europe/Amsterdam', new IntlGregorianCalendar('Europe/Lisbon'));
echo $df->format($ts), "\n";

//calendar has priority
$df = new IntlDateFormatter('es_ES', 0, 0, NULL, new IntlGregorianCalendar('Europe/Lisbon'));
echo $df->format($ts), "\n";

$df = new IntlDateFormatter('es_ES', 0, 0, 'Europe/Amsterdam', 0);
echo $df->format($ts), "\n";
?>
--EXPECT--
sábado, 31 de diciembre de 2011, 23:00:00 (hora estándar de las Azores)
domingo, 1 de enero de 2012, 1:00:00 (hora estándar de Europa central)
domingo, 1 de enero de 2012, 0:00:00 (hora estándar de Europa occidental)
sábado, 31 de diciembre de 2011, 19:00:00 (hora estándar oriental)
domingo, 1 de enero de 2012, 1:00:00 (hora estándar de Europa central)
domingo, 1 de enero de 2012, 0:00:00 (hora estándar de Europa occidental)
domingo, 1 de enero de 2012, 1:00:00 (hora estándar de Europa central)
