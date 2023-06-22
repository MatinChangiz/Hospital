jQuery(document).ready(function() {  

   // for style

   $("div.cst").addClass("faq_content");
   $("a.shdn").addClass("faq_content");
   $(".customC tr.xcrud-row > td:nth-child(3)").addClass("faq_content");
   $("[data-orderby='n_stories.content']").addClass("faq_content");
   $("[data-orderby='tv_program.info']").addClass("faq_content");
   $(".faq_content").hide();
   $("div.cst:nth-child(1)").show();
   $(".col-md-5 .xcrud-row").addClass("prs");


   // if page load at first time
   $(".prs:nth-child(1)").addClass('cstyle');

   $(".cstyle").find('td:eq(1)').addClass('selected');
   var title = $(".selected").text();
   $(".ttl").attr("value", title);



   $(".cstyle").find('td:eq(0)').addClass('idt');
   var vs = $(".idt").text();
   $(".ids").attr("value", vs);


   $(".cstyle").find('td:eq(4)').addClass('fid');
   var f = $('.fid').text();
   $('.tid').attr("value",f);


   $('.prs').click(function () {
      $('.prs').removeClass('cstyle'); /* This '.HeadingDiv' could be anything, I need something dynamic here */
      $(this).addClass('cstyle');
      var content = $(this).closest("tr").find('td:eq(2)').html();
      $(".paragraphs").html(function() {
         return content;
      });

      $('td').removeClass('idt');
      $(this).closest("tr").find('td:eq(0)').addClass('idt');

      var vs = $(".idt").text();
      $(".ids").attr("value", vs);



      $("td").removeClass('fid');
      $(this).closest("tr").find('td:eq(4)').addClass('fid');

      var f = $('.fid').text();
      $('.tid').attr("value",f);
   });




   $(".col-md-5 .xcrud-row").click(function () {
      $('.col-md-5 .xcrud-row').removeClass('cstyle'); /* This '.HeadingDiv' could be anything, I need something dynamic here */
      $(this).addClass('cstyle'); 
   });


   $('.prs').hover(function(){
         $(this).css('cursor','pointer');
   });


   // for function submit

  $( ".portlet-body > .form-horizontal" ).submit(function() {  
      var txt = $("div.note-editable").html();
      $(".infos").html(txt);
  }); 

  
  $( ".form-horizontales" ).submit(function() {  
      var txt = $("div.note-editable").html();
      $(".infos").html(txt);
  }); 


    // editor update
    $(".faq_content1").hide();

    $('.fdIn').click(function() {

      $('.faq_content1').fadeToggle();

    });



    // category title
    $('.cts').change(function () {

        $('.cts option').each(function() {
            if($(this).is(':selected')) {
              var txt =  $(this).attr("id");
              $(".cat").attr("value", txt);
            }
        });
    });


   // check box
   $( "input" ).click(function() {
     // $( ".group-checkable" ).$( "input:checked" ).attr("value", 1);
     // var r = $(".group-checkable").is(':checked') ? 1 : 0;
     if ($(".ichk").is(':checked') == 1) {
         var c = $(this).attr("id");
         var d = c+",";
         $(".pcats").append(d);
     };

   });


   $( ".form-horizontales" ).submit(function() {  
      var t = $(".pcats").html();
      $(".pcategory").attr("value", t);
  });




  // at load
  $(".cstyle").find('td:eq(0)').addClass('selectedId');
   var s_id = $(".selectedId").text();
   $(".textid").attr("value", s_id);


  $('.prs').click(function () {

      $('td').removeClass('selected');
      $(this).closest("tr").find('td:eq(1)').addClass('selected');


      var title = $(".selected").text();
      $(".ttl").attr("value", title);




      $('td').removeClass('selectedId');
      $(this).closest("tr").find('td:eq(0)').addClass('selectedId');


      var s_id = $(".selectedId").text();
      $(".textid").attr("value", s_id);

  });


  // print
  $(".fstBtn").click(function() {
    $(".table-striped,.portlet-title,.editor_content").removeClass("shw");
    $(".table-striped,.portlet-title,.editor_content,.col-md-5").removeClass("hde");
    $(".table-striped").addClass("shw");
    $(".portlet-title,.editor_content,.footer,.fstBtn,hr,.col-md-7").addClass("hde");

    window.print();
  });

  

  $(".sndBtn").click(function() {
    $(".table-striped,.portlet-title,.editor_content").removeClass("shw");
    $(".table-striped,.portlet-title,.editor_content").removeClass("hde");
    $(".editor_content").addClass("shw");
    $(".portlet-title,.table-striped,.footer,.fstBtn,.col-md-5,.fdIn,.editor,hr").addClass("hde");

    window.print();
  });

  $(".sub-menu,ul,li").click(function() {
    $(this).toggleClass("o");
  });


  $('ul.o li').click(function(e) {
    $(this).addClass('selected');
  });

});

//load requested page
function bring_page(url="",div){
	$.ajax({
		type: 'POST',
		url: url,
		data: '',
		success: function(response){
			//$('#'+div).html(response);
			 window.location = url;
		}
	});
}

//update
function doit(url="",id){
    var param = "&urn="+id;
    $.ajax({
        type: 'POST',
        url: url,
        data: param,
        success: function(response){
            location.reload();
        }
    });
}

//check if don't exist show message
function checkNumber(url="",id,div){
    var val = document.getElementById(id).value;
    var param = "&no="+val;
    $.ajax({
        type: 'POST',
        url: url,
        data: param,
        success: function(response){
            document.getElementById(div).innerHTML = response;
        }
    });
}

//dropdown onchange
function loadOnchange(url="",id,div){
    var val = document.getElementById(id).value;
    var param = "&no="+val;
    $.ajax({
        type: 'POST',
        url: url,
        data: param,
        success: function(response){
            document.getElementById(div).innerHTML = response;
            console.log("done");
        }
    });
}

function goBack() {
  window.history.back();
}

//dropdown onchange
function loadValue(id,div){
    var url = document.getElementById(id).value; 
    var param = "&no=''";
    $.ajax({
        type: 'POST',
        url: url,
        data: param,
        success: function(response){
            //document.getElementById(div).innerHTML = response;
            window.location = url;
        }
    });
}

function selectAll(aid,oclass){ 
    $('#'+aid).click(function(){
        if($(this).prop("checked")) {
            $("."+oclass).prop("checked", true);
        } else {
            $("."+oclass).prop("checked", false);
        }                
    });


    $('.'+oclass).click(function(){
        if($("."+oclass).length == $("."+oclass+":checked").length) {
            $("#"+aid).prop("checked", true);
        }else {
            $("#"+aid).prop("checked", false);            
        }
    });
}

function showHide(aid,oid){
    $('#'+aid).click(function(){
        if($(this).prop("checked")) {
            $("#"+oid).show();
        } else { 
            $("#"+oid).hide();
        }                
    });
}

//admore function
intTextBox = 1;
function addmore(div, div2, counter){
    if(intTextBox == 1 && counter >0){
        intTextBox = (counter + 1);
    }else {
        intTextBox = intTextBox+1; 
    }
    var contentID = document.getElementById(div2);
    var newTBDiv = document.createElement("table");
    newTBDiv.setAttribute("id","childDv2"+intTextBox);
    newTBDiv.setAttribute("class","table");
    var getopt = document.getElementById(div).innerHTML;
    newTBDiv.innerHTML = intTextBox+"<input type='button' class='btn btn-danger' id='rmbtn' name='rmbtn' value='-' onclick="+'"'+"javascript:removeElement('"+div2+"','"+intTextBox+"');"+'"'+">"+getopt;
    //newTBDiv.innerHTML = intTextBox+"<tr> <td scope='col' width='100%' class='iEntry' colspan='3'> <input type='button' class='btn btn-danger' value='-' onclick="+'"'+"javascript:removeElement('"+div2+"','"+intTextBox+"');"+'"'+">"+getopt+"</td></tr>";
    contentID.appendChild(newTBDiv);
}

//remove element function
function removeElementXXx(condivId,inpId){
    if(intTextBox != 0){
        var contentID = document.getElementById(condivId);
        contentID.removeChild(document.getElementById("childDv2"+inpId));
        intTextBox = inpId-1;
    }
}

//add multiple function
function addMultiple(url, div, counter){
    //counter = counter+1;
    if(intTextBox == 1 && counter >0){
        intTextBox = (counter + 1);
    }else {
        intTextBox = intTextBox+1; 
    }
    var param = "&no="+intTextBox;
    $.ajax({
        type: 'POST',
        url: url,
        data: param,
        success: function(response){
            //document.getElementById(div).innerHTML = response;
            $("#"+div).append(response);
        }
    });   
}

function removeElement(tardivid,inpId){
    if(intTextBox != 0){
        $("#"+tardivid).remove();
        intTextBox = inpId-1; 
    }
}

//function that make total of number
function totalThePrice(price,amount,totals){
    var priceVal = document.getElementById(price).value;  
    var amountVal = document.getElementById(amount).value; 
    if(amountVal == null || amountVal == ''){
        amountVal = 1;
    }
    var totalVal =  priceVal*amountVal;
    document.getElementById(totals).value = totalVal
}

//function that read url of added picture
function readURL(input,imgid){
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#'+imgid).attr('src',e.target.result).height(178);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

//check if don't exist show message
function check_duplicate(url="",id,div){
    var val = document.getElementById(id).value;  
    var param = "&no="+val;
    $.ajax({
        type: 'POST',
        url: url,
        data: param,
        success: function(response){
            document.getElementById(div).innerHTML = response;
            if(response != ''){
                document.getElementById('save_user').disabled=true;
            }else{
                document.getElementById('save_user').disabled=false;
            }
        }
    }); 
}

//for the buckup
function bringForm(id,div,form_code = ""){
    var url = document.getElementById(id).value; 
    if(form_code != ''){
        var param = "&no="+form_code;
    }else{
        var param = "&no=''";
    }
    $.ajax({
        type: 'POST',
        url: url,
        data: param,
        success: function(response){
            document.getElementById(div).innerHTML = response;
            //window.location = url;
        }
    });
}

//toggle function
function toggleThis(id,hide_btn,show_btn){
    $("#"+id).slideToggle("slow");
    $("#"+hide_btn).hide();
    $("#"+show_btn).show();
}

//pass the value to the controller
function submitSearch(url="",id, tardiv){       
    var formId = document.getElementById(id);
    var form_data = $(formId).serialize(); //Encode form elements for submission
    $.ajax({
        url : url,
        type: "POST",
        data : form_data
    }).done(function(response){ //
        $("#list_div1").html(response);
    });   
}

//pass the value to the controller
function print_report(url="",id){       
    var formId = document.getElementById(id);
    var form_data = $(formId).serialize(); //Encode form elements for submission
    $.ajax({
        url : url,
        type: "POST",
        data : form_data
    }).done(function(response){ //
        console.log('Work done');
    });   
}

/*load a content  by ajax with strign post data  */
function load_page_pagination(page,divname,starting,str)
{
     //alert(is_csrf);
     /*
      page: the server page where an ajax trigers
      starting: starting record 
      divname: where to display the server response text
      str: string where a user can send custome post data
     */
     //alert(str);
     // check the global variable.
     var url=page;

     var params='&starting='+starting+'&'+str;
     //alert(params);
     //call ajax 
     makerequest_sp(url, params, divname);
}



var xmlhttp_sp = false;
var is_csrf = true;
try {
//If the Javascript version is greater than 5.
      xmlhttp_sp = new ActiveXObject("Msxml2.XMLHTTP");

    } catch (e) {
//If not, then use the older active x object.
try {

       xmlhttp_sp = new ActiveXObject("Microsoft.XMLHTTP");

} catch (E) {
//Else we must be using a non-IE browser.
              xmlhttp_sp = false;
            }
}

if (!xmlhttp_sp && typeof XMLHttpRequest != 'undefined') {
          xmlhttp_sp = new XMLHttpRequest();

}
/*ajax request function*/
function makerequest_sp(serverPage, params, objID)
{ 
    /*add a random number at the end of parammeters*/
    var myRandom=parseInt(Math.random()*99999999);
    params+='&'+myRandom;
    //alert(params);
    //set url
    var url = serverPage;
    //set xml method to POST
    xmlhttp_sp.open("POST", url, true);
    //Send the proper header information along with the request
    xmlhttp_sp.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=UTF-8");
    xmlhttp_sp.setRequestHeader("Content-length", params.length);
    xmlhttp_sp.setRequestHeader("Connection", "close");
    xmlhttp_sp.onreadystatechange = function() {//Call a function when the state changes.
        if(xmlhttp_sp.readyState == 4 && xmlhttp_sp.status == 200) {
            document.getElementById(objID).innerHTML = xmlhttp_sp.responseText;
            
        }
    }
    
    //send parameters
    xmlhttp_sp.send(params);    
   
}


//print excel
function do_it2 (url,fname){    
    if (fname != '')
    {
         document.getElementById(fname).action = url;
        var form = document.getElementById(fname);
        form.submit();
    } 
    else 
    {
        return false;
    }
}

//function of get and set value
function bringPatientName(url,p_id, divid){
    var pid_val = document.getElementById(p_id).value; 
    if(pid_val != ''){
        var param = "&pid="+pid_val;
        $.ajax({
            type: 'POST',
            url: url,
            data: param,
            success: function(response){
                document.getElementById(divid).value = response;
                //window.location = url;
            }
        });
    }
}

//function of get and set value
function bringPrice(url,p_id, divid,doc_id,amount){
	var pid_val 	= document.getElementById(p_id).value; 
	var docid_val 	= document.getElementById(doc_id).value;
	var amountVal = Number(document.getElementById(amount).value);  
    if(pid_val != '' && docid_val != ''){
        var param = "&pid="+pid_val+"&dr_urn="+docid_val;
        $.ajax({
            type: 'POST',
            url: url,
            data: param,
            success: function(response){
                document.getElementById(divid).value = response;
				var resNumber 	= Number(response);
				var totalVal 	=  amountVal*resNumber;
				document.getElementById('total_price').value = totalVal
                //window.location = url;
            }
        });
    }
}

//function that make total of number
function totalTheFee(amount,price,total_price){
	var amountVal = Number(document.getElementById(amount).value);  
	var priceVal = Number(document.getElementById(price).value);
	alert(priceVal);
	if(amount !='0' && price !='0'){
		var totalVal =  amountVal*priceVal;
		document.getElementById(total_price).value = totalVal
	}else{
		document.getElementById(total_price).value = ""
	}
}