<!DOCTYPE html>
<html lang="en" class="no-js">
<!--<![endif]-->

<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title><?=$this->lang->line("hospital_system")?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="<?php echo base_url();?>assets/global/plugins/fontawesome-free/css/all.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN PAGE STYLES -->
    <link href="<?php echo base_url();?>assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->

    <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-summernote/summernote.css">

    <link href="<?php echo base_url();?>assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="<?php echo base_url();?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES --> 
    
    <!-- BEGIN PAGE LEVEL STYLES -->
    <!-- style of PopUp  -->
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
    <!-- END PAGE LEVEL STYLES -->
    <script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/script/script.js"></script>
    <link href="<?php echo base_url();?>assets/custom_style/custom.css" rel="stylesheet" type="text/css"/>
    <?php $baseUrl = base_url();?>
    <style type="text/css">
        @font-face {
                font-family: "amc";src: local("â˜º"), 
                url("<?= $baseUrl ?>assets/global/Yekan/Yekan.woff") format("woff"), 
                url("<?= $baseUrl ?>assets/global/Yekan/Yekan.eot") format("eot"), 
                url("<?= $baseUrl ?>assets/global/Yekan/Yekan.otf") format("otf"), 
                url("<?= $baseUrl ?>assets/global/Yekan/Yekan.ttf") format("truetype"), 
                url("<?= $baseUrl ?>assets/global/Yekan/Yekan.svg") format("svg");
        }
        div,h1,li,p,h2,h4,h3,a{
            font-family: "amc";
        }
    </style>                                                                           
    
    <!--********************************chosen setup********************************-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/docsupport/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/docsupport/prism.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.css">
    <!--********************************chosen setup********************************-->
</head>
    <body class="page-header-fixed page-quick-sidebar-over-content page-style-square" style="background:#f1f1f1;"> 
        <center><div align="" style="width:320px;margin-top:9%;border:0.5px solid #ccc">
            <?php
                if($this->session->flashdata('msg')){
                    echo $this->session->flashdata('msg');
                }
            ?>
            <div class="form-group row" align="center" style="padding:10px 15px 20px;background:#fff;width:100%;margin-bottom:0px; border-bottom:0.5px solid #cecece">
                <img src="<?php echo base_url();?>assets/images/LOGOSAMPLE.png" class="profpic" style="height:120px;">
            </div>

            <?php $attr = array('class' => 'login-form'); ?>
              <?php echo form_open('auth/home/login',$attr); ?>
                <div class="form-body">
                    <div class="form-group">
                        <input type="text" name="username" required="fill plase" class="form-control input-lg" placeholder="<?= $this->lang->line("username"); ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" required="" class="form-control input-lg" placeholder="<?= $this->lang->line("password"); ?>">
                    </div>    
                    <div class="form-group">
                        <input type="submit" required="" class="form-control input-lg" value="<?= $this->lang->line("login"); ?>" style="background:#66afe9; color:#fff;">
                    </div>    
                </div>
            </form>
        </div></center>
    </body>
</html>