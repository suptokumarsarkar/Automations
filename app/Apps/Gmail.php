<?php

namespace App\Apps;

use App\Apps\Triggers\GmailTrigger;
use App\Logic\Helpers;
use App\Models\Account;
use App\Models\AppsData;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Gmail
{
//    private $client_id = '68667692288-4bkagbc71fb2k0c9dr481ip9ib22iffv.apps.googleusercontent.com';
//    private $client_secret = "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";

    /**
     * @var mixed
     */
    private $client_id;
    /**
     * @var mixed
     */
    private $client_secret;

    public function __construct()
    {
        $gmail = AppsData::where("AppId", "Gmail")->first();
        if ($gmail) {
            $appInfo = json_decode($gmail->AppInfo, true);
            $this->client_id = $appInfo['client_id'];
            $this->client_secret = $appInfo['client_secret'];
        }
    }

    public function StoreGmail(Request $request)
    {
        $request = json_encode($request, true);
        $webSettings = new WebSetting;
        $webSettings->key = "email-" . rand();
        $webSettings->value = $request;
        $webSettings->save();
    }

    public function getTrigger(): array
    {
        return array(
            [
                'id' => 'new_label',
                'name' => Helpers::translate('New Label'),
                'description' => Helpers::translate('Triggers when you add a new label')
            ],
            [
                'id' => 'new_attachment',
                'name' => Helpers::translate('New Attachment'),
                'description' => Helpers::translate('Triggers when you receive a new attachment')
            ],
            [
                'id' => 'new_email',
                'name' => Helpers::translate('New Email'),
                'description' => Helpers::translate('Triggers when you receive a new email')
            ],
            [
                'id' => 'new_email_matching_search',
                'name' => Helpers::translate('New Email Matching Search'),
                'description' => Helpers::translate('Triggers when you receive a new email that matches with your provided string')
            ],
            /*
            [
                'id' => 'new_labeled_email',
                'name' => Helpers::translate('New Labeled Email'),
                'description' => Helpers::translate('Triggers when you label an email')
            ],*/

            [
                'id' => 'new_starred_email',
                'name' => Helpers::translate('New Starred Email'),
                'description' => Helpers::translate('Triggers when you receive an email and star it within two days')
            ],
            [
                'id' => 'new_thread',
                'name' => Helpers::translate('New Thread'),
                'description' => Helpers::translate('Triggers when a new thread starts')
            ]
        );
    }

    public function getActions(): array
    {
        return array(
            [
                'id' => 'add_label_to_email',
                'name' => Helpers::translate('New Label to Email'),
                'description' => Helpers::translate('Add a label to an email message')
            ],
            [
                'id' => 'create_draft',
                'name' => Helpers::translate('Create Draft'),
                'description' => Helpers::translate('Create but do not send a new email (saved into draft).')
            ],
            [
                'id' => 'create_label',
                'name' => Helpers::translate('Create Label'),
                'description' => Helpers::translate('Creates a label')
            ],
            [
                'id' => 'send_email',
                'name' => Helpers::translate('Send Email'),
                'description' => Helpers::translate('Create and send a new message')
            ],
            [
                'id' => 'remove_label_from_email',
                'name' => Helpers::translate('Remove Label From Email'),
                'description' => Helpers::translate('Remove a label from an email message')
            ],
            [
                'id' => 'reply_to_the_email',
                'name' => Helpers::translate('Reply to the Email'),
                'description' => Helpers::translate('Sends a reply to the email message')
            ]
        );
    }


    public function getRefreshToken($refreshToken)
    {
        $data = [
            'refresh_token' => $refreshToken,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'refresh_token'
        ];

        $url = "https://oauth2.googleapis.com/token";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

// execute!
        $response = curl_exec($ch);
        return json_decode($response, 1);
    }

    public function getToken($id)
    {
        $getProfile = Account::find($id);
        $token = json_decode($getProfile->token, true);
        $refreshToken = $this->getRefreshToken($token['refresh_token']);
        return $refreshToken['access_token'];
    }

    public function getUserId($actionAccount)
    {
        $getProfile = Account::find($actionAccount);
        $token = json_decode($getProfile->data, true);
        return $token['sub'];
    }

    public function getCheckupData($accountId, $labelId)
    {
        $getProfile = Account::find($accountId);
        $data = json_decode($getProfile->data, true);
        $access_token = $this->getToken($accountId);
        $trigger = new GmailTrigger($accountId);
        return [
            'access_token' => $access_token,
            'view' => $trigger->$labelId(),
        ];
    }

    public function checkAccount($id)
    {
        if ($access_token = $this->getToken($id)) {
            $url = "https://www.googleapis.com/oauth2/v3/userinfo?access_token=" . $access_token;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $profile = json_decode($response, 1);

            if (isset($profile) && count($profile) != 0) {
                return true;
            }
        }
        return false;
    }


//    Real API

    public function getLabels($access_token, $userId)
    {
        $url = "https://gmail.googleapis.com/gmail/v1/users/$userId/labels?access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        return json_decode($response, 1);
    }

    public function getLabel($access_token, $userId, $labelId)
    {
        $url = "https://gmail.googleapis.com/gmail/v1/users/$userId/labels/$labelId?access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        return json_decode($response, 1);
    }

    public function createLabel($access_token, $userId, $param = [])
    {

        $params = [
            'name' => $param['name'] ?? 'Demo Label ' . rand(),
            'messageListVisibility' => $param['messageListVisibility'] ?? 'show',
            'labelListVisibility' => $param['labelListVisibility'] ?? 'labelShow',
            'type' => $param['type'] ?? 'user',
            'color' => [
                'textColor' => '#ffffff',
                'backgroundColor' => '#3c78d8',
            ]
        ];
        $url = "https://gmail.googleapis.com/gmail/v1/users/me/labels?alt=json&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $data = curl_exec($ch);

        return json_decode($data, true);
    }

    // Gmail Messages
    public function getEmails($access_token, $userId, $param = [])
    {
        $params = [
            'maxResults' => $param['maxResults'] ?? 50,
            'includeSpamTrash' => $param['includeSpamTrash'] ?? false,
        ];
        if (isset($param['pageToken'])) {
            $params['pageToken'] = $param['pageToken'] ?? '';
        }
        if (isset($param['labelIds']) && is_array($param['labelIds'])) {
            if (!isset($params['q'])) {
                $string = '';
                foreach ($param['labelIds'] as $key => $label) {
                    $string .= "in:$label";
                    if ($key !== count($param['labelIds']) - 1) {
                        $string .= " ";
                    }
                }

                $params['q'] = " {" . $string . "} ";
            }
        } elseif (isset($param['labelIds'])) {
            $params['labelIds'] = $param['labelIds'];
        }
        if (isset($param['q'])) {
            foreach ($param['q'] as $q) {
                if ($q != null) {
                    if (!isset($params['q'])) {
                        $params['q'] = $q . " ";
                    } else {
                        $params['q'] .= $q . " ";
                    }
                }
            }
        }

        if (isset($param['hasAttachment'])) {
            if (!isset($params['q'])) {
                $params['q'] = ($param['hasAttachment'] ?? '') . " ";
            } else {
                $params['q'] .= ($param['hasAttachment'] ?? '') . " ";
            }
        }
        if (isset($params['q'])) {
            $params['q'] = trim($params['q']);
        }
        $url = "https://gmail.googleapis.com/gmail/v1/users/$userId/messages?alt=json&access_token=" . $access_token . "&" . http_build_query($params);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        return json_decode($response, 1);
    }

    // Gmail Messages
    public function getEmail($access_token, $userId, $emailId)
    {
        $url = "https://gmail.googleapis.com/gmail/v1/users/$userId/messages/$emailId?alt=json&access_token=" . $access_token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        return json_decode($response, 1);
    }

    // Gmail Threads
    public function getThreads($access_token, $userId, $param = [])
    {
        $params = [
            'maxResults' => $param['maxResults'] ?? 50,
            'includeSpamTrash' => $param['includeSpamTrash'] ?? false,
        ];
        if (isset($param['pageToken'])) {
            $params['pageToken'] = $param['pageToken'] ?? '';
        }
        if (isset($param['labelIds']) && is_array($param['labelIds'])) {
            if (!isset($params['q'])) {
                $string = '';
                foreach ($param['labelIds'] as $key => $label) {
                    $string .= "in:$label";
                    if ($key !== count($param['labelIds']) - 1) {
                        $string .= " ";
                    }
                }

                $params['q'] = " {" . $string . "} ";
            }
        } elseif (isset($param['labelIds'])) {
            $params['labelIds'] = $param['labelIds'];
        }
        if (isset($param['q'])) {
            foreach ($param['q'] as $q) {
                if ($q != null) {
                    if (!isset($params['q'])) {
                        $params['q'] = $q . " ";
                    } else {
                        $params['q'] .= $q . " ";
                    }
                }
            }
        }

        if (isset($param['hasAttachment'])) {
            if (!isset($params['q'])) {
                $params['q'] = ($param['hasAttachment'] ?? '') . " ";
            } else {
                $params['q'] .= ($param['hasAttachment'] ?? '') . " ";
            }
        }
        if (isset($params['q'])) {
            $params['q'] = trim($params['q']);
        }
        $url = "https://gmail.googleapis.com/gmail/v1/users/$userId/threads?alt=json&access_token=" . $access_token . "&" . http_build_query($params);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        return json_decode($response, 1);
    }

    // Gmail Messages
    public function getThread($access_token, $userId, $emailId)
    {
        $url = "https://gmail.googleapis.com/gmail/v1/users/$userId/threads/$emailId?alt=json&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        return json_decode($response, 1);
    }


    public function getLatestAttachment($access_token, $userId, $param, $id = null, $thread = false)
    {
        if ($thread) {
            if ($id == null) {
                $messages = $this->getThreads($access_token, $userId, $param);
                $lastMessage = $messages['threads'][0];
                $historyId = $lastMessage['historyId'];
                $getThread = $this->getThread($access_token, $userId, $lastMessage['id']);
                foreach ($getThread['messages'] as $message) {
                    if ($message['historyId'] == $historyId) {
                        $readMessage = $this->getEmail($access_token, $userId, $message['id']);
                    }
                }
            } else {
                $getThread = $this->getThread($access_token, $userId, $id);
                $historyId = $getThread['historyId'];
                foreach ($getThread['messages'] as $message) {
                    if ($message['historyId'] == $historyId) {
                        $readMessage = $this->getEmail($access_token, $userId, $message['id']);
                    }
                }
            }
        } else {
            if ($id == null) {
                $messages = $this->getEmails($access_token, $userId, $param);
                $lastMessage = $messages['messages'][0];
                $readMessage = $this->getEmail($access_token, $userId, $lastMessage['id']);
            } else {
                $readMessage = $this->getEmail($access_token, $userId, $id);
            }
        }
        $fileData = [];
        $messageHtml = '';
        $messageText = '';
        if (isset($readMessage['payload']['parts']) && $parts = $readMessage['payload']['parts']) {

            foreach ($parts as $file) {
                if ($file['filename'] != '') {
                    $fileData[] = [
                        'partId' => $file['partId'],
                        'filename' => $file['filename'],
                        'attachmentId' => $file['body']['attachmentId'],
                        'messageId' => $readMessage['id'],
                        'FileHandler' => 'Gmail'
                    ];
                }
            }

            $liveThread = 0;
            if ($parts[0]['partId'] == 0) {
                if (isset($parts[0]['parts'])) {
                    $vPart = $parts[0]['parts'];
                    foreach ($vPart as $file) {
                        if ($file['mimeType'] == 'text/plain') {
                            $messageText = base64_decode(str_replace(array('-', '_'), array('+', '/'), $file['body']['data']));
                        }
                        if ($file['mimeType'] == 'text/html') {
                            $messageHtml = base64_decode(str_replace(array('-', '_'), array('+', '/'), $file['body']['data']));
                        }
                    }
                } else {
                    $liveThread = 1;
                }
            }
            if ($liveThread) {
                foreach ($parts as $file) {
                    if ($file['mimeType'] == 'text/plain') {
                        $messageText = base64_decode(str_replace(array('-', '_'), array('+', '/'), $file['body']['data']));
                    }
                    if ($file['mimeType'] == 'text/html') {
                        $messageHtml = base64_decode(str_replace(array('-', '_'), array('+', '/'), $file['body']['data']));
                    }
                }
            }
        } else {
            if (isset($readMessage['payload']['body'])) {
                $messageText = base64_decode(str_replace(array('-', '_'), array('+', '/'), $readMessage['payload']['body']['data']));
                $messageHtml = base64_decode(str_replace(array('-', '_'), array('+', '/'), $readMessage['payload']['body']['data']));
            }
        }


        $manageHeaders = Helpers::IllitarableArray($readMessage['payload']['headers']);
        $rajaFiles['string'] = [
            'Message Labels' => $readMessage['labelIds'],
            'Snippet' => $readMessage['snippet'],
            'Subject' => $manageHeaders['Subject'][0],
            'From Email' => Helpers::freshEmail($manageHeaders['From'][0]),
            'To Email' => Helpers::freshEmail($manageHeaders['To'][0]),
            'Body as HTML' => quoted_printable_decode($messageHtml),
            'Body as Text' => quoted_printable_decode($messageText),
        ];
        if (empty($rajaFiles['string']['Body as HTML']) || $rajaFiles['string']['Body as HTML'] == '') {
            $rajaFiles['string']['Body as HTML'] = $rajaFiles['string']['Body as Text'];
        }
        $rajaFiles['var'] = [
            'MessageId' => $readMessage['id'],
            'ThreadId' => $readMessage['threadId'],
            'HistoryId' => $readMessage['historyId'],
        ];
        if (isset($manageHeaders['Message-ID'])) {
            $rajaFiles['hiddenVar'] = [
                'GlobalId' => $manageHeaders['Message-ID'][0]
            ];
        }
        if (is_array($fileData) && !empty($fileData)) {
            $rajaFiles['file'] = [
                'Attachment' => $fileData
            ];
            $naming = [];
            foreach ($fileData as $files10) {
                $naming[] = $files10['filename'];
            }
            $rajaFiles['string']['Files Name'] = $naming;
        } else {
            $rajaFiles['file'] = [
                'Attachment' => []
            ];
        }
        return $rajaFiles;


    }

    public function getGroupAttachment($access_token, $userId, array $array, $id, bool $true, $historyId = null)
    {
        $messages = [];
        $thread = $this->getThread($access_token, $userId, $id);
        if ($historyId == null) {
            $message = $thread['messages'];
            $history = $thread['historyId'];
            foreach ($message as $msg) {
                if ($msg['historyId'] === $history) {
                    $messages[] = $this->getLatestAttachment($access_token, $userId, [], $msg['id']);
                }
            }
        } else {
            $message = $thread['messages'];
            $started = 0;
            foreach ($message as $msg) {
                if ($started) {
                    $messages[] = $this->getLatestAttachment($access_token, $userId, [], $msg['id']);
                }

                if ($msg['snippet'] === $historyId) {
                    $started = 1;
                }
            }
        }


        return $messages;
    }

    // SEND Mail
    public function sendMail($access_token, $userId, $params)
    {
        $strRawMessage = $this->messageInstance($access_token, $userId, $params);
        $url = "https://gmail.googleapis.com/upload/gmail/v1/users/me/messages/send?alt=json&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: message/rfc822'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $strRawMessage);
        $data = curl_exec($ch);

        return json_decode($data, true);
    }

    // SEND Mail
    public function createDraft($access_token, $userId, $params)
    {
        $strRawMessage = $this->messageInstance($access_token, $userId, $params);
        $url = "https://gmail.googleapis.com/upload/gmail/v1/users/me/drafts?alt=json&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: message/rfc822'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $strRawMessage);
        $data = curl_exec($ch);

        return json_decode($data, true);
    }

    public function messageInstance($access_token, $userId, $params)
    {
        $strMailContent = $params['Body'];
        // $strMailTextVersion = strip_tags($strMailContent, '');

        $strRawMessage = "";
        $boundary = sha1(rand());
        $boundary2 = sha1(rand());
        $subjectCharset = $charset = 'utf-8';
        $strToMail = $params['To'];
        $strSesFromEmail = $params['From'];
        $strSubject = $params['Subject'];

        $strRawMessage .= 'From: ' . $strSesFromEmail . "\r\n";
        $strRawMessage .= 'To: ' . $strToMail . "\r\n";
        if (isset($params['Bcc'])) {
            $strRawMessage .= 'Bcc: ' . $params['Bcc'] . "\r\n";
        }
        if (isset($params['Cc'])) {
            $strRawMessage .= 'Cc: ' . $params['Cc'] . "\r\n";
        }

        $strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
        $strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
        if (isset($params['GlobalId'])) {
            $strRawMessage .= 'References: ' . $params['GlobalId'] . "\r\n";
            $strRawMessage .= 'References: ' . $params['GlobalId'] . "\r\n";
        }
        $strRawMessage .= 'Content-type: Multipart/Mixed; boundary="' . $boundary . '"' . "\r\n\r\n";

        $strRawMessage .= "--{$boundary}\r\n";
        $strRawMessage .= 'Content-Type: multipart/alternative; boundary="' . $boundary2 . '"' . "\r\n\r\n";

        if ($params['BodyType'][0] != 'text/plain') {
            $strRawMessage .= "--{$boundary2}\r\n";
            $strRawMessage .= 'Content-Type: text/plain; charset=' . $charset . "\r\n\r\n";
            $strRawMessage .= strip_tags($strMailContent) . "\r\n";
        }
        $strRawMessage .= "--{$boundary2}\r\n";
        $strRawMessage .= 'Content-Type: ' . $params['BodyType'][0] . '; charset=' . $charset . "\r\n\r\n";
        $strRawMessage .= $strMailContent . "\r\n";
        $strRawMessage .= "--{$boundary2}--\r\n";

        if (isset($params['Attachment'])) {
            foreach ($params['Attachment'] as $attachment) {
                $class = 'App\\Apps\\' . $attachment['FileHandler'];
                $fileManager = new $class;
                $file = $fileManager->setFile($attachment, [$access_token, $userId]);
                $strRawMessage .= "--{$boundary}\r\n";
                $strRawMessage .= 'Content-Type: ' . $file['mimeType'] . '; name="' . $file['filename'] . '";' . "\r\n";
                $strRawMessage .= 'Content-Disposition: attachment; filename="' . $file['filename'] . '";' . "\r\n";
                $strRawMessage .= 'Content-Transfer-Encoding: base64' . "\r\n";
                $strRawMessage .= 'X-Attachment-Id: f_' . time() . rand() . "\r\n";
                $strRawMessage .= 'Content-ID: <f_' . time() . rand() . '>' . "\r\n\r\n";
                $strRawMessage .= strtr($file['data'], array('-' => '+', '_' => '/')) . "\r\n";

            }
        }
        return $strRawMessage;
    }

    public function setFile($file, $access)
    {
        $attachmentId = $file['attachmentId'];
        $messageId = $file['messageId'];
        if ($att = $this->getAttachment($access[0], $access[1], $attachmentId, $messageId)) {
            $file['size'] = $att['size'];
            $file['mimeType'] = Helpers::mimeType($file['filename']);
            $file['data'] = $att['data'];
            $file['dataDecode'] = base64_decode($att['data']);
        }
        return $file;
    }

    public function getAttachment($access_token, $userId, $attachmentId, $messageId)
    {
        $url = "https://gmail.googleapis.com/gmail/v1/users/$userId/messages/$messageId/attachments/$attachmentId?alt=json&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        return json_decode($response, 1);
    }

    public function addLabel($access_token, $userId, array $param)
    {
        $params = [
            'addLabelIds' => $param['name']
        ];
        $url = "https://gmail.googleapis.com/gmail/v1/users/me/messages/" . $param['emailId'] . "/modify?alt=json&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $data = curl_exec($ch);

        return json_decode($data, true);
    }

    public function removeLabel($access_token, $userId, array $param)
    {
        $params = [
            'removeLabelIds' => $param['name']
        ];
        $url = "https://gmail.googleapis.com/gmail/v1/users/me/messages/" . $param['emailId'] . "/modify?alt=json&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $data = curl_exec($ch);

        return json_decode($data, true);
    }

}
