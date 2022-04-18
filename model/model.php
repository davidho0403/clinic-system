<?php

class Model {

  //連接資料庫
  private function getDB() {
    $host = 'localhost';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'Clinic_System';
    $link = mysqli_connect($host, $dbuser, $dbpassword, $dbname);

    return $link;
  }
  //執行sql，返回結果集
  public function execute($sql) {
    $result = mysqli_query($this->getDB(), $sql);
    return $result;
  }
  //取整個表
  public function getAll() {
    $sql = "SELECT * FROM $this->table";
    $list = $this->execute($sql);
    while ($row = mysqli_fetch_assoc($list)) {
      $result = $row;
    }
    return $result;
  }
  //取某屬性的全部值
  public function getSingleAttrAll($attr) {
    $sql = "SELECT $attr FROM $this->table";
    $list = $this->execute($sql);
    while ($row = mysqli_fetch_assoc($list)) {
      $result[] = $row;
    }
    return $result;
  }
  //取某表中的一行
  public function getSingle($table, $key_name, $key) {
    $sql = "SELECT * FROM $table WHERE $key_name = '$key'";
    $result = $this->execute($sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
  }
  //取某表中的多行
  public function getMultiple($table, $key_name, $key) {
    $sql = "SELECT * FROM $table WHERE $key_name = '$key'";
    $list = $this->execute($sql);
    while ($row = mysqli_fetch_assoc($list)) {
      $result[] = $row;
    }
    return $result;
  }
  //從某屬性$attr1找另一屬性$attr2
  public function getOtherAttr($attr1, $key, $attr2) {
    $sql = "SELECT $attr2 FROM $this->table WHERE $attr1 = '$key'";
    $list = $this->execute($sql);
    while ($row = mysqli_fetch_assoc($list)) {
      $result[] = $row;
    }
    return $result;
  }
  //通過某屬性判斷資料是否存在,返回資料筆數
  public function Exist($table, $key_name, $key) {
    $sql = "SELECT * FROM $table WHERE $key_name = '$key'";
    $result = $this->execute($sql);
    return mysqli_num_rows($result);
  }
}
