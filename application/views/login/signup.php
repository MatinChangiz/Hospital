<div class="row iRow">
    <div class="dashTitle">
        <?=$title;?>
    </div>
    <div class="icontent">
        <!-- <form class="form-horizontal"> -->
        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'q_add');
            echo form_open_multipart('login/home/create_user', $attributes);
            if($this->session->flashdata('msg')){
                echo $this->session->flashdata('msg');
            }
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
                                    <input type="text" class="form-control" id="name" name="name" required="fill plase" placeholder="<?= $this->lang->line("name"); ?>">     
                                </div>
                            </div>
                            
                            
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label><?= $this->lang->line("username"); ?>:</label>
                                </div>
                                <div class="textfield btm20padding">
                                    <input type="text" class="form-control" id="username" name="username" required="fill plase" placeholder="<?= $this->lang->line("username"); ?>" onkeyup="check_duplicate('<?=base_url()?>index.php/login/home/checkUser','username','msg_area');">
                                    <div id="msg_area"></div> 
                                </div>
                            </div>
                            
                            <div class="inputfield">
                                <div class="rLabel">
                                    <label><?= $this->lang->line("password"); ?>:</label>
                                </div>
                                <div class="textfield btm20padding">
                                    <input type="password" id="password" name="password" required="fill plase" class="form-control" placeholder="<?= $this->lang->line("password"); ?>">
                                </div>
                            </div>

                            <div class="inputfield">
                                <div class="rLabel"> 
                                    <label><?= $this->lang->line("password_again"); ?>:</label>
                                </div>
                                <div class="textfield btm20padding">
                                    <input type="password" id="pass_again" name="pass_again" required="" class="form-control" placeholder="<?= $this->lang->line("password_again"); ?>">
                                </div>
                            </div> 
                            
                            <div class="inputfield">
                                <div class="rLabel"> 
                                    <label><?= $this->lang->line("contact"); ?>:</label>
                                </div>
                                <div class="textfield btm20padding">
                                    <input type="text" id="contact" name="contact" required="" class="form-control" placeholder="<?= $this->lang->line("contact"); ?>">
                                </div>
                            </div>    
                        </td> 
                        <td scope="col" width="50%" class="iEntry">
                            <div class="alert alert-info row signup_info">
                                <label><strong><?= $this->lang->line("role_info"); ?></strong></label> 
                            </div>
                            <div class="checkbox-container btm20margin" style="margin-top:35px">
                                <label class="checkbox-label">
                                    <input type="checkbox" checked="checked" id="reception"  name="reception" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('reception')?> </span>
                                </label>
                            </div>
                            
                            <div class="checkbox-container btm20margin">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="farmcy" name="farmcy" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('materials')?> </span>
                                </label>
                            </div>
                            
                            <div class="checkbox-container btm20margin">
                                <label class="checkbox-label">
                                    <input type="checkbox" checked="checked" id="remains" name="remains" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('doctors')?> </span>
                                </label>
                            </div>
                            
                            <div class="checkbox-container btm20margin">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="expenses" name="expenses" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('reports')?> </span>
                                </label>
                            </div>
                            
                            <div class="checkbox-container btm20margin">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="admin" name="admin" value="1">
                                    <span class="checkbox-custom rectangular"></span>
                                    <span class='clabel' style="top:4px"><?=$this->lang->line('admin')?> </span>
                                </label>
                            </div>
                        </td>   
                    </tr> 

                    <!-- </thead> -->
                    <tr>
                        <td scope="col" width="100%%" class="iEntry" colspan="3">
                            <button type="submit" class="btn green" id='save_user' disalbled='disalbled'><?= $this->lang->line("save"); ?></button>
                            <button type="button" class="btn default" onclick="javascript:bring_page('<?=base_url()?>index.php/login/home/user_list')" /><?= $this->lang->line("cancel"); ?></button> 
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>