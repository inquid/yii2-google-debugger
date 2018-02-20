<?php

namespace inquid\google_debugger;

use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\LoggingClient;
use yii\log\Target;

/**
 * Created by Inquid Inc.
 * User: gogl92
 * Date: 25/07/17
 * Time: 01:45 AM
 */
class GoogleCloudLogger extends Target
{
    /**
     * @var string $projectId
     */
    public $projectId;
    /**
     * @var string $loggerInstance
     */
    public $loggerInstance;
    /**
     * @var string $clientSecretPath
     */
    public $clientSecretPath;
    /**
     * @var Logger $logger
     */
    private $logger;
    private $logging;

    /*
     * Constants to use along the project
     */
    const FACTURAS_LOG = "factura-log";
    const INVENTARIOS_LOG = "inventarios-log";
    const REPORTES_LOG = "reportes-log";
    const CATALOGOS_LOG = "catalogos-log";
    const ORDENES_LOG = "ordenes-log";

    /**
     * Initializes the GoogleCloudLogger component.
     * This method will initialize the Google Cloud property to make sure it refers to a valid Google project.
     */
    public function init()
    {
        parent::init();
        $this->logging = new LoggingClient([
            'projectId' => $this->projectId,
            'keyFilePath' => $this->clientSecretPath,
        ]);
        // Get a logger instance.
        $this->logger = $this->logging->logger($this->loggerInstance);
    }

    /**
     * Exports log [[messages]] to a specific destination.
     * Child classes must implement this method.
     */
    public function export()
    {
        $this->getLevels();
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            switch ($level) {
                case 1:
                    $this->logger->write(Target::formatMessage($message), ['severity' => Logger::ERROR]);
                    break;
                case 2:
                    $this->logger->write(Target::formatMessage($message), ['severity' => Logger::WARNING]);
                    break;
                case 4:
                    $this->logger->write(Target::formatMessage($message), ['severity' => Logger::INFO]);
                    break;
                case 8:
                    $this->logger->write(Target::formatMessage($message), ['severity' => Logger::DEBUG]);
                    break;
                case 64:
                    $this->logger->write(Target::formatMessage($message), ['severity' => Logger::DEBUG]);
                    break;
                default:
                    $this->logger->write(Target::formatMessage($message), ['severity' => Logger::INFO]);
                    break;
            }
        }
    }
}
