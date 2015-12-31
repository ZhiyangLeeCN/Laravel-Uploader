<?php namespace LaravelUploader\Controllers;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 21:41
 */

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use LaravelUploader\Contracts\Uploader\UploaderConfigManager;

class LaravelUploaderController extends Controller
{
    /**
     * Uploader Config Manager.
     *
     * @var UploaderConfigManager
     */
    protected $uploaderConfigManager;

    /**
     * Global upload event handler
     *
     * @var \LaravelUploader\Contracts\Event\GlobalUploadEvent
     */
    protected $gloablUploadEventHandler;

    /**
     *
     * local Filesystem
     *
     * @var
     */
    protected $localDisk;

    /**
     *  return uploader controller instance.
     *
     * @param UploaderConfigManager $uploaderConfigManager
     *
     */
    public function __construct(UploaderConfigManager $uploaderConfigManager)
    {
        $this->uploaderConfigManager = $uploaderConfigManager;
        $this->gloablUploadEventHandler = $this->uploaderConfigManager->getGlobalEventHandler();
        $this->localDisk = Storage::disk('local');
    }

    /**
     * Get pnly upload file name
     *
     * @return string
     */
    protected function createOnlyFileName()
    {
        return md5($_SERVER['REMOTE_ADDR'] . uniqid(mt_rand(), true));
    }

    /**
     *
     * check extension uploader is accept
     *
     * @param $extensionName
     * @param $acceptExtensions
     *
     * @return boolean
     */
    protected function isAcceptExtension($extensionName, $acceptExtensions)
    {
        if ($acceptExtensions[0] == '*') {

            return true;

        }

        return in_array($extensionName, $acceptExtensions);
    }

    /**
     *
     * response for download upload file
     *
     * @param Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Request $request)
    {
        if ($request->has('form_name') && $request->has('file_name')) {

            $formName = $request->input('form_name');
            $fileName = $request->input('file_name');
            $filePath = $formName . '/' . $fileName;

            if ($this->localDisk->exists($filePath)) {

                return response()->download(storage_path($filePath));

            }

        }

        return $this->gloablUploadEventHandler->downloadFileNotExistResponse();

    }

    /**
     *
     * process upload files
     *
     * @param Request $request
     * @return mixed
     */
    public function upload(Request $request)
    {

        if ($request->has('uploader')) {

            $uploaderName = $request->input('uploader');
            $uploaderConfig = $this->uploaderConfigManager->getUploaderConfig($uploaderName);
            $uploadEventHandler = $uploaderConfig->getUploadEventHandler();

            //is exist in config/uploader.php
            if ($uploaderConfig) {

                $formName = $uploaderConfig->getFormName();
                $acceptExtensions = $uploaderConfig->getAcceptExtensions();

                //check upload file is exist
                if ($request->hasFile($formName)) {

                    $uploadedFiles = [];

                    foreach ($request->file($formName) as $uploadFile) {

                        $extensionName = $uploadFile->getClientOriginalExtension();

                        if ($this->isAcceptExtension($extensionName, $uploaderConfig->getAcceptExtensions())) {

                            $destinationFileName  = $this->createOnlyFileName() . '.' .$extensionName;

                            array_push($uploadedFiles, $uploadFile->move(storage_path($formName), $destinationFileName));

                        } else {

                            return $uploadEventHandler->unacceptableExtensionResponse();

                        }
                    }

                    $uploadEventHandler->uploadCompleteResponse($uploadedFiles);

                } else {

                    $this->gloablUploadEventHandler->uploadFileNotExistResponse();

                }
            }
        }

        return $this->gloablUploadEventHandler->unknownUploaderResponse();

    }

}