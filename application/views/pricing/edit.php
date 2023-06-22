<div class="row iRow">
    <div class="dashTitle">
        <?=$this->lang->line("pricing_edit");?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'dr_add');
            echo form_open_multipart("pricing/home/edit/$enc_urn", $attributes);
        ?>
            <div class="table-responsive text-nowrap"> 
                  <table class="table btm6px">
                    <tr id="tardivid"> 
                        <td scope="col" width="50%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('dr_name')?> : </label>
                                </div>
                                <div class="textfield btm20padding">
                                    <select disabled="disabled" id="dr_name" name="dr_name" class="form-control nopadding" onchange="bringPatientName('<?=base_url()?>index.php/pricing/home/dr_code','dr_name','dr_code')">
                                        <option value="<?=$record->dr_urn?>"><?=$this->pricing_model->nameByUrn('doctors',$record->dr_urn,'dr_name')?></option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td scope="col" width="50%" class="iEntry">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('dr_code')?> : </label>                
                            </div>
                            <div class="textfield btm20padding">
                                <input id="dr_code" name="dr_code" readonly='readonly' type="text" placeholder="<?=$this->lang->line('dr_code')?>" class="form-control iInput" value="<?=$record->dr_code?>">     
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="col" width="50%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('materials')?> : </label>
                                </div>
                                <div class="textfield btm20padding">
                                    <select id="material" disabled="disabled" name="material" class="form-control nopadding">
                                        <!--<option value="0"><?=$this->lang->line('materials')?></option>-->
                                        <option value="<?=$record->material_urn?>"><?=$this->pricing_model->nameByUrn('materials',$record->material_urn,'name')?></option>
                                    </select>
                                </div>
                            </div> 
                        </td>
                        <td scope="col" width="50%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('price')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="price" name="price" type="text" placeholder="<?=$this->lang->line('price')?>" class="form-control iInput" value="<?=$record->price?>">     
                                </div>
                            </div>    
                        </td>   
                    </tr>
                </table>
                <table class="table btm6px" id="scopdiv"> 
                </table>
                <table class="table btm6px"> 
                    <!-- </thead> -->
                    <tr>
                        <td scope="col" width="100%%" class="iEntry" colspan="3">
                            <input type="submit" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('save')?>">
                            <input type="button" onclick="bring_page('<?=base_url()?>index.php/pricing/home/listRecords','')" class="btn btn-danger" value="<?=$this->lang->line('cancel')?>" >
                        </td>
                    </tr>
                </table>

            </div>
        </form>
    </div>
</div>