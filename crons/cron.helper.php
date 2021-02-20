<?php

	define('LOCK_DIR', '/home/sparky/crons/');
	define('LOCK_SUFFIX', '.lock');

	class cronHelper {

		private static $pid;

		function __construct() {}

		function __clone() {}

		private static function isrunning() {
			$pids = explode(PHP_EOL, `ps -e | awk '{print $1}'`);
			if(in_array(self::$pid, $pids))
				return TRUE;
			return FALSE;
		}

		public static function lock() {
			global $argv;

			$lock_file = LOCK_DIR.$argv[0].LOCK_SUFFIX;

			if(file_exists("/home/sparky/crons/delSheets.lock.php")) {
				//return FALSE

				// Is running?
				self::$pid = file_get_contents("/home/sparky/crons/delSheets.lock.php");
				if(self::isrunning()) {
					error_log("==".self::$pid."== Already in progress...");
					return FALSE;
				}
				else {
					error_log("==".self::$pid."== Previous job died abruptly...");
				}
			}

			self::$pid = getmypid();
			file_put_contents("/home/sparky/crons/delSheets.lock.php", self::$pid);
			error_log("==".self::$pid."== Lock acquired, processing the job...");
			return self::$pid;
		}

		public static function unlock() {
			global $argv;

			$lock_file = LOCK_DIR.$argv[0].LOCK_SUFFIX;

			if(file_exists("/home/sparky/crons/delSheets.lock.php"))
				unlink("/home/sparky/crons/delSheets.lock.php");

			error_log("==".self::$pid."== Releasing lock...");
			return TRUE;
		}

	}

?>