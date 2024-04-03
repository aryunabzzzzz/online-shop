<?php

namespace Core;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Logger implements LoggerInterface
{
    public function emergency(string|\Stringable $message, array $context = []): void
    {
//        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(string|\Stringable $message, array $context = []): void
    {
//        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(string|\Stringable $message, array $context = []): void
    {
//        $this->log(LogLevel::CRITICAL, $message,$context);
    }

    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
//        $this->log(LogLevel::WARNING, $message, $context);

    }

    public function notice(string|\Stringable $message, array $context = []): void
    {
//        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
//        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
//        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $date = date('Y-m-d-m-Y-H-i-s');
        $context = implode("\n", $context);

        $message = sprintf('[%s] %s: %s%s', $date, $level, $message.$context."\n", PHP_EOL);

        file_put_contents(dirname(__DIR__) . '/Storage/Logs/errors.txt', $message, FILE_APPEND);

    }

}