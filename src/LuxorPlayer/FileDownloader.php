<?php
namespace LuxorPlayer;

use DateTime;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class FileDownloader
{
    
    private string $name = "File Downloader";
    private Logger $logger;
    
    public function __construct()
    {
        $this->logger = new Logger($this->name);    
    }
    
    /**
     * Download, replace csv file from remote server, but only if 
     * csv file was deleted from local directory or remote file is 
     * newer than locally stored version
     * 
     * @return bool
     */    
    public function downloadCsv() :bool
    {
        try {
            $file = include  __DIR__ . '/../../config/luxor.php';
            if(@fopen($file['file_paths']['remote_path'],"r")==true){
                $header = get_headers($file['file_paths']['remote_path'], 1);          
                $remoteTimestamp = $this->getRemoteTimestamp($header);
                return $this->saveCsv($file, $remoteTimestamp);
            } else {
                $this->logError($file['file_paths']['remote_path'] . " not found", Logger::ERROR);
            }
        } catch(Exception $ex){
            $this->logError($ex, Logger::CRITICAL);
        }
        return false;
    }

    /**
     * Log error to file
     *
     * @param string $message
     * @param int $level
     */
    private function logError(string $message, int $level) :void
    {
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/error.log', $level));
        $this->logger->critical($message);
    }

    /**
     * Get timestamp of remote file
     *
     * @param $header
     * @return int
     * @throws Exception
     */
    private function getRemoteTimestamp($header) :int
    {
        if(!$header || strpos($header[0], '200') !== false) {
            $remoteModificationDate = new DateTime($header['Last-Modified']);
            return $remoteModificationDate->getTimestamp();
        }
        return 0;
    }

    /**
     * Save csv
     *
     * @param $file
     * @param $remoteTimestamp
     * @return bool
     */
    private function saveCsv($file, $remoteTimestamp) :bool
    {
        if(!file_exists($file['file_paths']['local_path']) || (file_exists($file['file_paths']['local_path']) &&
                ($remoteTimestamp > filemtime($file['file_paths']['local_path'])))){
            file_put_contents($file['file_paths']['local_path'], file_get_contents($file['file_paths']['remote_path']));
            return true;
        }
        return false;
    }
    
}