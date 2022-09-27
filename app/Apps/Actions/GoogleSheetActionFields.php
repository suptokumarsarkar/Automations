<?php

namespace App\Apps\Actions;

use App\Apps\Gmail;
use App\Apps\GoogleSheet;
use App\Http\Controllers\Api\Apps\Manager;
use App\Logic\Helpers;
use App\Models\Account;

class GoogleSheetActionFields
{
    /**
     * @var GoogleSheet
     */
    private $mainClass;

    function __construct($accountId = 0)
    {
        $this->mainClass = new GoogleSheet;
        if ($accountId != 0) {
            $this->account = Account::find($accountId);
            $this->userId = json_decode($this->account['data'], true)['sub'];
            $this->mainClass = new GoogleSheet;
            $this->access_token = $this->mainClass->getToken($accountId);
        }
    }

    function accountSetup($accountId)
    {
        if ($accountId != 0) {
            $this->account = Account::find($accountId);
            $this->userId = json_decode($this->account['data'], true)['sub'];
            $this->mainClass = new GoogleSheet;
            $this->access_token = $this->mainClass->getToken($accountId);
        }
    }

    // Copy SpreadSheet

    public function copy_worksheet($data)
    {
        $form = [];
        $dataV = json_decode(json_encode($data, true), true);
        $accountId = $dataV['action']['account_id'];
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);
        $this->accountSetup($accountId);
        $sheets = $this->mainClass->getSheets($this->access_token);
        // Custom Data
        foreach ($sheets as $key1 => $value1) {
            $form['Custom']['string'][] = [
                'id' => "spreadsheet/24110/" . $value1['id'],
                'name' => $value1['name']
            ];
        }

        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Spreadsheet",
            'labelId' => "spreadsheet",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "spreadsheet",
            'labelName' => "Spreadsheet",
        ])->render();

        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "spreadsheetId",
            'labelId' => "[api]spreadsheetId/24110/spreadsheetId",
            'required' => true,
            'hidden' => true,
            'value' => ''
        ])->render();

        // Labels
        $id = rand(0, 4548575451);
        $views[] = $view;


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "worksheetId",
            'labelId' => "[api]id/24110/id",
            'required' => true,
            'hidden' => true,
            'value' => ''
        ])->render();
        $views[] = $view;

        $view = Helpers::rap_with_form($views, $data);

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }


    public function copy_worksheet_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new GoogleSheet;
        $this->access_token = $this->mainClass->getToken($accountId);
        if (isset($mainData['spreadsheet'])) {
            $SpreadSheet = 0;
            if (!is_array($mainData['spreadsheet'])) {
                $SpreadSheet = $mainData['spreadsheet'];
            } else {
                $SpreadSheet = $mainData['spreadsheet'][0];
            }

            $this->mainClass->copyTo($this->access_token, $mainData['spreadsheetId'], $mainData['id'], ['destinationSpreadsheetId' => $SpreadSheet]);
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


    public function create_spreadsheet($data)
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
        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "title/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }

        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "Title",
            'labelId' => "title",
            'required' => true
        ])->render();
        $views[] = $view;

        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => "title",
            'labelName' => "Title",
        ])->render();


        $view = Helpers::rap_with_form($views, $data);

        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];

    }

    public function create_spreadsheet_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new GoogleSheet;
        $this->access_token = $this->mainClass->getToken($accountId);

        if (isset($mainData['title'])) {
            $sheetId = 0;
            $SpreadSheet = 0;
            if (!is_array($mainData['title'])) {
                $SpreadSheet = $mainData['title'];
            } else {
                $SpreadSheet = $mainData['title'][0];
            }

            $this->mainClass->createSpreadSheet($this->access_token, ['title' => $SpreadSheet]);
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


    function create_spreadsheet_row($data)
    {
        $form = [];
        $dataV = json_decode(json_encode($data, true), true);
        $accountId = $dataV['action']['account_id'];
        $accessToken = $this->mainClass->getToken($accountId);
        $spreadSheets = $this->mainClass->getSheets($accessToken);
        if (!$spreadSheets) {
            return [
                'message' => Helpers::translate("Couldn't target any Spreadsheets in your account. Please create one and try again."),
                'status' => 400,
            ];
        }
        $firstSheet = $spreadSheets[0]['id'];
        $sheets = $this->mainClass->getSpreadSheetSheets($accessToken, $firstSheet);
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);
        foreach ($spreadSheets as $key1 => $value1) {
            $form['Custom']['string'][] = [
                'id' => "SpreadSheet/24110/" . $value1['id'],
                'name' => $value1['name']
            ];
        }
        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "SpreadSheet/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "SpreadSheet",
            'labelId' => "SpreadSheet",
            'required' => true,
            'multiple' => false,
            'dataLoad' => 'sheetId2250ss',
            'formName' => 'action_suffer',
            'dataAction' => json_encode([
                'AppId' => 'GoogleSheet',
                'Func' => 'UpdateSheets',
                'Mode' => 'Actions',
                'AccountId' => $accountId
            ])
        ])->render();
        $views[] = $view;

        $id = rand(0, 4548575451);
        $form = [];
        foreach ($sheets as $sheet) {
            $form['Custom']['string'][] = [
                'id' => "sheetId/24110/" . $sheet['id'],
                'name' => $sheet['title']
            ];
        }
        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select WorkSheet'),
            'required' => true,
            'multiple' => false,
            'acceptDataLoad' => 'sheetId2250ss',
            'dataLoad' => 'sheetId2250mnoni',
            'formName' => 'action_suffer',
            'dataAction' => json_encode([
                'AppId' => 'GoogleSheet',
                'Func' => 'UpdateTaskDetails',
                'Mode' => 'Actions',
                'AccountId' => $accountId
            ])
        ])->render();

        $views[] = $view;

        $id = rand(0, 4548575451);
        $form = [];
        foreach ($sheets as $sheet) {
            $form['Custom']['string'][] = [
                'id' => "task/24110/" . $sheet['id'],
                'name' => $sheet['title']
            ];
        }
        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Task'),
            'required' => true,
            'multiple' => false,
            'disabled' => true,
            'acceptDataLoad' => 'sheetId2250mnoni'
        ])->render();

        $views[] = $view;
        $scripts = [];

        $view = Helpers::rap_with_form($views, $data, 'action_suffer', ['vk' => $api_fields]);
        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];
    }

    public function create_spreadsheet_row_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new GoogleSheet;
        $this->access_token = $this->mainClass->getToken($accountId);
        if (isset($mainData['SpreadSheet']) && isset($mainData['sheetId'])) {
            $sheetId = 0;
            $SpreadSheet = 0;
            if (!is_array($mainData['SpreadSheet'])) {
                $SpreadSheet = $mainData['SpreadSheet'];
            } else {
                $SpreadSheet = $mainData['SpreadSheet'][0];
            }
            if (!is_array($mainData['sheetId'])) {
                $sheetId = $mainData['sheetId'];
            } else {
                $sheetId = $mainData['sheetId'][0];
            }

            unset($mainData['SpreadSheet']);
            unset($mainData['sheetId']);

            $this->mainClass->appendValue($this->access_token, $SpreadSheet, $sheetId, $mainData);
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


    function update_worksheet_row($data)
    {
        $form = [];
        $dataV = json_decode(json_encode($data, true), true);
        $accountId = $dataV['action']['account_id'];
        $accessToken = $this->mainClass->getToken($accountId);
        $spreadSheets = $this->mainClass->getSheets($accessToken);
        if (!$spreadSheets) {
            return [
                'message' => Helpers::translate("Couldn't target any Spreadsheets in your account. Please create one and try again."),
                'status' => 400,
            ];
        }
        $firstSheet = $spreadSheets[0]['id'];
        $sheets = $this->mainClass->getSpreadSheetSheets($accessToken, $firstSheet);
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);
        foreach ($spreadSheets as $key1 => $value1) {
            $form['Custom']['string'][] = [
                'id' => "SpreadSheet/24110/" . $value1['id'],
                'name' => $value1['name']
            ];
        }
        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "SpreadSheet/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "SpreadSheet",
            'labelId' => "SpreadSheet",
            'required' => true,
            'multiple' => false,
            'dataLoad' => 'sheetId2250ss',
            'formName' => 'action_suffer',
            'dataAction' => json_encode([
                'AppId' => 'GoogleSheet',
                'Func' => 'UpdateSheets',
                'Mode' => 'Actions',
                'AccountId' => $accountId
            ])
        ])->render();
        $views[] = $view;

        $id = rand(0, 4548575451);
        $form = [];
        foreach ($sheets as $sheet) {
            $form['Custom']['string'][] = [
                'id' => "sheetId/24110/" . $sheet['id'],
                'name' => $sheet['title']
            ];
        }
        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select WorkSheet'),
            'required' => true,
            'multiple' => false,
            'acceptDataLoad' => 'sheetId2250ss',
            'dataLoad' => 'sheetId2250mnoni',
            'formName' => 'action_suffer',
            'dataAction' => json_encode([
                'AppId' => 'GoogleSheet',
                'Func' => 'UpdateTaskDetails',
                'Mode' => 'Actions',
                'AccountId' => $accountId
            ])
        ])->render();

        $views[] = $view;

        $id = rand(0, 4548575451);
        $form = [];
        foreach ($sheets as $sheet) {
            $form['Custom']['string'][] = [
                'id' => "task/24110/" . $sheet['id'],
                'name' => $sheet['title']
            ];
        }
        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Task'),
            'required' => true,
            'multiple' => false,
            'disabled' => true,
            'acceptDataLoad' => 'sheetId2250mnoni'
        ])->render();
        $views[] = $view;
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "rowId",
            'labelId' => "[api]rowId/24110/rowId",
            'required' => true,
            'hidden' => true,
            'value' => ''
        ])->render();

        $views[] = $view;
        $scripts = [];

        $view = Helpers::rap_with_form($views, $data, 'action_suffer', ['vk' => $api_fields]);
        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];
    }

    public function update_worksheet_row_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new GoogleSheet;
        $this->access_token = $this->mainClass->getToken($accountId);
        if (isset($mainData['SpreadSheet']) && isset($mainData['sheetId'])) {
            $sheetId = 0;
            $SpreadSheet = 0;
            if (!is_array($mainData['SpreadSheet'])) {
                $SpreadSheet = $mainData['SpreadSheet'];
            } else {
                $SpreadSheet = $mainData['SpreadSheet'][0];
            }
            if (!is_array($mainData['sheetId'])) {
                $sheetId = $mainData['sheetId'];
            } else {
                $sheetId = $mainData['sheetId'][0];
            }

            $rowId = ($mainData['rowId'] ?? 0) + 1;

            unset($mainData['SpreadSheet']);
            unset($mainData['sheetId']);
            unset($mainData['rowId']);

            $this->mainClass->updateWorksheet($this->access_token, $SpreadSheet, $sheetId, $rowId, $mainData);
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


    function delete_spreadsheet_row($data)
    {
        $form = [];
        $dataV = json_decode(json_encode($data, true), true);
        $accountId = $dataV['action']['account_id'];
        $accessToken = $this->mainClass->getToken($accountId);
        $spreadSheets = $this->mainClass->getSheets($accessToken);
        if (!$spreadSheets) {
            return [
                'message' => Helpers::translate("Couldn't target any Spreadsheets in your account. Please create one and try again."),
                'status' => 400,
            ];
        }
        $firstSheet = $spreadSheets[0]['id'];
        $sheets = $this->mainClass->getSpreadSheetSheets($accessToken, $firstSheet);
        $manager = new Manager;
        $api_fields = $manager->getTriggerValue($dataV);
        foreach ($spreadSheets as $key1 => $value1) {
            $form['Custom']['string'][] = [
                'id' => "SpreadSheet/24110/" . $value1['id'],
                'name' => $value1['name']
            ];
        }
        if (isset($api_fields['string'])) {
            foreach ($api_fields['string'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "SpreadSheet/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }
        // Labels
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "SpreadSheet",
            'labelId' => "SpreadSheet",
            'required' => true,
            'multiple' => false,
            'dataLoad' => 'sheetId2250ss',
            'formName' => 'action_suffer',
            'dataAction' => json_encode([
                'AppId' => 'GoogleSheet',
                'Func' => 'UpdateSheets',
                'Mode' => 'Actions',
                'AccountId' => $accountId
            ])
        ])->render();
        $views[] = $view;

        $id = rand(0, 4548575451);
        $form = [];
        foreach ($sheets as $sheet) {
            $form['Custom']['string'][] = [
                'id' => "sheetId/24110/" . $sheet['id'],
                'name' => $sheet['title']
            ];
        }
        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select WorkSheet'),
            'required' => true,
            'multiple' => false,
            'acceptDataLoad' => 'sheetId2250ss',
        ])->render();

        $views[] = $view;


        // Labels
        $id = rand(0, 4548575451);
        $form = [];
        if (isset($api_fields['api'])) {
            foreach ($api_fields['api'] as $key1 => $value1) {
                $form['Api']['api'][] = [
                    'id' => "rowId/24110/" . $key1,
                    'name' => $key1
                ];
            }
        }

        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => "rowId",
            'labelId' => "[api]rowId/24110/rowId",
            'required' => true,
            'multiple' => false,
            'value' => ''
        ])->render();

        $views[] = $view;
        $scripts = [];

        $view = Helpers::rap_with_form($views, $data, 'action_suffer', ['vk' => $api_fields]);
        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With Data Fields'),
            'status' => 200,
        ];
    }

    public function delete_spreadsheet_row_post($accountId, $mainData, $data)
    {
        $this->account = Account::find($accountId);
        $this->userId = json_decode($this->account['data'], true)['sub'];
        $this->mainClass = new GoogleSheet;
        $this->access_token = $this->mainClass->getToken($accountId);
        if (isset($mainData['SpreadSheet']) && isset($mainData['sheetId'])) {
            $sheetId = 0;
            $SpreadSheet = 0;
            if (!is_array($mainData['SpreadSheet'])) {
                $SpreadSheet = $mainData['SpreadSheet'];
            } else {
                $SpreadSheet = $mainData['SpreadSheet'][0];
            }
            if (!is_array($mainData['sheetId'])) {
                $sheetId = $mainData['sheetId'];
            } else {
                $sheetId = $mainData['sheetId'][0];
            }

            $rowId = ($mainData['rowId'] ?? 0) + 1;

            unset($mainData['SpreadSheet']);
            unset($mainData['sheetId']);
            unset($mainData['rowId']);
            dd($this->mainClass->deleteWorksheet($this->access_token, $SpreadSheet, $sheetId, $rowId));
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


    public function UpdateSheets($Fid, $Fsheet, $data = null): array
    {
        $id = rand(0, 4548575451);
        $form = [];
        $sheetId = $Fsheet['string']['SpreadSheet'][0];
        $sheets = $this->mainClass->getSpreadSheetSheets($this->access_token, $sheetId);
        foreach ($sheets as $sheet) {
            $form['Custom']['string'][] = [
                'id' => "sheetId/24110/" . $sheet['id'],
                'name' => $sheet['title']
            ];
        }
        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select WorkSheet'),
            'required' => true,
            'multiple' => false,
            'acceptDataLoad' => 'sheetId2250ss',
            'dataLoad' => 'sheetId2250mnoni',
            'formName' => 'action_suffer',
            'dataAction' => json_encode([
                'AppId' => 'GoogleSheet',
                'Func' => 'UpdateTaskDetails',
                'Mode' => 'Actions',
                'AccountId' => $this->account->id
            ])
        ])->render();
        return [
            'view' => $view,
            'id' => $Fid
        ];
    }

    public function UpdateTaskDetails($Fid, $Fsheet, $data = null): array
    {
        $form = [];
        $spreadSheetId = $Fsheet['string']['SpreadSheet'][0];
        $sheetId = $Fsheet['string']['sheetId'][0];
        $range = $this->mainClass->getRangeName($this->access_token, $spreadSheetId, $sheetId);
        $sheets = $this->mainClass->getSpreadSheetSheetsValue($this->access_token, $spreadSheetId, $range);
        $headerSheets = $this->mainClass->getHeaderSheets($sheets);
        $api_fields = json_decode($data, true);
        foreach ($headerSheets as $key => $sheet) {
            $form = [];
            if (isset($api_fields['string'])) {
                foreach ($api_fields['string'] as $key1 => $value1) {
                    $form['Api']['api'][] = [
                        'id' => "{$key}/24110/" . $key1,
                        'name' => $key1
                    ];
                }
            }
            if (isset($api_fields['api'])) {
                foreach ($api_fields['api'] as $key1 => $value1) {
                    $form['Api']['api'][] = [
                        'id' => "{$key}/24110/" . $key1,
                        'name' => $key1
                    ];
                }
            }
            $form['Custom']['custom'][] = [
                'id' => 'custom',
                'name' => Helpers::translate('Add Custom')
            ];
            $id = rand(0, 4548575451);
            $view[] = view('App.Actions.Fields.Input', [
                'form' => $form,
                'id' => $id,
                'label' => Helpers::translate($key),
                'required' => true,
                'acceptDataLoad' => 'sheetId2250mnoni'
            ])->render();

            $view[] = view('App.Actions.Fields.Script', [
                'form' => $form,
                'id' => $id,
                'labelId' => $key,
                'labelName' => Helpers::translate($key),
            ])->render();
        }

        return [
            'view' => Helpers::wrap($view, $Fid),
            'id' => $Fid
        ];
    }
}
