<div class="row iRow">
    <div class="dashTitle">
        <?=$this->lang->line("pricing_add");?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'dr_add');
            echo form_open_multipart('pricing/home/add', $attributes);
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
                                    <select id="dr_name" name="dr_name" class="form-control nopadding chosen-select" onchange="bringPatientName('<?=base_url()?>index.php/pricing/home/dr_code','dr_name','dr_code')">
                                        <option value=""><?=$this->lang->line('dr_name')?></option>
                                        <?php
                                        if($doctors){
                                            foreach($doctors as $p_id){
                                                if(in_array($p_id->urn,$exdoctors)){
                                                    $class = "disabled='disabled'";
                                                }else{
                                                    $class = "";
                                                }
                                                ?>
                                                <option <?=$class?> value="<?=$p_id->urn?>"><?=$p_id->dr_name?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td scope="col" width="50%" class="iEntry">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('dr_code')?> : </label>                
                            </div>
                            <div class="textfield btm20padding">
                                <input id="dr_code" name="dr_code" readonly='readonly' type="text" placeholder="<?=$this->lang->line('dr_code')?>" class="form-control iInput" >     
                            </div>
                        </td>
                    </tr>
                    <?php
                    if($material){
                        foreach($material as $p_id){
                            ?>
                    <tr id="padle">
                        <td scope="col" width="50%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('materials')?> : </label>
                                </div>
                                <div class="textfield btm20padding">
                                    <select id="material[]" name="material[]" class="form-control nopadding">
                                        <!--<option value="0"><?=$this->lang->line('materials')?></option>-->
                                        <option value="<?=$p_id->urn?>"><?=$p_id->name?></option>
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
                                    <input id="price[]" name="price[]" type="text" placeholder="<?=$this->lang->line('price')?>" class="form-control iInput">     
                                </div>
                            </div>    
                        </td>   
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
                <table class="table btm6px" id="scopdiv"> 
                </table>
                <table class="table btm6px"> 
                    <!-- </thead> -->
                    <tr>
                        <td scope="col" width="100%%" class="iEntry" colspan="3">
                            <input type="submit" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('save')?>">
                            <input type="button" onclick="bring_page('<?=base_url()?>index.php/pricing/home/listRecords','')" class="btn btn-danger" value="<?=$this->lang->line('cancel')?>" >
                            <input type="reset"  id="singlebutton" name="singlebutton" class="btn btn-default" value="<?=$this->lang->line('clean')?>">
                        </td>
                    </tr>
                </table>

            </div>
        </form>
    </div>
</div>