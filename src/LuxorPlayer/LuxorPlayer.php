<?php
namespace LuxorPlayer;


abstract class LuxorPlayer
{
    protected const DEFAULT_WEEKS_ANALYZED = 0;
    protected const DEFAULT_DRAWS_PLAYED = 0;
    protected const DEFAULT_NUM_TICKETS = 0;
    protected const DEFAULT_MIN_SELECTION = 20;
    protected const DEFAULT_MAX_SELECTION = 70;
    protected const DEFAULT_REPEAT_TIMES = 1;
    protected const DEFAULT_STRATEGIES_PLAYED = 1;
    protected const DEFAULT_ORDER_BY = "orderByUniqueTotal";
}