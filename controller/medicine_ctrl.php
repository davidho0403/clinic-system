<?php


require_once("../model/medicine_mod.php");

class Medicine_ctrl extends Medicine_mod {

    //顯示藥品資料
    public function showMedInfo($param) {
        $med_id = $param['med_id'];
        return $this->getSingle($this->table, $this->keyname, $med_id);
    }

    //新增藥品資料
    public function insertMedInfo($param) {
        $med_id = $param['med_id'];
        $med_name = $param['med_name'];
        $med_academic_name = $param['med_academic_name'];
        $med_effect = $param['med_effect'];
        return $this->insert($med_id, $med_name, $med_academic_name, $med_effect);
    }

    //更改藥品資料
    // change place : 修改屬性, change text : 修改內容
    public function updateMedInfo($param) {
        $med_id = $param['med_id'];
        $change_place = $param['change_place'];
        $change_text = $param['change_text'];
        if ($change_place == "med_id") { // med_id is PK 不能修改
            return "PK error";
        }
        return $this->update($med_id, $change_place, $change_text);
    }

    //取得所有藥品
    public function getAllMedInfo() {
        return $this->getAll();
    }
}
