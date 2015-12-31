<?php namespace LaravelUploader\Contracts\Event;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 22:17
 */


interface GlobalUploadEvent
{
    /**
     *
     *  does not exist in config/uploader.php
     *
     * @return mixed
     *
     */
    public function unknownUploaderResponse();

    /**
     *
     *  form name does not exist in request
     *
     * @return mixed
     */
    public function uploadFileNotExistResponse();

    /**
     *
     * download file not exist in web server
     *
     * @return mixed
     */
    public function downloadFileNotExistResponse();

}