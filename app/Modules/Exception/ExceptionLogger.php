<?php

	namespace Modules\Exception;

	use Monolog\Handler\StreamHandler;
	use Monolog\Logger;

	class ExceptionLogger
	{
		public static function write($logMessage, $logLevel)
		{
			$date = date('d_m_y');

			$logFile = public_path() . '/logs/log_' . $date . '.log';

			if (!file_exists($logFile)) {
				$fp = fopen($logFile, 'w');
				fwrite($fp, '');
				fclose($fp);
			}

			$log = new Logger('');

			switch ($logLevel) {
				case 'Warn':
					$log->pushHandler(new StreamHandler($logFile, Logger::WARNING));
					$log->addWarning($logMessage);
					break;

				case 'Error':
					$log->pushHandler(new StreamHandler($logFile, Logger::ERROR));
					$log->addError($logMessage);
					break;

				default:
					$log->pushHandler(new StreamHandler($logFile, Logger::INFO));
					$log->addInfo($logMessage);
			}

			$log->addInfo($logMessage);
		}
	}
