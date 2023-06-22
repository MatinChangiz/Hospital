<!-- <form class="form-horizontal"> -->
<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'filter');
    echo form_open_multipart('material/home/filter', $attributes);
?>
<table class="table">
    <!-- <thead> -->
    <tr>
        <td scope="col" width="33%" class="iEntry">
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
        </td>
    </tr>
</table>
<table class="table"> 
    <!-- </thead> -->
    <tr>
        <td scope="col" width="100%%" class="iEntry" colspan="3">
            <input type="button" id="singlebutton" name="singlebutton" class="btn btn-success" value="<?=$this->lang->line('search')?>" onclick="submitSearch('<?=base_url()?>index.php/materials/home/filter','filter','list_div1');">                                            
            <input type="reset"  id="singlebutton" name="singlebutton" class="btn btn-default" value="<?=$this->lang->line('clean')?>">
        </td>
    </tr>
</table>
<?=form_close()?>