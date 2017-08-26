/*
Reddact Javascript File Version
0.0.1.01

*/


/* Code by ge∅  */
function hasClass(el, name) {
    return new RegExp('(\\s|^)' + name + '(\\s|$)').test(el.getAttribute("class"));
}

function getParentByClassName(elem, className) {
    var node = elem;
    while (node !== null && node !== document.documentElement) {
        if (hasClass(node, className)) {
            return node;
        }
        node = node.parentNode;
    }
    return null;
}

function getParentByClassNames(elem, classNames) {
  for (var i = 0, j = classNames.length; i < j; i++) {
    var node = getParentByClassName(elem, classNames[i]);
    if (node !== null) {
    	return node;
    }
  }
  return null;
}


/* Rest of the Code */
function plopRelay(id)
{
	$('#spacedrop').on('click','button',function() {
		$(this).prop('disabled', true).addClass('disabled');
		$.ajax({ 
		type:"POST", 
		url:'SPAC.php',
		data:{uid:uid,sid:id,x:x,y:y},
		complete(data) { console.log(data); },
		success: function(data) { 
			if(data == 1) { $('#spacedrop').load('spaceDrop.php',{sid:id,x:x,y:y},
				function() 
				{ 
					loadMap(x,y,z); 
				}) 
			}
			else 
			{
			$('#spacedrop button').prop("disabled", false).removeClass('disabled').effect
										('shake', { direction: 'left', 
													times: 1}); } 
			}
		})
		
	 } );
	 $('#sinfor #exit a').on('click',function() {
		$('#sinfor').addClass('hidden');
		$('#sinfor #holder').empty();
		loadMap(x,y,z);
		});	
	 
}
function videoPop()
{
	$('#map').click('click','.trans',function(){
				$('#sinfor').removeClass('hidden').draggable();
			$('#holder').html("<img src='assets/ajax-loader.gif' id='loader''>");
						$('#holder').load('video.php');
			$('#sinfor #exit a').on('click',function() { 
				$('#sinfor').addClass('hidden');
				$('#sinfor #holder').empty();
				 });
	});
}
function CMA(id)
{
		$('#starinfo').on('click','button',
			function(){
						var method = $(this).attr('id');
	
						$(this).prop("disabled", true).addClass('disabled '); 
							$.ajax({
									type:"POST",
									url: "cma.php",
									data: {uid:uid, sid:id, method:method, z:z},
									complete: function(data) { 
									console.log(data); },
									success: function(data) {
									if(data == 1)
									{
										reloadMenu();
										$('#holder').empty();
										$('#holder').html('<img src="assets/ajax-loader.gif" id="loader">');
													$('#holder').load('sinfor.php',{sid:id}, function() 
													{ 
													sUpgrade(id);
													CMA(id);
													});
									}
									if(data == 0)
									{
										reloadMenu();
										$('#starinfo button').prop("disabled", false).removeClass('disabled').effect
										('shake', { direction: 'left', 
													times: 1});
										
									}
									if(data == 2)
									{
									location.reload(true);	
									}
									}
								});
							})	
}
function sUpgrade(id)
{
	$('.supgrade').on('click', this, function() {
		var up = $(this).attr('id');
		$.ajax({url:'upgrade_action.php', type:"POST", data:{'upgrade':up,'sid':id,'type':'supgrade'}, success:
		function(data) {
			$('#holder').html("<img src='assets/ajax-loader.gif' id='loader''>");
			$('#holder').load('sinfor.php',{sid:id}, function() 
			{ 
							CMA(id);
							upgrade();
							sUpgrade(id);
							reloadMenu();
						});
		} })
		 });
}
function upgrade()
{
	bresource();
		xpbar(xp);
	$('#cMenu').off('click', '.upgrades .upgrade');
	$('#cMenu').on('click', '.upgrades .upgrade', 
		function() { 
		var id = $(this).attr('id');
			$.ajax({url:'upgrade_action.php', type:"POST", data:{'upgrade':id,'type':'upgrade'}, success: function(data) {
				if(data == 'true')
				{
					reloadMenu();
				}
				else
				{
					$('#error').dialog({
						height: 'auto',
						width: 300,
						modal: true,
						dialogClass: 'dlgfixed',
						position: "center",
						center: true
					});
				}
				 }
			});
			
			});
}
function transmission()
{
	$('.mission').on('click',this,
	function() { 
		var action = $(this).data('action');
		var dtype = 	$(this).data('missiontype');
		var levels = $('#levels').data('levels');
			$.ajax({
				type:"POST",
				url:"mission.php",
				data:{'dtype':dtype,'action':action},
				complete(data) { console.log(data);
				 },
				success:function(data) {
					if(levels >= 2){
						$('.mission-text').html(data); 
						$('.mission-actions').empty(); 
					$('#sinfor #exit a').on('click',function() { 
					$('#sinfor').addClass('hidden');
					$('#sinfor #holder').empty();
					loadMap(x, y,z);
					reloadMenu();
				 });
					}
					else
					{
					$('#sinfor').addClass('hidden');
					$('#holder').empty();
					loadMap(x, y,z);
					reloadMenu()
					}
					 }
				});
	});
}

function toggle() {
	var name = $(this).attr('name');
  checkboxes = document.getElementsByName('');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
function bresource()
{
		resource();
	$('#bresource').off('click', 'button'); 
	$('#bresource').on('click', 'button',function(event) { 
		event.preventDefault();
		var type = $(this).attr('id'); 
		$.ajax(
			{
				url:'buyfuel.php', 
				type:"POST", 
				data:{fuel:type}, 
				dataType:"text",
				success: function(data) { 

				if(data == 'true')
				{
				reloadMenu();		
				}
				else
				{
				$('#error').dialog({
						height: 'auto',
						width: 300,
						modal: true,
						dialogClass: 'dlgfixed',
						position: "center",
						center: true
					});
				}
				}
		 } );	
	})
}
function openEventWindow()
{
	$('#map').load('map.php', {'x':x,'y':y,'z':z}, function() { 
	$('#map .space').on('click', this, function() {
			var id = $(this).attr('id');
			transmission();
			$('#sinfor').removeClass('hidden').draggable();
			$('#holder').html("<img src='assets/ajax-loader.gif' id='loader''>");
						$('#holder').load('spaceDrop.php',{sid:id,'x':x,'y':y}, function() 
						{ 
							plopRelay(id);
							upgrade();
							sUpgrade(id);
						});
			$('#sinfor #exit a').on('click',function() { 
				$('#sinfor').addClass('hidden');
				$('#sinfor #holder').empty();
				 });
	});
	$('#map .warp').on('click', this, function() { 
		$('#sinfor').removeClass('hidden').draggable();
		$('#holder').html("<img src='assets/ajax-loader.gif' id='loader'>");
		$('#holder').load('warpJump.php',{'uid':uid}, function()
		{				
							upgrade();
							transmission();	
				$('#sinfor #exit a').on('click',function() { 
				$('#sinfor').addClass('hidden');
				$('#sinfor #holder').empty();
				 });	
		});
	});
	$('#map .trans').on('click', this, function() { 
		var dtype = $(this).data('mtype');
		$('#sinfor').removeClass('hidden').draggable();
		$('#holder').html("<img src='assets/ajax-loader.gif' id='loader'>");
		$('#holder').load('video.php',{'uid':uid,'dtype':dtype}, function()
		{				
							upgrade();
							transmission();
				$('#sinfor #exit a').on('click',function() { 
				$('#sinfor').addClass('hidden');
				$('#sinfor #holder').empty();
				
				 });	
		});
	});
	$('#map .star').on('click', this,
	function() 
		{
			
			var id = $(this).attr('id');
			$('#sinfor').removeClass('hidden').draggable();
			$('#holder').html("<img src='assets/ajax-loader.gif' id='loader''>");
						$('#holder').load('sinfor.php',{sid:id}, function() 
						{ 
							CMA(id);
							upgrade();
							sUpgrade(id);;
						});
		})})
}
function loadMap(x, y,z)
{
	if(z != 0)
	{
		$('#map').addClass('hell');	
	}
	bresource();
	openEventWindow();
}
function reloadMenu()
{
		$('#cMenu').empty().html('<img src="assets/ajax-loader.gif" id="loader">');
		$('#cMenu').load('context_menu.php', function() { upgrade(); 	xpbar(xp); });	
}
function resource()
{
	$('#bresource').on('click', this, function(){ 
		$('#dres').removeClass('hide'); 
		$('#bresource').on('click', this, function () { 
			$('#dres').addClass('hide'); resource(); });
		});
	
}
function xpbar(xp)
{

	$('#progressbar').progressbar(
	{
		 value: xp
		 
	});	
	$("#progressbar").css({ 'background': 'url(images/white-40x100.png) #0B8F78 repeat-x 50% 50%;' });
    $("#progressbar").css({ 'background': 'url(images/lime-1x100.png) #0B8F78 repeat-x 50% 50%;' });
}
function tut(firstTime)
{
	if(firstTime == 1)
	{
		$('<div />').html(
		"<h4>Hello and welcome to Reddact Game!</h4>"+
		"<p>To get started, click on the Star Map button!</p>"+
		"<p>This tutorial is still under work, so i appologize if it keeps poping up</p>").dialog();
		$('#smbut').on('click',function() { var tutorialLevel = 'sm'; })
	}
}
function forceEncounter()
{
	$('#forcedEncounter').off('click','button');
	$('#forcedEncoutner').load('encounterText.php');
	$('#forcedEncounter').removeClass('hidden');
	$('#forcedEncounter').on('click','.actionButton',function() { 
		var data = $(this).data('type');
		var eid = $(this).data('eid');
		$.ajax({
			url: "encounters.php",
			type:"POST", 
			data: {'data':data,'eid':eid},
			complete(data) { console.log(data); },
			success: function(data) { 

			$('#forcedEncounter .exit').removeClass('hidden');
			$('#forcedEncounter .action').addClass('hidden');
			$('#forcedEncounter .body').html(data);
			$('#forcedEncounter').on('click','.encit',function () { 
							reloadMenu();
				$('#forcedEncounter').addClass('hidden'); } );
			}
		})
	
	 } );
}
$(document).ready(function() {

if(typeof(forcedEncounter) != "undefined" && forcedEncounter !== null)
	{
	if(forcedEncounter == true)
	{
		forceEncounter();
	}
	}
	$(document).tooltip({
		tooltipClass: 'warning-tooltip', 
        at: 'center left',
        my: 'center left',
		show: {
		effect: 'slideDown',
		delay: 200 },
		hide: { effect: 'slideUp', delay: 0 }
		});
			$('#sinfor #exit a').on('click',function() { 
				$('#sinfor').addClass('hidden');
				loadMap(x, y,z);
				reloadMenu()
				$('#sinfor #holder').empty();
				 });
	upgrade();
});
