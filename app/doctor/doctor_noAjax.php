<?php
require_once("../db_con.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor</title>
</head>

<body>
    <h3>病患病歷查詢</h3>
    <form method="POST" action="./doctor_noAjax.php">
        請選擇病例號碼：
        <!-- <input type="text" value="請輸入病歷號碼" name="case_id" id="case_id"><br> -->
        <input list="patient_case_id" name="case_id"><br>
        <datalist id="patient_case_id">
            <?php
            $sql =  "SELECT * FROM `patient`";
            $result = mysqli_query($link, $sql);
            $datas = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $datas[] = $row;
            }

            for ($i = 0; $i < count($datas); $i++) {
                echo '<option value=' . $datas[$i]["case_id"] . '>';
            }
            ?>
        </datalist>
        <input type="submit" value="查詢" name="searchBtn" id="searchBtn"><br>
    </form>

    <?php
    if (isset($_POST['case_id'])) {
        $case_id = trim($_POST["case_id"]);
        $patient_datas = array();
        $sql = "SELECT * FROM `patient_records` WHERE `case_id`='$case_id'";

        $result = mysqli_query($link, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $patient_datas[] = $row;
                }

                $sql = "SELECT * FROM `patient` WHERE `case_id` = '$case_id'";
                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo '病歷號碼：' . $row['case_id'] . ' 病患名稱：' . $row['patient_name'] . '<br><br>';
                }

                for ($i = 0; $i < count($patient_datas); $i++) {
                    echo '看診紀錄編號：' . $patient_datas[$i]['record_id'] . '<br>';
                    if ($patient_datas[$i]['comment'] == NULL) {
                        $patient_datas[$i]['comment'] = 'NONE';
                    }
                    echo '醫生編號：' . $patient_datas[$i]['doc_id'] . ' 看診日期：' . $patient_datas[$i]['consulation_date'] . ' 疾病名稱：' . $patient_datas[$i]['disease_name'] . ' 用藥天數：' . $patient_datas[$i]['med_days'] . ' 備註：' . $patient_datas[$i]['comment'] . '<br><br>';
                }
            } else {
                while ($row = mysqli_fetch_array($result)) {
                    echo '病歷編號：' . $row['case_id'] . ' 病患名稱：' . $row['patient_name'] . '<br><br>';
                }
                echo '尚無就診紀錄<br>';
            }
            mysqli_free_result($result);
        }
        // mysqli_close($link);
    }
    // if (!empty($result)) {
    //     // 如果結果不為空，就利用print_r方法印出資料
    //     echo count($patient_datas);
    //     print_r($patient_datas);
    // } else {
    //     // 為空表示沒資料
    //     echo "查無資料";
    // }
    ?>

    <h3>新增病歷資料</h3>
    <form method="GET" action="./doctor_noAjax.php">
        病歷號碼:
        <input list="patient_case_id" name="rec_case_id">
        醫生編號：
        <input list="doc_id" name="doc_id">
        <datalist id="doc_id">
            <?php
            $sql =  "SELECT * FROM `doctor`";
            $result = mysqli_query($link, $sql);
            $datas = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $datas[] = $row;
            }

            for ($i = 0; $i < count($datas); $i++) {
                echo '<option value=' . $datas[$i]["doc_id"] . '>';
            }
            ?>
        </datalist>
        看診日期：
        <input type="date" id="date"><br><br>
        疾病名稱：
        <input type="text" id="disease_name">
        用藥天數：
        <input type="text" id="med_days">
        備註：
        <input type="text" id="comment"><br><br>
        <input type="submit" value="新增" id="sub_new_rec">
    </form>
    <?php
    require_once("../db_con.php");
    // if (isset($_POST['case_id']) && isset($_POST['doc_id']) && isset($_POST['date']) && isset($_POST['disease_name']) && isset($_POST['med_days'])) {
        $rec_case_id = $_GET["rec_case_id"];
        $doc_id = $_GET["doc_id"];
        $date = $_GET["date"];
        $disease_name = $_GET["disease_name"];
        $med_days = $_GET["med_days"];
        $comment = $_GET["comment"];

        $sql = "INSERT INTO `patient_records` VALUES (NULL, '$rec_case_id', '$doc_id', '$date', '$disease_name', '$med_days', '$comment')";
        if (mysqli_query($link, $sql)) {
            echo '病患病歷新增成功';
        } else {
            echo '病患病歷新增失敗';
        }
        // $sql_query = "INSERT INTO `patient_records` (`case_id`, `doc_id`, `consulation_date`, `disease_name`, `med_days`, `comment`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        // $stmt = $link->prepare($sql_query);
        // $stmt->bind_param($_POST["rec_case_id"], $_POST["doc_id"], $_POST["date"], $_POST["disease_name"], $_POST["med_days"], $_POST["comment"]);
        // $stmt->execute();
    // }
    ?>
</body>

</html>