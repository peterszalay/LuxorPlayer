<?php
namespace LuxorPlayer;

interface TicketCreator
{
    public function getTickets() :array;
    public function createTicketsWithRandomNumbers(int $numberOfTickets, bool $enforceOddEvenRatio = false) :void;
    public function createTicketsWithRandomNumbersFromSelection(int $numberOfTickets, array $selection) :void;
    public function createTicketWithRandomNumbers(bool $enforceOddEvenRatio = false) :Ticket;
    public function createTicketWithRandomNumbersFromSelection(array $selection) :Ticket;
    public static function createTicket(array $picture, array $frame) :Ticket;
}
