<div class="row iRow">
    <div class="dashTitle">
        <?=$this->lang->line('register_edit')?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'dr_add');
            echo form_open_multipart("register/home/edit/$enc_urn", $attributes);
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
                                            foreach($doctors as $d_id){
                                                if($record->dr_name == $d_id->urn){
                                                    ?>
                                                    <option selected="selected" value="<?=$d_id->urn?>"><?=$d_id->dr_name?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="<?=$d_id->urn?>"><?=$d_id->dr_name?></option>
                                                    <?php
                                                }
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
                                <input id="dr_code" name="dr_code" readonly='readonly' type="text" placeholder="<?=$this->lang->line('dr_code')?>" class="form-control iInput" value="<?=$record->dr_code?>">     
                            </div>
                        </td>
                        <td scope="col" width="33%" class="iEntry">
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('amount')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="amount" name="amount" type="text" placeholder="<?=$this->lang->line('amount')?>" class="form-control iInput" onkeyup="bringPrice('<?=base_url()?>index.php/register/home/getPrice','material','price','dr_name','amount')" value="<?=$record->amount?>"> 
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
                                            foreach($material as $m_id){
                                                if($record->material == $m_id->urn){
                                                    ?>
                                                    <option selected="selected" value="<?=$m_id->urn?>"><?=$m_id->name?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="<?=$m_id->urn?>"><?=$m_id->name?></option>
                                                    <?php
                                                }
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
                                    <input id="shade" name="shade" type="text" placeholder="<?=$this->lang->line('shade')?>" class="form-control iInput" value="<?=$record->shade?>">     
                                </div>
                            </div>
                        </td>
                        <td scope="col" width="33%" class="iEntry"> 
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('job_code')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="job_code" name="job_code" type="text" placeholder="<?=$this->lang->line('job_code')?>" class="form-control iInput" value="<?=$record->job_code?>">     
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
                                    <input id="price" name="price" readonly="readonly" type="text" placeholder="<?=$this->lang->line('price')?>" class="form-control iInput" value="<?=$record->price?>"> 
                                </div>
                            </div>  
                        </td>
                        <td scope="col" width="67%" class="iEntry" colspan="2"> 
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('total_price')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="total_price" name="total_price" readonly="readonly" type="text" placeholder="<?=$this->lang->line('total_price')?>" class="form-control iInput" value="<?=$record->total_price?>">     
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
                            <?=$position_edit?>
                        </td>
                    </tr>
                </table>
                <table class="table btm6px"> 
                    <!-- </thead> -->
                    <tr>
                        <td scope="col" width="100%%" class="iEntry" colspan="3">
                            <input type="submit" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('save')?>">
                            <input type="button" onclick="bring_page('<?=base_url()?>index.php/register/home/view/<?=$enc_urn?>','')" class="btn btn-danger" value="<?=$this->lang->line('cancel')?>" >
                        </td>
                    </tr>
                </table>  
            </div>
        </form>
    </div>
</div>