<?php namespace LaravelUploader\Contracts\Uploader;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 21:00
 */


interface UploaderConfig
{
    /**
     * Get file name in form
     *
     * @return mixed
     */
    public function getFormName();

    /**
     * Get Uploader accept extensions
     *
     * @return mixed
     */
    public function getAcceptExtensions();

    /**
     * Get process upload event hanlder instance
     *
     * @return mixed
     */
    public function getUploadEventHandler();

}