<?php

namespace App\Apps\Triggers;

use App\Apps\Gmail;
use App\Http\Controllers\Api\Apps\Manager;
use App\Logic\Helpers;
use App\Models\Account;
use function App\Logic\translate;

class GmailTrigger
{
    private $account;
    /**
     * @var Gmail
     */
    private $mainClass;
    /**
     * @var mixed
     */
    private $access_token;

    function __construct($accountId)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new Gmail;
        $this->access_token = $this->mainClass->getToken($accountId);
    }


    public function new_email(): array
    {
//        Check For Labels
        $allLabels = $this->mainClass->getLabels($this->access_token, $this->userId)['labels'];
//        Return The View Code

        $form = [];

        // Custom Data
        foreach ($allLabels as $key => $value) {
            $form['Custom']['string'][] = [
                'id' => "labelIds/24110/" . $value['id'],
                'name' => $value['name']
            ];
        }
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select Label (By Default All Labels)'),
            'required' => false
        ])->render();

        $scripts = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelName' => Helpers::translate('Label'),
            'labelId' => 'labelIds',
        ])->render();
        $views[] = $view;


        $view = Helpers::rap_with_form($views, [], 'triggerForm');

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }


    public function new_email_check($data = null)
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        return $this->mainClass->getLatestAttachment($this->access_token, $this->userId, $value['string']);

    }


    public function new_email_update_database($data = null, $database = null): array
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $latestModel = $this->mainClass->getEmails($this->access_token, $this->userId, $value['string']);
        return ['lastMailId' => $latestModel['messages'][0]['id']];
    }


    public function new_email_changes($zapDatabase = [], $zapData = [])
    {
        $zapData = json_decode($zapData, true);
        $data = Helpers::IllitarableArray($zapData['trigger']['Data']);
        $value = Helpers::evaluteData($data);
        $database = json_decode($zapDatabase, true);
//        Check For Mails
        $allMails = $this->mainClass->getEmails($this->access_token, $this->userId, $value['string'])['messages'];
        $newMailIds = [];
        $i = 0;
        foreach ($allMails as $mail) {
            $i++;
            if($i == 5)
            {
                break;
            }
            if ($mail['id'] != $database['lastMailId']) {
                $newMailIds[] = $mail['id'];
            } else {
                break;
            }
        }
        $data = [];
        foreach ($newMailIds as $id) {
            $data[] = $this->mainClass->getLatestAttachment($this->access_token, $this->userId, [], $id);
        }
        if ($data != [] || !empty($data)) {
            return $data;
        }

        return false;
    }

    // New Threads
    public function new_thread(): array
    {
//        Check For Labels
        $allLabels = $this->mainClass->getLabels($this->access_token, $this->userId)['labels'];
//        Return The View Code

        $form = [];

        // Custom Data
        foreach ($allLabels as $key => $value) {
            $form['Custom']['string'][] = [
                'id' => "labelIds/24110/" . $value['id'],
                'name' => $value['name']
            ];
        }
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select Label (By Default All Labels)'),
            'required' => false
        ])->render();

        $scripts = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelName' => Helpers::translate('Label'),
            'labelId' => 'labelIds',
        ])->render();
        $views[] = $view;


        $view = Helpers::rap_with_form($views, [], 'triggerForm');

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }


    public function new_thread_check($data = null): array
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        return $this->mainClass->getLatestAttachment($this->access_token, $this->userId, $value['string'], null, true);

    }


    public function new_thread_update_database($data = null, $database = null): array
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $latestModel = $this->mainClass->getThreads($this->access_token, $this->userId, $value['string']);
        return ['lastMailId' => $latestModel['threads'][0]['id'] , 'snippet' => $latestModel['threads'][0]['snippet']];
    }

    private static function merchantSort($a,$b)
    {
        if ($a['historyId']==$b['historyId']) return 0;
        return ($a['historyId']>$b['historyId'])?-1:1;
    }


    public function new_thread_changes($zapDatabase = [], $zapData = [])
    {
        $zapData = json_decode($zapData, true);
        $data = Helpers::IllitarableArray($zapData['trigger']['Data']);
        $value = Helpers::evaluteData($data);
        $database = json_decode($zapDatabase, true);
//        Check For Mails
        $allMails = $this->mainClass->getThreads($this->access_token, $this->userId, $value['string'])['threads'];
        $data = [];

        usort($allMails, array($this,'merchantSort'));
        $i = 0;
        foreach ($allMails as $mail) {
            $i++;
            if($i == 5)
            {
                break;
            }
            if ($mail['id'] != $database['lastMailId']) {
                $dataV = $this->mainClass->getGroupAttachment($this->access_token, $this->userId, [], $mail['id'], true);
                Helpers::arrayMarge($dataV, $data);
            } elseif($mail['id'] === $database['lastMailId'] && $mail['snippet'] != $database['snippet'] ) {
                $dataV = $this->mainClass->getGroupAttachment($this->access_token, $this->userId, [], $mail['id'], true, $database['snippet']);
                Helpers::arrayMarge($dataV, $data);
                break;
            } else {
                break;
            }
        }
        if ($data != [] || !empty($data)) {
            return $data;
        }

        return false;
    }

    // New Email Matching Search




    public function new_email_matching_search(): array
    {
        $form = [];
        $id = rand(0, 4548575451);
        $form = [
            'id' => "string" . $id . "q",
            'name' => '',
            'description' => Helpers::translate("By default this search will trigger on emails in all folders, including Sent emails, which most people don't want. To limit results, like to your inbox, include in:inbox.

This works the same as the search bar you see in Gmail. For example: from:amy OR from:david or in:inbox subject:dinner label:my-family.") . '<a href="http://support.google.com/mail/bin/answer.py?hl=en&amp;answer=7190" target="_blank" rel="noopener noreferrer nofollow">'.Helpers::translate('Learn more.').'</a>'
        ];

        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate("Match String"),
            'required' => false,
            'input' => true
        ])->render();


        $views[] = $view;
        $view = Helpers::rap_with_form($views, [], 'triggerForm');

        return [
            'view' => $view,
            'script' => '',
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }


    public function new_email_matching_search_check($data = null)
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        return $this->mainClass->getLatestAttachment($this->access_token, $this->userId, $value['string']);

    }


    public function new_email_matching_search_update_database($data = null, $database = null): array
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $latestModel = $this->mainClass->getEmails($this->access_token, $this->userId, $value['string']);
        return ['lastMailId' => $latestModel['messages'][0]['id']];
    }

    public function new_email_matching_search_changes($zapDatabase = [], $zapData = [])
    {
        $zapData = json_decode($zapData, true);
        $data = Helpers::IllitarableArray($zapData['trigger']['Data']);
        $value = Helpers::evaluteData($data);
        $database = json_decode($zapDatabase, true);
//        Check For Mails
        $allMails = $this->mainClass->getEmails($this->access_token, $this->userId, $value['string'])['messages'];
        $newMailIds = [];
        $i = 0;
        foreach ($allMails as $mail) {
            $i++;
            if($i == 5)
            {
                break;
            }
            if ($mail['id'] != $database['lastMailId']) {
                $newMailIds[] = $mail['id'];
            } else {
                break;
            }
        }
        $data = [];
        foreach ($newMailIds as $id) {
            $data[] = $this->mainClass->getLatestAttachment($this->access_token, $this->userId, [], $id);
        }
        if ($data != [] || !empty($data)) {
            return $data;
        }

        return false;
    }



    // Attachment Functions



    public function new_attachment(): array
    {
//        Check For Labels
        $allLabels = $this->mainClass->getLabels($this->access_token, $this->userId)['labels'];
//        Return The View Code

        $form = [];

        // Custom Data
        foreach ($allLabels as $key => $value) {
            $form['Custom']['string'][] = [
                'id' => "labelIds/24110/" . $value['id'],
                'name' => $value['name']
            ];
        }
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select Label (By Default All Labels)'),
            'required' => false
        ])->render();

        $scripts = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelName' => Helpers::translate('Label'),
            'labelId' => 'labelIds',
        ])->render();
        $views[] = $view;

        $form = [];
        $id = rand(0, 4548575451);
        $form = [
            'id' => "string" . $id . "q",
            'name' => '',
            'description' => Helpers::translate("By default this search will trigger on emails in all folders, including Sent emails, which most people don't want. To limit results, like to your inbox, include in:inbox.

This works the same as the search bar you see in Gmail. For example: from:amy OR from:david or in:inbox subject:dinner label:my-family.") . '<a href="http://support.google.com/mail/bin/answer.py?hl=en&amp;answer=7190" target="_blank" rel="noopener noreferrer nofollow">'.Helpers::translate('Learn more.').'</a>'
        ];


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate("Match String"),
            'required' => false,
            'input' => true
        ])->render();


        $views[] = $view;
        $view = Helpers::rap_with_form($views, [], 'triggerForm');

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }

    public function new_attachment_update_database($data = null, $database = null): array
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $value['string']['hasAttachment'] = 'has:attachment';
        $latestModel = $this->mainClass->getEmails($this->access_token, $this->userId, $value['string']);
        return ['lastMailId' => $latestModel['messages'][0]['id']];
    }

    public function new_attachment_changes($zapDatabase = [], $zapData = [])
    {
        $zapData = json_decode($zapData, true);
        $data = Helpers::IllitarableArray($zapData['trigger']['Data']);
        $value = Helpers::evaluteData($data);
        $value['string']['hasAttachment'] = 'has:attachment';
        $database = json_decode($zapDatabase, true);
//        Check For Mails
        $allMails = $this->mainClass->getEmails($this->access_token, $this->userId, $value['string'])['messages'];
        $newMailIds = [];
        $i = 0;
        foreach ($allMails as $mail) {
            $i++;
            if($i == 5)
            {
                break;
            }
            if ($mail['id'] != $database['lastMailId']) {
                $newMailIds[] = $mail['id'];
            } else {
                break;
            }
        }
        $data = [];
        foreach ($newMailIds as $id) {
            $data[] = $this->mainClass->getLatestAttachment($this->access_token, $this->userId, [], $id);
        }
        if ($data != [] || !empty($data)) {
            return $data;
        }

        return false;
    }


    public function new_attachment_check($data = null)
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $value['string']['hasAttachment'] = 'has:attachment';
        return $this->mainClass->getLatestAttachment($this->access_token, $this->userId, $value['string']);

    }

    // Starred Emails Functions



    public function new_starred_email(): array
    {
//        Check For Labels
        $allLabels = $this->mainClass->getLabels($this->access_token, $this->userId)['labels'];
//        Return The View Code

        $form = [];

        // Custom Data
        foreach ($allLabels as $key => $value) {
            $form['Custom']['string'][] = [
                'id' => "labelIds/24110/" . $value['id'],
                'name' => $value['name']
            ];
        }
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select Label (By Default All Labels)'),
            'required' => false
        ])->render();

        $scripts = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelName' => Helpers::translate('Label'),
            'labelId' => 'labelIds',
        ])->render();
        $views[] = $view;

        $form = [];
        $id = rand(0, 4548575451);
        $form = [
            'id' => "string" . $id . "q",
            'name' => '',
            'description' => Helpers::translate("By default this search will trigger on emails in all folders, including Sent emails, which most people don't want. To limit results, like to your inbox, include in:inbox.

This works the same as the search bar you see in Gmail. For example: from:amy OR from:david or in:inbox subject:dinner label:my-family.") . '<a href="http://support.google.com/mail/bin/answer.py?hl=en&amp;answer=7190" target="_blank" rel="noopener noreferrer nofollow">'.Helpers::translate('Learn more.').'</a>'
        ];


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate("Match String"),
            'required' => false,
            'input' => true
        ])->render();


        $views[] = $view;
        $view = Helpers::rap_with_form($views, [], 'triggerForm');

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }

    public function new_starred_email_update_database($data = null, $database = null): array
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $value['string']['hasAttachment'] = 'is:starred';
        $latestModel = $this->mainClass->getEmails($this->access_token, $this->userId, $value['string']);
        return ['lastMailId' => $latestModel['messages'][0]['id']];
    }

    public function new_starred_email_changes($zapDatabase = [], $zapData = [])
    {
        $zapData = json_decode($zapData, true);
        $data = Helpers::IllitarableArray($zapData['trigger']['Data']);
        $value = Helpers::evaluteData($data);
        $value['string']['hasAttachment'] = 'is:starred';
        $database = json_decode($zapDatabase, true);
//        Check For Mails
        $allMails = $this->mainClass->getEmails($this->access_token, $this->userId, $value['string'])['messages'];
        $newMailIds = [];
        $i = 0;
        foreach ($allMails as $mail) {
            $i++;
            if($i == 5)
            {
                break;
            }
            if ($mail['id'] != $database['lastMailId']) {
                $newMailIds[] = $mail['id'];
            } else {
                break;
            }
        }
        $data = [];
        foreach ($newMailIds as $id) {
            $data[] = $this->mainClass->getLatestAttachment($this->access_token, $this->userId, [], $id);
        }
        if ($data != [] || !empty($data)) {
            return $data;
        }

        return false;
    }


    public function new_starred_email_check($data = null)
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $value['string']['hasAttachment'] = 'is:starred';
        return $this->mainClass->getLatestAttachment($this->access_token, $this->userId, $value['string']);

    }

    // New Label

    public function new_label(): array
    {
//        Check For Labels
        $allLabels = $this->mainClass->getLabels($this->access_token, $this->userId)['labels'];
//        Return The View Code
        $view = view('App.Triggers.Gmail.new_label', [
            'labels' => $allLabels
        ])->render();
        return [
            'view' => $view
        ];
    }

    public function new_label_check($data = null)
    {
//        Check For Labels
        $allLabels = $this->mainClass->getLabels($this->access_token, $this->userId)['labels'];
        $data = $this->mainClass->getLabel($this->access_token, $this->userId, $allLabels[count($allLabels) - 1]['id']);
        $rData['string'] = [
            "id" => $data['id'],
            "name" => $data['name'],
            "type" => $data['type'],
        ];
        return $rData;
    }

    public function new_label_changes($zapDatabase = [], $zapData = [])
    {
        $database = json_decode($zapDatabase, true);
//        Check For Labels
        $allLabels = $this->mainClass->getLabels($this->access_token, $this->userId)['labels'];
        $newLabelIds = [];
        foreach ($allLabels as $label) {
            if (!in_array($label['id'], $database)) {
                $newLabelIds[] = $label['id'];
            }
        }
        $labels = [];
        foreach ($newLabelIds as $id) {
            $labels[] = $this->mainClass->getLabel($this->access_token, $this->userId, $id);
        }
        if (!empty($labels) && $labels != []) {
            return [$labels];
        }
        return false;
    }

    public function new_label_update_database($data = null, $database = null)
    {
//        Check For Labels
        $allLabels = $this->mainClass->getLabels($this->access_token, $this->userId)['labels'];
        $lastLabel = $allLabels[count($allLabels) - 1]['id'];
        $currentIds = [];
        foreach ($allLabels as $allLabel) {
            $currentIds[] = $allLabel['id'];
        }
        return $currentIds;
    }

    public function new_label_check_store(): string
    {
//        Check For Labels
        $allLabels = $this->mainClass->getLabels($this->access_token, $this->userId)['labels'];
//        Return The View Code
        return view('App.Triggers.Gmail.new_label', [
            'labels' => $allLabels
        ])->render();
    }
}
