<!-- BEGIN CONTENT -->
<div class="row iRow">
    <div class="dashTitle" style="margin-bottom:10px;">
        <?=$title;?>
    </div>
    
    <div class="icontent">
        <!--queue of this date-->
        <div class="queue_date" style="border-bottom:0.5px solid #444;margin-bottom:20px;">
            <div class="textfield btm20padding" style="padding-bottom:10px;">
                <input type="button" id="singlebutton" style="min-width:100px;" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('create_user')?>" onclick="bring_page('<?=base_url()?>index.php/login/home/create_user','')"> 
            </div>
        </div>
        <div class="page-content-wrapper" id="list_div1">
            <div class="table-responsive table-scrollable customC">
                <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                            <tr>
                                <th width="10%">
                                    <span><?=$this->lang->line('id')?></span>
                                </th>
                                
                                <th width="18%">
                                    <span><?=$this->lang->line('complete_name')?></span>
                                </th>

                                <th width="18%">
                                    <span><?=$this->lang->line('username')?></span>
                                </th>
                                
                                <th width="15%">
                                    <span><?=$this->lang->line('contact')?></span>                                        
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
                            $i = 1;
                            foreach($records as $row){
                            ?>
                            <tr class="prs">
                                <td><center><?=$i?></center></td>
                                <td><?=$row->full_name?></td>
                                <td><?=$row->username?></td>
                                <td><?=$row->contact?></td>
                                <td>
                                    <?php
                                    if($row->registerdate){
                                        $reg_date   = explode(" ",$row->registerdate);
                                        $date_arr1  = explode("-",$reg_date[0]);
                                        $jdate      = gregorian_to_jalali($date_arr1[0],$date_arr1[1],$date_arr1[2],"/");
                                        $jdate_arr  = explode("/",$jdate);
                                        $jday       = $jdate_arr[2];
                                        $jmonth     = $jdate_arr[1];
                                        $jyear      = $jdate_arr[0];
                                        echo $jday." - ".$this->lang->line('month'.$jmonth)." - ".$jyear;
                                     }?>
                                </td>
                                <td>
                                    <center><input class="btn btn-success" value="<?=$this->lang->line("view");?>" onclick="javascript:bring_page('<?=base_url()?>index.php/login/home/view/<?=$this->clean_encrypt->encode($row->urn);?>','<?=$row->urn;?>')" style="width:110px;"></center> 
                                </td>
                            </tr>
                            <?php $i++; }} ?>
                        </tbody>
                </table>
            </div> 
            <!-- end of row  -->
            <ul class="pagination">
                <?php foreach ($links as $link) {
                     echo "<li>". $link."</li>";
                } ?>
           </ul>
        </div>
    </div>
</div>   
<!-- END CONTENT -->