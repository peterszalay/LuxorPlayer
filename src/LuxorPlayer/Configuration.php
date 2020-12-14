<?php
namespace LuxorPlayer;

abstract class Configuration
{
    private const DEFAULT_WEEKS_ANALYZED = 1;
    private const DEFAULT_DRAWS_PLAYED = 1;
    private const DEFAULT_NUM_TICKETS = 1;
    private const DEFAULT_REPEAT_TIMES = 1;
    private const DEFAULT_ORDER_BY = "orderByTotal";
    private const DEFAULT_PREVIOUS_DRAWS = [1];
    private const DEFAULT_STRATEGIES_PLAYED = ["LEAST_DRAWN","MOST_DRAWN","LEAST_DRAWN_AND_RANDOM","MOST_DRAWN_AND_RANDOM",
                                                "LEAST_AND_MOST_DRAWN","MOST_LEAST_AND_RANDOM"];
    protected const DEFAULT_FIRST_SELECTION = [];
    protected const DEFAULT_SECOND_SELECTION = [];
    protected const DEFAULT_THIRD_SELECTION = [];

    protected static int $draws = 0;
    protected static int $ticketCount = 0;
    protected static array $strategies = [];
    protected static array $previousDraws = [];
    protected static int $weeksAnalyzed = 0;
    protected static int $repeat = 0;
    protected static string $orderBy = '';
    protected static array $firstSelection = [];
    protected static array $secondSelection = [];
    protected static array $thirdSelection = [];

    /**
     * Checks if element contains the correct type and value above $returnValue
     * If yes it returns $element, if not it returns $returnValue
     *
     * @param $element
     * @param int $returnValue
     * @return int
     */
    protected static function getIntMinValue($element, int $returnValue) :int
    {
        return (is_int($element) && $element > $returnValue) ? $element : $returnValue;
    }

    /**
     * @param array $config
     */
    public static function setDraws(array $config): void
    {
        self::$draws = (isset($config['draws'])) ? self::getIntMinValue($config['draw'], self::DEFAULT_DRAWS_PLAYED) :
                       self::DEFAULT_DRAWS_PLAYED;
    }

    /**
     * @param array $config
     */
    public static function setTicketCount(array $config): void
    {
        self::$ticketCount = (isset($config['tickets'])) ? self::getIntMinValue($config['tickets'], self::DEFAULT_NUM_TICKETS) :
                             self::DEFAULT_NUM_TICKETS;
    }

    /**
     * @param array $config
     */
    public static function setStrategies(array $config): void
    {
        self::$strategies = (isset($config['strategies']) && is_array($config['strategies'])) ? $config['strategies'] :
                             self::DEFAULT_STRATEGIES_PLAYED;
    }

    /**
     * @param array $config
     */
    public static function setPreviousDraws(array $config): void
    {
        self::$previousDraws = (isset($config['previous_draws']) && is_array($config['previous_draws'])) ? $config['previous_draws'] :
                                self::DEFAULT_PREVIOUS_DRAWS;
    }

    /**
     * @param array $config
     */
    public static function setWeeksAnalyzed(array $config): void
    {
        self::$weeksAnalyzed = (isset($config['weeks_analyzed'])) ? self::getIntMinValue($config['weeks_analyzed'], self::DEFAULT_WEEKS_ANALYZED) :
                                self::DEFAULT_WEEKS_ANALYZED;
    }

    /**
     * @param array $config
     */
    public static function setRepeat(array $config): void
    {
        self::$repeat = (isset($config['repeat_times'])) ? self::getIntMinValue($config['repeat_times'], self::DEFAULT_REPEAT_TIMES) :
                        self::DEFAULT_REPEAT_TIMES;
    }

    /**
     * @param array $config
     */
    public static function setOrderBy(array $config): void
    {
        self::$orderBy = (is_string($config['order_by'])) ? $config['order_by'] : self::DEFAULT_ORDER_BY;
    }

    /**
     * @param array $config
     */
    public static function setFirstSelection(array $config): void
    {
        self::$firstSelection = (isset($config['one_selection']) && is_array($config['one_selection'])) ? $config['one_selection'] :
            self::DEFAULT_FIRST_SELECTION;
    }

    /**
     * @param array $config
     */
    public static function setSecondSelection(array $config): void
    {
        self::$secondSelection = (isset($config['two_selections']) && is_array($config['two_selections'])) ? $config['two_selections'] :
            self::DEFAULT_SECOND_SELECTION;
    }

    /**
     * @param array $config
     */
    public static function setThirdSelection(array $config): void
    {
        self::$thirdSelection = (isset($config['three_selections']) && is_array($config['three_selections'])) ? $config['three_selections'] :
            self::DEFAULT_THIRD_SELECTION;
    }

    /**
     * @return int
     */
    public static function getDraws(): int
    {
        return self::$draws;
    }

    /**
     * @return int
     */
    public static function getTicketCount(): int
    {
        return self::$ticketCount;
    }

    /**
     * @return array
     */
    public static function getStrategies(): array
    {
        return self::$strategies;
    }

    /**
     * @return array
     */
    public static function getPreviousDraws(): array
    {
        return self::$previousDraws;
    }

    /**
     * @return int
     */
    public static function getWeeksAnalyzed(): int
    {
        return self::$weeksAnalyzed;
    }

    /**
     * @return int
     */
    public static function getRepeat(): int
    {
        return self::$repeat;
    }

    /**
     * @return string
     */
    public static function getOrderBy(): string
    {
        return self::$orderBy;
    }

    /**
     * @return array
     */
    public static function getFirstSelection(): array
    {
        return self::$firstSelection;
    }

    /**
     * @return array
     */
    public static function getSecondSelection(): array
    {
        return self::$secondSelection;
    }

    /**
     * @return array
     */
    public static function getThirdSelection(): array
    {
        return self::$thirdSelection;
    }

    /**
     * @param array $config
     */
    protected static function setConfiguration(array $config) :void
    {
        self::setDraws($config);
        self::setWeeksAnalyzed($config);
        self::setRepeat($config);
        self::setStrategies($config);
        self::setPreviousDraws($config);
        self::setTicketCount($config);
        self::setOrderBy($config);
        self::setFirstSelection($config);
        self::setSecondSelection($config);
        self::setThirdSelection($config);
    }

    /**
     * @param string $configName
     * @return bool
     */
    public abstract function loadBaseConfig(string $configName) :bool;
}