<?php namespace LaravelUploader\Contracts\Uploader;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 20:53
 */

interface UploaderConfigManager
{
    /**
     * Get Uploader Server
     *
     * @param string $serverName
     * @return mixed
     */
    public function getUploaderConfig($serverName);

    /**
     * Get global upload event handler
     *
     * @return mixed
     */
    public function getGlobalEventHandler();

}