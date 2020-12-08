<?php

use Aws\Laravel\AwsServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | AWS SDK Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options set in this file will be passed directly to the
    | `Aws\Sdk` object, from which all client objects are created. This file
    | is published to the application config directory for modification by the
    | user. The full set of possible options are documented at:
    | http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html
    |
    */
    // 'credentials' => [
    //     'key'    => env('AWS_ACCESS_KEY_ID', ''),
    //     'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
    // ],
    // 'region' => env('AWS_REGION', 'us-east-1'),
    // 'version' => 'latest',
    // 'ua_append' => [
    //     'L5MOD/' . AwsServiceProvider::VERSION,
    // ],iconv(in_charset, out_charset, str)
        'credentials' => [
        'key'    => '0026ba12819e5c30000000005',
        'secret' => 'K002wp5uuJJkwMSAc93Fs9IwVNPA40w',
             ],
    'endpoint' => 'https://s3.us-west-002.backblazeb2.com',
    // 'profile' => 'b2',
    'region' => 'us-west-002',
    'version' => 'latest',
    // 'ua_append' => [
    //     'L5MOD/' . AwsServiceProvider::VERSION,
    // ],
];
