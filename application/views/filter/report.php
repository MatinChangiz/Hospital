<div class="row iRow">
    <div class="dashTitle">
        <?=$this->lang->line('report')?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'filter');
            echo form_open_multipart('report/home/do_filter', $attributes);
        ?>
            <div class="table-responsive text-wrap"> 
                <table class="table btm6px" style="">
                    <tr>
                        <td scope="col" width="50%" class="iEntry">
                            <div class="rLabel">
                                    <label class="" for="textinput"><?=$this->lang->line('dr_code')?> : </label>                
                                </div>
                                <div class="textfield btm20padding">
                                    <input id="dr_code" name="dr_code" type="text" placeholder="<?=$this->lang->line('dr_code')?>" class="form-control iInput" >     
                            </div>
                        </td>

                        <td scope="col" width="50%" class="iEntry">
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
                                    <label class="" for="textinput"><?=$this->lang->line('to')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </label>
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
                    </tr>
                </table>
                <table class="table btm6px"> 
                    <!-- </thead> -->
                    <tr>
                        <td scope="col" width="100%%" class="iEntry" colspan="2">
                            <input type="button" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('search')?>" onclick="submitSearch('<?=base_url()?>index.php/report/home/do_filter','filter','list_div1');">                                            
                            <input type="reset"  id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('clean')?>">
                            <input type="button" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('print_rep')?>" onclick="do_it2('<?=base_url()?>index.php/report/home/genDBexelprint','filter');">
                        </td>
                    </tr>
                </table>  
            </div>
        </form>
    </div>
</div>

<!-- BEGIN CONTENT -->   
<div class="row iRow">
    <div class="icontent">
        <div class="page-content-wrapper" id="list_div1">
                                                  
        </div>
    </div>
</div>   
<!-- END CONTENT -->