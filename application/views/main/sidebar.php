<!--********************************* BEGIN SIDEBAR *****************************************-->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler" style="color:#fff;margin:8px 11px 12px 11px">
						<i class="fa fa-compress itoggler" style="width:34px; color:#00bcd4"></i>
					</div>
				</li>

				<li class="">
					<a href="<?php echo site_url(); ?> ">
					<i class="icon-home"></i>
					<span class="title"><?=$this->lang->line('dashboard');?></span>
					<span class="fa fa-caret-right "></span>
					</a>					
				</li>
                
                <?php if($this->amc_auth->check_myrole('reception')){ ?>
                <li class="">
                    <a href="<?=base_url()?>index.php/register/home">
                    <i class="fa fa-folder"></i>
                
                    <span class="title"><?=$this->lang->line('register_part');?></span>
                    <span class="fa fa-caret-right "></span>
                    </a>
                </li>
                <?php } ?>

                <?php if($this->amc_auth->check_myrole('drug_store')){ ?>
                <li class="">
                    <a href="<?=base_url()?>index.php/materials/home">
                    <i class="fa fa-folder"></i>
                
                    <span class="title"><?=$this->lang->line('materials');?></span>
                    <span class="fa fa-caret-right "></span>
                    </a>
                </li>
                <?php } ?>
                
                <?php if($this->amc_auth->check_myrole('remains')){ ?> 
                <li class="">
                    <a href="<?=base_url()?>index.php/doctors/home">
                    <i class="fa fa-folder"></i>
                
                    <span class="title"><?=$this->lang->line('doctors');?></span>
                    <span class="fa fa-caret-right "></span>
                    </a>
                </li>
                <?php } ?>

				<?php if($this->amc_auth->check_myrole('drug_store')){ ?>
                <li class="">
                    <a href="<?=base_url()?>index.php/pricing/home">
                    <i class="fa fa-folder"></i>
                
                    <span class="title"><?=$this->lang->line('material_price');?></span>
                    <span class="fa fa-caret-right "></span>
                    </a>
                </li>
                <?php } ?>
                
                <?php if($this->amc_auth->check_myrole('expense')){ ?> 
                <li class="">
                    <a href="<?=base_url()?>index.php/report/home">
                    <i class="fa fa-folder"></i>
                
                    <span class="title"><?=$this->lang->line('reports');?></span>
                    <span class="fa fa-caret-right "></span>
                    </a>
                </li>
                <?php } ?>

				<?php if($this->amc_auth->check_myrole('admin')){ ?> 
                <li class="">
                    <a href="<?=base_url()?>index.php/register/home/bill_list">
                    <i class="fa fa-folder"></i>
                
                    <span class="title"><?=$this->lang->line('pay_bill');?></span>
                    <span class="fa fa-caret-right "></span>
                    </a>
                </li>
                <?php } ?>
                
                <?php if($this->amc_auth->check_myrole('admin')){ ?>
                <li class="">
					<a href="<?=base_url()?>index.php/login/home">
					<i class="fa fa-folder"></i>
				
					<span class="title"><?=$this->lang->line('admin');?></span>
					<span class="fa fa-caret-right"></span>
					</a>
				</li>
                <?php } ?>

                
				<!--<li>
					<a href="javascript:;">
					<i class="fa fa-calculator"></i>
					<span class="title"><?=$this->lang->line('finance_management');?></span>
					<span class="selected"></span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="">
							<i class="fab fa-rev"></i>
							The Title Here</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:;">
					<i class="fa fa-chalkboard"></i>
					<span class="title"><?=$this->lang->line('class_management');?></span>
					<span class="selected"></span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="">
							<i class="fab fa-rev"></i>
							The Title Here</a>
						</li>
					</ul>
				</li>-->
               <?php ////if($this->amc_auth->check_myrole('search')){ ?>
				<!--<li >
					
					<a href="<?//=base_url()?>index.php/search/home">
					<i class="fa fa-search"></i>
					<span class="title"><?//=$this->lang->line('search');?></span>
					<span class="fa fa-caret-right"></span>
					</a>
				</li>-->
                <?php //} ?>

			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!--********************************* END SIDEBAR ******************************************-->