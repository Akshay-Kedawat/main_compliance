<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

abstract class Controller extends BaseController
{
    public $status  = false;
    public $code    = '';
    public $message = '';
    public $data    = [];
    public $type    = '';
    public $token   = '';
    public $expires = '';

    public function apiResponse()
    {
        header('Content-Type: application/json');
        if ($this->token!='') {
            $response = [
                'status'    => $this->status,
                'code'      => $this->code,
                'message'   => $this->message,
                'data'      => $this->data,
                'type'      => $this->type,
                'expires'   => $this->expires,
                'token'     => $this->token
            ];
        }else {
            $response = [
                'status'    => $this->status,
                'message'   => $this->message,
                'data'      => $this->data
            ];
        }
        echo json_encode($response);
    }
    public function uploadFile($file, $path)
    {
        $fileName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        $filePath = $path . $fileName;
        Storage::disk('public')->put($filePath, file_get_contents($file));
        
        return ['filePath' => 'storage/'.$filePath];
    }
    public function unlinkFile($filePath)
    {
        if (!empty($filePath)) {
            $path = str_replace('storage/', '', $filePath);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
        return true;
    }
}
