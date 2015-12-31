<?php namespace LaravelUploader;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 21:11
 */

use LaravelUploader\Contracts\Uploader\UploaderConfig as UploaderConfigContract;

class UploaderConfig implements UploaderConfigContract
{

    /**
     * file name in form
     *
     * @var
     */
    protected $formName;

    /**
     * uploader accept extensions
     *
     * @var
     */
    protected $acceptExtensions;

    /**
     * process upload event handler instance
     *
     * @var
     */
    protected $uploadEventHandler;

    /**
     * return uploaderConfig instance
     *
     * UploaderConfig constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->formName = $config['form_name'];
        $this->acceptExtensions = $config['accept_extensions'];
        $this->uploadEventHandler = $this->getEventHandlerInstance($config['event_handler']);

    }

    /**
     *
     * Get event handler instance
     *
     * @param $class
     * @return UploadEventAdapter
     */
    protected function getEventHandlerInstance($class)
    {
        if (isset($class) && !empty($class)) {

            return new $class();

        } else {

            return new UploadEventAdapter();

        }
    }

    /**
     * Get file name in form
     *
     * @return mixed
     */
    public function getFormName()
    {
        return $this->formName;
    }

    /**
     * Get Uploader accept extensions
     *
     * @return mixed
     */
    public function getAcceptExtensions()
    {
        return $this->acceptExtensions;
    }

    /**
     * Get process upload event hanlder instance
     *
     * @return mixed
     */
    public function getUploadEventHandler()
    {
        return $this->uploadEventHandler;
    }
}