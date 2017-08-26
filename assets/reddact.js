// 
//
// 		REDDACT REWRITE - 2017
//		
///////////////////////////////////
/*

	Transmission Functions

*/
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
					//alert(action);
					reloadCoffers();
					$('.mission').prop('disabled',true).addClass('disabled');
						if(action === "neg")
							{
								$('.int').addClass('hidden');
								$('.neg').removeClass('hidden');
							}
						else
							{
								$('.int').addClass('hidden');
								$('.pos').removeClass('hidden');
							}
					 }
				});
	});
}
function reloadMenu()
{
		$('#cMenu').empty().html('<img src="assets/ajax-loader.gif" id="loader">');
		$('#cMenu').load('context_menu.php', function() { upgrade(); 	xpbar(xp); });
}
function reloadCoffers()
{
	$(function() { $("#navigation").load("cmenu-new.php"); });
}
function loadMap(x,y,z)
{
	sidebarUpgrade();
	if(z != 0)
		{
			$('#map').addClass('hell');
		}
	$('#map').load('map.php', {'x':x,'y':y,'z':z},
				   function() 
				   { 
					
					sinform();
					firstTime();
					}
				  );
}
function sidebarUpgrade()
{
	/* 
	
	
		THIS SHOULD BE UPDATED AT SOME POINT, ITS JUST C&P fROM OLD CODE
		
	
	*/
		
		$('#sidebar').off('click','dl');
		$('#sidebar').on('click', 'dl', function() {
					var id = $(this).attr('id');
			$.ajax({url:'upgrade_action.php', type:"POST", data:{'upgrade':id,'type':'upgrade'},
					complete: function(data){console.log(data); }, 
			success: function(data)
			{
				if(data == 'true')
				{
					$(function(){ $('#sidebar').load('upgrade.php'); reloadCoffers(); });
					
				}
				else
				{
					alert('you broke');	
				}
			}
			
			 });
		} ) 
}
function showSinfor()
{
	$('#sinfor').delay('slow').removeClass('hidden').addClass('show');
	exitSinfor();
	sUpgrade();
	cmac();
}
function exitSinfor()
{
	$('#sinfor').off('click','#exit a');
	$('#sinfor').on('click','#exit a',
	function()
	{
		$('#sinfor').addClass('hidden').removeClass('show');
		loadMap(x,y,z);
	});

}
function cmac()
{
	$('#holder #starinfo button').off('click');
	$("#holder #starinfo button").on("click", this, function(){ 
		var method = $(this).attr('id');
		var id = $(this).data('sid');
		$(this).prop("disabled", true).addClass('disabled');
		$.ajax({ 
			type:"POST",
			url: "cma.php",
			data: {uid:uid, sid:id, method:method, z:z},
			complete: function(data) { console.log(data);},
			success: function(data) {
				if(data == 1)
				{
					$(this).delay('slow').empty().fadeIn('1',function(){showSinfor();});
				$('#holder').load('sinfor.php', {sid:id}, function() { showSinfor();});
					var owned = '#'+id;
					if($(owned).hasClass('owned'))
						{
							$(owned).removeClass('unmined');
						}
					else
						{
							$(owned).addClass('owned');
						}
				}
				else
				{
					$('#holder button').effect('shake').prop('disabled', false).removeClass('disabled');
				}
								reloadCoffers();
			}
		})
	});
}
function firstTime()
{

}
//* System Upgrade Function; no longer requires sid to be passed for it to work; should probably include a ownership check in the server side
function sUpgrade()
{
	$('.supgrade').off('click');
	$('.supgrade').on('click', this,function(){
		var up = $(this).attr('id');
		var sid = $(this).data('sid');
		var obj = $(this);
		$.ajax({
			url:'upgrade_action.php',
			type:"POST",
			data:{'upgrade':up,sid:sid,type:'supgrade'},
			success:
				function(data){
					if(data == 'true') {
						$(obj).prop('disabled', true).addClass('disabled success');
						/*
							There's gotta be a better way to reload this without actually reloading the file each time
						*/
							$('#holder').load('sinfor.php', {sid:sid}, function() { showSinfor();});
					}
					else
						{
							$('.supgrade').prop('disabled', true).addClass('disabled failed').delay(1000).queue(
								function(){ $(this).removeClass('disabled failed');
										  });
						}
				}
			
		})
	})
}
function sinform()
{
	reloadMenu();
	$('#map').off('click','div div');
	$('#map').on('click', 'div div', function(){
		$('#sinfor').draggable();
		var type = $(this).attr('class').split(' ');
		var id = $(this).attr('id');
		switch(type[0])
		{
			case 'star':
				$('#holder').load('sinfor.php',{sid:id}, function() { 
						showSinfor(id);
							//sUpgrade(id);
				});
			break;
			case 'space':
				$('#holder').load('spaceDrop.php',{sid:id,'x':x,'y':y},
								  function()
								  {
									showSinfor();
									$(this).on('click', '#relay',function(){
										
										$(this).prop('disabled', true).addClass('disabled');
										$.ajax({
											type:"POST",
											url:'SPAC.php',
											data:{uid:uid,sid:id,x:x,y:y},
											complete: function(data) { console.log(data);},
											success: function(data){
												if(data == 1)
													{
														$('#holder').load('warpJump.php',{uid:uid});
														loadMap(x,y,z);
													}
												else
													{
														$('#relay').effect('shake').prop('disabled', false).removeClass('disabled');
													}
											}
											}
										)
									})
								  }
								 )
			break;
			case 'warp':
				$('#holder').load('warpJump.php',{uid:uid},function() { showSinfor();});
				break;
			case 'trans':
		var dtype = $(this).data('mtype');
		var action = $(this).data('action');
		var levels = $('#levels').data('levels');
		$('#holder').load('video.php',{'uid':uid,'dtype':dtype}, function()
		{				
			showSinfor();
			transmission();
			
		})
			break;
		}
	})
}
$(document).ready(function(){  })