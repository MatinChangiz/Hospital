<!-- footer start -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 Developed By EasyNet
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>

<!-- new style loaded in this file  -->
<script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>


<!--******************************************chosen setup*************************************-->
<!--<script src="docsupport/jquery-3.2.1.min.js" type="text/javascript"></script> -->
<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url();?>assets/chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
<!--******************************************chosen setup*************************************-->


<script src="<?php echo base_url();?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/pages/scripts/components-editors.js"></script>
<script src="<?php echo base_url();?>assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>

<!-- for PopUp -->
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<!-- end of PopUp -->

<!-- END PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>

<script>
     $(".chosen-select").chosen({rtl: true}); 
     $(".chosen-select").chosen({rtl2: true}); 
     
$(document).ready(function(){
       $('.chosen-select').chosen();
       $('.chosen-select1').chosen();
       $('.chosen-select-rtl2').chosen();
       $('.chosen-select-rtl3').chosen();  
});
	function CheckAll(x)
	{

		
	    var allInputs = document.getElementsByName(x.name);
	    for (var i = 0, max = allInputs.length; i < max; i++) 
	    {
	        if (allInputs[i].type == 'checkbox')
	        if (x.checked == true)
	            allInputs[i].checked = true;
	        else
	            allInputs[i].checked = false;
	    }
	}

	jQuery(document).ready(function() {  
		// for editor
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		QuickSidebar.init(); // init quick sidebar
		Demo.init(); // init demo features
		ComponentsEditors.init();
	});
    
    
    var sheight = $(window).height();
    $(".page-sidebar.navbar-collapse").css({"min-height":sheight});
</script>
<!-- END JAVASCRIPTS -->

</body>
<!-- END BODY -->
</html>
<!-- footer ended -->