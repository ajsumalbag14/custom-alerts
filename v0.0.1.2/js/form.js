/*  New window */
function Popup(apri) {
	var stile = "top=10, left=10, width=800, height=750 status=no, menubar=no, toolbar=no, scrollbars=yes";
	window.open(apri, "", stile);
}

function closeWin() {
		window.close();
}


function showPass(id,txt){
	var objid = document.getElementById(id);
	var objtxt = document.getElementById(txt);

	if(objid.checked == true)
  		objtxt.type = "text";
  	else
  		objtxt.type = "password";

}

/* Remarks Functions */

function closeRpt(){

	document.getElementById("err").style.display = "none";
	document.getElementById("loading").style.display = "block";

	var to_id = document.rem.elements['tid'].value;
	var body = document.rem.elements['body'].value;

	$.post('control/json_send_remarks.php',{to_id: to_id, body: body}, 
				function(data){
					if(data != 1)
					{
						document.getElementById("loading").style.display = "none";
						document.getElementById("err").style.display = "block";	
						$('#err').html(data);
					}
					else
					{
						document.getElementById("loading").style.display = "none";
						alert("Report successfully closed!");
						window.close();
					}
				});

}

/* End Message Functions */

/* Respose Function */

function sendResp(page,id){

	document.getElementById("err").style.display = "none";
	document.getElementById("loading").style.display = "block";

	var sel = document.resp.elements['dispcode'].selectedIndex;
	var disp = document.resp.elements['dispcode'].options[sel].value;
	//var sel2 = document.resp.elements['sanc'].selectedIndex;
	//var sanc = document.resp.elements['sanc'].options[sel2].value;
	var body = document.resp.elements['upe_comment'].value;

	$.post('modules/json_send_resp.php',{page: page, id: id, disp: disp,
				body: body}, 
				function(data){
					if(data != 1)
					{
						document.getElementById("loading").style.display = "none";
						document.getElementById("err").style.display = "block";	
						$('#err').html(data);
					}
					else
					{
						document.getElementById("loading").style.display = "none";
						alert("Feedback added.");
						document.location="feedback.php?page="+page+"&id="+id;
					}
				});

}

function editResp(id,crd,comp,stor){

	document.getElementById("err").style.display = "none";
	document.getElementById("loading").style.display = "block";

	var sel = document.resp.elements['dispcode'].selectedIndex;
	var disp = document.resp.elements['dispcode'].options[sel].value;
	var sel2 = document.resp.elements['sanc'].selectedIndex;
	var sanc = document.resp.elements['sanc'].options[sel2].value;
	var body = document.resp.elements['upe_comment'].value;
	var respid = document.resp.elements['respid'].value;
	var mode = 'edit';

	$.post('modules/json_send_resp.php',{disp: disp,
				sanc: sanc, body: body, respid: respid, mode: mode}, 
				function(data){
					if(data != 1)
					{
						document.getElementById("loading").style.display = "none";
						document.getElementById("err").style.display = "block";	
						$('#err').html(data);
					}
					else
					{
						document.getElementById("loading").style.display = "none";
						alert("Feedback updated.");
						document.location="feedback.php?page="+page+"&id="+id;
					}
				});

}

/* End Response Function */


function ruleParam(){

	var sel = document.getElementById("rule").selectedIndex;
	var val = document.getElementById("rule").options[sel].value;

	switch(val){

		case 'GT':
		case 'LT': 
			document.getElementById('param1').style.display = 'block';
			document.getElementById('param2').style.display = 'none';
			break;
		case 'BT': 
			document.getElementById('param1').style.display = 'block';
			document.getElementById('param2').style.display = 'inline';
			break;
		default: 
			document.getElementById('param1').style.display = 'none';
			document.getElementById('param2').style.display = 'none';
			break;
	}
}

function filterShow(){

	
	document.getElementById('region').style.display = 'none';
	document.getElementById('district').style.display = 'none';
	document.getElementById('store').style.display = 'none';
	document.getElementById('status').style.display = 'none';
	document.getElementById('manager').style.display = 'none';
	document.getElementById('loc_type').style.display = 'none';
	document.getElementById('lifestyle').style.display = 'none';
	document.getElementById('associate').style.display = 'none';
	document.getElementById('daypart').style.display = 'none';

	//var sel = document.getElementById("filter").selectedIndex;
	//var val = document.getElementById("filter").options[sel].value;
	var sel = document.getElementById( 'filter' );
	var select  = [];

	for (var i = 0; i < sel.length; i++) {
        if (sel.options[i].selected) select.push(sel.options[i].value);
    }
	
	console.log(select);

	for ( var i = 0, l = sel.options.length, o; i < l; i++ )
	{

		
	  	//console.log(select.options);
	  	o = sel.options[i];

		 if ( select.indexOf( o.text ) != -1 )
		 {
		    //o.selected = true;

		    switch(o.text){

				case 'REGION': 
					document.getElementById('region').style.display = 'block';
					break;
				case 'DISTRICT': 
					document.getElementById('district').style.display = 'block';
					break;
				case 'STORE': 
					document.getElementById('store').style.display = 'block';
					break;
				case 'STATUS': 
					document.getElementById('status').style.display = 'block';
					break;
				case 'MANAGER': 
					document.getElementById('manager').style.display = 'block';
					break;
				case 'LOCATION TYPE': 
					document.getElementById('loc_type').style.display = 'block';
					break;
				case 'CUST LIFESTYLE': 
					document.getElementById('lifestyle').style.display = 'block';
					break;
				case 'ASSOCIATE ID': 
					document.getElementById('associate').style.display = 'block';
					break;
				case 'DAY PART': 
					document.getElementById('daypart').style.display = 'block';
					break;
			}

		}
	}

	
	
	

}