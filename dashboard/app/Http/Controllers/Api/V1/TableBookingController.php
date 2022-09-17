<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\CategoryLogic;
use App\Http\Controllers\Controller;
use App\Model\Tablebooking;
use Illuminate\Http\Request;
use Hash;

class TableBookingController extends Controller
{
    public function addNew(Request $request){
        $tableBooking = new Tablebooking;
        $tableBooking->dateTime = $request->dateTime;
        $tableBooking->numberOfPerson = $request->numberOfPerson;
        $tableBooking->occasion = $request->occasion;
        $tableBooking->message = $request->message;
        $tableBooking->status = $request->status;
        $tableBooking->branchId = $request->branchId;
        $tableBooking->customerId = $request->customerId;
        if($tableBooking->save()){
            return response()->json([
                "status"=>200,
                "message"=>trans("Saved Successfully"),
                "data"=>$tableBooking
            ]);
        }
    }

    public function branch($id){
//        echo Hash::make("123456");
        $tableBooking = Tablebooking::where("branchId",$id)->get();
            return response()->json([
                "status"=>200,
                "data"=>$tableBooking
            ]);
    }
    public function customer($id){
        $tableBooking = Tablebooking::where("customerId",$id)->get();
            return response()->json([
                "status"=>200,
                "data"=>$tableBooking
            ]);
    }
    public function single($id){
        $tableBooking = Tablebooking::find($id);
            return response()->json([
                "status"=>200,
                "data"=>$tableBooking
            ]);
    }

    public function delete($id){
        $tableBooking = Tablebooking::find($id);
        if($tableBooking && $tableBooking->delete()){
            return response()->json([
                "status"=>200,
                "message"=>trans("Deleted Successfully")
            ]);
        }
        return response()->json([
            "status"=>201,
            "message"=>trans("Deleting Failed")
        ]);

    }

    public function edit(Request $request){
        if(!$request->id){
            return response()->json([
                "status"=>201,
                "message"=>trans("Id is Required")
            ]);
        }
        if($tableBooking = Tablebooking::find($request->id)){
            if($request->dateTime){
                $tableBooking->dateTime = $request->dateTime;
            }
            if($request->numberOfPerson) {
                $tableBooking->numberOfPerson = $request->numberOfPerson;
            }
            if($request->occasion) {
                $tableBooking->occasion = $request->occasion;
            }
            if($request->message) {
                $tableBooking->message = $request->message;
            }
            if ($request->status){
                $tableBooking->status = $request->status;
            }
            if ($request->branchId){
                $tableBooking->branchId = $request->branchId;
            }
            if ($request->customerId){
                $tableBooking->customerId = $request->customerId;
            }
            if($tableBooking->save()){
                return response()->json([
                    "status"=>200,
                    "message"=>trans("Saved Successfully"),
                    "data"=>$tableBooking
                ]);
            }
        }else{
            return response()->json([
                "status"=>201,
                "message"=>trans("Id is Not Valid")
            ]);
        }

    }
}
