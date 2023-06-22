<div class="row iRow">
  <div style="padding:0px 10px 0px 10px;">
    <div class="">
      <img src="<?php echo base_url();?>assets/images/covor.jpg" class="profpic" style="width:100%;height:130px;border:1px solid #aaa;box-shadow: 0px 1px 1px 0px #bbb;">
      <!--<h3 style="display:inline;"><?=$this->lang->line('hospital_system');?></h3>-->
    </div>
  </div>
  <div id="changeable">
      
      <?php if($this->amc_auth->check_myrole('reception')){ ?>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 iPanel">
        <div class="card text-white bg-primary mb-3 trnsition" style="max-width: 18rem;" onclick="javascript:bring_page('<?=base_url()?>index.php/register/home/','changeable')">
          <div class="card-header"><?=$this->lang->line('register_part');?></div>
          <div class="card-body">
            <i class="fa fa-folder"></i>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if($this->amc_auth->check_myrole('drug_store')){ ?> 
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 iPanel">
        <div class="card text-white bg-primary mb-3 trnsition" style="max-width: 18rem;" onclick="javascript:bring_page('<?=base_url()?>index.php/materials/home','changeable')">
          <div class="card-header"><?=$this->lang->line('materials');?></div>
          <div class="card-body">
            <i class="fas fa-folder"></i>
          </div>
        </div>
      </div>
      <?php } ?> 

      <?php if($this->amc_auth->check_myrole('remains')){ ?> 
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 iPanel">
        <div class="card text-white bg-primary mb-3 trnsition" style="max-width: 18rem;" onclick="javascript:bring_page('<?=base_url()?>index.php/doctors/home','changeable')">
          <div class="card-header"><?=$this->lang->line('doctors');?></div>
          <div class="card-body">
            <i class="fa fa-folder"></i> 
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if($this->amc_auth->check_myrole('drug_store')){ ?> 
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 iPanel">
        <div class="card text-white bg-primary mb-3 trnsition" style="max-width: 18rem;" onclick="javascript:bring_page('<?=base_url()?>index.php/pricing/home','changeable')">
          <div class="card-header"><?=$this->lang->line('material_price');?></div>
          <div class="card-body">
            <i class="fas fa-folder"></i>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if($this->amc_auth->check_myrole('expense')){ ?> 
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 iPanel">
        <div class="card text-white bg-primary mb-3 trnsition" style="max-width: 18rem;" onclick="javascript:bring_page('<?=base_url()?>index.php/report/home','changeable')">
          <div class="card-header"><?=$this->lang->line('report');?></div>
          <div class="card-body">
            <i class="fa fa-folder"></i>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if($this->amc_auth->check_myrole('admin')){ ?> 
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 iPanel">
        <div class="card text-white bg-primary mb-3 trnsition" style="max-width: 18rem;" onclick="javascript:bring_page('<?=base_url()?>index.php/register/home/bill_list','changeable')">
          <div class="card-header"><?=$this->lang->line('pay_bill');?></div>
          <div class="card-body">
            <i class="fa fa-folder"></i>
          </div>
        </div>
      </div>
      <?php } ?>

  </div>
</div>