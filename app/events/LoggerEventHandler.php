<?php

class LoggerEventHandler {

	protected $opening;

	protected $closing;

	protected $filename;

  public function onLoggerExporting() {

    $FOLDER_PATH = storage_path('logs/');

    Self::setFilename();

    $filepath = "{$FOLDER_PATH}{$this->filename}.log";
      
    if (!file_exists($filepath)) {

      $file = fopen($filepath, 'a');

      Logger::chunk(200, function($logs) use($file) {

        foreach ($logs as $log) {
          
          $register = Self::getRegister($log);

          fwrite($file, $register);
        }
      });

      fclose($file);

      Logger::truncate();
    }
  }

  public function subscribe($events) {

    $events->listen('logger.exporting', 'LoggerEventHandler@onLoggerExporting');
  }

	private function setFilename() {

		if (date('d') >= 1 && date('d') <= 10)

      $this->filename = date('Y-m-30', strtotime(" -1 month"));

    if (date('d') > 10 && date('d') <= 20)

      $this->filename = date('Y-m-10');

    if (date('d') > 20 && date('d') <= 31)

      $this->filename = date('Y-m-20');
  }

  // Register Maker - Put all the pieces together to make a register line
  private static function getRegister($log) {

    $action     = $log->action;
    $created_at = $log->created_at;
    $message    = $log->message;
    $user       = 'NO USER';
    $role       = 'ANONYMOUS';

    if (!is_null($log->user)) {

      $user = "({$log->user_id}) {$log->user->email}";
      $role = $log->user->minRole()->name;
    }

    $register = "$created_at | [ $user : $role ] | $action | $message \r\n";

    return $register;
  }
}