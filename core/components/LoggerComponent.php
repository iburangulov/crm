<?php

namespace App\components;

use App\contracts\ComponentsContract;
use App\exceptions\RaptorException;

final class LoggerComponent extends BaseComponent implements ComponentsContract
{
    const COMPONENT_NAME = 'Logger';

    const DATE = 'Y-m-d';
    const TIME = 'H:i:s';

    /**
     * @var bool
     * Логгироание
     */
    private $logging = false;

    /**
     * @var string
     * Файл лога
     */
    private $logfile = null;

    public function init()
    {
        if ($_ENV['LOGGING'] === 'true') {
            $this->logging = true;
            $this->logfile = ROOT_DIR . 'logs/' . $this->getTimeStamp(self::DATE) . '.log';
        }
    }

    public function test()
    {
        if ($this->logging && !is_writable(ROOT_DIR)) throw new RaptorException(ComponentsManager::getErrorMessage('NOT_WRITABLE'));
    }

    /**
     * @param string $message
     * @param array $context
     * @throws RaptorException
     * Запись в лог
     */
    public static function log(string $message, array $context = []): void
    {
        $logger = ComponentsManager::getComponent(self::COMPONENT_NAME);

        if ($logger->logging)
        {
            if (!file_exists(ROOT_DIR . 'logs/')) mkdir(ROOT_DIR . 'logs/');

            $messageFormated = $logger->getTimeStamp() . ': ' . ComponentsManager::getErrorMessage($message) . PHP_EOL;
            if ($context) {
                foreach ($context as $errName => $errMsg) {
                    $messageFormated .= "\t" . $errName . ': ' . $errMsg . PHP_EOL;
                }
            }
            file_put_contents($logger->logfile, $messageFormated, FILE_APPEND);
        }
    }

    /**
     * @return string
     * Возвращает текущие дату и время
     */
    private function getTimeStamp(string $type = ''): string
    {
        switch ($type) {
            case self::DATE:
                return date("Y-m-d");
            case self::TIME:
                return date("H:i:s");
            default:
                return date("Y-m-d H:i:s");
        }
    }
}