<!-- <form class="form-horizontal"> -->
<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'filter');
    echo form_open_multipart('register/home/filter', $attributes);
?>
<table class="table">
    <!-- <thead> -->
    <tr>
        <td scope="col" width="33%" class="iEntry">
            <div class="inputfield">
                <div class="rLabel">
                    <label class="" for="textinput"><?=$this->lang->line('registerDate')?> : </label>
                </div>
                <div class="textfield btm20padding">
                      <label class="" for="textinput"><?=$this->lang->line('of')?> : </label>
                      <select id="fday" name="fday" class="form-control nopadding inline" style="width:80px">
                            <option value="00"><?=$this->lang->line('day')?> </option>
                            <?=$days?>
                      </select>
                      <select id="fmonth" name="fmonth" class="form-control nopadding inline" style="width:80px">
                            <option value="00"><?=$this->lang->line('month')?> </option>
                            <?=$months?>
                      </select>
                      <select id="fyear" name="fyear" class="form-control nopadding inline" style="width:80px">
                            <option value="0000"><?=$this->lang->line('year')?></option>
                            <?=$years?>
                      </select>
                </div>
                <div class="textfield btm20padding">
                      <label class="" for="textinput"><?=$this->lang->line('to')?> &nbsp;&nbsp;&nbsp;&nbsp;: </label>
                      <select id="tday" name="tday" class="form-control nopadding inline" style="width:80px">
                            <option value="00"><?=$this->lang->line('day')?> </option>
                            <?=$days?>
                      </select>
                      <select id="tmonth" name="tmonth" class="form-control nopadding inline" style="width:80px">
                            <option value="00"><?=$this->lang->line('month')?> </option>
                            <?=$months?>
                      </select>
                      <select id="tyear" name="tyear" class="form-control nopadding inline" style="width:80px">
                            <option value="0000"><?=$this->lang->line('year')?></option>
                            <?=$years?>
                      </select>
                </div>
            </div>
        </td>
        <td scope="col" width="33%" class="iEntry">
            <div class="inputfield">
                <div class="rLabel">
                    <label class="" for="textinput"><?=$this->lang->line('dr_code')?> : </label>                
                </div>
                <div class="textfield btm20padding">
                    <input id="dr_code" name="dr_code" type="text" placeholder="<?=$this->lang->line('dr_code')?>" class="form-control iInput" value="">     
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td scope="col" width="" class="iEntry">
            <div class="inputfield">
                <div class="rLabel">
                    <label class="" for="textinput"><?=$this->lang->line('materials')?> : </label>
                </div>
                <div class="textfield btm20padding">
                    <select id="material" name="material" class="form-control nopadding">
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
                    <label class="" for="textinput"><?=$this->lang->line('amount')?> : </label>                
                </div>
                <div class="textfield btm20padding">
                    <input id="amount" name="amount" type="text" placeholder="<?=$this->lang->line('amount')?>" class="form-control iInput"> 
                </div>
            </div> 
        
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
</table>
<table class="table"> 
    <!-- </thead> -->
    <tr>
        <td scope="col" width="100%%" class="iEntry" colspan="3">
            <input type="button" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('search')?>" onclick="submitSearch('<?=base_url()?>index.php/register/home/filter','filter','list_div1');">                                            
            <input type="reset"  id="singlebutton" name="singlebutton" class="btn btn-default" value="<?=$this->lang->line('clean')?>">
            <?php if($this->amc_auth->check_myrole('report')){ ?>
            <!--<input type="button" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('print_excel')?>" onclick="do_it2('<?=base_url()?>index.php/register/home/genDBexelprint','filter');">-->
            <?php } ?>
        </td>
    </tr>
</table>
<?=form_close()?>