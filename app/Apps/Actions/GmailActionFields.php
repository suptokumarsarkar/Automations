<?php

namespace App\Apps\Actions;

use App\Apps\Gmail;
use App\Http\Controllers\Api\Apps\Manager;
use App\Logic\Helpers;
use App\Models\Account;

class GmailActionFields
{
    private $account;
    /**
     * @var mixed
     */
    private $userId;
    /**
     * @var Gmail
     */
    private $mainClass;
    /**
     * @var mixed
     */
    private $access_token;

    public function add_label_to_email($data)
    {
        $form = [];


        // Labels
        $actionAccount = $data['action']['account_id'];
        $gmail = new Gmail;
        $accessToken = $gmail->getToken($actionAccount);
        $userId = $gmail->getUserId($actionAccount);
        $allLabels = $gmail->getLabels($accessToken, $userId)['labels'];

        // Custom Data
        foreach ($allLabels as $key => $value) {
            $form['Custom']['string'][] = [
                'id' => "name/24110/" . $value['id'],
                'name' => $value['name']
            ];
        }
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select Label (By Default All Labels)'),
            'labelId' => "name",
            'required' => false
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "name",
            'labelName' => "Label Id",
        ])->render();

//BCC
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        $dataV = json_decode(json_encode($data, true), true);
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);

        if (isset($api_fields['var'])) {
            foreach ($api_fields['var'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "MessageId/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Message Id",
            'labelId' => "MessageId",
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "MessageId",
            'labelName' => "Message Id",
        ])->render();


        $view = Helpers::rap_with_form($views, $data);


        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }

    public function add_label_to_email_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new Gmail;
        $this->access_token = $this->mainClass->getToken($accountId);
        if (isset($mainData['name'])) {
            if (!is_array($mainData['name'])) {
                $this->mainClass->addLabel($this->access_token, $this->userId, ["name" => $mainData['name'], 'emailId' => $mainData['MessageId']]);
            } else {
                foreach ($mainData['name'] as $name) {
                    $this->mainClass->addLabel($this->access_token, $this->userId, ["name" => $name, 'emailId' => $mainData['MessageId']]);
                }
            }
            return json_encode([
                'status' => 200,
                'message' => Helpers::translate('Successfully Applied First Zap')
            ]);
        } else {
            return json_encode([
                'status' => 400,
                'message' => Helpers::translate('Failed to Process Name for Label Creation.')
            ]);
        }
    }

    // Remove label from email
    public function remove_label_from_email($data)
    {
        $form = [];


        // Labels
        $actionAccount = $data['action']['account_id'];
        $gmail = new Gmail;
        $accessToken = $gmail->getToken($actionAccount);
        $userId = $gmail->getUserId($actionAccount);
        $allLabels = $gmail->getLabels($accessToken, $userId)['labels'];

        // Custom Data
        foreach ($allLabels as $key => $value) {
            $form['Custom']['string'][] = [
                'id' => "name/24110/" . $value['id'],
                'name' => $value['name']
            ];
        }
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select Label (By Default All Labels)'),
            'labelId' => "name",
            'required' => false
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "name",
            'labelName' => "Label Id",
        ])->render();

//BCC
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        $dataV = json_decode(json_encode($data, true), true);
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);

        if (isset($api_fields['var'])) {
            foreach ($api_fields['var'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "MessageId/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Message Id",
            'labelId' => "MessageId",
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "MessageId",
            'labelName' => "Message Id",
        ])->render();


        $view = Helpers::rap_with_form($views, $data);


        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }

    public function remove_label_from_email_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new Gmail;
        $datas = [];
        $this->access_token = $this->mainClass->getToken($accountId);
        if (isset($mainData['name'])) {
            if (!is_array($mainData['name'])) {
                $datas[] = $this->mainClass->removeLabel($this->access_token, $this->userId, ["name" => $mainData['name'], 'emailId' => $mainData['MessageId']]);
            } else {
                foreach ($mainData['name'] as $name) {
                    $datas[] = $this->mainClass->removeLabel($this->access_token, $this->userId, ["name" => $name, 'emailId' => $mainData['MessageId']]);
                }
            }
            return json_encode([
                'status' => 200,
                'data' => $datas,
                'message' => Helpers::translate('Successfully Applied First Zap')
            ]);
        } else {
            return json_encode([
                'status' => 400,
                'message' => Helpers::translate('Failed to Process Name for Label Creation.')
            ]);
        }
    }


    // Create Label

    public function create_label($data)
    {
        $form = [];
        $dataV = json_decode(json_encode($data, true), true);
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);
        // Custom Data
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];
        // Custom Data
        /*        $form['Custom']['string'][] = [
                    'id' => 'name/24110/Latest',
                    'name' => Helpers::translate('Latest')
                ];*/
        // Custom Data
        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "name/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }

        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Label Name",
            'labelId' => "name",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "name",
            'labelName' => "Label Name",
        ])->render();


        $view = Helpers::rap_with_form($views, $data);

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }

    public function create_label_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new Gmail;
        $this->access_token = $this->mainClass->getToken($accountId);

        if (isset($mainData['name'])) {
            if (!is_array($mainData['name'])) {
                $this->mainClass->createLabel($this->access_token, $this->userId, ["name" => $mainData['name']]);
            } else {
                foreach ($mainData['name'] as $name) {
                    $this->mainClass->createLabel($this->access_token, $this->userId, ["name" => $name]);
                }
            }
            return json_encode([
                'status' => 200,
                'message' => Helpers::translate('Successfully Applied First Zap')
            ]);
        } else {
            return json_encode([
                'status' => 400,
                'message' => Helpers::translate('Failed to Process Name for Label Creation.')
            ]);
        }
    }


    // Create Email

    public function send_email($data)
    {
        $form = [];
        $dataV = json_decode(json_encode($data, true), true);
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);


        // Custom Data
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "To/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "To",
            'labelId' => "To",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "To",
            'labelName' => "To",
        ])->render();

//BCC
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Bcc/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Bcc",
            'labelId' => "Bcc",
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Bcc",
            'labelName' => "Bcc",
        ])->render();

//CC
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Cc/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Cc",
            'labelId' => "Cc",
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Cc",
            'labelName' => "Cc",
        ])->render();


//From
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "From/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "From",
            'labelId' => "From",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "From",
            'labelName' => "From",
        ])->render();


//Subject
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Subject/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Subject",
            'labelId' => "Subject",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Subject",
            'labelName' => "Subject",
        ])->render();

//Body Type
        $form = [];

        $form['Custom']['string'][] = [
            'id' => "BodyType/24110/text/plain",
            'name' => "Plain"
        ];
        $form['Custom']['string'][] = [
            'id' => "BodyType/24110/text/html",
            'name' => "Html"
        ];


        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "BodyType",
            'labelId' => "BodyType",
            'single' => true,
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "BodyType",
            'labelName' => "BodyType",
        ])->render();


//Body
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Body/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Body",
            'labelId' => "Body",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Body",
            'labelName' => "Body",
        ])->render();
//Attachment
        $form = [];

        if (isset($api_fields['file'])) {
            foreach ($api_fields['file'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Attachment/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Attachment",
            'labelId' => "Attachment",
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Attachment",
            'labelName' => "Attachment",
        ])->render();

        $view = Helpers::rap_with_form($views, $data);

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }

    public function send_email_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new Gmail;
        $this->access_token = $this->mainClass->getToken($accountId);
        if (isset($mainData['To']) && isset($mainData['Subject']) && isset($mainData['Body']) && isset($mainData['From']) && isset($mainData['BodyType'])) {
            if (is_array($mainData['From'])) {
                $mainData['From'] = $mainData['From'][0];
            }
            $ct = [];

            if (isset($mainData['Bcc']) && is_array($mainData['Bcc'])) {
                $mainData['Bcc'] = implode(",", $mainData['Bcc']);
            }
            if (isset($mainData['Cc']) && is_array($mainData['Cc'])) {
                $mainData['Cc'] = implode(",", $mainData['Cc']);
            }
            if (is_array($mainData['Subject'])) {
                $mainData['Subject'] = implode(".", $mainData['Subject']);
            }
            if (is_array($mainData['Body'])) {
                $mainData['Body'] = implode(".", $mainData['Body']);
            }
            if (is_array($mainData['To'])) {
                $to = $mainData['To'];
                foreach ($to as $newMail) {
                    $mainData['To'] = $newMail;
                    $ct[] = $this->mainClass->sendMail($this->access_token, $this->userId, $mainData);
                }
            } else {
                $ct[] = $this->mainClass->sendMail($this->access_token, $this->userId, $mainData);
            }
            return json_encode([
                'status' => 200,
                'message' => Helpers::translate('Successfully Applied First Zap'),
                'data' => $ct
            ]);
        } else {
            return json_encode([
                'status' => 400,
                'message' => Helpers::translate('Failed to Process Name for Label Creation.')
            ]);
        }
    }

    // Create Draft

    public function create_draft($data)
    {
        $form = [];
        $dataV = json_decode(json_encode($data, true), true);
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);


        // Custom Data
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "To/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "To",
            'labelId' => "To",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "To",
            'labelName' => "To",
        ])->render();

//BCC
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Bcc/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Bcc",
            'labelId' => "Bcc",
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Bcc",
            'labelName' => "Bcc",
        ])->render();

//CC
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Cc/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Cc",
            'labelId' => "Cc",
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Cc",
            'labelName' => "Cc",
        ])->render();


//From
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "From/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "From",
            'labelId' => "From",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "From",
            'labelName' => "From",
        ])->render();


//Subject
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Subject/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Subject",
            'labelId' => "Subject",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Subject",
            'labelName' => "Subject",
        ])->render();

//Body Type
        $form = [];

        $form['Custom']['string'][] = [
            'id' => "BodyType/24110/text/plain",
            'name' => "Plain"
        ];
        $form['Custom']['string'][] = [
            'id' => "BodyType/24110/text/html",
            'name' => "Html"
        ];


        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "BodyType",
            'labelId' => "BodyType",
            'single' => true,
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "BodyType",
            'labelName' => "BodyType",
        ])->render();


//Body
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Body/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Body",
            'labelId' => "Body",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Body",
            'labelName' => "Body",
        ])->render();
//Attachment
        $form = [];

        if (isset($api_fields['file'])) {
            foreach ($api_fields['file'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Attachment/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Attachment",
            'labelId' => "Attachment",
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Attachment",
            'labelName' => "Attachment",
        ])->render();

        $view = Helpers::rap_with_form($views, $data);

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }

    public function create_draft_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new Gmail;
        $this->access_token = $this->mainClass->getToken($accountId);
        if (isset($mainData['To']) && isset($mainData['Subject']) && isset($mainData['Body']) && isset($mainData['From']) && isset($mainData['BodyType'])) {
            if (is_array($mainData['From'])) {
                $mainData['From'] = $mainData['From'][0];
            }
            $ct = [];

            if (isset($mainData['Bcc']) && is_array($mainData['Bcc'])) {
                $mainData['Bcc'] = implode(",", $mainData['Bcc']);
            }
            if (isset($mainData['Cc']) && is_array($mainData['Cc'])) {
                $mainData['Cc'] = implode(",", $mainData['Cc']);
            }
            if (is_array($mainData['Subject'])) {
                $mainData['Subject'] = implode(".", $mainData['Subject']);
            }
            if (is_array($mainData['Body'])) {
                $mainData['Body'] = implode(".", $mainData['Body']);
            }
            if (is_array($mainData['To'])) {
                $to = $mainData['To'];
                foreach ($to as $newMail) {
                    $mainData['To'] = $newMail;
                    $ct[] = $this->mainClass->createDraft($this->access_token, $this->userId, $mainData);
                }
            } else {
                $ct[] = $this->mainClass->createDraft($this->access_token, $this->userId, $mainData);
            }
            return json_encode([
                'status' => 200,
                'message' => Helpers::translate('Successfully Applied First Zap'),
                'data' => $ct
            ]);
        } else {
            return json_encode([
                'status' => 400,
                'message' => Helpers::translate('Failed to Process Name for Label Creation.')
            ]);
        }
    }

    // Create Reply

    public function reply_to_the_email($data)
    {
        $form = [];
        $dataV = json_decode(json_encode($data, true), true);
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);

//Body
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['var'])) {
            foreach ($api_fields['var'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "MessageId/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Message Id",
            'labelId' => "MessageId",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "MessageId",
            'labelName' => "Message Id",
        ])->render();
//Body Type
        $form = [];

        $form['Custom']['string'][] = [
            'id' => "BodyType/24110/text/plain",
            'name' => "Plain"
        ];
        $form['Custom']['string'][] = [
            'id' => "BodyType/24110/text/html",
            'name' => "Html"
        ];


        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "BodyType",
            'labelId' => "BodyType",
            'single' => true,
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "BodyType",
            'labelName' => "BodyType",
        ])->render();


//Body
        $form = [];
        $form['Custom']['custom'][] = [
            'id' => 'custom',
            'name' => Helpers::translate('Add Custom')
        ];

        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Body/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Body",
            'labelId' => "Body",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Body",
            'labelName' => "Body",
        ])->render();
//Attachment
        $form = [];

        if (isset($api_fields['file'])) {
            foreach ($api_fields['file'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "Attachment/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Attachment",
            'labelId' => "Attachment",
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "Attachment",
            'labelName' => "Attachment",
        ])->render();

        $view = Helpers::rap_with_form($views, $data);

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }

    public function reply_to_the_email_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new Gmail;
        $this->access_token = $this->mainClass->getToken($accountId);
        $extraData = $this->mainClass->getLatestAttachment($this->access_token, $this->userId, [], $mainData['MessageId']);
        if(isset($extraData['hiddenVar']['GlobalId'])){
            $mainData['GlobalId'] = $extraData['hiddenVar']['GlobalId'];
        }else{
            return json_encode([
                'status' => 200,
                'message' => Helpers::translate('Message is not replyable. But checking succeed.')
            ]);
        }
        $mainData['To'] = $extraData['string']['From Email'];
        $mainData['From'] = $extraData['string']['To Email'];
        $mainData['Subject'] = $extraData['string']['Subject'];
        if (isset($mainData['To']) && isset($mainData['Subject']) && isset($mainData['Body']) && isset($mainData['From']) && isset($mainData['BodyType'])) {
            if (is_array($mainData['From'])) {
                $mainData['From'] = $mainData['From'][0];
            }
            $ct = [];

            if (isset($mainData['Bcc']) && is_array($mainData['Bcc'])) {
                $mainData['Bcc'] = implode(",", $mainData['Bcc']);
            }
            if (isset($mainData['Cc']) && is_array($mainData['Cc'])) {
                $mainData['Cc'] = implode(",", $mainData['Cc']);
            }
            if (is_array($mainData['Subject'])) {
                $mainData['Subject'] = implode(".", $mainData['Subject']);
            }
            if (is_array($mainData['Body'])) {
                $mainData['Body'] = implode(".", $mainData['Body']);
            }
            if (is_array($mainData['To'])) {
                $to = $mainData['To'];
                foreach ($to as $newMail) {
                    $mainData['To'] = $newMail;
                    $ct[] = $this->mainClass->sendMail($this->access_token, $this->userId, $mainData);
                }
            } else {
                $ct[] = $this->mainClass->sendMail($this->access_token, $this->userId, $mainData);
            }
            return json_encode([
                'status' => 200,
                'message' => Helpers::translate('Successfully Applied First Zap'),
                'data' => $ct
            ]);
        } else {
            return json_encode([
                'status' => 400,
                'message' => Helpers::translate('Failed to Process Name for Label Creation.')
            ]);
        }
    }
}
