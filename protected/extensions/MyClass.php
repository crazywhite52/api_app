<?php

class MyClass {

    public function generateCode($fyear, $fmonth, $fnumb, $ftext, $formats, $fsp) {
        #$fyearส่งตัวแปล y=ปีสองหลัก, Y=ปีสี่หลัง
        #$fmonth ส่งตวแป n=เดือนหลักเดียว, m=เดือนสองหลัก
        #$fumb จำนวนหลังที่เจนตัวเลย กำหนดเป็นจำนวนตัวเลข
        #$ftext ตัวอักษรนำหน้าเลขเจน
        #$formats รูปแบบเลขเจนเดิมเพื่อนำมาบวกค่าล่าสุด
        #$fsp กรณีที่จะกำหนดปีเป็น format thai
        $lenword1 = strlen($ftext);
        if ($fyear == "y") {
            $lenword2 = 2;
        } elseif ($fyear == "Y") {
            $lenword2 = 4;
        }
        if ($fmonth == "n") {
            $lenword3 = 1;
        } elseif ($fmonth == "m") {
            $lenword3 = 2;
        }
        $omonth = $lenword1 + $lenword2;
        $omonth = substr($formats, $omonth, $lenword3);
        $setyear = date($fyear);
        if ($fsp) {
            $setyear = $setyear + $fsp;
        }
        if ($omonth == date($fmonth)) {
            $lenword4 = strlen($formats);
            $setpoint = ($lenword4 - $fnumb) + 1;
            $genumb = (substr($formats, $setpoint, $fnumb) + 0) + 1;
            $generate = $ftext . $setyear . date($fmonth) . sprintf("%0" . $fnumb . "d", $genumb);
        } else {
            $generate = $ftext . $setyear . date($fmonth) . sprintf("%0" . $fnumb . "d", 1);
        }
        return $generate;
    }

    public function gennum($num) {
        if (!empty($num)) {
            $sumnum = $num + 1;
        } else {
            $sumnum = 1;
        }
        return $sumnum;
    }

    public function insertDate($setdate) {
        $date = "";
        if ($setdate) {
            $exp = explode("/", $setdate);
            $date = $exp[2] . $exp[1] . $exp[0];
        }
        return $date;
    }

    public function convertDate($setdate) {
        $date = "";
        if ($setdate) {
            $exp = explode("-", $setdate);
            $date = $exp[2] . "/" . $exp[1] . "/" . $exp[0];
        }
        return $date;
    }

    public static function ageWork($birthday) {
        list($day, $month, $year) = explode("/", $birthday);

        $datedeb = mktime(0, 0, 0, $month, $day, $year);
        $datefin = time();

        $aad = date("Y", $datedeb);
        $mmd = date("m", $datedeb);
        $jjd = date("d", $datedeb);

        $aaf = date("Y", $datefin);
        $mmf = date("m", $datefin);
        $jjf = date("d", $datefin);

        $nbj = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); //ÇÑ¹áµèÅÐà´×Í¹
        if (($aaf % 4) == 0) {
            $nbj[2] = 29;
        } //»ÕÍ¸Ô¡ÊØÃ·Ô¹
        if ((($aaf % 100) == 0) & (($aaf % 400) != 0)) {
            $nbj[2] = 28;
        } //»ÕÍ¸Ô¡ÊØÃ·Ô¹

        if ($jjf < $jjd) {
            $jjf = $jjf + $nbj[(int) $mmf];
            $mmf = $mmf - 1;
        }
        if ($mmf < $mmd) {
            $mmf = $mmf + 12;
            $aaf = $aaf - 1;
        }

        return "" . sprintf("%02d", ($aaf - $aad)) . " ปี " . sprintf("%02d", ($mmf - $mmd)) . " เดือน " . sprintf("%02d", ($jjf - $jjd)) . " วัน ";
    }

    public static function monthThai($setmonth) {
        $monththai = '';
        $mformat = sprintf('%02d', $setmonth);
        if ($mformat == '01') {
            $monththai = 'มกราคม';
        } elseif ($mformat == '02') {
            $monththai = 'กุมภาพันธ์';
        } elseif ($mformat == '03') {
            $monththai = 'มีนาคม';
        } elseif ($mformat == '04') {
            $monththai = 'เมษายน';
        } elseif ($mformat == '05') {
            $monththai = 'พฤษภาคม';
        } elseif ($mformat == '06') {
            $monththai = 'มิถุนายน';
        } elseif ($mformat == '07') {
            $monththai = 'กรกฎาคม';
        } elseif ($mformat == '08') {
            $monththai = 'สิงหาคม';
        } elseif ($mformat == '09') {
            $monththai = 'กันยายน';
        } elseif ($mformat == '10') {
            $monththai = 'ตุลาคม';
        } elseif ($mformat == '11') {
            $monththai = 'พฤศจิกายน';
        } elseif ($mformat == '12') {
            $monththai = 'ธันวาคม';
        }
        return $monththai;
    }

    public static function monthThaiFull($setdate) {
        $dateyear = "";
        $monththai = "";
        if ($setdate) {
            $exp = explode("-", $setdate);
            $mformat = sprintf('%02d', $exp[1]);
            if ($mformat == '01') {
                $monththai = 'มกราคม';
            } elseif ($mformat == '02') {
                $monththai = 'กุมภาพันธ์';
            } elseif ($mformat == '03') {
                $monththai = 'มีนาคม';
            } elseif ($mformat == '04') {
                $monththai = 'เมษายน';
            } elseif ($mformat == '05') {
                $monththai = 'พฤษภาคม';
            } elseif ($mformat == '06') {
                $monththai = 'มิถุนายน';
            } elseif ($mformat == '07') {
                $monththai = 'กรกฎาคม';
            } elseif ($mformat == '08') {
                $monththai = 'สิงหาคม';
            } elseif ($mformat == '09') {
                $monththai = 'กันยายน';
            } elseif ($mformat == '10') {
                $monththai = 'ตุลาคม';
            } elseif ($mformat == '11') {
                $monththai = 'พฤศจิกายน';
            } elseif ($mformat == '12') {
                $monththai = 'ธันวาคม';
            }
            $year = $exp[0] + 543;
            $dateyear = $exp[2] . " " . $monththai . " " . $year;
        }
        return $dateyear;
    }
    public static function chkofficer($id){
        $data="";
        if($id<>''){
            $chkname = "SELECT * FROM sysuser WHERE name='" .trim($id). "'";
            $res = Yii::app()->db2->createCommand($chkname)->queryRow();
            $data = $res['fullname']."&nbsp;".$res['surname'];
        }
        return $data;
    }
    public static function chkbranck($br){
        $brname="";
        if($br<>''){
            $chk = "SELECT branchname FROM branch WHERE branch='" .trim($br). "'";
            $b = Yii::app()->db3->createCommand($chk)->queryRow();
            $brname = trim($b['branchname']);
        }
        return $brname;
    }
    public static function chkclass($class){
        $nclass="";
        if($class<>''){
            $chkc="SELECT * FROM category WHERE categoryid='".trim($class)."' ";
            $val = Yii::app()->db->createCommand($chkc)->queryRow();
            $nclass = trim($val['catname']);
        }
        return $nclass;
    }
    public static function docstatus($doc){
        $status="";
        if($doc<>''){
            if ($doc == 1) {
                $status = "อยู่ที่สาขา";
            } else if ($doc == 2) {
                $status = "ส่งมาเคลมแต่ยังไม่รับ";
            } else if ($doc == 3) {
                $status = "รับสินค้าแล้วแต่ยังไม่ตรวจสอบ";
            } else if ($doc == 4) {
                $status = "รับสินค้าตรวจสอบแล้ว";
            } else if ($doc == 5) {
                $status = "ส่ง sup แล้ว";
            } else if ($doc == 6) {
                $status = "รับสินค้าจาก sup แล้วยังไม่ตรวจสอบ";
            } else if ($doc == 7) {
                $status = "รับสินค้าจาก sup แล้วตรวจสอบแล้ว";
            } else if ($doc == 8) {
                $status = "ทดสอบสินค้าจาก sup (ผ่านแล้ว)";
            } else if ($doc == 9) {
                $status = "ส่งคืนสาขาแล้ว";
            } else if ($doc == 10) {
                $status = "สาขารับสินค้าแล้ว";
            } else if ($doc == 11) {
                $status = "ปิด job แล้ว หรือส่งคืนลูกค้าแล้ว";
            } else if ($doc == 12) {
                $status = "ไม่มีสินค้าคืนเงิน";
            } else if ($doc == 13) {
                $status = "อัพเกรดเพิ่มเงิน";
            } else if ($doc == 14) {
                $status = "ปิด DS แล้ว";
            } elseif ($doc == 15) {
                $status = "สินค้าหาย";
            } else if ($doc == 0) {
                $status = "รหัสถูกยกเลิก";
            }
        }
        return $status;

    }
    public static function chkcomment($id){
        $cc="SELECT GROUP_CONCAT(postcomm SEPARATOR ', ') AS comm FROM commboard WHERE claimno='$id' ";
        $value = Yii::app()->db->createCommand($cc)->queryRow();
        $text=$value['comm'];
     return $text;
 }

}

?>