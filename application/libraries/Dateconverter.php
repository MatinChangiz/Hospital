<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * Date converter script is to convert date betweeen hijri shamsi and gregorean format
 * The date conversion between hijri to gregorian there is a logical error 
 * which converts 10-12-1390 to 29-02-2011, Febrauary can not  be 29 days
 * so here we have solved by taking the module of hijri year by 4 and if the reminder is 2
 * and hijri month is 12, the reseult will be 01-03-2011 and vice versa to convert again to hijri
 * the same process will continue
 * 
 * @package        CodeIgniter
 * @author        Naser
 * @license       mngafghan@gmail.com
 * @since        Version 1.0
 * @filesource
 */
class Dateconverter
{
    
        //days in month in gregorean and shamsi 
        private $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        private $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
        //miladi to shamsi
        function GregorianToJalali($g_y, $g_m, $g_d)
        {
            $g_days_in_month = $this->g_days_in_month;
            $j_days_in_month = $this->j_days_in_month;
               
           $gy = $g_y-1600;
           $gm = $g_m-1;
           $gd = $g_d-1;

           $g_day_no = 365*$gy+$this->div($gy+3,4)-$this->div($gy+99,100)+$this->div($gy+399,400);

           for ($i=0; $i < $gm; ++$i)
              $g_day_no += $g_days_in_month[$i];
           if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
              /* leap and after Feb */
              ++$g_day_no;
           $g_day_no += $gd;

           $j_day_no = $g_day_no-79;

           $j_np = $this->div($j_day_no, 12053);
           $j_day_no %= 12053;

           $jy = 979+33*$j_np+4*$this->div($j_day_no,1461);

           $j_day_no %= 1461;

           if ($j_day_no >= 366) {
              $jy += $this->div($j_day_no-1, 365);
              $j_day_no = ($j_day_no-1)%365;
           }

           for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) {
              $j_day_no -= $j_days_in_month[$i];
           }
           $jm = $i+1;
           $jd = $j_day_no+1;
            return array($jy, $jm, $jd);
        }
        //hijri shamsi to miladi
        function JalaliToGregorian($year,$month,$day)
        {
            $gDaysInMonth = $this->g_days_in_month;
            $jDaysInMonth = $this->j_days_in_month;
            $jy=$year-979;
            $jm=$month-1;
            $jd=$day-1;
            $jDayNo=365*$jy + $this->div($jy,33)*8 + $this->div((($jy%33)+3),4);
                for ($i=0; $i < $jm; ++$i)  
                $jDayNo += $jDaysInMonth[$i];
            $jDayNo +=$jd;
            $gDayNo=$jDayNo + 79;
            //146097=365*400 +400/4 - 400/100 +400/400
            $gy=1600+400*$this->div($gDayNo,146097);
            $gDayNo = $gDayNo%146097;
            $leap=1;
            if($gDayNo >= 36525)
            {
                $gDayNo =$gDayNo-1;
                //36524 = 365*100 + 100/4 - 100/100
                $gy +=100* $this->div($gDayNo,36524);
                $gDayNo=$gDayNo % 36524;

                if($gDayNo>=365)
                $gDayNo = $gDayNo+1;
                else
                $leap=0;
            }
            //1461 = 365*4 + 4/4
            $gy += 4*$this->div($gDayNo,1461);
            $gDayNo %=1461;
            if($gDayNo>=366)
            {
                $leap=0;
                $gDayNo=$gDayNo-1;
                $gy += $this->div($gDayNo,365);
                $gDayNo=$gDayNo %365;
            }
            $i=0;
            $tmp=0;
            while ($gDayNo>= ($gDaysInMonth[$i]+$tmp))
            {
                if($i==1 && $leap==1)
                $tmp=1;
                else
                $tmp=0;

                $gDayNo -= $gDaysInMonth[$i]+$tmp;
                $i=$i+1;
            }
            $gm=$i+1;
            $gd=$gDayNo+1;
            return array($gy, $gm, $gd);
        }

        function div($a, $b) {
           return (int) ($a / $b);
        }
    
        function grgIsLeap ($Year)
        {
            return (($Year%4) == 0 && (($Year%100) != 0 || ($Year%400) == 0));
        }
         
        function hshIsLeap ($Year)
        {
            $Year = ($Year - 474) % 128;
            $Year = (($Year >= 30) ? 0 : 29) + $Year;
            $Year = $Year -round($Year/33) - 1;
            return (($Year % 4) == 0);
        }
        
        function date_div($a,$b) 
        {
            return (int) ($a / $b);
        }
        
        function jalali_to_gregorian($j_y, $j_m, $j_d) 
        { 
            
            
            $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
            $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

            $jy = $j_y-979; 
            $jm = $j_m-1; 
            $jd = $j_d-1; 

            $j_day_no = 365*$jy + $this->date_div($jy, 33)*8 + $this->date_div($jy%33+3, 4); 
            for ($i=0; $i < $jm; ++$i) 
              $j_day_no += $j_days_in_month[$i]; 

           $j_day_no += $jd; 

           $g_day_no = $j_day_no+79; 

           $gy = 1600 + 400*$this->date_div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */ 
           $g_day_no = $g_day_no % 146097; 

           $leap = true; 
           if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */ 
           { 
              $g_day_no--; 
              $gy += 100*$this->date_div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */ 
              $g_day_no = $g_day_no % 36524; 

              if ($g_day_no >= 365) 
                 $g_day_no++; 
              else 
                 $leap = false; 
           } 

           $gy += 4*$this->date_div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */ 
           $g_day_no %= 1461; 

           if ($g_day_no >= 366) { 
              $leap = false; 

              $g_day_no--; 
              $gy += $this->date_div($g_day_no, 365); 
              $g_day_no = $g_day_no % 365; 
           } 

           for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++) 
              $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap); 
           $gm = $i+1; 
           $gd = $g_day_no+1; 
           if ($j_m == 12 && $gm==2 && $gd==29)
            {
               $gd = 1;
               $gm= 3;
            }
            
            if(strlen($gd)==1)
            {
                 $gd="0".$gd;
            }
            if(strlen($gm)==1)
            {
                 $gm="0".$gm;
            }
            return  $gy."-".$gm."-".$gd;  
        }
        //convert hijri to gregoian  2011-03-09
        function ToGregorian ($hshYear,$hshMonth,$hshDay)
        {
            $miladiDate = array();  
            $miladiDate = $this->jalali_to_gregorian2($hshYear."-".$hshMonth."-".$hshDay);
            
            return  $miladiDate;
            /*
            $gd  = $miladiDate[2];
            $gm  = $miladiDate[1];
            $gy  = $miladiDate[0];
            if(strlen($gd)==1)
            {
                 $gd="0".$gd;
            }
            if(strlen($gm)==1)
            {
                 $gm="0".$gm;
            }
            //check if the year with module 4 is 2 and month 12 and day is 10
            if($hshYear % 4 == 2 && $hshMonth==12 &&  $hshDay==10)
            {
               return  $gy."-02-29";
            }
            else
            {
                return  $gy."-".$gm."-".$gd;  
            }
            */
            //return $this->jalali_to_gregorian($hshYear,$hshMonth,$hshDay);
            /*exit;
        
            $grgSumOfDays=Array(Array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365),Array(0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366));
            $hshSumOfDays=Array(Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365), Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 366));
         
            $grgYear = $hshYear+621;
            $grgMonth;
            $grgDay;
         
            $hshLeap=$this->hshIsLeap($hshYear);
            $grgLeap=$this->grgIsLeap($grgYear);
            $hshElapsed=$hshSumOfDays [$hshLeap ? 1:0][$hshMonth-1]+$hshDay;
            $grgElapsed;
         
            if ($hshMonth > 10 || ($hshMonth == 10 && $hshElapsed > 286+($grgLeap ? 1:0)))
            {
                $grgYear=$grgYear+1;
                $grgElapsed = $hshElapsed - (285 + ($grgLeap ? 1:0));
                $grgLeap = $this->grgIsLeap ($grgYear+1);
            }
            else
            {
                $hshLeap =$this->hshIsLeap ($hshYear-1);
                $grgElapsed = $hshElapsed + 79 + ($hshLeap ? 1:0) - ($this->grgIsLeap($grgYear-1) ? 1:0);
            }
         
            for ($i=1; $i <= 12; $i++)
            {
                if ($grgSumOfDays [$grgLeap ? 1:0][$i] >= $grgElapsed)
                {
                    $grgMonth = $i;
                    $grgDay = $grgElapsed - $grgSumOfDays [$grgLeap ? 1:0][$i-1];
                    break;
                }
            }
            if ($hshMonth == 12 && $grgMonth==2 && $grgDay==29)
            {
               $grgDay = 1;
               $grgMonth= 3;
            }
            
            if(strlen($grgDay)==1)
            {
                 $grgDay="0".$grgDay;
            }
            if(strlen($grgMonth)==1)
            {
                 $grgMonth="0".$grgMonth;
            }
            return  $grgYear."-".$grgMonth."-".$grgDay;   */
        }
        
        function ToGregorianyear ($hshYear)
        {
            
        
            $grgSumOfDays=Array(Array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365),Array(0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366));
            $hshSumOfDays=Array(Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365), Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 366));
         
            $grgYear = $hshYear+621;
         
            $hshLeap=$this->hshIsLeap($hshYear);
            $grgLeap=$this->grgIsLeap($grgYear);
            $hshElapsed=$hshSumOfDays [$hshLeap ? 1:0];
            $grgElapsed;
        
            return  $grgYear;
        }
        //convert gregorean to hijri shamsi format
        //2 Hamal 1390
       function ToShamsi($grgYear,$grgMonth,$grgDay)
        {
            
            $shamsiDate = array();
            $shamsiDate = $this->GregorianToJalali($grgYear,$grgMonth,$grgDay);
            $year  = $shamsiDate[0];
            $month = $shamsiDate[1];
            $day   = $shamsiDate[2];
            if($year % 4 == 2 && $grgMonth==3 && $grgDay==1)
            {
               $day = $day-1;
            }
            if(strlen($day)==1)
            {
                 $day="0".$day;
            }
            if(strlen($month)==1)
            {
                 $month="0".$month;
            } 
            //echo $this->Convertnumber2farsi($year).'/'.$day; exit;
            return ($day)."-".($month)."-".($year); 
            
            /*
            $grgSumOfDays=Array(Array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365),Array(0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366));
            $hshSumOfDays=Array(Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365), Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 366));

            $hshYear = $grgYear-621;
            $hshMonth;
            $hshDay;
            
            $grgLeap=$this->grgIsLeap ($grgYear);
            $hshLeap=$this->hshIsLeap ($hshYear-1);
            $hshElapsed;
            
            $grgElapsed = $grgSumOfDays[($grgLeap ? 1:0)][$grgMonth-1]+$grgDay;
             $XmasToNorooz = ($hshLeap && $grgLeap) ? 80 : 79;

            if ($grgElapsed <= $XmasToNorooz)
            {
                $hshElapsed = $grgElapsed+286;
                $hshYear--;
                if ($hshLeap && !$grgLeap)
                    $hshElapsed++;
            }
            else
            {
                $hshElapsed = $grgElapsed - $XmasToNorooz;
                $hshLeap = $this->hshIsLeap ($hshYear);
            }
             
            for ($i=1; $i <= 12 ; $i++)
            {
                if ($hshSumOfDays [($hshLeap ? 1:0)][$i] >= $hshElapsed)
                {
                    $hshMonth = $i;
                    $hshDay = $hshElapsed - $hshSumOfDays [($hshLeap ? 1:0)][$i-1];
                    break;
                }
            }
            if($hshYear % 4 == 2 && $grgMonth==3 && $grgDay==1)
            {
               $hshDay = $hshDay-1;
            }
            
             return  $hshDay.' '.$this->monthname_shamsi($hshMonth). " ".$hshYear;
            */ 
        }

        function ToShamsiYear($grgYear)
        {
            
            $grgSumOfDays=Array(Array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365),Array(0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366));
            $hshSumOfDays=Array(Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365), Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 366));

            $hshYear = $grgYear-621;
            $hshMonth;
            $hshDay;
            
            $grgLeap=$this->grgIsLeap ($grgYear);
            $hshLeap=$this->hshIsLeap ($hshYear-1);
            $hshElapsed;
            
            $grgElapsed = $grgSumOfDays[($grgLeap ? 1:0)];
             $XmasToNorooz = ($hshLeap && $grgLeap) ? 80 : 79;

            if ($grgElapsed <= $XmasToNorooz)
            {
                $hshElapsed = $grgElapsed+286;
                $hshYear--;
                if ($hshLeap && !$grgLeap)
                    $hshElapsed++;
            }
            else
            {
                //$hshElapsed = $grgElapsed - $XmasToNorooz;
                $hshLeap = $this->hshIsLeap ($hshYear);
            }
             
             return $hshYear;
             
        }
        
        function dayname_shamsi($gday)
        {
         $gname_day=Array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
         $sname_day=Array('دوشنبه','سه شنبه','چهارشنبه','پنج شنبه','جمعه','شنبه','يکشنبه');    
         for($i=0;$i<sizeof($gname_day);$i++)
         {
            if($gname_day[$i]==$gday)
            {
              return $sname_day[$i];
              break;
            }
         }
        }
        
        function monthname_shamsi($month)
        {
         $smonthname_day=Array('حمل','ثور','جوزا','سرطان','اسد','سنبله','ميزان','عقرب','قوس','جدي','دلو','حوت');    
         switch($month)
         {
          case '1':{return $smonthname_day[0];}break;
          case '2':{return $smonthname_day[1];}break; 
          case '3':{return $smonthname_day[2];}break; 
          case '4':{return $smonthname_day[3];}break; 
          case '5':{return $smonthname_day[4];}break; 
          case '6':{return $smonthname_day[5];}break; 
          case '7':{return $smonthname_day[6];}break; 
          case '8':{return $smonthname_day[7];}break; 
          case '9':{return $smonthname_day[8];}break; 
          case '10':{return $smonthname_day[9];}break; 
          case '11':{return $smonthname_day[10];}break; 
          case '12':{return $smonthname_day[11];}break; 
         
         }
        }
        //to short shamsi format 1390-02-20
        function ToShamsi_short($grgYear,$grgMonth,$grgDay)
        {
            $shamsiDate = array();
            $shamsiDate = $this->GregorianToJalali($grgYear,$grgMonth,$grgDay);
            $year  = $shamsiDate[0];
            $month = $shamsiDate[1];
            $day   = $shamsiDate[2];
            if($year % 4 == 2 && $grgMonth==3 && $grgDay==1)
            {
               $day = $day-1;
            }
            if(strlen($day)==1)
            {
                 $day="0".$day;
            }
            if(strlen($month)==1)
            {
                 $month="0".$month;
            }
            return  $day."-".$month. "-".$year; 
            /*
            
            $grgSumOfDays=Array(Array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365),Array(0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366));
            $hshSumOfDays=Array(Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365), Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 366));

            $hshYear = $grgYear-621;
            $hshMonth;
            $hshDay;
            
            $grgLeap=$this->grgIsLeap ($grgYear);
            $hshLeap=$this->hshIsLeap ($hshYear-1);
            $hshElapsed;
            
            $grgElapsed = $grgSumOfDays[($grgLeap ? 1:0)][$grgMonth-1]+$grgDay;
             $XmasToNorooz = ($hshLeap && $grgLeap) ? 80 : 79;

            if ($grgElapsed <= $XmasToNorooz)
            {
                $hshElapsed = $grgElapsed+286;
                $hshYear--;
                if ($hshLeap && !$grgLeap)
                    $hshElapsed++;
            }
            else
            {
                $hshElapsed = $grgElapsed - $XmasToNorooz;
                $hshLeap = $this->hshIsLeap ($hshYear);
            }
             
            for ($i=1; $i <= 12 ; $i++)
            {
                if ($hshSumOfDays [($hshLeap ? 1:0)][$i] >= $hshElapsed)
                {
                    $hshMonth = $i;
                    $hshDay = $hshElapsed - $hshSumOfDays [($hshLeap ? 1:0)][$i-1];
                    break;
                }
            }
            if($hshYear % 4 == 2 && $grgMonth==3 && $grgDay==1)
            {
               $hshDay = $hshDay-1;
            }
            
            if(strlen($hshDay)==1)
            {
                 $hshDay="0".$hshDay;
            }
            if(strlen($hshMonth)==1)
            {
                 $hshMonth="0".$hshMonth;
            }
             return  $hshDay.'-'.$hshMonth. "-".$hshYear;
            */ 
        }
        
        function ToShamsi_shortYear($grgYear)
        {
            
            $grgSumOfDays=Array(Array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365),Array(0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366));
            $hshSumOfDays=Array(Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365), Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 366));

            $hshYear = $grgYear-621;
            
            $grgLeap=$this->grgIsLeap ($grgYear);
            $hshLeap=$this->hshIsLeap ($hshYear-1);
            $hshElapsed;
            
            $grgElapsed = $grgSumOfDays[($grgLeap ? 1:0)];
             $XmasToNorooz = ($hshLeap && $grgLeap) ? 80 : 79;

            if ($grgElapsed <= $XmasToNorooz)
            {
                $hshElapsed = $grgElapsed+286;
                $hshYear--;
                if ($hshLeap && !$grgLeap)
                    $hshElapsed++;
            }
            else
            {
               // $hshElapsed = $grgElapsed - $XmasToNorooz;
                $hshLeap = $this->hshIsLeap ($hshYear);
            }
             
             return $hshYear;
             
        }

        //============ali date converter modified======
        function jalali_to_gregorian2($jalali_date)
        {
            $date_array = explode("-",$jalali_date);
            if(count($date_array) > 2)
            {
                $j_y = $date_array[0];
                $j_m = $date_array[1];
                $j_d = $date_array[2];    
            }
            else
            {
                $j_y = 0;
                $j_m = 0;
                $j_d = 0;                
            }
        
            $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
            $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

            $jy = $j_y-979;
            $jm = $j_m-1;
            $jd = $j_d-1;

            $j_day_no = 365*$jy + $this->div($jy, 33)*8 + $this->div($jy%33+3, 4);
            for ($i=0; $i < $jm; ++$i)
                $j_day_no += $j_days_in_month[$i];
        
            $j_day_no += $jd;
            $g_day_no = $j_day_no+79;

            $gy = 1600 + 400*$this->div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
            $g_day_no = $g_day_no % 146097;

            $leap = true;

            if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
            {
                $g_day_no--;
                $gy += 100*$this->div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */
                $g_day_no = $g_day_no % 36524;

                if ($g_day_no >= 365)
                    $g_day_no++;
                else
                    $leap = false;

            }

            $gy += 4*$this->div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
            $g_day_no %= 1461;

            if ($g_day_no >= 366) 
            {
                $leap = false;
                $g_day_no--;
                $gy += $this->div($g_day_no, 365);
                $g_day_no = $g_day_no % 365;

            }

            for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
                $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
        
            $gm = $i+1;
            $gd = $g_day_no+1;


            return implode("-",array($gy, str_pad($gm, 2, "0", STR_PAD_LEFT), str_pad($gd, 2, "0", STR_PAD_LEFT)));
        }
        
        /*
    * convert and formats the given time stamp string to the Persian date.
    * format strings are the same with php date function. 
    */
    function pdate_format($time_stamp,$format='j F Y')
    {
        return $this->pdate($format,strtotime($time_stamp));
    }
    
    function pdate($type,$maket="now")
    {   //echo $maket; exit;
        //set 1 if you want translate number to farsi or if you don't like set 0  
        $transnumber=1;
        ///chosse your timezone
        $TZhours=0;
        $TZminute=0;

        if($maket=="now"){
            $year=date("Y");
            $month=date("m");
            $day=date("d");
            list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
            $maket=$this->pmktime(date("h")+$TZhours,date("i")+$TZminute,date("s"),$jmonth,$jday,$jyear);
        }else{
            $maket+=$TZhours*3600+$TZminute*60;
            $date=date("Y-m-d",$maket);
            list( $year, $month, $day ) = preg_split ( '/-/', $date );

            list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
        }

        $need= $maket;
        $year=date("Y",$need);
        $month=date("m",$need);
        $day=date("d",$need);
        $result=null;
        $i=0;
        //echo $need; exit;
        while($i<strlen($type))
        {
            $subtype=substr($type,$i,1);
            switch ($subtype)
            {

                case "A":
                    $result1=date("a",$need);
                    if($result1=="pm") $result.= "بعدازظهر";
                    else $result.="قبل ازظهر";
                    break;

                case "a":
                    $result1=date("a",$need);
                    if($result1=="pm") $result.= "ب.ظ";
                    else $result.="ق.ظ";
                    break;
                case "d":
                    list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
                    if($jday<10)$result1="0".$jday;
                    else     $result1=$jday;
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "D":
                    $result1=date("D",$need);
                    if($result1=="Thu") $result1="پنج شنبه";
                    else if($result1=="Sat") $result1="شنبه";
                    else if($result1=="Sun") $result1="يکشنبه";
                    else if($result1=="Mon") $result1="دو شنبه";
                    else if($result1=="Tue") $result1="سه شنبه";
                    else if($result1=="Wed") $result1="چهارشنبه";
                    else if($result1=="Thu") $result1="پنچ شنبه";
                    else if($result1=="Fri") $result1="جمعه";
                    $result.=$result1;
                    break;
                case"F":
                    list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
                    $result.=$this->monthname($jmonth);
                    break;
                case "g":
                    $result1=date("g",$need);
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "G":
                    $result1=date("G",$need);
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "h":
                    $result1=date("h",$need);
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "H":
                    $result1=date("H",$need);
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "i":
                    $result1=date("i",$need);
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "j":
                    list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
                    $result1=$jday;
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "l":
                    $result1=date("l",$need);
                    if($result1=="Saturday") $result1="شنبه";
                    else if($result1=="Sunday") $result1="يکشنبه";
                    else if($result1=="Monday") $result1="دوشنبه";
                    else if($result1=="Tuesday") $result1="سه شنبه";
                    else if($result1=="Wednesday") $result1="چهارشنبه";
                    else if($result1=="Thursday") $result1="پنجشنبه";
                    else if($result1=="Friday") $result1="جمعه";
                    $result.=$result1;
                    break;
                case "m":
                    list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
                    if($jmonth<10) $result1="0".$jmonth;
                    else    $result1=$jmonth;
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "M":
                    list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
                    $result.=$this->monthname($jmonth);
                    break;
                case "n":
                    list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
                    $result1=$jmonth;
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "s":
                    $result1=date("s",$need);
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "S":
                    $result.="??";
                    break;
                case "t":
                    $result.=$this->lastday ($month,$day,$year);
                    break;
                case "w":
                    $result1=date("w",$need);
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "y":
                    list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
                    $result1=substr($jyear,2,4);
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                case "Y":
                    list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
                    $result1=$jyear;
                    if($transnumber==1) $result.=$this->Convertnumber2farsi($result1);
                    else $result.=$result1;
                    break;
                default:
                    $result.=$subtype;
            }
            $i++;
        }
        return $result;
    }



    function pmktime($hour,$minute,$second,$jmonth,$jday,$jyear)
    {
        list( $year, $month, $day ) = $this->jalali_to_gregorian($jyear, $jmonth, $jday);
        $i=mktime($hour,$minute,$second,$month,$day,$year);
        return $i;
    }


    ///Find Day Begining Of Month
    function mstart($month,$day,$year)
    {
        list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($year, $month, $day);
        list( $year, $month, $day ) = $this->jalali_to_gregorian($jyear, $jmonth, "1");
        $timestamp=mktime(0,0,0,$month,$day,$year);
        return date("w",$timestamp);
    }

    //Find Number Of Days In This Month
    function lastday ($month,$day,$year)
    {   
        //echo $year.'-'.$month.'-'.$day.'-----<br/>'; 
        $lastdayen=date("d",mktime(0,0,0,$month+1,0,$year));      
        list( $jyear, $jmonth, $jday ) = $this->GregorianToJalali($year, $month, $day);
        //$check_date = $this->GregorianToJalali($year, $month, $day);
        $lastdatep=$jday;
        $jday2=$jday;
        //echo $lastdayen; exit;
        //echo $jyear.'-'.$jmonth.'-'.$jday; exit;
        //echo "<pre/>"; print_R($check_date); exit;
        while($jday2!="0")
        {   //echo $day.'/'.$lastdayen; exit;
            if($day<$lastdayen)
            {
                $day++;
                //echo $year.'-'.$month.'-'.$day.'<br/>';
                list( $jyear, $jmonth, $jday2 ) = $this->GregorianToJalali($year, $month, $day);
                //echo $jyear.'-'.$jmonth.'-'.$jday2; exit;
                if($jday2=="1") break;
                if($jday2!="1") $lastdatep++;
            }
            else
            {
                $day=0;
                $month++;
                if($month==13)
                {
                    $month="1";
                    $year++;
                }
            }

        }
        return $lastdatep;    
        //return $lastdatep-1;
    } 
    //translate number of month to name of month
    function monthname($month)
    {

        if($month=="01") return "حمل";

        if($month=="02") return "ثور";

        if($month=="03") return "جوزا";

        if($month=="04") return  "سرطان";

        if($month=="05") return "اسد";

        if($month=="06") return "سنبله";

        if($month=="07") return "ميزان";

        if($month=="08") return "عقرب";

        if($month=="09") return "قوس";

        if($month=="10") return "جدي";

        if($month=="11") return "دلو";

        if($month=="12") return "حوت";
    }

    ////here convert to  number in persian
    function Convertnumber2farsi($srting)
    {
        return $srting;
        $num0="٠";
        $num1="۱";
        $num2="۲";
        $num3="۳";
        $num4="۴";
        $num5="۵";
        $num6="۶";
        $num7="۷";
        $num8="۸";
        $num9="۹";

        $stringtemp="";
        $len=strlen($srting);
        for($sub=0;$sub<$len;$sub++)
        {
            if(substr($srting,$sub,1)=="0")$stringtemp.=$num0;
            elseif(substr($srting,$sub,1)=="1")$stringtemp.=$num1;
            elseif(substr($srting,$sub,1)=="2")$stringtemp.=$num2;
            elseif(substr($srting,$sub,1)=="3")$stringtemp.=$num3;
            elseif(substr($srting,$sub,1)=="4")$stringtemp.=$num4;
            elseif(substr($srting,$sub,1)=="5")$stringtemp.=$num5;
            elseif(substr($srting,$sub,1)=="6")$stringtemp.=$num6;
            elseif(substr($srting,$sub,1)=="7")$stringtemp.=$num7;
            elseif(substr($srting,$sub,1)=="8")$stringtemp.=$num8;
            elseif(substr($srting,$sub,1)=="9")$stringtemp.=$num9;
            else $stringtemp.=substr($srting,$sub,1);

        }
        return   $stringtemp;

    }///end conver to number in persian
    function Convertnumber2english($string)
    {                       
        $persian = array('٠','۱','۲','۳','۴','۵','۶','۷','۸','۹');
        $num = range(0, 9);
        return str_replace($persian,$num,$string);

    }///end conver to number in persian




      
    function gregorian_to_jalali ($g_y, $g_m, $g_d)
    {
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

        //echo $g_y.'-'.$g_m.'-'.$g_d.'<br/>'; 

         

        $gy = $g_y-1600;
        $gm = $g_m-1;
        $gd = $g_d-1;  
        $g_day_no = 365*$gy+$this->div($gy+3,4)-$this->div($gy+99,100)+$this->div($gy+399,400);
        //echo $g_day_no.'<br/>'; 
        for ($i=0; $i < $gm; ++$i) 
        $g_day_no += $g_days_in_month[$i]; //echo $g_day_no; exit;
        if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
        /* leap and after Feb */
        $g_day_no++; //echo $g_day_no; exit;
        $g_day_no += $gd;

        $j_day_no = $g_day_no-79;
        //echo $j_day_no; exit;
        $j_np = $this->div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */    //echo $j_np; exit;
        $j_day_no = $j_day_no % 12053;
        //echo $j_day_no.'<br/>'; 
        $jy = 979+33*$j_np+4*$this->div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */
        //echo $jy; 
        $j_day_no %= 1461;
        //echo '<br/>'.$j_day_no; 
        if ($j_day_no >= 366) {
            $jy += $this->div($j_day_no-1, 365); echo '<br/>'.$jy; 
            $j_day_no = ($j_day_no-1)%365;  echo '<br/>'.$j_day_no;  
        } 
        for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) //echo '<br/>'.$i; 
        $j_day_no -= $j_days_in_month[$i];  //echo '<br/>'.$j_day_no.'<br/>';
        $jm = $i+1;
        $jd = $j_day_no;
        //echo $jd; exit;
        return array($jy, $jm, $jd);
    }

    function jalali_to_gregorian1($j_y, $j_m, $j_d)
    {
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

         

        $jy = $j_y-979;
        $jm = $j_m-1;
        $jd = $j_d-1;

        $j_day_no = 365*$jy + $this->div($jy, 33)*8 + $this->div($jy%33+3, 4);
        for ($i=0; $i < $jm; ++$i)
        $j_day_no += $j_days_in_month[$i];

        $j_day_no += $jd;

        $g_day_no = $j_day_no+79;

        $gy = 1600 + 400*$this->div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        $g_day_no = $g_day_no % 146097;

        $leap = true;
        if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
        {
            $g_day_no--;
            $gy += 100*$this->div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */
            $g_day_no = $g_day_no % 36524;

            if ($g_day_no >= 365)
            $g_day_no++;
            else
            $leap = false;
        }

        $gy += 4*$this->div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
        $g_day_no %= 1461;

        if ($g_day_no >= 366) {
            $leap = false;

            $g_day_no--;
            $gy += $this->div($g_day_no, 365);
            $g_day_no = $g_day_no % 365;
        }

        for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
        $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
        $gm = $i+1;
        $gd = $g_day_no+1;

        return array($gy, $gm, $gd);
    }
}
?>