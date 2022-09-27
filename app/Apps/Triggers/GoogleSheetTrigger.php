<?php

namespace App\Apps\Triggers;

use App\Apps\GoogleSheet;
use App\Logic\Helpers;
use App\Models\Account;

class GoogleSheetTrigger
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
        $this->mainClass = new GoogleSheet;
        $this->access_token = $this->mainClass->getToken($accountId);
    }

    public function new_worksheet()
    {
        $files = $this->mainClass->getSheets($this->access_token);

        foreach ($files as $file) {
            $form['Custom']['string'][] = [
                'id' => 'worksheet/24110/' . $file['id'],
                'name' => $file['name']
            ];
        }
        $id = rand(0, 4548575451);
        $view[] = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select Worksheet'),
            'required' => true,
        ])->render();
        $view = Helpers::rap_with_form($view, [], 'triggerForm');
        $scripts[] = view('App.Actions.Fields.Script', [
            'form' => $form,
            'id' => $id,
            'labelId' => 'worksheet',
            'labelName' => Helpers::translate('Worksheet'),
        ])->render();
        return [
            'view' => $view,
            'script' => $scripts,
            'message' => Helpers::translate('Connected With SpreadSheets'),
            'status' => 200,
        ];
    }

    public function new_worksheet_check($data = null)
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $files = $this->mainClass->getSpreadSheetSheets($this->access_token, $value['string']['worksheet'][0]);
        foreach ($files as $key => $file) {
            $files[$key]['spreadsheetId'] = $value['string']['worksheet'][0];
        }
        $return['string'] = $files[count($files) - 1];
        return $return;
    }

    public function new_worksheet_changes($zapDatabase = [], $zapData = [])
    {
        $zapDatabase = json_decode($zapDatabase, true)['Files'];
        $zapData = json_decode($zapData, true);
        $data = Helpers::IllitarableArray($zapData['trigger']['Data']);
        $value = Helpers::evaluteData($data);
        $files = $this->mainClass->getSpreadSheetSheets($this->access_token, $value['string']['worksheet'][0]);
        $oldFiles = [];
        $dataFiles = [];
        foreach ($files as $key => $file) {
            $dataFiles[$file['id']] = $file;
        }
        foreach ($zapDatabase as $key => $file) {
            $oldFiles[] = $file['id'];
        }
        $files = [];
        foreach ($dataFiles as $key => $latest) {
            if (!in_array($key, $oldFiles)) {
                $files[] = $latest;
            }
        }

        foreach ($files as $key => $file) {
            $files[$key]['spreadsheetId'] = $value['string']['worksheet'][0];
        }
        return $files;
    }

    public function new_worksheet_update_database($data = null)
    {

        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $files = $this->mainClass->getSpreadSheetSheets($this->access_token, $value['string']['worksheet'][0]);
        return ['Files' => $files];
    }


    public function new_spreadsheet()
    {
        $files = $this->mainClass->getSheets($this->access_token);
        return [
            'view' => view('App.Triggers.GoogleSheet.new_spreadsheet', compact('files'))->render(),
            'script' => '',
            'message' => Helpers::translate('Connected With SpreadSheets'),
            'status' => 200,
        ];
    }

    public function new_spreadsheet_check($data = null)
    {
        $files = $this->mainClass->getSheets($this->access_token);
        $return['string'] = $files[0];
        return $return;
    }

    public function new_spreadsheet_changes($zapDatabase = [], $zapData = [])
    {
        $zapDatabase = json_decode($zapDatabase, true)['Files'];
        $files = $this->mainClass->getSheets($this->access_token);
        $latestId = [];
        foreach ($files as $file) {
            $latestId[$file['id']] = $file;
        }
        $oldId = [];
        foreach ($zapDatabase as $file) {
            $oldId[] = $file['id'];
        }
        $fileData = [];
        foreach ($latestId as $id => $latest) {
            if (!in_array($id, $oldId)) {
                $fileData[] = $latest;
            }
        }
        return $fileData;
    }

    public function new_spreadsheet_update_database($data = null)
    {

        $files = $this->mainClass->getSheets($this->access_token);
        return ['Files' => $files];
    }


    public function new_spreadsheet_row()
    {
        $files = $this->mainClass->getSheets($this->access_token);
        $firstSheet = $files[0]['id'];
        $sheets = $this->mainClass->getSpreadSheetSheets($this->access_token, $firstSheet);
        $form = [];

        // Custom Data
        foreach ($files as $key => $value) {
            $form['Custom']['string'][] = [
                'id' => "spreadsheetId/24110/" . $value['id'],
                'name' => $value['name']
            ];
        }
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select Spreadsheet'),
            'required' => true,
            'multiple' => false,
            'dataLoad' => 'sheetId2250',
            'formName' => 'triggerForm',
            'dataAction' => json_encode([
                'AppId' => 'GoogleSheet',
                'Func' => 'UpdateSheets',
                'Mode' => 'Triggers',
                'AccountId' => $this->account->id
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
            'acceptDataLoad' => 'sheetId2250'
        ])->render();

        $views[] = $view;

        $view = Helpers::rap_with_form($views, [], 'triggerForm');

        return [
            'view' => $view,
            'script' => '',
            'message' => Helpers::translate('Connected With SpreadSheets'),
            'status' => 200,
        ];
    }

    public function new_spreadsheet_row_check($data = null)
    {

        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $rows = $this->mainClass->getSpreadSheetSheetsValue($this->access_token, $value['string']['spreadsheetId'][0],
            $this->mainClass->getRangeName($this->access_token, $value['string']['spreadsheetId'][0], $value['string']['sheetId'][0]));
        $return['api'] = $this->mainClass->getHeaderSheets($rows);
        return $return;
    }

    public function new_spreadsheet_row_changes($zapDatabase = [], $zapData = [])
    {
        $zapData = json_decode($zapData, true);
        $zapDatabase = json_decode($zapDatabase, true);

        $data = Helpers::IllitarableArray($zapData['trigger']['Data']);
        $value = Helpers::evaluteData($data);
        $rowss = $this->mainClass->getSpreadSheetSheetsValue($this->access_token, $value['string']['spreadsheetId'][0],
            $this->mainClass->getRangeName($this->access_token, $value['string']['spreadsheetId'][0], $value['string']['sheetId'][0]));
        $return = [];
        $rows = $rowss['values'];
        $j = 5;
        $dg = Helpers::hideKeys($zapDatabase['Values']);
        $headers = $this->mainClass->getHeader($rowss);
        for ($i = (count($rows) - 1); $i > -1; $i--) {
            if (json_encode($rows[$i]) == json_encode($dg)) {
                break;
            }
            $j--;
            if ($j == 0) {
                break;
            }
            $dst = Helpers::keyAndValue($headers, $rows[$i]);

            $return[] = $dst;
        }
        return $return;
    }

    public function new_spreadsheet_row_update_database($data = null)
    {

        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $rows = $this->mainClass->getSpreadSheetSheetsValue($this->access_token, $value['string']['spreadsheetId'][0],
            $this->mainClass->getRangeName($this->access_token, $value['string']['spreadsheetId'][0], $value['string']['sheetId'][0]));
        $values = $this->mainClass->getHeaderSheets($rows);
        return ['Values' => $values];
    }


    public function new_or_updated_spreadsheet_row()
    {
        $files = $this->mainClass->getSheets($this->access_token);
        $firstSheet = $files[0]['id'];
        $sheets = $this->mainClass->getSpreadSheetSheets($this->access_token, $firstSheet);
        $form = [];

        // Custom Data
        foreach ($files as $key => $value) {
            $form['Custom']['string'][] = [
                'id' => "spreadsheetId/24110/" . $value['id'],
                'name' => $value['name']
            ];
        }
        $id = rand(0, 4548575451);


        $view = view('App.Actions.Fields.Input', [
            'form' => $form,
            'id' => $id,
            'label' => Helpers::translate('Select Spreadsheet'),
            'required' => true,
            'multiple' => false,
            'dataLoad' => 'sheetId2250',
            'formName' => 'triggerForm',
            'dataAction' => json_encode([
                'AppId' => 'GoogleSheet',
                'Func' => 'UpdateSheets',
                'Mode' => 'Triggers',
                'AccountId' => $this->account->id
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
            'acceptDataLoad' => 'sheetId2250'
        ])->render();

        $views[] = $view;

        $view = Helpers::rap_with_form($views, [], 'triggerForm');

        return [
            'view' => $view,
            'script' => '',
            'message' => Helpers::translate('Connected With SpreadSheets'),
            'status' => 200,
        ];
    }

    public function new_or_updated_spreadsheet_row_check($data = null)
    {
        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $rows = $this->mainClass->getSpreadSheetSheetsValue($this->access_token, $value['string']['spreadsheetId'][0],
            $this->mainClass->getRangeName($this->access_token, $value['string']['spreadsheetId'][0], $value['string']['sheetId'][0]));
        $return['api'] = $this->mainClass->getHeaderSheets($rows, true);
        return $return;
    }

    public function new_or_updated_spreadsheet_row_changes($zapDatabase = [], $zapData = [])
    {
        $zapData = json_decode($zapData, true);
        $zapDatabase = json_decode($zapDatabase, true);

        $data = Helpers::IllitarableArray($zapData['trigger']['Data']);
        $value = Helpers::evaluteData($data);
        $rowss = $this->mainClass->getSpreadSheetSheetsValue($this->access_token, $value['string']['spreadsheetId'][0],
            $this->mainClass->getRangeName($this->access_token, $value['string']['spreadsheetId'][0], $value['string']['sheetId'][0]));
        $return = [];
        $rows = $rowss['values'];
        $j = 5;
        $dg = $zapDatabase['Values']['values'];
        $headers = $this->mainClass->getHeader($rowss);

        $updated = [];
        $modify = [];
        for ($i = (count($rows) - 1); $i > -1; $i--) {
            $rowsr[$i] = $rows[$i];
            $rowsr[$i]['rowId'] = $i;
            $modify[json_encode($rows[$i], true)] = $rowsr[$i];
        }

        for ($i = 0; $i < count($dg); $i++) {
            if (array_key_exists(json_encode($dg[$i], true), $modify)) {
                unset($modify[json_encode($dg[$i], true)]);
            }
            $j--;
        }
        $return = [];
        foreach ($modify as $mode) {
            $dst = Helpers::keyAndValue($headers, $mode, true);
            $return[] = $dst;
        }
        return $return;
    }

    public function new_or_updated_spreadsheet_row_update_database($data = null)
    {

        $data = Helpers::IllitarableArray($data);
        $value = Helpers::evaluteData($data);
        $rows = $this->mainClass->getSpreadSheetSheetsValue($this->access_token, $value['string']['spreadsheetId'][0],
            $this->mainClass->getRangeName($this->access_token, $value['string']['spreadsheetId'][0], $value['string']['sheetId'][0]));
        return ['Values' => $rows];
    }

    public function UpdateSheets($Fid, $Fsheet, $data = null): array
    {
        $id = rand(0, 4548575451);
        $form = [];
        $sheetId = $Fsheet['string']['spreadsheetId'][0];
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
            'acceptDataLoad' => 'sheetId2250'
        ])->render();
        return [
            'view' => $view,
            'id' => $Fid
        ];
    }

}
