<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class RunningCodesController extends Controller
{
        public $Month = "";		// เก็บค่าเดือน เช่น 04  date("m")
	public $LastID = "";			// รหัส 4 ตัว
	
	public $Key = "";               // อักษรย่อ
        public $last_id,$last_3_digit = ""; 

	//public $CODE = $Key.$Year.$Month;
       
        
        public function RunningCodes($field,$table,$key){	
            
            $this->Month = date("m");
            $this->Year = substr((date("Y")),2);
            
            $this->CODE = $this->Key.$this->Year.$this->Month;
            $run = $this->findCode($field,$table,$this->CODE);
            if(!isset($run['id'])){
                    
                            $this->last_id = $run['id'];
                            //echo $last_id."<br>";
                            $this->last_3_digit = substr($this->last_id,-3,3);// ตัดเอาเฉพาะ 4 หลักสุดท้าย
                            //echo $last_4_digit."<br>";
                            $this->last_3_digit = $this->last_3_digit+1;
                            //echo $last_4_digit."<br>";
                            while(strlen($this->last_3_digit)<3){
                                    $this->last_3_digit = "0".$this->last_3_digit;
                            }

                            $this->CODE = $this->CODE.$this->last_3_digit;
                            return $this->CODE;
                            //$ObjQry=mysql_query("INSERT INTO create_id(row,id) VALUES('','$CODE')");
                   
            }else{
                    $this->CODE = $this->CODE."001";
                    return $this->CODE;
            }

    }
    
    public function findCode($field,$table,$code)
    {
        $sql="SELECT MAX($field) as id FROM $table WHERE $field LIKE '$code%'";
	
        $command = Yii::$app()->createCommand($sql);
        $row = $command->queryRow();
        return $row;
    }
}
?>

