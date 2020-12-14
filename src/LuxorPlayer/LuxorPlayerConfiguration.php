<?php
namespace LuxorPlayer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Exception;

class LuxorPlayerConfiguration extends LuxorConfiguration
{
    private static string $name = "Luxor Player Configuration";
    protected Logger $logger;

    private const DEFAULT_STRATEGIES_PLAYED = 1;
    private string $playerName;
    private array $playerStrategies;
    private int $playerNumStrategiesPlayed;
    private int $playerMinSelection;
    private int $playerMaxSelection;
    private array $playerPreviousDraws;
    private array $playerFirstSelection;
    private array $playerSecondSelection;
    private array $playerThirdSelection;
    private string $playerOrderBy;

    /**
     * LuxorPlayerConfiguration constructor.
     * @param string $playerName
     */
    public function __construct(string $playerName)
    {
        $this->playerName = $playerName;
        $this->logger = new Logger(self::$name);
    }

    /**
     * @return string
     */
    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    /**
     * @return array
     */
    public function getPlayerStrategies(): array
    {
        return $this->playerStrategies;
    }

    /**
     * @param array $config
     */
    public function setPlayerStrategies(array $config): void
    {
        $this->playerStrategies = (isset($config['strategies']) && is_array($config['strategies'])) ? $config['strategies'] :
                                    self::$strategies;
    }

    /**
     * @return int
     */
    public function getPlayerNumStrategiesPlayed(): int
    {
        return $this->playerNumStrategiesPlayed;
    }

    /**
     * @param array $config
     */
    public function setPlayerNumStrategiesPlayed(array $config): void
    {
        $this->playerNumStrategiesPlayed = (isset($config['strategies_played'])) ? self::getIntMinValue($config['strategies_played'], self::DEFAULT_STRATEGIES_PLAYED) :
                                            self::DEFAULT_STRATEGIES_PLAYED;
    }

    /**
     * @return int
     */
    public function getPlayerMinSelection(): int
    {
        return $this->playerMinSelection;
    }

    /**
     * @param array $config
     */
    public function setPlayerMinSelection(array $config): void
    {
        $this->playerMinSelection = (isset($config['min_selection'])) ? self::getIntMinValue($config['min_selection'], self::$minSelection) :
                                    self::$minSelection;
    }

    /**
     * @return int
     */
    public function getPlayerMaxSelection(): int
    {
        return $this->playerMaxSelection;
    }

    /**
     * @param array $config
     */
    public function setPlayerMaxSelection(array $config): void
    {
        $this->playerMaxSelection = (isset($config['max_selection'])) ? self::getIntMinValue($config['max_selection'], self::$maxSelection) :
                                    self::$maxSelection;
    }

    /**
     * @return array
     */
    public function getPlayerPreviousDraws(): array
    {
        return $this->playerPreviousDraws;
    }

    /**
     * @param array $config
     */
    public function setPlayerPreviousDraws(array $config): void
    {
        $this->playerPreviousDraws = (isset($config['previous_draws']) && is_array($config['previous_draws'])) ? $config['previous_draws'] :
                                     self::$previousDraws;
    }

    /**
     * @return array
     */
    public function getPlayerFirstSelection(): array
    {
        return $this->playerFirstSelection;
    }

    /**
     * @param array $config
     */
    public function setPlayerFirstSelection(array $config): void
    {
        $this->playerFirstSelection = (isset($config['one_selection']) && is_array($config['one_selection'])) ? $config['one_selection'] :
                                      self::$firstSelection;
    }

    /**
     * @return array
     */
    public function getPlayerSecondSelection(): array
    {
        return $this->playerSecondSelection;
    }

    /**
     * @param array $config
     */
    public function setPlayerSecondSelection(array $config): void
    {
        $this->playerSecondSelection = (isset($config['two_selections']) && is_array($config['two_selections'])) ? $config['two_selections'] :
                                       self::$secondSelection;
    }

    /**
     * @return array
     */
    public function getPlayerThirdSelection(): array
    {
        return $this->playerThirdSelection;
    }

    /**
     * @param array $config
     */
    public function setPlayerThirdSelection(array $config): void
    {
        $this->playerThirdSelection = (isset($config['three_selections']) && is_array($config['three_selections'])) ? $config['three_selections'] :
                                      self::$thirdSelection;
    }

    /**
     * @return string
     */
    public function getPlayerOrderBy(): string
    {
        return $this->playerOrderBy;
    }

    /**
     * @param array $config
     */
    public function setPlayerOrderBy(array $config): void
    {
        $this->playerOrderBy = (is_string($config['order_by'])) ? $config['order_by'] : self::$orderBy;
    }

    public function loadPlayerConfig(string $configName) :bool
    {

    }

}
