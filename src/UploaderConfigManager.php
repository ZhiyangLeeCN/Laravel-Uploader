<?php namespace LaravelUploader;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 20:38
 */

use LaravelUploader\Contracts\Uploader\UploaderConfigManager as UploaderConfigManagerContract;

class UploaderConfigManager implements UploaderConfigManagerContract
{
    /**
     * uploaderServers
     *
     * @var array
     */
    protected $uploaderConfig = [];

    /**
     *
     *  Handler on global upload event
     *
     * @var
     */
    protected $globalEventHandler;


    /**
     *
     * return UploaderAdapter Instance
     *
     * UploaderAdapter constructor.
     * @param array $uploaderConfig
     */
    public function __construct(array $uploaderConfig)
    {
        $this->registerUploaderConfig($uploaderConfig);
        $this->registerGlobalEventHandler($uploaderConfig);
    }

    /**
     *
     * register uploader config
     *
     * @param $uploaderConfig
     */
    protected function registerUploaderConfig($uploaderConfig)
    {
        foreach($uploaderConfig['uploaders'] as $uploaderName => $uploaderConfig) {

            $this->uploaderConfig[$uploaderName] = new UploaderConfig($uploaderConfig);

        }
    }

    /**
     * register global upload event handler
     *
     * @param $uploaderConfig
     */
    protected function registerGlobalEventHandler($uploaderConfig)
    {
        $handlerClass = $uploaderConfig['global_event_handler'];

        $this->globalEventHandler =  new $handlerClass();
    }


    /**
     * Get Uploader Server
     *
     * @param string $serverName
     * @return mixed
     */
    public function getUploaderConfig($serverName)
    {
        if (array_key_exists($serverName, $this->uploaderConfig)) {

            return $this->uploaderConfig[$serverName];

        } else {

            return null;

        }
    }

    /**
     * Get global upload event handler
     *
     * @return mixed
     *
     */
    public function getGlobalEventHandler()
    {
        return $this->globalEventHandler;
    }
}