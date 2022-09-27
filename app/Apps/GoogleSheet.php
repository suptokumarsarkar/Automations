<?php

namespace App\Apps;

use App\Apps\Triggers\GmailTrigger;
use App\Apps\Triggers\GoogleSheetTrigger;
use App\Logic\Helpers;
use App\Models\Account;
use App\Models\AppsData;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Request;

class GoogleSheet
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
        $gmail = AppsData::where("AppId", "GoogleSheet")->first();
        if ($gmail) {
            $appInfo = json_decode($gmail->AppInfo, true);
            $this->client_id = $appInfo['client_id'];
            $this->client_secret = $appInfo['client_secret'];
        }
    }


    public function getTrigger(): array
    {
        return array(
            [
                'id' => 'new_spreadsheet',
                'name' => Helpers::translate('New Spreadsheet'),
                'description' => Helpers::translate('Triggers when you create a new spreadsheet')
            ],
            [
                'id' => 'new_spreadsheet_row',
                'name' => Helpers::translate('New Spreadsheet Row'),
                'description' => Helpers::translate('Triggers when you add a new row into the bottom of the spreadsheet')
            ],
            [
                'id' => 'new_or_updated_spreadsheet_row',
                'name' => Helpers::translate('New or Updated Spreadsheet row'),
                'description' => Helpers::translate('Triggers when you create or update a new spreadsheet row')
            ],
            [
                'id' => 'new_worksheet',
                'name' => Helpers::translate('New Worksheet'),
                'description' => Helpers::translate('Triggers when you create a new worksheet into the spreadsheet')
            ]
        );
    }

    public function getActions(): array
    {
        return array(
//            [
//                'id' => 'create_a_spreadsheet_column',
//                'name' => Helpers::translate('Create a spreadsheet column'),
//                'description' => Helpers::translate('Creates a new column into the spreadsheet')
//            ],
            [
                'id' => 'create_spreadsheet_row',
                'name' => Helpers::translate('Create Spreadsheet row'),
                'description' => Helpers::translate('Creates a spreadsheet row')
            ],
            [
                'id' => 'copy_worksheet',
                'name' => Helpers::translate('Copy Worksheet'),
                'description' => Helpers::translate('Creates a new worksheet coping an existing worksheet')
            ],
            [
                'id' => 'create_spreadsheet',
                'name' => Helpers::translate('Create Spreadsheet'),
                'description' => Helpers::translate('Creates a blank spreadsheet or duplicates the existing Spreadsheet ( Optionally, Provide headers )')
            ],
            [
                'id' => 'create_worksheet',
                'name' => Helpers::translate('Create Worksheet'),
                'description' => Helpers::translate('Creates a blank worksheet with a title ( Optionally, Provide headers )')
            ],
            [
                'id' => 'delete_spreadsheet_row',
                'name' => Helpers::translate('Delete Spreadsheet row'),
                'description' => Helpers::translate('Deletes the content of your spreadsheet rows. The deleted content will be shown as blank rows. Please use with caution.')
            ],
            [
                'id' => 'update_worksheet_row',
                'name' => Helpers::translate('Update worksheet row'),
                'description' => Helpers::translate('Updates a row of a specific worksheet')
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
        $trigger = new GoogleSheetTrigger($accountId);
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

    // Real API

    public function getSheets($access_token)
    {

        $url = "https://www.googleapis.com/drive/v3/files?access_token=" . $access_token . "&q=" . urlencode("mimeType='application/vnd.google-apps.spreadsheet'");

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        return json_decode($response, 1)['files'];
    }


    public function getSpreadSheet($access_token, $spreadsheetId)
    {

        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}?access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        return json_decode($response, 1);
    }

    public function getSpreadSheetSheets($access_token, $spreadsheetId): array
    {
        $sheetsData = [];
        $sheets = $this->getSpreadSheet($access_token, $spreadsheetId)['sheets'];
        foreach ($sheets as $sheet) {
            $sheetsData[] = [
                'id' => $sheet['properties']['sheetId'],
                'title' => $sheet['properties']['title'],
                'sheetType' => $sheet['properties']['sheetType']
            ];
        }
        return $sheetsData;
    }

    public function getRangeName($access_token, $spreadsheetId, $sheetId)
    {
        $sheets = $this->getSpreadSheetSheets($access_token, $spreadsheetId);
        foreach ($sheets as $sheet) {
            if ($sheet['id'] == $sheetId) {
                return $sheet['title'];
            }
        }
        return false;
    }

    public function getSpreadSheetSheetsValue($access_token, $spreadsheetId, $sheet)
    {
        $sheet = urlencode($sheet);
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values/'{$sheet}'?access_token=" . $access_token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        return json_decode($response, 1);
    }

    public function copyTo($access_token, $spreadsheetId, $sheetId, $param = [])
    {

        $params = [
            'destinationSpreadsheetId' => $param['destinationSpreadsheetId']
        ];
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/sheets/$sheetId:copyTo?alt=json&access_token=" . $access_token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $data = curl_exec($ch);

        return json_decode($data, true);
    }

    public function deleteRow($access_token, $spreadsheetId, $param = [])
    {

        $params = [
            'ranges' => $param['ranges']
        ];
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values:batchClear?alt=json&access_token=" . $access_token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $data = curl_exec($ch);

        return json_decode($data, true);
    }

    public function createSpreadSheet($access_token, $param = [])
    {

        $params = [
            'properties' => [
                "title" => $param['title'],
                "locale" => "en",
            ]
        ];
        $url = "https://sheets.googleapis.com/v4/spreadsheets?alt=json&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $data = curl_exec($ch);

        return json_decode($data, true);
    }

    public function appendValue($access_token, $spreadsheetId, $sheet, $param = [])
    {
        Helpers::margeIfArray($param);
        $param = Helpers::hideKeys($param);
        $sheet = $this->getRangeName($access_token, $spreadsheetId, $sheet);
        $params = [
            'range' => $sheet,
            'majorDimension' => "ROWS",
            "values" => [$param]
        ];
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values/" . urlencode($sheet) . ":append?alt=json&valueInputOption=RAW&includeValuesInResponse=true&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $data = curl_exec($ch);
        return json_decode($data, true);
    }

    public function updateWorksheet($access_token, $spreadsheetId, $sheet, $rowId, $param = [])
    {
        Helpers::margeIfArray($param);
        $param = Helpers::hideKeys($param);
        $sheet = $this->getRangeName($access_token, $spreadsheetId, $sheet);
        $params = [
            'valueInputOption' => "RAW",
            "data" => [
                [
                    "range" => "$sheet!A{$rowId}",
                    "values" => [$param]
                ]
            ]
        ];
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values:batchUpdate?alt=json&valueInputOption=RAW&includeValuesInResponse=true&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $data = curl_exec($ch);
        return json_decode($data, true);
    }

    public function deleteWorksheet($access_token, $spreadsheetId, $sheet, $rowId)
    {

        $sheet = $this->getRangeName($access_token, $spreadsheetId, $sheet);
        $params = [
            "ranges" => ["$sheet!A{$rowId}:Z{$rowId}"],
        ];
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values:batchClear?alt=json&access_token=" . $access_token;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $data = curl_exec($ch);
        return json_decode($data, true);
    }

    public function getHeader($sheets)
    {
        $values = $sheets['values'];
        $headers = $sheets['values'][0];
        foreach ($values as $row) {
            if (count($row) > count($headers)) {
                $fill = count($row) - count($headers);
                for ($i = 0; $i < $fill; $i++) {
                    $headers[] = "Header - " . (1 + count($headers));
                }
            }
        }
        return $headers;
    }

    public function getHeaderSheets($sheets, $includeRow = false)
    {

        // Fill Header And Make Smooth with latest
        $headers = $this->getHeader($sheets);
        $header = [];
        $lastOne = $sheets['values'][count($sheets['values']) - 1];
        $i = 0;
        foreach ($headers as $key) {
            $header[$key] = $lastOne[$i];
            $i++;
        }
        if ($includeRow) {
            $header['rowId'] = count($sheets['values']) - 1;
        }
        return $header;
    }


}
