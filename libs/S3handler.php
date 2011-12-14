<?php

// include pre-required
require_once dirname(dirname(__FILE__))."/venders/aws/sdk.class.php";

class S3handler {
    protected $s3;
    protected $options;

    public function __construct($options=null) {
        $this->options = array(
            'aws_s3_key' => '',
            'aws_s3_secret' => '',
            'aws_s3_bucket' => ''
        );
        if ($options) {
             $this->options = array_replace_recursive($this->options, $options);
        }

        try {
            $this->s3 = new AmazonS3($this->options['aws_s3_key'], $this->options['aws_s3_secret']);
        } catch (S3_Exception $e) {
            echo "Error: " . $e;
        }
    }
}

/* End of file S3handler.php */