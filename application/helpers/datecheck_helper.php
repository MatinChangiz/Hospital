<?php
/*
* Check date function
* Developed by: Jamshid HASHIMI
*/
if(!function_exists('dateconvert'))
{
    function dateconvert($thedate,$lang)
    {
        if($lang=='en')
        {
            return $thedate;
        }
        else
        {
            $thedate = explode("-",$thedate); 
            $year    = $thedate[0];
            $month   = $thedate[1];
            $day     = $thedate[2];
        }
        
        $CI =& get_instance();
        $CI->load->library('dateconverter'); // load library
        
        if($day=='00')
         {
            $day = '01';
         }
         else
         {
           $day = $day;  
         } 
         
         if($lang=='dr' || $lang=='pa')
         {
             if($month=='00' && $year=='0000')
             {
                 $theDate = array
                 (
                    'date_day'        => '00',
                    'date_month'      => '00',
                    'date_year'       => '0000' 
                );
                $compDate = $theDate['date_year']."-".$theDate['date_month']."-".$theDate['date_day'];
             }
             else
             {
                 $theDate = array
                 (
                    'date_day'        => $day,
                    'date_month'      => $month,
                    'date_year'       => $year
                 );
                 
                 $compDate = $CI->dateconverter->ToShamsi($theDate['date_year'],$theDate['date_month'],$theDate['date_day']);
             }
         }
         return $compDate;
    }
}
if(!function_exists('datecheck'))
{
	function datecheck($year,$month,$day,$lang)
	{   //echo $year.'-'.$month.'-'.$day; exit;
		$CI =& get_instance();
		$CI->load->library('dateconverter'); // load library 
		
		if($day=='00')
		 {
			$day = '01';
		 }
		 else
		 {
		   $day = $day;  
		 } 
		 $compDate = "";
		 //If language is Dari or Pashto then date is converted to gregorian format firstly 
		 if($lang=='dr' || $lang=='pa')
		 {
			 if($month!='00' && $year!='0000' && intval($month)!=0 && intval($year)!=0 && $month!='' && $year!='')
			 {
				 $theDate = array
				 (
					'date_day'        => $day,
					'date_month'      => $month,
					'date_year'       => $year
				 );
				 $compDate = $CI->dateconverter->ToGregorian($theDate['date_year'],$theDate['date_month'],$theDate['date_day']);
			 }
			 else
			 {
				 if($month=='00' OR $year=='0000')
				 {
					 $theDate = array
					 (
						'date_day'        => '00',
						'date_month'      => '00',
						'date_year'       => '0000' 
					);
					$compDate = $theDate['date_year']."-".$theDate['date_month']."-".$theDate['date_day'];
				 }
			 }
		 }
		 
		 if($lang=='en')
		 {
			 if($month=='00' && $year=='0000')
			 {
				 $theDate = array
				 (
					'date_day'        => '00',
					'date_month'      => '00',
					'date_year'       => '0000', 
				);
				$compDate = $theDate['date_year']."-".$theDate['date_month']."-".$theDate['date_day'];
			 }
			 else if($month=='00' OR $year=='0000')
			 {
					 $theDate = array
					 (
						'date_day'        => '00',
						'date_month'      => '00',
						'date_year'       => '0000' 
					);
					$compDate = $theDate['date_year']."-".$theDate['date_month']."-".$theDate['date_day'];
			 }
			 else
			 {
				 $theDate = array
				 (
					'date_day'        => $day,
					'date_month'      => $month,
					'date_year'       => $year
				 );
				 
				 $compDate = $theDate['date_year']."-".$theDate['date_month']."-".$theDate['date_day'];
			 }
		 }
         //echo $compDate; exit;
		 return $compDate;
	}
}

if(!function_exists('datedetails1'))
{
    function datedetails1($day=0,$month=0,$year=0,$field,$typeofdate='',$foredit=0,$section=0,$stop=0)
    {    
        //Get CI instance
        $CI =& get_instance();
        $lang = $CI->mng_auth->get_language();
        $toFarsiNumber = $CI->load->library('dateconverter');
        if ($day!=0)
        {
            $StartDateDay = '';
            //if the day is 00 in database
            if($foredit==0 || $section=='0')
            {  
               $StartDateDay.="<option value ='00' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line('global_day')."</option>";
            }
           
            /*if($section == "00" && $foredit==1)
            {
                $StartDateDay.="<option value ='00' ".set_select($field,'00',TRUE).">00</option>";    
            }
            else
            {
                 $StartDateDay.="<option value ='00' ".set_select($field,'00').">00</option>";   
            }
            */
            
            for($i=1; $i<=31; $i++)
            {
                if(strlen($i)< 2)                                                  
                {
                    $i="0".$i;
                }
                if($section!=0 && $section==$i)
                {
                    if($lang != 'en')
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$CI->dateconverter->Convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$i."</option>";
                    } 
                }
                else
                {
                    if($lang != 'en')
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i).">".$i."</option>";
                    }
                }   
            }
            return $StartDateDay; 
        }

        if($month!=0)
        {
            $StartDateMonth = '';
             //if the month is 00 in database
            if($foredit==0 || $section=='0')
            {  
                $StartDateMonth.="<option value ='00' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line('global_month')."</option>";

            }
            /*if($section=='00' && $foredit==1)
            {
                $StartDateMonth.="<option value ='00'".set_select($field,'00',TRUE).">00</option>";
            }
            else
            {
                $StartDateMonth.="<option value ='00'".set_select($field,'00').">00</option>"; 
            }
            */
            $lettermonths = Array();
            if($typeofdate=='en')
            {
                $nameofarray = 'date_monthsnames_en';
            }
            else
            {
                $nameofarray = 'date_monthsnames_dr';
            }
            $lettermonths = $CI->lang->line($nameofarray);
            for($i=1; $i<=12; $i++)
            {   
                if($section!=0 && $section==$i)
                {
                    $StartDateMonth.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$lettermonths[$i]."</option>"; 
                }
                else
                {
                    $StartDateMonth.="<option value ='".$i."' ".set_select($field,$i).">".$lettermonths[$i]."</option>";   
                }
            }   

            return $StartDateMonth;
        }
        if($year!=0)
        {   
            if($typeofdate=='en')
            {
                $startyear = date('Y') - 10;
                $endyear   = date('Y');
            }
            else
            {
                $startyear = date('Y') - 621 - 10;
                $endyear   = date('Y') - 621; 
            }
            $StartDateYear = '';
            
            //if the year is 0000 in database
            if($foredit==0 || $section=='0')
            {
               $StartDateYear.="<option value ='0000' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line("global_year")."</option>";
            }
            /*if($section=='00' && $foredit==1)
            {
                $StartDateYear.="<option value ='0000' ".set_select($field,'0000',TRUE).">0000</option>";
            }
            else
            {
                $StartDateYear.="<option value ='0000' ".set_select($field,'0000').">0000</option>";
            }
            */
            for($i=$endyear; $i>=$startyear; $i--)
            {
                if($section!=0 && $section==$i)
                {
                    if($lang != 'en')
                    {
                        $StartDateYear.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
                        $StartDateYear.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$i."</option>"; 
                    }
                }
                else
                {
                    if($lang != 'en')
                    {
                        $StartDateYear.="<option value ='".$i."' ".set_select($field,$i).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
                        $StartDateYear.="<option value ='".$i."' ".set_select($field,$i).">".$i."</option>";
                    }
                }  
            }    
        }
        return $StartDateYear;   
    }
}

  if(!function_exists('dateprovider'))
{
    function dateprovider($date,$lang='en')
    {               
      if($date =='0000-00-00')
      {
         return $date;
      }
      else
      {  
           
           $CI =& get_instance();
           $CI->load->library('dateconverter'); // load library
           
           if($lang=='en')
           {
              return  $date;
           }
           else
           {   
               $date = explode("-",$date); 
               //return converted date
               $date_converted = $CI->dateconverter->ToShamsi($date[0],$date[1],$date[2]); 
               //echo $date; 
               //if($date[0] == '0000' AND $date[1] == '00' AND $date[2] == '00'){echo "<pre/>"; print_r($date_converted); exit;} 
               return  $date_converted;
           }
           
           
      }
    }

}

//Convert persian date to shamsi short version
if(!function_exists('sdateconvert'))
{
	function sdateconvert($thedate,$lang)
	{
		if($lang=='en')
		{
			$thedate = explode("-",$thedate);
			$theDate = array
			(
				'date_day'        => $thedate[2],
				'date_month'      => $thedate[1],
				'date_year'       => $thedate[0]
			);
			return $thedate; 
		}
		else
		{
			$CI =& get_instance();
			$CI->load->library('dateconverter'); // load library
			$thedate = explode("-", $thedate);
			$theDate = array
			(
				'date_day'        => $thedate[2],
				'date_month'      => $thedate[1],
				'date_year'       => $thedate[0]
			);

			//$compDate = $theDate['date_year']."-".$theDate['date_month']."-".$theDate['date_day'];
			$compDate = $CI->dateconverter->ToShamsi_short($theDate['date_year'],$theDate['date_month'],$theDate['date_day']);
			$compDate = explode("-",$compDate);  
			$theDate = array
			(
				'0'        => $compDate[2],
				'1'        => $compDate[1],
				'2'        => $compDate[0]
			);
			return $theDate; 
		}
	} 
}

if(!function_exists('datecheckyear'))
{   
	function datecheckyear($year,$lang)
	{
		$CI =& get_instance();
		$CI->load->library('dateconverter'); // load library
		
		 
		 //If language is Dari or Pashto then date is converted to gregorian format firstly 
		 if($lang=='dr' || $lang=='pa')
		 {
			 if( $year!='0000')
			 {
				 $theDate = array
				 (
					'date_years'       => $year
				 );
				 $compDate = $CI->dateconverter->ToGregorianyear($theDate['date_years']);
			 }
			 else
			 {
				 if( $year=='0000')
				 {
					 $theDate = array
					 (
						'date_years'       => '0000' 
					);
					$compDate = $theDate['date_years'];
				 }
				 else
				 {
					 $theDate = array
					 (
						'date_years'       => $year
					 );
					 
					 $compDate = $theDate['date_years'];
				 }
			 }
		 }
		 
		 if($lang=='en')
		 {
			 if( $year=='0000')
			 {
				 $theDate = array
				 (
					'date_years'       => '0000', 
				);
				$compDate = $theDate['date_years'];
			 }
			 else
			 {
				 $theDate = array
				 (
					'date_years'       => $year
				 );
				 
				 $compDate = $theDate['date_years'];
			 }
		 }
		 return $compDate;
	}
}
     

if(!function_exists('dateprovider2'))
{
	function dateprovider2($date,$lang='en')
	{ 
	  if($date =='0000-00-00')
	  {
		 return $date;
	  }
	  else
	  {  
		   
		   $CI =& get_instance();
		   $CI->load->library('dateconverter'); // load library
		   
		   if($lang=='en')
		   {
			  return  $date;
		   }
		   else
		   {
				$date = explode("-",$date);
			   //return converted date
			   $date_converted = $CI->dateconverter->ToShamsi_short($date[0],$date[1],$date[2]);
			   return  $date_converted;
		   }
		   
		   
	  }
	}

}

//To shamsi Short
if(!function_exists('dateprovider_sshort'))
{
	function dateprovider_sshort($date,$lang='en')
	{ 
	  if($date =='0000-00-00')
	  {
		 return $date;
	  }
	  else
	  {  
		   
		   $CI =& get_instance();
		   $CI->load->library('dateconverter'); // load library
		   
		   if($lang=='en')
		   {
			  return  $date;
		   }
		   else
		   {
				$date = explode("-",$date);
			   //return converted date
			   $date_converted = $CI->dateconverter->ToShamsi_short($date[0],$date[1],$date[2]);
			   return  $date_converted;
		   }
		   
		   
	  }
	}

}

//search date criteria between 2 date
if(!function_exists('searchdate'))
{
   function searchdate($sd='00',$sm='00',$sy='0000',$ed='00',$em='00',$ey='0000',$datefield,$lang='en')
   {                         
	   //add prifix ziro for month options
	   if(strlen($sm)<2 && $sm!=00) 
	  {
		  $sm = "0".$sm;
	  }
	  if(strlen($em)<2 && $em!=00) 
	  {
		  $em = "0".$em;
	  }

	  if(strlen($sd)<2 && $sd!=00) 
	  {
		  $sd = "0".$sd;
	  }
	  if(strlen($ed)<2 && $ed!=00) 
	  {
		  $ed = "0".$ed;
	  }
	  
	  $sql_casedate = 1; 
	  $CI =& get_instance();
	  $CI->load->library('dateconverter'); // load library 
	  if($datefield != "")
	  {
		   
		 
		  //provide date comparisan search
		 //d-m-y AND d-m-y 
		if($sd != '00' && $sm != '00' && $sy != '0000'
		  && $ed != '00' && $em != '00' && $ey != '0000')
		{
			 
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian($sy,$sm,$sd); 
			   $endDate = $CI->dateconverter->ToGregorian($ey,$em,$ed); //echo $startDate; exit;
			}
			else
			{
			   $startDate =$sy."-".$sm."-".$sd;
			   $endDate   =$ey."-".$em."-".$ed;
			} 
			//check if the start date is smaller than end date
			if($startDate < $endDate)
			{
			  $sql_casedate = $datefield." BETWEEN '".$startDate."' AND '".$endDate."'";
			}
			else if($startDate > $endDate)
			{
			   $sql_casedate = $datefield." BETWEEN '".$endDate."' AND '".$startDate."'";
			}
			else if($startDate == $endDate)
			{
			   $sql_casedate = $datefield."='".$startDate."'";
			}
		} 
		
		//m-y AND m-y
		else if($sd == '00' && $sm != '00' && $sy != '0000'
		  && $ed == '00' && $em != '00' && $ey != '0000')
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian($sy,$sm,'01'); 
			   $endDate = $CI->dateconverter->ToGregorian($ey,$em,'01'); 
			}
			else
			{
			   $startDate =$sy."-".$sm."-"."01";
			   $endDate =$ey."-".$em."-"."01";
			}
			
			//explode date to year, month and day
			$sdate = explode("-",$startDate);
			$edate = explode("-",$endDate);
			
			//check if the start date is smaller than end date
			if($startDate < $endDate)
			{ 
				//since user select just month and year
				$sql_casedate = "DATE_FORMAT(".$datefield.",'%Y-%m') BETWEEN '".$sdate[0]."-".$sdate[1]."' AND '".$edate[0]."-".$edate[1]."'";
			}
			else if($startDate > $endDate)
			{
				$sql_casedate = "DATE_FORMAT(".$datefield.",'%Y-%m') BETWEEN '".$edate[0]."-".$edate[1]."' AND '".$sdate[0]."-".$sdate[1]."'";
			}
			else if($startDate == $endDate)
			{
				$sql_casedate = "DATE_FORMAT(".$datefield.",'%Y-%m') ='".$sdate[0]."-".$sdate[1]."'";
			}
			
		}
		
		 //y AND y
		else if($sd == '00' && $sm == '00' && $sy != '0000'
		  && $ed == '00' && $em == '00' && $ey != '0000')
		{
			 //convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $sy+621; 
			   $endDate = $ey + 621;
			}
			else
			{
			   $startDate =$sy;
			   $endDate =$ey;
			}
			
			//check if the start date is smaller than end date
			if($startDate < $endDate)
			{ 
				//since user select just month and year
				$sql_casedate = "YEAR(".$datefield.") BETWEEN '".$startDate."' AND '".$endDate."'";
			}
			else if($startDate > $endDate)
			{
				$sql_casedate = "YEAR(".$datefield.") BETWEEN '".$endDate."' AND '".$startDate."'";
			}
			else if($startDate == $endDate)
			{
				$sql_casedate = "YEAR(".$datefield.") ='".$startDate."'";
			}
		}
		
		//d-m AND d-m
		if($sd != '00' && $sm != '00' && $sy == '0000'
		  && $ed != '00' && $em != '00' && $ey == '0000')
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian('1389',$sm,$sd); 
			   $endDate = $CI->dateconverter->ToGregorian('1389',$em,$ed); 
			}
			else
			{
			   $startDate ="2010"."-".$sm."-".$sd;
			   $endDate ="2010"."-".$em."-".$ed;
			}
			
			//explode date to year, month and day
			$sdate = explode("-",$startDate);
			$edate = explode("-",$endDate);
			//check if the start date is smaller than end date
			if($startDate < $endDate)
			{
				//since user select just month and year
				$sql_casedate = "DATE_FORMAT(".$datefield.",'%m-%d') BETWEEN '".$sdate[1]."-".$sdate[2]."' AND '".$edate[1]."-".$edate[2]."'";
			}
			else if($startDate > $endDate)
			{
			   $sql_casedate = "DATE_FORMAT(".$datefield.",'%m-%d') BETWEEN '".$edate[1]."-".$edate[2]."' AND '".$sdate[1]."-".$sdate[2]."'";
			}
			else if($startDate == $endDate)
			{
			   $sql_casedate = "DATE_FORMAT(".$datefield.",'%m-%d') ='".$edate[1]."-".$edate[2]."'";
			}
			
			
		}
		
		//d-Y AND d-Y
		if($sd != '00' && $sm == '00' && $sy != '0000'
		  && $ed != '00' && $em == '00' && $ey != '0000')
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian($sy,'02',$sd); 
			   $endDate = $CI->dateconverter->ToGregorian($ey,'02',$ed); 
			}
			else
			{
			   $startDate =$sy."-".'04'."-".$sd;
			   $endDate =$sy."-".'04'."-".$sd;
			}
			
			//explode date to year, month and day
			$sdate = explode("-",$startDate);
			$edate = explode("-",$endDate);
			//check if the start date is smaller than end date
			if($startDate < $endDate)
			{
				//since user select just month and year
				$sql_casedate = "DATE_FORMAT(".$datefield.",'%Y-%d') BETWEEN '".$sdate[0]."-".$sdate[2]."' AND '".$edate[0]."-".$edate[2]."'";
			}
			else if($startDate > $endDate)
			{
			   $sql_casedate = "DATE_FORMAT(".$datefield.",'%Y-%d') BETWEEN '".$edate[0]."-".$edate[2]."' AND '".$sdate[0]."-".$sdate[2]."'";
			}
			else if($startDate == $endDate)
			{
			   $sql_casedate = "DATE_FORMAT(".$datefield.",'%Y-%d') ='".$edate[0]."-".$edate[2]."'";
			}
			
			
		}  
		
		//d AND d
		if($sd != '00' && $sm == '00' && $sy == '0000'
		  && $ed != '00' && $em == '00' && $ey == '0000')
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
				
			   $startDate = $CI->dateconverter->ToGregorian('1389','02',$sd); 
			   $endDate = $CI->dateconverter->ToGregorian('1389','02',$ed); 
			}
			else
			{
			   $startDate ="2009"."-".'04'."-".$sd;
			   $endDate ="2009"."-".'04'."-".$ed;
			}
			
			//explode date to year, month and day
			$sdate = explode("-",$startDate);
			$edate = explode("-",$endDate);
			//check if the start date is smaller than end date
			if($startDate < $endDate)
			{
				//since user select just month and year
				$sql_casedate = "DATE_FORMAT(".$datefield.",'%d') BETWEEN '".$sdate[2]."' AND '".$edate[2]."'";
			}
			else if($startDate > $endDate)
			{
			   $sql_casedate = "DATE_FORMAT(".$datefield.",'%d') BETWEEN '".$edate[2]."' AND '".$sdate[2]."'";
			}
			else if($startDate == $endDate)
			{
			   $sql_casedate = "DATE_FORMAT(".$datefield.",'%d') ='".$edate[2]."'";
			}
			
			
		}
		
		//m AND m
		if($sd == '00' && $sm != '00' && $sy == '0000'
		  && $ed == '00' && $em != '00' && $ey == '0000')
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $sm+2; 
			   $endDate = $em+2;
			   //check if the date is not bigger than 12 december
			   if($startDate > 12)
			   {
				  $startDate = $startDate % 12;
			   }
			   
			   if($endDate > 12)
			   {
				  $endDate = $endDate % 12;
			   }
			   
			}
			else
			{
				$startDate = $sm; 
				$endDate = $em;
			}
			
			//check if the start date is smaller than end date
			if($startDate < $endDate)
			{
				//since user select just month and year
				$sql_casedate = "MONTH(".$datefield.") BETWEEN '".$startDate."' AND '".$endDate."'";
			}
			else if($startDate > $endDate)
			{
			   $sql_casedate = "MONTH(".$datefield.") BETWEEN '".$endDate."' AND '".$startDate."'";
			}
			else if($startDate == $endDate)
			{
			   $sql_casedate = "MONTH(".$datefield.") ='".$startDate."'";
			}
			//echo $sql_casedate;
			
		}
        
		//d-m-y
		if($sd != '00' && $sm != '00' && $sy != '0000'
		&& $ed == '00' && $em == '00' && $ey == '0000')
		{            	
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian($sy,$sm,$sd); 
			}
			else
			{
			   $startDate =$sy."-".$sm."-".$sd;
			}
			//if the user selected first date
			$sql_casedate = $datefield."='".$startDate."'"; 
            //echo $sql_casedate; exit;   
		}  
		
		//m-y
		else if($sd == '00' && $sm != '00' && $sy != '0000'
		&& $ed == '00' && $em == '00' && $ey == '0000')
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian($sy,$sm,'01'); 
			}
			else
			{
			   $startDate =$sy."-".$sm."-"."01";
			}
			
			//explode date to year, month and day
			$sdate = explode("-",$startDate);
			$sql_casedate = "DATE_FORMAT(".$datefield.",'%Y-%m') ='".$sdate[0]."-".$sdate[1]."'";
	
		}
		//y
		else if($sd == '00' && $sm == '00' && $sy != '0000'
		&& $ed == '00' && $em == '00' && $ey == '0000')
		{
			 //convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $sy+621; 
			}
			else
			{
			   $startDate =$sy;
			}
			$sql_casedate = "YEAR(".$datefield.") ='".$startDate."'";
		}    
						 
		//d-m
		if($sd != '00' && $sm != '00' && $sy == '0000'
		&& $ed == '00' && $em == '00' && $ey == '0000')
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian('1389',$sm,$sd); 
			}
			else
			{
			   $startDate ="2010"."-".$sm."-".$sd;
			}
			
			//explode date to year, month and day
			$sdate = explode("-",$startDate);
			//date format
			$sql_casedate = "DATE_FORMAT(".$datefield.",'%m-%d') ='".$sdate[1]."-".$sdate[2]."'";
			
			
			
		}
		
		//d-Y
		if($sd != '00' && $sm == '00' && $sy != '0000'
		&& $ed == '00' && $em == '00' && $ey == '0000')
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian($sy,'02',$sd); 
			}
			else
			{
			   $startDate =$sy."-".'04'."-".$sd;
			}
			
			//explode date to year, month and day
			$sdate = explode("-",$startDate);
			
			$sql_casedate = "DATE_FORMAT(".$datefield.",'%Y-%d') ='".$sdate[0]."-".$sdate[2]."'";
			
			
			
		}
		
		//d
		if($sd != '00' && $sm == '00' && $sy == '0000'
		&& $ed == '00' && $em == '00' && $ey == '0000') 
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian('1389','02',$sd); 
			  
			}
			else
			{
			   $startDate ="2009"."-".'04'."-".$sd;
			 
			}
			
			//explode date to year, month and day
			$sdate = explode("-",$startDate);
		
			$sql_casedate = "DATE_FORMAT(".$datefield.",'%d') ='".$sdate[2]."'";
		}
		
		//m
		if($sd == '00' && $sm != '00' && $sy == '0000'
		  && $ed == '00' && $em == '00' && $ey == '0000')
		{
			
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
				
			   $sdate = $CI->dateconverter->ToGregorian('1385',$sm,'4');   
			   $sdate = explode("-",$sdate);
			   $startDate  = $sdate[1];
			}
			else
			{
				$startDate = $sm; 
				
			}
			$sql_casedate = "MONTH(".$datefield.") BETWEEN '".$startDate."' AND '".($startDate+1)."'";
			
			
		}
        //echo $sql_casedate; exit;
		 return  $sql_casedate; 
	  } 
	  else
	  {
		return $sql_casedate;
	  }
   }
}
	  
//field condtion keyword function
if(!function_exists('searchTime'))
{
	function searchTime($starthour,$startminute='00', $endhour, $endminute='00',$timefield,$lang='en')
	{                
			
		$sql_field = "";
		//--- check if start and end time stamp are not empty
		if(!empty($starthour) &&  !empty($startminute) && !empty($endhour) && !empty($endminute))
		{
			$startTime = $starthour.":".$startminute;
			$endTime   = $endhour.":".$endminute;
			$sql_field = "DATE_FORMAT($timefield,'%H:%i') BETWEEN '$startTime' AND '$endTime'";
		}
		else if(!empty($starthour) &&  !empty($startminute) && empty($endhour) && empty($endminute))
		{
			$startTime = $starthour.":".$startminute; 
			$sql_field = "DATE_FORMAT($timefield,'%H:%i') = '$startTime'"; 
		}
		else if(empty($starthour) && empty($startminute) && !empty($endhour) && !empty($endminute))
		{
			$endTime   = $endhour.":".$endminute;
			$sql_field = "DATE_FORMAT($timefield,'%H:%i') = '$endTime'"; 
		}
		else
		{
		   $sql_field = 1;
		}
	   
		//return date time format
		return $sql_field;    
	}
}

//field condtion keyword function
if(!function_exists('searchtimesecond'))
{
	function searchtimesecond($starthour,$startminute='00',$startsecond, $endhour, $endminute='00',$endsecond,$timefield,$lang='en')
	{                
			
		$sql_field = "";
		//--- check if start and end time stamp are not empty
		if(!empty($starthour) &&  !empty($startminute) &&  !empty($startsecond) && !empty($endhour) && !empty($endminute) && !empty($endsecond) )
		{
			$startTime = $starthour.":".$startminute.":".$startsecond;
			$endTime   = $endhour.":".$endminute.":".$endsecond;
			$sql_field = "DATE_FORMAT($timefield,'%H:%i:%s') BETWEEN '$startTime' AND '$endTime'";
		}
		else if(!empty($starthour) &&  !empty($startminute) &&  !empty($startsecond) && empty($endhour) && empty($endminute) && empty($endsecond))
		{
			$startTime = $starthour.":".$startminute.":".$startsecond; 
			$sql_field = "DATE_FORMAT($timefield,'%H:%i:%s') = '$startTime'"; 
		}
		
		else if(!empty($starthour) &&  !empty($startminute) && empty($endhour) && empty($endminute))
		{
			$startTime = $starthour.":".$startminute; 
			$sql_field = "DATE_FORMAT($timefield,'%H:%i') = '$startTime'"; 
		}
		else if(empty($starthour) && empty($startminute) && empty($startsecond) && !empty($endhour) && !empty($endminute) && !empty($endsecond))
		{
			$endTime   = $endhour.":".$endminute.":".$endsecond;
			$sql_field = "DATE_FORMAT($timefield,'%H:%i:%s') = '$endTime'"; 
		}
		else if(empty($starthour) && empty($startminute) && !empty($endhour) && !empty($endminute))
		{
			$endTime   = $endhour.":".$endminute;
			$sql_field = "DATE_FORMAT($timefield,'%H:%i') = '$endTime'"; 
		}
		else if(!empty($startminute) && !empty($startsecond) && empty($endminute) && empty($endsecond))
		{
			$startTime   = $startminute.":".$startsecond;
			$sql_field = "DATE_FORMAT($timefield,'%i:%s') = '$startTime'"; 
		}
		else if(empty($startminute) && empty($startsecond) && !empty($endminute) && !empty($endsecond))
		{
			$endTime   = $endminute.":".$endsecond; 
			$sql_field = "DATE_FORMAT($timefield,'%i:%s') = '$endTime'"; 
		}
		else if(!empty($startminute) && !empty($startsecond) && !empty($endminute) && !empty($endsecond))
		{
			$startTime = $startminute.":".$startsecond;
			$endTime   = $endhour.":".$endminute;
			$sql_field = "DATE_FORMAT($timefield,'%i:%s')  BETWEEN '$startTime' AND '$endTime'"; 
		}
		else
		{
		   $sql_field = 1;
		}
	   
		//return date time format
		return $sql_field;	
	}
}

//field condtion keyword function
if(!function_exists('searchfield'))
{
	function searchfield($dbfield,$condition,$keyword)
	{
		  $sql_field = 1;
		  if($condition == 'ilike')
		  {
			  //check if its like condtion
			  //$sql_field = $dbfield." LIKE '%".$keyword."%'";
			  $sql_field = "REPLACE(REPLACE(".$dbfield.",' ',''),'\n','') LIKE '%".str_replace(" ","",$keyword)."%'";  
		  }
		  else if($condition  == 'notilike')
		  {
			  //check if it is not like condtion
			  $sql_field = "(REPLACE(REPLACE(".$dbfield.",' ',''),'\n','') NOT LIKE '%".str_replace(" ","",$keyword)."%' OR $dbfield IS NULL)"; 
			  //$sql_field = $dbfield." NOT LIKE '%".$keyword."%'";
		  }
		  else if($condition == '=')
		  {
			  //check if its equal condtion
			  $sql_field = "REPLACE(REPLACE(".$dbfield.",' ',''),'\n','')='".str_replace(" ","",$keyword)."'"; 
		  }
		  else if($condition == 'notequal')
		  {
			  //check if its not equal condtion
			  $sql_field = "(REPLACE(REPLACE(".$dbfield.",' ',''),'\n','') <> '".str_replace(" ","",$keyword)."' OR $dbfield IS NULL)"; 
		  }
		  else if($condition == 'starting')
		  {
			  //check if its not equal condtion
			  $sql_field = "REPLACE(REPLACE(".$dbfield.",' ',''),'\n','') LIKE '".str_replace(" ","",$keyword)."%'";   
		  }
		  else if($condition == 'ending')
		  {
			  //check if its not equal condtion
			  $sql_field = "REPLACE(REPLACE(".$dbfield.",' ',''),'\n','') LIKE '%".str_replace(" ","",$keyword)."'";   
		  }
		  else
		  {
			  $sql_field = 1;
		  }
		  //return generated sql result
		  return   $sql_field;
	}
}


/*
*access: public
* parrams: 
* 1.start age dropdown value 
* 2. end age dropdown value
* 3. dobage field name from database table
* 4. dob field name from db 
* 5. year field name from db
* 6. age field name from db
* 7. casedate field name from datbase
* 
* Note: if you want to just send the default non selection, just set dropdown
* value to 0 (zero)
*/

if(!function_exists('searchage'))
{
	
  function searchage($sage,$eage,$dobage,$dobfield,$yearfield,$agefield,$casedate)
  {
	  
	  $yearfield = " IF(".$yearfield." >0,".$yearfield.",YEAR(".$casedate."))";
	  
	  //define sql var to return
	  $sql_agedate = 1;  
	  //if both of them zero send 1
	  if($sage=='00' && $eage=='00')
	  {
		  $sql_agedate = 1;  
	  }
	  else if($sage!='00' && $eage=='00')
	  {
		  //if they are equal
		  $startageyear = "YEAR(".$casedate.")-".$sage.""; 
		  $sql_agedate = " IF(".$dobage."=2,(".$yearfield."-".$agefield.")=".$startageyear."";
		  $sql_agedate .= " , YEAR(".$dobfield.") = ".$startageyear.")";
	
	  }
	  else if($sage=='00' && $eage!='00')
	  {
		  //if they are equal
		  $startageyear = "YEAR(".$casedate.")-".$eage.""; 
		  $sql_agedate = " IF(".$dobage."=2,(".$yearfield."-".$agefield.") =".$startageyear."";
		  $sql_agedate .= " , YEAR(".$dobfield.") = ".$startageyear.")";
	
	  } 
	  else if($sage < $eage)
	  {
		 //start and end age from case date 
		 $startageyear = "YEAR(".$casedate.")-".$eage.""; 
		 $endageyear = "YEAR(".$casedate.")-".$sage.""; 
		 
		 $sql_agedate = " IF(".$dobage."=2,(".$yearfield."-".$agefield.") BETWEEN ".$startageyear." AND ".$endageyear;
		 $sql_agedate .= " , YEAR(".$dobfield.") BETWEEN ".$startageyear." AND ".$endageyear.")";
	  }
	  else if($sage > $eage)
	  {
		  //if end age is smaller than start age
		  $startageyear = "YEAR(".$casedate.")-".$sage.""; 
		  $endageyear = "YEAR(".$casedate.")-".$eage.""; 
		 
		  $sql_agedate = " IF(".$dobage."=2,(".$yearfield."-".$agefield.") BETWEEN ".$startageyear." AND ".$endageyear;
		  $sql_agedate .= " , YEAR(".$dobfield.") BETWEEN ".$startageyear." AND ".$endageyear.")";
	
	  }
	  else if($sage == $eage)
	  {
		  //if they are equal
		  $startageyear = "YEAR(".$casedate.")-".$sage.""; 
		  $sql_agedate = " IF(".$dobage."=2,(".$yearfield."-".$agefield.") =".$startageyear."";
		  $sql_agedate .= " , YEAR(".$dobfield.") = ".$startageyear.")";
	
	  }
	  //return age sql
	  return $sql_agedate;
	  
  }
}

  /*
*case summary 
*/
if(!function_exists('general_info_summary'))
{
	 function general_info_summary($initial_id)
	 {
		//echo $initial_id; exit;
		  //load header file
		  $CI =& get_instance(); 
		  
		  //load language file
		  $lang    = $CI->mng_auth->get_language();
		  if($lang=='dr')
		  {
			  $language = "dari"; 
		  }
		  else if($lang=='pa')
		  {
			  $language = "pashto"; 
		  }
		  else
		  {
			  $language = "english"; 
		  }
		  $CI->lang->load('home', $language);
		  
		 //bring data in array
		  $data = array();
		  //get user,name, dep from mng_auth library
		  $CI->load->library('mng_auth');
		  //main modul model
		  $CI->load->model('general_info/general_info_model');
		  $FormsObj = $CI->general_info_model->GetOneRecord("phone_general_information","phone_urn,register_date,register_location,department,user_id","phone_urn",$initial_id);
		  //print_r($InitialsObj->result_array()); exit;
		  if($FormsObj)
		  {          
			 //get case owner
			 $data['formnumber']  = $FormsObj->row()->phone_urn; 
			 $data['username']    = $CI->mng_auth->GetInitialsOwner($FormsObj->row()->user_id); 
			 $data['depname']     = $CI->mng_auth->GetDepartmentName($FormsObj->row()->department); 
			 $data['form_id']     = $FormsObj->row()->phone_urn; 
			 $data['location']    = $CI->mng_auth->GetProvinceName($FormsObj->row()->register_location);  
			 $date                = explode(" ",$FormsObj->row()->register_date);  
			 $data['date']        = dateprovider($date[0],$lang);  
			 $data['time']        = $date[1];  
			 return $CI->load->view('general_info/general_info_summary',$data,TRUE);
		  }
	
	 }
}


/*
* search date different
*/
if(!function_exists('searchdatediff'))
{
	function searchdatediff($n_months,$date)
	{
		$gdate=explode("-",$date);
		$month = mktime(0,0,0,$gdate[1]-$n_months,$gdate[2],$gdate[0]);
		return date('Y-m-d',$month);
			 
	}
						   
}

  
if(!function_exists('datedetails'))
{
	function datedetails($day=0,$month=0,$year=0,$field,$typeofdate='',$foredit=0,$section=0,$stop=0)
	{    
		//Get CI instance
		$CI =& get_instance();
        $lang = $CI->mng_auth->get_language();
		$toFarsiNumber = $CI->load->library('dateconverter');
		if ($day!=0)
		{
			$StartDateDay = '';
			//if the day is 00 in database
			if($foredit==0 || $section=='0')
			{  
			   $StartDateDay.="<option value ='' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line('global_day')."</option>";
			}
		   
			/*if($section == "00" && $foredit==1)
			{
				$StartDateDay.="<option value ='00' ".set_select($field,'00',TRUE).">00</option>";    
			}
			else
			{
				 $StartDateDay.="<option value ='00' ".set_select($field,'00').">00</option>";   
			}
			*/
			
			for($i=1; $i<=31; $i++)
			{
				if(strlen($i)< 2)                                                  
				{
					$i="0".$i;
				}
				if($section!=0 && $section==$i)
				{
                    if($lang != 'en')
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$CI->dateconverter->Convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$i."</option>";
                    } 
				}
				else
				{
                    if($lang != 'en')
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
					    $StartDateDay.="<option value ='".$i."' ".set_select($field,$i).">".$i."</option>";
                    }
				}   
			}
			return $StartDateDay; 
		}

		if($month!=0)
		{
			$StartDateMonth = '';
			 //if the month is 00 in database
			if($foredit==0 || $section=='0')
			{  
				$StartDateMonth.="<option value ='' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line('global_month')."</option>";

			}
			/*if($section=='00' && $foredit==1)
			{
				$StartDateMonth.="<option value ='00'".set_select($field,'00',TRUE).">00</option>";
			}
			else
			{
				$StartDateMonth.="<option value ='00'".set_select($field,'00').">00</option>"; 
			}
		    */
			$lettermonths = Array();
			if($typeofdate=='en')
			{
				$nameofarray = 'date_monthsnames_en';
			}
			else
			{
				$nameofarray = 'date_monthsnames_dr';
			}
			$lettermonths = $CI->lang->line($nameofarray);
			for($i=1; $i<=12; $i++)
			{   
				if($section!=0 && $section==$i)
				{
					$StartDateMonth.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$lettermonths[$i]."</option>"; 
				}
				else
				{
					$StartDateMonth.="<option value ='".$i."' ".set_select($field,$i).">".$lettermonths[$i]."</option>";   
				}
			}   

			return $StartDateMonth;
		}
		if($year!=0)
		{   
			if($typeofdate=='en')
			{
				$startyear = date('Y') - 10;
				$endyear   = date('Y');
			}
			else
			{
				$startyear = date('Y') - 621 - 10;
				$endyear   = date('Y') - 621; 
			}
			$StartDateYear = '';
			
			//if the year is 0000 in database
			if($foredit==0 || $section=='0')
			{
			   $StartDateYear.="<option value ='' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line("global_year")."</option>";
			}
			/*if($section=='00' && $foredit==1)
			{
				$StartDateYear.="<option value ='0000' ".set_select($field,'0000',TRUE).">0000</option>";
			}
			else
			{
				$StartDateYear.="<option value ='0000' ".set_select($field,'0000').">0000</option>";
			}
            */
			for($i=$endyear; $i>=$startyear; $i--)
			{
				if($section!=0 && $section==$i)
				{
                    if($lang != 'en')
                    {
                        $StartDateYear.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
					    $StartDateYear.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$i."</option>"; 
				    }
                }
				else
				{
                    if($lang != 'en')
                    {
                        $StartDateYear.="<option value ='".$i."' ".set_select($field,$i).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
                        $StartDateYear.="<option value ='".$i."' ".set_select($field,$i).">".$i."</option>";
                    }
				}  
			}    
		}
		return $StartDateYear;   
	}
}
/**
* @desc This function's usage is to make date multiselectable list of months 
*/
if(!function_exists('dateDetailsMultiSelection'))
{
    function dateDetailsMultiSelection($day=0,$month=0,$year=0,$field,$typeofdate='',$foredit=0,$section=0,$number_ofDays=31)
    {
        //Get CI instance
        $CI =& get_instance();
        $lang = $CI->mng_auth->get_language();
        $toFarsiNumber = $CI->load->library('dateconverter');
        
        if ($day!=0)
        {
            $StartDateDay = '';
            //if the day is 00 in database
            if($foredit==0 || $section=='0')
            {  
               $StartDateDay.="<option value ='' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line('global_day')."</option>";
            }
           
            if($section == "00" && $foredit==1)
            {
                if($lang != 'en')
                {
                    $StartDateDay.="<option value ='00' ".set_select($field,'00',TRUE).">".$CI->dateconverter->convertnumber2farsi('00')."</option>";
                }
                else
                {
                    $StartDateDay.="<option value ='00' ".set_select($field,'00',TRUE).">00</option>";
                }      
            }
            else
            {
                if($lang != 'en')
                {
                    $StartDateDay.="<option value ='00' ".set_select($field,'00').">".$CI->dateconverter->convertnumber2farsi('00')."</option>";
                }
                else
                {
                    $StartDateDay.="<option value ='00' ".set_select($field,'00').">00</option>";
                }
            }
            
            
            for($i=1; $i<=$number_ofDays; $i++)
            {
                if(strlen($i)< 2)                                                  
                {
                    $i="0".$i;
                }
                if($section!=0 && $section==$i)
                {
                    if($lang != 'en')
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$i."</option>";
                    }
                }
                else
                {
                    if($lang != 'en')
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }                                                                       
                    else
                    {
                        $StartDateDay.="<option value ='".$i."' ".set_select($field,$i).">".$i."</option>";
                    }
                }   
            }
            return $StartDateDay; 
        }

        if($month!=0)
        {
            $StartDateMonth = '';
             //if the month is 00 in database
            if($foredit==0 || $section=='0')
            {  
                $StartDateMonth.="<option value ='' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line('global_month')."</option>";

            }
            /*if($section=='00' && $foredit==1)
            {
                if($lang != 'en')
                {
                    $StartDateMonth.="<option value ='00'".set_select($field,'00',TRUE).">".$CI->dateconverter->convertnumber2farsi('00')."</option>";
                }
                else
                {
                    $StartDateMonth.="<option value ='00'".set_select($field,'00',TRUE).">00</option>";
                }
            }
            else
            {
                if($lang != 'en')
                {
                    $StartDateMonth.="<option value ='00'".set_select($field,'00').">".$CI->dateconverter->convertnumber2farsi('00')."</option>";
                }
                else
                {
                    $StartDateMonth.="<option value ='00'".set_select($field,'00').">00</option>"; 
                }
            } */
            $lettermonths = Array();
            if($typeofdate=='en')
            {
                $nameofarray = 'date_monthsnames_en';
            }
            else
            {
                $nameofarray = 'date_monthsnames_dr';
            }
            $lettermonths = $CI->lang->line($nameofarray);
            for($i=1; $i<=12; $i++)
            {   
                //if($section!=0 && $section==$i)
                //{
                    //$StartDateMonth.= "<label id='labl_".$field."".$i."' style='background-color: #80FF80;'><input type='checkbox' value='".$i."' name='".$field."[]' id='".$field."".$i."' checked='checked' onclick=\"javascript:changeMonthListBackground('".$field.''.$i."');\" onchange=\"javascript:add_groups('report_6months', 'selected_months', '".$field."".$i."','labl_".$field."".$i."')\">".$lettermonths[$i]."</input></label><br/>";
                    //$StartDateMonth.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$lettermonths[$i]."</option>"; 
                //}
                //else
                //{
                    //$StartDateMonth.= "<label id='labl_".$field."".$i."'><input type='checkbox' value='".$i."' name='".$field."[]' id='".$field."".$i."' disabled='disabled' onclick=\"javascript:changeMonthListBackground('".$field.''.$i."');\" onchange=\"javascript:add_groups('report_6months', 'selected_months', '".$field."".$i."','labl_".$field."".$i."')\">".$lettermonths[$i]."</input></label><br/>";
                    $StartDateMonth.= "<label id='labl_".$field."".$i."'>
                            <input type='checkbox' value='".$i."' name='".$field."[]' id='".$field."".$i."' disabled='disabled'>".$lettermonths[$i]."</input>
                            </label><br/>";
                    //$StartDateMonth.="<option value ='".$i."' ".set_select($field,$i).">".$lettermonths[$i]."</option>";   
                //}
            }   

            return $StartDateMonth;
        }
        if($year!=0)
        {
            if($typeofdate=='en')
            {
                $startyear = date('Y') - 10;
                $endyear   = date('Y');
            }
            else
            {
                $startyear = date('Y') - 621 - 10;
                $endyear   = date('Y') - 621; 
            }
            $StartDateYear = '';
            
            //if the year is 0000 in database
            if($foredit==0 || $section=='0')
            {
               $StartDateYear.="<option value ='' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line("global_year")."</option>";
            }
            if($section=='00' && $foredit==1)
            {
                if($lang != 'en')
                {
                    $StartDateYear.="<option value ='0000' ".set_select($field,'0000',TRUE).">".$CI->dateconverter->convertnumber2farsi('0000')."</option>";
                }
                else
                {
                    $StartDateYear.="<option value ='0000' ".set_select($field,'0000',TRUE).">0000</option>";
                }
            }
            else
            {
                if($lang != 'en')
                {
                    $StartDateYear.="<option value ='0000' ".set_select($field,'0000').">".$CI->dateconverter->convertnumber2farsi('0000')."</option>";
                }
                else
                {
                    $StartDateYear.="<option value ='0000' ".set_select($field,'0000').">0000</option>";
                }
            }
            for($i=$endyear; $i>=$startyear; $i--)
            {
                //if($section!=0 && $section==$i)
                //{
                    //$StartDateYear.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$i."</option>"; 
                //}
                //else
                //{
                    if($lang != 'en')
                    {
                        $StartDateYear.="<option value ='".$i."' ".set_select($field,$i).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
                        $StartDateYear.="<option value ='".$i."' ".set_select($field,$i).">".$i."</option>";
                    }
                //}  
            }    
        }
        return $StartDateYear;   
    }
}
if(!function_exists('timedetails'))
{   
	function timedetails($hour=0,$minute=0,$field,$foredit=0,$section=0)
	{ 
        //Get CI instance
        $CI =& get_instance();
        $CI->load->library('dateconverter');
        $lang = $CI->mng_auth->get_language();
		$timedetails = ''; 

		if($hour==1)  
		{
			if(strlen($section) < 2)
			{
				$section = "0".$section; 
			}
			
			//if the day is 00 in database
			if($foredit==0)
			{
				$timedetails.="<option value ='' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line('global_hour')."</option>";
			} 

			for($i=1; $i<=24; $i++)
			{
				if(strlen($i)< 2)                                                  
				{
					$i="0".$i;
				}
				if($section!=0 && $i==$section)
				{ 
                    if($lang != 'en')
                    {
                        $timedetails.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
					else
                    {
                        $timedetails.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$i."</option>";
                    }
				}
				else
				{
                    if($lang != 'en')
                    {
                        $timedetails.="<option value ='".$i."' ".set_select($field,$i).">".$CI->dateconverter->convertnumber2farsi($i)."</option>"; 
                    }
					else
                    {
                        $timedetails.="<option value ='".$i."' ".set_select($field,$i).">".$i."</option>"; 
                    }
				}   
			}   
		}

		elseif($minute==1)  
		{
			if(strlen($section) < 2)
			{
				$section = "0".$section; 
			}

			//if the day is 00 in database
			if($foredit==0)
			{
				$timedetails.="<option value ='' selected=\"selected\" ".set_select($field,'',TRUE).">".$CI->lang->line('global_minute')."</option>";
			} 

			for($i=0; $i<=59; $i++)
			{
				if(strlen($i)< 2)                                                  
				{
					$i="0".$i;
				}
				if($section!=0 && $i==$section)
				{
                    if($lang != 'en')
                    {
                        $timedetails.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
					    $timedetails.="<option value ='".$i."' ".set_select($field,$i,TRUE).">".$i."</option>";
				    }
                }
				else
				{
                    if($lang != 'en')
                    {
                        $timedetails.="<option value ='".$i."' ".set_select($field,$i).">".$CI->dateconverter->convertnumber2farsi($i)."</option>";
                    }
                    else
                    {
					    $timedetails.="<option value ='".$i."' ".set_select($field,$i).">".$i."</option>";
				    }
                }   
			} 
		}   
		return $timedetails; 
	}
}

//search date criteria between 2 date
if(!function_exists('searchDatePrice'))
{
   function searchDatePrice($sd='00',$sm='00',$sy='0000',$ed='00',$em='00',$ey='0000',$datefield,$lang='en')
   {                         
	   //add prifix ziro for month options
	   if(strlen($sm)<2 && $sm!=00) 
	  {
		  $sm = "0".$sm;
	  }
	  if(strlen($em)<2 && $em!=00) 
	  {
		  $em = "0".$em;
	  }

	  if(strlen($sd)<2 && $sd!=00) 
	  {
		  $sd = "0".$sd;
	  }
	  if(strlen($ed)<2 && $ed!=00) 
	  {
		  $ed = "0".$ed;
	  }
	  
	  $sql_casedate = 1; 
	  $CI =& get_instance();
	  $CI->load->library('dateconverter'); // load library 
	  if($datefield != "")
	  {
		   
		 
		  //provide date comparisan search
		 //d-m-y AND d-m-y 
		if(($sd != '00' && $sm != '00' && $sy != '0000') || ($ed != '00' && $em != '00' && $ey != '0000'))
		{
			 
			//convert start date and end date to miladi if language is dari or pashto
			if($lang =='dr' OR $lang == 'pa')
			{
			   $startDate = $CI->dateconverter->ToGregorian($sy,$sm,$sd); 
			   $endDate = $CI->dateconverter->ToGregorian($ey,$em,$ed); //echo $startDate; exit;
			}
			else
			{
				$startDate =$sy."-".$sm."-".$sd;
			   	$endDate   =$ey."-".$em."-".$ed;
				if($endDate > $startDate){
					$searchDate = $ey."-".$em."-".$ed;
				}else{
					$searchDate = $sy."-".$sm."-".$sd;
				}
			} 
			//check if the start date is smaller than end date
			$sql_casedate = $datefield." <= '".$searchDate."'";
		} 
		
        //echo $sql_casedate; exit;
		 return  $sql_casedate; 
	  } 
	  else
	  {
		return $sql_casedate;
	  }
   }
}

?>
