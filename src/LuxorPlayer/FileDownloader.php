<?php
namespace LuxorPlayer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class FileDownloader {
    
    private $name = "File Downloader";
    private $logger;
    
    public function __construct(){
        $this->logger = new Logger($this->name);    
    }
    
    /**
     * Download, replace csv file from remote server, but only if 
     * csv file was deleted from local directory or remote file is 
     * newer than locally stored version
     * 
     * @return boolean
     */    
    public function downloadCsv(){
        try {
            $file = include  __DIR__ . '/../../config/luxor.php';
            if(@fopen($file['file_paths']['remote_path'],"r")==true){
                $header = get_headers($file['file_paths']['remote_path'], 1);          
                $remoteTimestamp = 0;
                if(!$header || strpos($header[0], '200') !== false) {
                    $remoteModificationDate = new \DateTime($header['Last-Modified']);
                    $remoteTimestamp = $remoteModificationDate->getTimestamp();
                }
                if(!file_exists($file['file_paths']['local_path']) || (file_exists($file['file_paths']['local_path']) && 
                    ($remoteTimestamp > filemtime($file['file_paths']['local_path'])))){
                    file_put_contents($file['file_paths']['local_path'], file_get_contents($file['file_paths']['remote_path']));
                    return true;
                }
            } else {
                $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/error.log', Logger::ERROR));
                $this->logger->error($file['file_paths']['remote_path'] . " not found");    
            }
        } catch(\Exception $ex){
            $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/error.log', Logger::CRITICAL));
            $this->logger->critical($ex);
        }
        return false;
    }
    
}