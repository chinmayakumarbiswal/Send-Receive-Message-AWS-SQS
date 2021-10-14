<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
    require './vendor/autoload.php';

    use Aws\Sqs\SqsClient;



        $client = SqsClient::factory(array(

        'credentials' => array (
            'key' => '<YOUR KEY HERE>',
            'secret' => '<YOUR SECRET KEY HERE>'
        ),

        'region' => 'ap-south-1',
        'version' => 'latest'
        ));
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQS Message</title>

    <style>
    .contact-form {
        margin-top: 15px;
    }

    .contact-form .textarea {
        min-height: 220px;
        resize: none;
    }

    .form-control {
        box-shadow: none;
        border-color: #eee;
        height: 49px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #00b09c;
    }

    .form-control-feedback {
        line-height: 50px;
    }

    .main-btn {
        background: #00b09c;
        border-color: #00b09c;
        color: #fff;
    }

    .main-btn:hover {
        background: #00a491;
        color: #fff;
    }

    .form-control-feedback {
        line-height: 50px;
        top: 0;
    }
    </style>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet"
        href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css" />
    <script type="text/javascript"
        src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js">
    </script>
</head>

<body>
    <div class="container">
        <div class="row">
            <form role="form" id="contact-form" class="contact-form" action="#" method="post">
                <div class="row">
                    <div class="row">
                        <div class="col-md-12">

                            <input type="submit" class="btn main-btn pull-right" value="Get Message" name="sendm"
                                required />
                        </div>
                    </div>
            </form>
            <?php

                if(isset($_POST['sendm']))
                {
                    $res = $client->receiveMessage(array(
                        'QueueUrl'          => 'https://sqs.ap-south-1.amazonaws.com/<YOUR SQS URL>',
                        'WaitTimeSeconds'   => 1
                    ));
                    if ($res->getPath('Messages')) {
                
                
                        foreach ($res->getPath('Messages') as $msg) {
                            echo "Received Msg: ".$msg['Body']."<br>";
                            echo "MessageId".$msg['MessageId']."<br>";
                            // Do something useful with $msg['Body'] here i delete the message 
                            $res = $client->deleteMessage(array(
                                'QueueUrl'      => 'https://sqs.ap-south-1.amazonaws.com/<YOUR SQS URL>',
                                'ReceiptHandle' => $msg['ReceiptHandle']
                            ));
                        }
                    }
                    else
                    {
                            echo "no data found";
                    }
                }
            ?>
        </div>
    </div>
</body>

</html>
