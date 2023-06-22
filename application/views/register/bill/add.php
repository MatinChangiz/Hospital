<div class="row iRow">
    <div class="dashTitle">
        <?=$this->lang->line('pay_bill')?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'dr_add');
            echo form_open_multipart('register/home/pay_bill', $attributes);
        ?>
            <div class="table-responsive text-wrap"> 
                <table class="table btm6px" style="min-height:400px;">
                    <tr>
                        <td scope="col" width="33%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('dr_name')?> : </label>
                                </div>
                                <div class="textfield btm20padding">
                                    <select id="dr_name" name="dr_name" class="form-control nopadding chosen-select" onchange="bringPatientName('<?=base_url()?>index.php/pricing/home/dr_code','dr_name','dr_code');">
                                        <option value="0"><?=$this->lang->line('dr_name')?></option>
                                        <?php
                                        if($doctors){
                                            foreach($doctors as $p_id){
                                                ?>
                                                <option value="<?=$p_id->urn?>"><?=$p_id->dr_name?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td scope="col" width="33%" class="iEntry">
                            <div class="rLabel">
                                <label class="" for="textinput"><?=$this->lang->line('dr_code')?> : </label>                
                            </div>
                            <div class="textfield btm20padding">
                                <input id="dr_code" name="dr_code" readonly='readonly' type="text" placeholder="<?=$this->lang->line('dr_code')?>" class="form-control iInput" >     
                            </div>
                        </td>
                        <td scope="col" width="33%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('pay_amount')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="amount" name="amount" type="text" placeholder="<?=$this->lang->line('pay_amount')?>" class="form-control iInput"> 
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
                            <input type="button" onclick="bring_page('<?=base_url()?>index.php/register/home/bill_list','')" class="btn btn-danger" value="<?=$this->lang->line('cancel')?>" >
                            <input type="reset"  id="singlebutton" name="singlebutton" class="btn btn-default" value="<?=$this->lang->line('clean')?>">
                        </td>
                    </tr>
                </table>  
            </div>
        </form>
    </div>
</div>