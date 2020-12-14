<?php
namespace LuxorPlayer;

interface Game
{
    public function getResults() :array;
    public function processTicketsForDraws(array $tickets, array $draws) :array;
    public function processTicketsForADraw(array $tickets, array $draw) :void;
    public function processTicket(Ticket $ticket, array $draw) :void;
}
