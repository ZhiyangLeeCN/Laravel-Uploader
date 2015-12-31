<?php namespace LaravelUploader;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 21:39
 */


use LaravelUploader\Contracts\Event\UploadEvent;

class UploadEventAdapter implements UploadEvent
{

    /**
     *
     * Responseup for Uploader unacceptable upload file extension
     *
     * @return mixed
     *
     */
    public function unacceptableExtensionResponse()
    {
        return response()->json(['state' => 'ERROR', 'msg' => 'the extension unacceptable']);
    }

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
    public function uploadCompleteResponse($formName, array $files)
    {
        $urls = [];

        foreach ($files as $file) {

            array_push($urls, action('LaravelUploader\Controllers\LaravelUploaderController@download', [

                'form_name' => $formName,
                'file_name' => $file->getFilename()

            ]));

        }

        return response()->json(['state' => 'SUCCESS', 'urls' => $urls]);
    }

    /**
     *
     *  does not exist in config/uploader.php
     *
     * @return mixed
     *
     */
    public function unknownUploader()
    {
        return response()->json(['state' => 'ERROR', 'msg' => 'unknown uploader']);
    }
}