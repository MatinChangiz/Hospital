<div class="row iRow">
    <div class="dashTitle">
        <?=$title;?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'p_edit');
            echo form_open_multipart('login/home/change_password/'.$enc_urn, $attributes);
            if($this->session->flashdata('msg')){
                echo $this->session->flashdata('msg');
            }
            //if($record){ 
        ?>
            <div class="table-responsive text-nowrap">

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="inputfield">
                            <div class="rLabel">
                                <label><?= $this->lang->line("old_password"); ?>:</label>
                            </div>
                            <div class="textfield btm20padding">
                                <input type="password" id="password" name="password" class="form-control" placeholder="<?= $this->lang->line("password"); ?>">
                            </div>
                        </div>
                        
                        <div class="inputfield">
                            <div class="rLabel">
                                <label><?= $this->lang->line("new_password"); ?>:</label>
                            </div>
                            <div class="textfield btm20padding">
                                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="<?= $this->lang->line("password"); ?>">
                            </div>
                        </div>

                        <div class="inputfield">
                            <div class="rLabel"> 
                                <label><?= $this->lang->line("repeat_new_password"); ?>:</label>
                            </div>
                            <div class="textfield btm20padding">
                                <input type="password" id="new_pass_again" name="new_pass_again"  class="form-control" placeholder="<?= $this->lang->line("password_again"); ?>">
                            </div>
                        </div>   
                        <button type="submit" class="btn green"><?= $this->lang->line("save"); ?></button>
                        <button type="button" class="btn default" onclick="javascript:bring_page('<?=base_url()?>index.php/dashboard/home')" /><?= $this->lang->line("cancel"); ?></button> 
                </div>
            </div>
            <?php //} ?>
        </form>
    </div>
</div>