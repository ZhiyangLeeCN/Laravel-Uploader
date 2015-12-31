<?php namespace LaravelUploader;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 22:18
 */


use LaravelUploader\Contracts\Event\GlobalUploadEvent;

class GlobalUploadEventAdapter implements GlobalUploadEvent
{

    /**
     *
     *  does not exist in config/uploader.php
     *
     * @return mixed
     *
     */
    public function unknownUploaderResponse()
    {
        return response()->json(['state' => 'ERROR', 'msg' => 'unknown uploader']);
    }

    /**
     *
     *  form name does not exist in request
     *
     * @return mixed
     */
    public function uploadFileNotExistResponse()
    {
        return response()->json(['state' => 'ERROR', 'msg' => 'upload file not exist']);
    }

    /**
     *
     * download file not exist in web server
     *
     * @return mixed
     */
    public function downloadFileNotExistResponse()
    {
        return response()->json(['state' => 'ERROR', 'msg' => 'download file not exist']);
    }
}