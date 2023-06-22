<div class="table-responsive table-scrollable customC">
    <table class="table table-striped table-bordered table-advance table-hover">
        <thead>
            <tr>
                <th width="10%">
                    <center><span><?=$this->lang->line('id')?></span></center>
                </th>
                
                <th width="18%">
                    <span><?=$this->lang->line('m_name')?></span>
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
                <td><?=$row->name?></td>
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
                    <center><input class="btn btn-success" value="<?=$this->lang->line("edit");?>" onclick="javascript:bring_page('<?=base_url()?>index.php/materials/home/edit/<?=$this->clean_encrypt->encode($row->urn);?>','<?=$row->urn;?>')" style="width:110px;">
                </td>
            </tr>
            <?php $i++; }} ?>
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