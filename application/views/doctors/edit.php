<div class="row iRow">
    <div class="dashTitle">
        <?=$this->lang->line("doctor_edit");?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'dr_add');
            echo form_open_multipart("doctors/home/edit/$enc_urn", $attributes);
        ?>
            <div class="table-responsive text-nowrap"> 
                  <table class="table btm6px">
                    <tr id="tardivid"> 
                        <td scope="col" width="33%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('dr_name')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="dr_name" name="dr_name" type="text" placeholder="<?=$this->lang->line('dr_name')?>" class="form-control iInput" value="<?=$record->dr_name?>">     
                                </div>
                            </div>
                        </td>
                        <td scope="col" width="33%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('dr_code')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="dr_code" name="dr_code" type="text" placeholder="<?=$this->lang->line('dr_code')?>" class="form-control iInput" value="<?=$record->dr_code?>">     
                                </div>
                            </div>    
                        </td>
                        <td scope="col" width="34%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('contact')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="contact" name="contact" type="text" placeholder="<?=$this->lang->line('contact')?>" class="form-control iInput" value="<?=$record->contact?>">     
                                </div>
                            </div>    
                        </td>   
                    </tr>
                </table>
                <table class="table btm6px"> 
                    <!-- </thead> -->
                    <tr>
                        <td scope="col" width="100%%" class="iEntry" colspan="3">
                            <input type="submit" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('save')?>">
                            <input type="button" onclick="bring_page('<?=base_url()?>index.php/doctors/home/listRecords','')" class="btn btn-danger" value="<?=$this->lang->line('cancel')?>" >
                        </td>
                    </tr>
                </table>

            </div>
        </form>
    </div>
</div>