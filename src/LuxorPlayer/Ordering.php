<?php
namespace LuxorPlayer;

trait Ordering
{
    private static int $luxorMultiplier = 100;
    private static int $frameMultiplier = 10;

    private static function getTotal(int $picture, int $frame, int $luxor) :int
    {
        return ($luxor * self::$luxorMultiplier) + ($frame * self::$frameMultiplier) + $picture;
    }

    /**
     * Helper function that orders array elements by value of unique picture and frame
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByUniquePicturesAndFrames(array $a, array $b) :int
    {
        return (self::getTotal($b['unique_picture'], $b['unique_frame'] , 0) <=> self::getTotal($a['unique_picture'], $a['unique_frame'] , 0) );
    }

    /**
     * Helper function that orders array elements by value of unique picture and frame desc
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByUniquePicturesAndFramesDesc(array $a, array $b) :int
    {
        return (self::getTotal($a['unique_picture'], $a['unique_frame'] , 0) <=> self::getTotal($b['unique_picture'], $b['unique_frame'] , 0));
    }

    /**
     * Helper function that orders array elements by value of picture and frame
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByPicturesAndFrames(array $a, array $b) :int
    {
        return (self::getTotal($b['pictures'], $b['frames'] , 0) <=> self::getTotal($a['pictures'], $a['frames'] , 0));
    }

    /**
     * Helper function that orders array elements by value of picture and frame desc
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByPicturesAndFramesDesc(array $a, array $b) :int
    {
        return (self::getTotal($a['pictures'], $a['frames'] , 0) <=> self::getTotal($b['pictures'], $b['frames'] , 0));
    }

    /**
     * Helper function that orders array elements by value of total
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByTotal(array $a, array $b) :int
    {
        return (self::getTotal($b['pictures'], $b['frames'] , $b['luxor']) <=> self::getTotal($a['pictures'], $a['frames'] , $a['luxor'] ));
    }

    /**
     * Helper function that orders array elements by value of total desc
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByTotalDesc(array $a, array $b) :int
    {
        return (self::getTotal($a['pictures'], $a['frames'] , $a['luxor'] ) <=> self::getTotal($b['pictures'], $b['frames'] , $b['luxor']));
    }

    /**
     * Helper function that orders array elements by value of total
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByUniqueTotal(array $a, array $b) :int
    {
        return (self::getTotal($b['unique_picture'], $b['unique_frame'] , $b['unique_luxor']) <=>
                self::getTotal($a['unique_picture'], $a['unique_frame'] , $a['unique_luxor']));
    }

    /**
     * Helper function that orders array elements by value of total desc
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByUniqueTotalDesc(array $a, array $b) :int
    {
        return (self::getTotal($a['unique_picture'], $a['unique_frame'] , $a['unique_luxor']) <=>
                self::getTotal($b['unique_picture'], $b['unique_frame'] , $b['unique_luxor']));
    }

    /**
     * Helper function which is used by usort to sort by times_drawn and avg_draw_position in order of most drawn
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByMostDrawn(array $a, array $b) :int
    {
        if($a['times_drawn'] < $b['times_drawn'] || ($a['times_drawn'] == $b['times_drawn'] &&
                $a['avg_draw_position'] > $b['avg_draw_position'])){
            return 1;
        }else if($a['times_drawn'] > $b['times_drawn'] || ($a['times_drawn'] == $b['times_drawn'] &&
                $a['avg_draw_position'] < $b['avg_draw_position'])){
            return -1;
        }
        return 0;
    }

    /**
     * Helper function which is used by usort to sort by times_drawn and avg_draw_position in order of least drawn
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByLeastDrawn(array $a, array $b) :int
    {
        if($a['times_drawn'] > $b['times_drawn'] || ($a['times_drawn'] == $b['times_drawn']
                && $a['avg_draw_position'] < $b['avg_draw_position'])){
            return 1;
        }else if($a['times_drawn'] < $b['times_drawn'] || ($a['times_drawn'] == $b['times_drawn']
                && $a['avg_draw_position'] > $b['avg_draw_position'])){
            return -1;
        }
        return 0;
    }
}
