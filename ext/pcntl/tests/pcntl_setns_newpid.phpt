--TEST--
pcntl_setns()
--EXTENSIONS--
pcntl
posix
--SKIPIF--
<?php
if (!function_exists("pcntl_setns")) die("skip pcntl_setns is not available");
if (getenv('SKIP_ASAN')) die('skip Timeouts under ASAN');

$pid = pcntl_fork();
if ($pid == -1) die("skip pcntl_fork failed");
if ($pid != 0) {
    if (@pcntl_setns($pid, CLONE_NEWPID) === false && pcntl_get_last_error() == PCNTL_EPERM) {
        die("skip Insufficient privileges to use pcntl_setns()");
    }
}
?>
--FILE--
<?php
$pid = pcntl_fork();
if ($pid == -1) die("pcntl_fork failed");
if ($pid != 0) {
	var_dump(pcntl_setns($pid, CLONE_NEWPID));
}
?>
--EXPECT--
bool(true)
