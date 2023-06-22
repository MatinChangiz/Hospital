<div class="row iRow">
    <div class="dashTitle">
        <?=$this->lang->line('register_add')?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'dr_add');
            echo form_open_multipart('register/home/add', $attributes);
        ?>
            <div class="table-responsive text-wrap"> 
                <table class="table btm6px">
                    <tr>
                        <td scope="col" width="33%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('dr_name')?> : </label>
                                </div>
                                <div class="textfield btm20padding">
                                    <select id="dr_name" name="dr_name" class="form-control nopadding chosen-select" onchange="bringPatientName('<?=base_url()?>index.php/pricing/home/dr_code','dr_name','dr_code');bringPrice('<?=base_url()?>index.php/register/home/getPrice','material','price','dr_name','amount')">
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
                                    <label class="" for="textinput"><?=$this->lang->line('amount')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="amount" name="amount" type="text" placeholder="<?=$this->lang->line('amount')?>" class="form-control iInput" onkeyup="bringPrice('<?=base_url()?>index.php/register/home/getPrice','material','price','dr_name','amount')"> 
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
                                    <select id="material" name="material" class="form-control nopadding chosen-select" onchange="bringPrice('<?=base_url()?>index.php/register/home/getPrice','material','price','dr_name','amount')">
                                        <option value="0"><?=$this->lang->line('materials')?></option>
                                        <?php
                                        if($material){
                                            foreach($material as $mt){
                                                ?>
                                                <option value="<?=$mt->urn?>"><?=$mt->name?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div> 
                        </td>
                        <td scope="col" width="33%" class="iEntry"> 
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('shade')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="shade" name="shade" type="text" placeholder="<?=$this->lang->line('shade')?>" class="form-control iInput">     
                                </div>
                            </div>
                        </td>
                        <td scope="col" width="33%" class="iEntry"> 
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('job_code')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="job_code" name="job_code" type="text" placeholder="<?=$this->lang->line('job_code')?>" class="form-control iInput">     
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
                                    <input id="price" name="price" readonly="readonly" type="text" placeholder="<?=$this->lang->line('price')?>" class="form-control iInput"> 
                                </div>
                            </div>  
                        </td>
                        <td scope="col" width="67%" class="iEntry" colspan="2"> 
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('total_price')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="total_price" name="total_price" readonly="readonly" type="text" placeholder="<?=$this->lang->line('total_price')?>" class="form-control iInput">     
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
                            <?=$position?>
                        </td>
                    </tr>
                </table>
                <table class="table btm6px"> 
                    <!-- </thead> -->
                    <tr>
                        <td scope="col" width="100%%" class="iEntry" colspan="3">
                            <input type="submit" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('save')?>">
                            <input type="button" onclick="bring_page('<?=base_url()?>index.php/register/home/index','')" class="btn btn-danger" value="<?=$this->lang->line('cancel')?>" >
                            <input type="reset"  id="singlebutton" name="singlebutton" class="btn btn-default" value="<?=$this->lang->line('clean')?>">
                        </td>
                    </tr>
                </table>  
            </div>
        </form>
    </div>
</div>