<?php namespace LaravelUploader\Contracts\Event;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 21:29
 */

interface UploadEvent
{
    /**
     *
     * Responseup for Uploader unacceptable upload file extension
     *
     * @return mixed
     *
     */
    public function unacceptableExtensionResponse();

    /**
     *
     * Responseup for file upload complete
     *
     * @param  string $formName file name in form
     * @param  array $files uploaded file
     *
     * @return mixed
     *
     */
    public function uploadCompleteResponse($formName, array $files);

}