<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use \App;
use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;

class downloadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $strlow=strtolower($this->provider);
        $cloud=['black blaze','aws s3','google cloud'];
        if(in_array($strlow, $cloud))
        {
              $s3 = App::make('aws')->createClient('s3');
              $buckets = 'Anime6';

              $cmd = $s3->getCommand('GetObject', [
                'Bucket' => $buckets,
                'Key' => $this->file_name
            ]);
           // $url = $s3->getObjectUrl($buckets, $this->file_name);
          $request = $s3->createPresignedRequest($cmd, '+60 minutes');
        // // Get the actual presigned-url
               $presignedUrl = (string)$request->getUri();
            return [
                'link'=> $presignedUrl,
                'provider'=>$this->provider,
                'quality'=>$this->quality,
            ];
        }
        else
        {
              return [
              'link'=>$this->download_link,
              'provider'=>$this->provider,
                'quality'=>$this->quality,
            ];
        }
        // return parent::toArray($request);
    }
}




// use Aws\S3\S3Client;

//(aws settings at config/aws.php)


//generating signed url