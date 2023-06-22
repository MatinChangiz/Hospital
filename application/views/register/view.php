<div class="row iRow">
    <div class="dashTitle">
        <?=$this->lang->line('register_view')?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <div class="table-responsive text-wrap"> 
            <table class="table btm6px">
                <tr>
                    <td scope="col" width="33%" class="iEntry">
                        <div class="inputfield">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('dr_name')?> : </label>
                            </div>
                            <div class="textfield btm20padding">
                                <?=$this->register_model->nameByUrn('doctors',$record->dr_name,'dr_name')?>
                            </div>
                        </div>
                    </td>
                    <td scope="col" width="33%" class="iEntry">
                        <div class="rLabel">
                            <label class="" for="textinput"><?=$this->lang->line('dr_code')?> : </label>                
                        </div>
                        <div class="textfield btm20padding">
                            <?=$record->dr_code?>     
                        </div>
                    </td>
                    <td scope="col" width="33%" class="iEntry">
                        <div class="inputfield">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('amount')?> : </label>                
                            </div>
                            <div class="textfield btm20padding">
                                <?=$record->amount?>
                            </div>
                        </div>  
                    </td>
                </tr>
                <tr>
                    <td scope="col" width="33%" class="iEntry">
                        <div class="inputfield">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('materials')?> : </label>
                            </div>
                            <div class="textfield btm20padding">
                                <?=$this->register_model->nameByUrn('materials',$record->material,'name')?>
                            </div>
                        </div> 
                    </td>
                    <td scope="col" width="33%" class="iEntry"> 
                        <div class="inputfield">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('shade')?> : </label>                
                            </div>
                            <div class="textfield btm20padding">
                                <?=$record->shade?>   
                            </div>
                        </div>
                    </td>
                    <td scope="col" width="33%" class="iEntry"> 
                        <div class="inputfield">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('job_code')?> : </label>                
                            </div>
                            <div class="textfield btm20padding">
                                <?=$record->job_code?>    
                            </div>
                        </div>     
                    </td>
                </tr>
                <tr>
                    <td scope="col" width="33%" class="iEntry">
                        <div class="inputfield">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('price')?> : </label>                
                            </div>
                            <div class="textfield btm20padding">
                                <?=$record->price?>
                            </div>
                        </div>  
                    </td>
                    <td scope="col" width="67%" class="iEntry" colspan="2"> 
                        <div class="inputfield">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('total_price')?> : </label>                
                            </div>
                            <div class="textfield btm20padding">
                                <?=$record->total_price?>    
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="table btm6px"> 
                <tr>
                    <td scope="col" width="30%" class="iEntry alert alert-success" style="vertical-align:middle;text-align:center;font-size:28px;background-color:#d6e9c6">
                        <label class="" for="textinput"><?=$this->lang->line('position')?></label>     
                    </td>
                    <td scope="col" width="70%" class="iEntry alert-success" colspan="2">
                        <?=$position_view?>
                    </td>
                </tr>
            </table>
            <table class="table btm6px"> 
                <!-- </thead> -->
                <tr>
                    <td scope="col" width="100%%" class="iEntry" colspan="3">
                        <input type="button" onclick="bring_page('<?=base_url()?>index.php/register/home/edit/<?=$this->clean_encrypt->encode($record->urn);?>','')" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('edit')?>">
                        <input type="button" onclick="bring_page('<?=base_url()?>index.php/register/home/listRecords','')" class="btn btn-default" value="<?=$this->lang->line('backToList')?>" >
                    </td>
                </tr>
            </table>  
        </div>
    </div>
</div>