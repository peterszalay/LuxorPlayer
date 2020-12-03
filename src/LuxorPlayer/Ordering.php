<?php
namespace LuxorPlayer;

trait Ordering
{
    /**
     * Helper function that orders array elements by value of unique picture and frame
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    private function orderByUniquePicturesAndFrames(array $a, array $b) :int
    {
        $aTotal = ($a['unique_frame'] * 10) + $a['unique_picture'];
        $bTotal = ($b['unique_frame'] * 10) + $b['unique_picture'];
        if($aTotal < $bTotal){
            return 1;
        }else if($aTotal > $bTotal){
            return -1;
        }
        return 0;
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
        $aTotal = ($a['unique_frame'] * 10) + $a['unique_picture'];
        $bTotal = ($b['unique_frame'] * 10) + $b['unique_picture'];
        if($aTotal > $bTotal){
            return 1;
        }else if($aTotal < $bTotal){
            return -1;
        }
        return 0;
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
        $aTotal = ($a['frames'] * 10) + $a['pictures'];
        $bTotal = ($b['frames'] * 10) + $b['pictures'];
        if($aTotal < $bTotal){
            return 1;
        }else if($aTotal > $bTotal){
            return -1;
        }
        return 0;
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
        $aTotal = ($a['frames'] * 10) + $a['pictures'];
        $bTotal = ($b['frames'] * 10) + $b['pictures'];
        if($aTotal > $bTotal){
            return 1;
        }else if($aTotal < $bTotal){
            return -1;
        }
        return 0;
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
        $aTotal = ($a['luxor'] * 100) + ($a['frames'] * 10) + $a['pictures'];
        $bTotal = ($b['luxor'] * 100) + ($b['frames'] * 10) + $b['pictures'];
        if($aTotal < $bTotal){
            return 1;
        }else if($aTotal > $bTotal){
            return -1;
        }
        return 0;
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
        $aTotal = ($a['luxor'] * 100) + ($a['frames'] * 10) + $a['pictures'];
        $bTotal = ($b['luxor'] * 100) + ($b['frames'] * 10) + $b['pictures'];
        if($aTotal > $bTotal){
            return 1;
        }else if($aTotal < $bTotal){
            return -1;
        }
        return 0;
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
        $aTotal = ($a['unique_luxor'] * 100) + ($a['unique_frame'] * 10) + $a['unique_picture'];
        $bTotal = ($b['unique_luxor'] * 100) + ($b['unique_frame'] * 10) + $b['unique_picture'];
        if($aTotal < $bTotal){
            return 1;
        }else if($aTotal > $bTotal){
            return -1;
        }
        return 0;
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
        $aTotal = ($a['unique_luxor'] * 100) + ($a['unique_frame'] * 10) + $a['unique_picture'];
        $bTotal = ($b['unique_luxor'] * 100) + ($b['unique_frame'] * 10) + $b['unique_picture'];
        if($aTotal > $bTotal){
            return 1;
        }else if($aTotal < $bTotal){
            return -1;
        }
        return 0;
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
