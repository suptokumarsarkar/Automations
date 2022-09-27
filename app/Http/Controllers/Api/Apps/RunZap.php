<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\Controller;
use App\Logic\Helpers;
use App\Models\Zap;
use App\Models\ZapRecord;

class RunZap extends Controller
{
    public function runZap()
    {
        $zaps = Zap::where("status", "active")->get();
        $manager = new Manager;
        foreach ($zaps as $zap) {
            if ($manager->hasZaps($zap->userId)) {
                $data = json_decode($zap->zapData, true);
                $value = json_decode($zap->func, true);
                $mainData = [];


                $triggerAction = $data['trigger']['action_id'];
                $triggerAccount = $data['trigger']['account_id'];
                $triggerApp = $data['trigger']['AppId'];
                $triggerApp = "App\\Apps\\Triggers\\" . $triggerApp . "Trigger";
                $trigger = new $triggerApp($triggerAccount);
                $triggerActionFunc = $triggerAction . "_changes";
                $funcDataV2 = $trigger->$triggerActionFunc($zap->database, $zap->zapData);

                if ($funcDataV2) {
                    foreach ($funcDataV2 as $funcData) {
                        if (isset($value['api'])) {

                            // Check The Api Actions

                            $funcData = $manager->freshArrayApi($funcData);

                            if (!$manager->checkApiMatch($value['api'], $funcData)) {
                                return json_encode([
                                    'status' => 400,
                                    'message' => Helpers::translate("API Key Mismatch. Request Not Valid")
                                ]);
                            }
                            $mainData = $manager->dataFillup($value['api'], $funcData);

                        }

                        Helpers::stringValueFillup($mainData, $value);


                        $action_data = $manager->runZap($mainData, $data, $zap->userId);
                        $zapRecord = new ZapRecord;
                        $zapRecord->zapId = $zap->id;
                        $zapRecord->userId = $zap->userId;
                        $zapRecord->triggerData = json_encode($mainData, true);
                        $zapRecord->ActionData = json_encode($action_data, true);
                        $zapRecord->message = "Updated Successfully.";
                        $zapRecord->save();

                        $triggerActionFunc = $triggerAction . "_update_database";
                        $zapData = json_decode($zap->zapData,1);
                        if(isset($zapData['trigger']['Data'])){
                            $updateDatabase = $trigger->$triggerActionFunc($zapData['trigger']['Data'], $zap->database);
                        }else{
                            $updateDatabase = $trigger->$triggerActionFunc($zap->zapData, $zap->database);
                        }
                        $zap->database = json_encode($updateDatabase, true);
                        $zap->save();

                    }
                }


            } else {

            }
        }

        return json_encode([
            'status' => 200,
            'message' => Helpers::translate('Api executed successfully.')
        ]);
    }
}
