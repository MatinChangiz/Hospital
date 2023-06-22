<div class="row iRow">
    <div class="dashTitle">
        <?=$title;?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'u_edit');
            echo form_open_multipart('login/home/edit_user/'.$enc_urn, $attributes);
            if($this->session->flashdata('msg')){
                echo $this->session->flashdata('msg');
            }
            if($record){ 
        ?>
            <div class="table-responsive text-nowrap">

                <table class="table">
                    <!-- <thead> -->
                    <tr>
                        <td scope="col" width="50%" class="iEntry">
                            <div class="alert alert-info row signup_info">
                                <label><strong><?= $this->lang->line("personal_info"); ?></strong></label> 
                            </div> 
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label><?= $this->lang->line("complete_name"); ?>:</label>                 
                                </div>
                                <div class="textfield btm20padding">
                                    <input type="text" class="form-control" id="name" name="name" required="fill plase" placeholder="<?= $this->lang->line("name"); ?>" value="<?=$record->full_name?>">     
                                </div>
                            </div>
                            
                            
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label><?= $this->lang->line("username"); ?>:</label>
                                </div>
                                <div class="textfield btm20padding">
                                    <input type="text" class="form-control" id="username" name="username" required="fill plase" placeholder="<?= $this->lang->line("username"); ?>" value="<?=$record->username?>">
                                </div>
                            </div>
                            
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label><?= $this->lang->line("password"); ?>:</label>
                                </div>
                                <div class="textfield btm20padding">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="<?= $this->lang->line("password"); ?>">
                                </div>
                            </div>

                            <div class="inputfield">
                                <div class="rLabel"> 
                                    <label><?= $this->lang->line("password_again"); ?>:</label>
                                </div>
                                <div class="textfield btm20padding">
                                    <input type="password" id="pass_again" name="pass_again"  class="form-control" placeholder="<?= $this->lang->line("password_again"); ?>">
                                </div>
                            </div> 
                            
                            <div class="inputfield">
                                <div class="rLabel"> 
                                    <label><?= $this->lang->line("contact"); ?>:</label>
                                </div>
                                <div class="textfield btm20padding">
                                    <input type="text" id="contact" name="contact" class="form-control" placeholder="<?= $this->lang->line("contact"); ?>" value="<?=$record->contact?>">
                                </div>
                            </div>    
                        </td> 
                        <td scope="col" width="50%" class="iEntry">
                            <div class="alert alert-info row signup_info">
                                <label><strong><?= $this->lang->line("role_info"); ?></strong></label> 
                            </div>
                            <div class="checkbox-container btm20margin" style="margin-top:35px">
                                <label class="checkbox-label">
                                    <input type="checkbox" <?php if($record->reception == 1){echo "checked";}?> id="reception"  name="reception" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('reception')?> </span>
                                </label>
                            </div>
                            
                            <div class="checkbox-container btm20margin">
                                <label class="checkbox-label">
                                    <input type="checkbox" <?php if($record->drug_store == 1){echo "checked";}?> id="farmcy" name="farmcy" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('materials')?> </span>
                                </label>
                            </div>
                            
                            <div class="checkbox-container btm20margin">
                                <label class="checkbox-label">
                                    <input type="checkbox" <?php if($record->remains == 1){echo "checked";}?> id="remains" name="remains" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('doctors')?> </span>
                                </label>
                            </div>
                            
                            <div class="checkbox-container btm20margin">
                                <label class="checkbox-label">
                                    <input type="checkbox" <?php if($record->expense == 1){echo "checked";}?> id="expenses" name="expenses" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('reports')?> </span>
                                </label>
                            </div>
                            
                            <div class="checkbox-container btm20margin">
                                <label class="checkbox-label">
                                    <input type="checkbox" <?php if($record->admin == 1){echo "checked";}?> id="admin" name="admin" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('admin')?> </span>
                                </label>
                            </div>
                        </td>   
                    </tr> 

                    <!-- </thead> -->
                    <tr>
                        <td scope="col" width="100%%" class="iEntry" colspan="3">
                            <button type="submit" class="btn green"><?= $this->lang->line("save"); ?></button>
                            <button type="button" class="btn default" onclick="javascript:bring_page('<?=base_url()?>index.php/login/home/view/<?=$this->clean_encrypt->encode($record->urn);?>')" /><?= $this->lang->line("cancel"); ?></button> 
                        </td>
                    </tr>
                </table>
            </div>
            <?php } ?>
        </form>
    </div>
</div>