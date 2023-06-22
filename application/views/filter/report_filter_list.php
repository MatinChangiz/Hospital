<style>
    .table-advance thead tr th.fncl{background-color:#cfe9ba;color:brown;}
</style>
<div class="table-responsive table-scrollable customC">
    <table class="table table-striped table-bordered table-advance table-hover">
        <thead>
            <tr>
                <th width="10%">
                    <center><span><?=$this->lang->line('id')?></span></center>
                </th>
                
                <th width="18%">
                    <span><?=$this->lang->line('dr_name')?></span>
                </th>

                <th width="10%">
                    <span><?=$this->lang->line('shade')?></span>
                </th>

                <th width="15%">
                    <span><?=$this->lang->line('materials')?></span>                                        
                </th>

                <th width="10%">
                    <span><?=$this->lang->line('amount')?></span>                                        
                </th>
                
                <th width="20%">
                    <span><?=$this->lang->line('registerDate')?></span>                                        
                </th>
                
                <th width="10%">
                    <center><span><?=$this->lang->line('actions')?></span></center>                                        
                </th>
            </tr>
        </thead>

        <tbody>
            <?php if($records){
            $i = $page+1;
            foreach($records->result() as $row){
            ?>
            <tr class="prs">
                <td><center><?=$i?></center></td>
                <td><?=$this->register_model->nameByUrn('doctors',$row->dr_name,'dr_name')?></td>
                <td><?=$row->shade?></td>
                <td><?=$this->register_model->nameByUrn('materials',$row->material,'name')?></td>
                <td><?=$row->amount?></td>
                <td>
                    <?php
                    if($row->registerdate){
                        $reg_date   = explode(" ",$row->registerdate);
                        $date_arr1  = explode("-",$reg_date[0]);
                        $jday       = $date_arr1[2];
                        $jmonth     = $date_arr1[1];
                        $jyear      = $date_arr1[0];
                        echo $jday." - ".$this->lang->line('month'.$jmonth)." - ".$jyear;
                        }?>
                </td>
                <td>
                    <center><input class="btn btn-success" value="<?=$this->lang->line("view");?>" onclick="javascript:bring_page('<?=base_url()?>index.php/register/home/view/<?=$this->clean_encrypt->encode($row->urn);?>','<?=$row->urn;?>')" style="width:110px;"></center> 
                </td>
            </tr>
            <?php $i++; }} ?>
        </tbody>
    </table>
    <table class="table table-striped table-bordered table-advance table-hover">  
        <tr>
            <td style="background:#cfe9ba;font-size:16px;color:brown;font-weight:bold;text-align:center;border-bottom:1px solid brown;">
                <?=$this->lang->line("finance");?>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-advance" style="background:#dff0d8;color:brown">
        <thead>
            <tr>
                <th width="10%" class="fncl">
                    <center><span><?=$this->lang->line('id')?></span></center>
                </th>
                
                <th width="18%" class="fncl">
                    <span><?=$this->lang->line('dr_name')?></span>
                </th>

                <th width="10%" class="fncl">
                    <span><?=$this->lang->line('dr_code')?></span>
                </th>

                <th width="15%" class="fncl">
                    <span><?=$this->lang->line('total_price')?></span>
                </th>

                <th width="10%" class="fncl">
                    <span><?=$this->lang->line('paid_price')?></span>                                        
                </th>

                <th width="12%" class="fncl">
                    <span><?=$this->lang->line('remain_price')?></span>                                        
                </th>

                <th width="12%" class="fncl">
                    <span><?=$this->lang->line('payable')?></span>                                        
                </th>
            </tr>
        </thead>

        <tbody>
            <?php if($doc_calc){
                $b = 1;
            foreach($doc_calc as $con_key=>$val){
                $key_arr = explode("#",$con_key);
                $key        = $key_arr['0'];
                $dr_code    = $key_arr['1'];
                $paid       = "0";
                $remain     = "0";
                $the_remian = "0";
                $details_rec   = $this->report_model->getDetailsRec($key);
                if($details_rec){
                    foreach($details_rec as $drc){
                        $paid += $drc->paid_amount;
                    }
                }
                //calculation
                if($pr_calc){
                    $toDateTotal = $pr_calc[$key];
                    if(intval($toDateTotal) > intval($paid)){
                        $remain = intval($toDateTotal)-intval($paid);
                        //calculate paid price
                        if(intval($val)>intval($remain)){
                            $paid   = intval($val)-intval($remain);
                        }else{
                            $paid   = "0";
                        }
                        //calculatee remain price
                        if($remain > $val){
                            $the_remian = intval($remain)-intval($val);
                        }else{
                            $the_remian = $remain;
                        }
                    }else{
                        $paid = $val;
                    }
                    //echo $the_remian;exit;
                }
            ?>
            <tr class="prs">
                <td><center><?=$b?></center></td>
                <td><?=$this->register_model->nameByUrn('doctors',$key,'dr_name')?></td>
                <td><?=$dr_code?></td> 
                <td><?=$val?></td>
                <td><?=$paid?></td>
                <td><?=$the_remian?></td>
                <td><?=$remain?></td>
            </tr>
            <?php $b++; }} ?>
        </tbody>
    </table>
    <table class="table table-striped table-bordered table-advance table-hover">  
        <tr>
            <td>
                <ul class= "leftpagination">
                    <li><?= $total ?>  </li>
                </ul>
                <ul class="pagination">
                    <?= $links ?> 
                </ul>
            </td>
        </tr>
    </table>
</div>