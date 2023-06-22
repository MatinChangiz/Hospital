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
	    		font-family: "amc";src: local("☺"), 
		        url("<?= $baseUrl ?>assets/global/Yekan/Yekan.woff") format("woff"), 
		        url("<?= $baseUrl ?>assets/global/Yekan/Yekan.eot") format("eot"), 
		        url("<?= $baseUrl ?>assets/global/Yekan/Yekan.otf") format("otf"), 
		        url("<?= $baseUrl ?>assets/global/Yekan/Yekan.ttf") format("truetype"), 
		        url("<?= $baseUrl ?>assets/global/Yekan/Yekan.svg") format("svg");
		}
		div,h1,li,p,h2,h4,h3,a{
			font-family: "amc";
		}
		ul.cr_dr li{list-style-type:none}
		div.page-container>.page-content-wrapper{background:#3d3d3d;}
	</style>
    
    <!--********************************chosen setup********************************-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/docsupport/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/docsupport/prism.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.css"> 
    <!--********************************chosen setup********************************-->
    
</head>


<body class="bd page-header-fixed page-quick-sidebar-over-content page-style-square"> 
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<div class="page-header-inner">
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<!-- Profile is here  -->
				<!-- END NOTIFICATION DROPDOWN -->
				<!-- BEGIN INBOX DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				<!--<li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="fas fa-level-down-alt"></i>
					<span class="badge badge-default">
					<?php
                        $today_visit = $this->amc_auth->todayVisit();
                        if($today_visit){
                            echo count($today_visit);
                        }else{
                            echo "0";
                        }
                    ?> 
                    </span>
					</a>
					<ul class="dropdown-menu">
						<li class="external">
							<h3><span class="bold"><?= $this->lang->line('today_visits'); ?></span></h3>
							<a href="<?=base_url()?>index.php/next_visit/home/next_visit_list"><?= $this->lang->line('home_list_all'); ?></a>
						</li>
						<li>
							<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#437283">
								<?php
                                    if($today_visit){ 
                                        $i = 1;
                                        foreach($today_visit AS $rec){
                                            $nextDone = $this->amc_auth->isDone($rec->patient_id);
                                            if($nextDone){
                                                $class = "visited";
                                            }else{
                                                $class = "";
                                            }
                                ?>
                                <li class="<?=$class?>">
									<a href="<?=base_url()?>index.php/next_visit/home/view/<?=$this->clean_encrypt->encode($rec->urn);?>">
                                        
									    <span class="subject">
									    <span class="from">
									        <span class="badge badge-default" style="margin-right:-30px;background-color:#d64635;position:relative;top:2px;">
                                                <?=$i?>
                                            </span>&nbsp;&nbsp;&nbsp;
                                            <?=$rec->name?> </span>
									    </span>
									    <span class="message">
                                            <?php
                                                //next time
                                                $time_arr = explode(":",$rec->next_time);
                                                
                                                //next date
                                                $date_arr   = explode(" ",$rec->next_visit);
                                                $date_arr1  = explode("-",$date_arr[0]);   
                                                $jdate      = gregorian_to_jalali($date_arr1[0],$date_arr1[1],$date_arr1[2],"/");
                                                $jdate_arr  = explode("/",$jdate);
                                                $jday       = $jdate_arr[2];
                                                $jmonth     = $jdate_arr[1];
                                                $jyear      = $jdate_arr[0];
                                                echo $jday."-".$this->lang->line('month'.$jmonth)."-".$jyear." &nbsp;&nbsp; ".$time_arr[1]." : ".$time_arr[0];
                                             ?>
									    </span>
									</a>
								</li>
                                <?php $i++;}}else{
                                ?>
                                <li> 
                                    <span class="alert alert-danger">
                                        <?=$this->lang->line('no_visitor');?> </span>
                                    </span>   
                                </li>
                                <?php
                                }?>
							</ul>
						</li>
					</ul>
				</li>-->
                 
				<!-- END TODO DROPDOWN -->
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				

					<!-- Profile is here  -->
				<li class="dropdown dropdown-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<!-- <img alt="" class="img-circle" src="assets/admin/layout/img/avatar3_small.jpg"/> -->
					<span class="username username-hide-on-mobile">
						<?= $this->session->userdata("full_name"); ?>
					</span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default cr_dr">
						<!-- <li>
							<a href="extra_profile.html">
							<i class="icon-user"></i> <?//= $profile; ?></a>
						</li> -->
						<li>
							<a href="<?php echo site_url('login/home/change_password'); ?>">
							<i class="icon-key" style="position:relative;top:4px;"></i><?= $this->lang->line('chang_password'); ?></a>
						</li>
						
						<li class="divider">
						</li>
						
						<li>
							<a href="<?php echo site_url('login/home/logout'); ?>">
							<i class="icon-logout"></i><?= $this->lang->line('logout'); ?></a>
						</li>
					</ul>
				</li>
			</ul>
		</div>

		<div class="mlist">
			<div class="menu-toggler sidebar-toggler hide">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>		
			<a href="javascript:;" class="menu-toggler responsive-toggler nav nav-right" style="float: right; margin-top:9px;" data-toggle="collapse" data-target=".navbar-collapse">
				<i class="fa fa-compress itoggler"></i>
			</a>
			<!--<ul style="float: right; margin-top:4px;" class="right_custom_menu">
				<li><a href="<?php echo site_url('conductorC/index'); ?>"><h4><?= $this->lang->line('queue_list'); ?></h4></a></li>
				<li><a href="<?php echo site_url('tvC/index'); ?>"><h4><?= $this->lang->line('employee'); ?></h4></a></li>
				<li><a href="<?php echo site_url('my_postC/index'); ?>"><h4><?= $this->lang->line('register'); ?></h4></a></li> 
				
			</ul> -->
		</div>
	</div>
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">