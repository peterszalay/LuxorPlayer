<?php
namespace LuxorPlayer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Exception;

class LuxorConfiguration extends Configuration
{
    protected const DEFAULT_MIN_SELECTION = 20;
    protected const DEFAULT_MAX_SELECTION = 65;

    protected static int $minSelection = 0;
    protected static int $maxSelection = 0;

    private string $name = "Luxor Configuration";
    protected Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger($this->name);
    }

    /**
     * @param array $config
     */
    public static function setMinSelection(array $config): void
    {
        self::$minSelection = (isset($config['min_selection'])) ? self::getIntMinValue($config['min_selection'], self::DEFAULT_MIN_SELECTION) :
            self::DEFAULT_MIN_SELECTION;
    }

    /**
     * Checks if element contains the correct type and value below $returnValue
     * If yes it returns $element, if not it returns $returnValue
     *
     * @param $element
     * @param int $returnValue
     * @return int
     */
    protected static function getIntMaxValue($element, int $returnValue) :int
    {
        return (is_int($element) && $element < $returnValue) ? $element : $returnValue;
    }

    /**
     * @param array $config
     */
    public static function setMaxSelection(array $config): void
    {
        self::$maxSelection = (isset($config['max_selection'])) ? self::getIntMaxValue($config['max_selection'], self::DEFAULT_MAX_SELECTION) :
            self::DEFAULT_MAX_SELECTION;
    }

    /**
     * @return int
     */
    public static function getMinSelection(): int
    {
        return self::$minSelection;
    }

    /**
     * @return int
     */
    public static function getMaxSelection(): int
    {
        return self::$maxSelection;
    }

    protected static function setConfiguration(array $config): void
    {
        parent::setConfiguration($config);
        self::setMinSelection($config);
        self::setMaxSelection($config);
    }

    public function loadBaseConfig(string $configName) :bool
    {
        try {
            $file = include  __DIR__ . '/../../config/luxor.php';
            if (isset($file[$configName])) {
                self::setConfiguration($file[$configName]);
                return true;
            }
        } catch(Exception $ex){
            $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/error.log', Logger::CRITICAL));
            $this->logger->critical($ex);
        }
        return false;
    }

}
