function blinker(selector) {
    $(selector).fadeOut(500);
    $(selector).fadeIn(500);
}


function reloadCoffers()
{
	$(function() { $("#navigation").load("cmenu-new.php"); });
}
function sUpgrade(id)
{
	$(".supgrade").off("click", this);
	$('.supgrade').on('click', this, function() {
		var up = $(this).attr('id');
		$.ajax({url:'upgrade_action.php', type:"POST", data:{'upgrade':up,'sid':id,'type':'supgrade'}, success:
		function(data) {
			$('#holder').html("<img src='assets/ajax-loader.gif' id='loader''>");
			$('#holder').load('sinfor.php',{sid:id}, function() 
			{ 
					reloadCoffers();
					sUpgrade(id)
						});
		} })
		 });
}
function loadMap(x,y,z)
{
	if(z != 0)
	{
		$('#map').addClass('hell');	
	}
	$('#map').load('map.php', {'x':x,'y':y,'z':z});	
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
				complete: function(data) { console.log(data);
				 },
				success:function(data) {
					if(levels >= 2){
						$('.mission-text').html(data); 
						$('.mission-actions').empty(); 
					$('#sinfor #exit a').on('click',function() { 
					$('#sinfor').addClass('hidden');
					$('#sinfor #holder').empty();
					reloadCoffers();
				 });
					}
					else
					{
					$('#sinfor').addClass('hidden');
					$('#holder').empty();
					loadMap(x, y,z);
					reloadCoffers();
					}
					 }
				});
	});
	$('.mission').off('click','.mission');
}
$(document).ready(function() {
	/* 
		Main Upgrade Stuff 
	*/
	$('#map').off('click', 'div div');
	$('#map').on('click', 'div div',function()
	{
		$('#sinfor').draggable();
		var type = 	$(this).attr('class').split(' ');
		var id = $(this).attr('id');
		switch(type[0])
		{
			case 'star':
			$('#holder').load('sinfor.php',{sid:id}, function() {
						sUpgrade(id);
							$('#sinfor').removeClass('hidden').addClass('show');
				$('#holder button').on('click', this, 
					function() {
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
										reloadCoffers();
										$('#holder').empty();
										$('#holder').html('<img src="assets/ajax-loader.gif" id="loader">');
													$('#holder').load('sinfor.php',{sid:id},function() { sUpgrade(id) });
									}
									if(data == 0)
									{
										reloadCoffers();
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
			});

			break;
			case 'space':
						$('#holder').html("<img src='assets/ajax-loader.gif' id='loader''>");
						$('#holder').load('spaceDrop.php',{sid:id,'x':x,'y':y}, function() 
						{ 
						$('#sinfor').removeClass('hidden').addClass('show');
						$(this).on('click', '#relay',function() {
								$(this).prop('disabled', true).addClass('disabled');
								$.ajax({ 
									type:"POST", 
									url:'SPAC.php',
									data:{uid:uid,sid:id,x:x,y:y},
									complete: function(data) { 
									console.log(data); },
									success: function(data) { 
										if(data == 1)
										{
											/* This should probably be altered to actually show the warp selector */
											$('#holder').load('spaceDrop.php',{sid:id,'x':x,'y':y});
											loadMap(x,y,z);
											reloadCoffers();
										}
										else
										{
											alert('you broke!');	
										}
									 }
								});
							});

						});
			break;
			case 'warp':
			$('#holder').load('warpJump.php',{'uid':uid},function() {$('#sinfor').removeClass('hidden').addClass('show'); });
			break;
			case 'trans':
			var dtype = $(this).data('mtype');
			$('#holder').load('video.php',{'uid':uid,'dtype':dtype},function() {$('#sinfor').removeClass('hidden').addClass('show'); 
			transmission();
			} );
			break;
		}
		$('#exit a').on('click', this, function() { $('#sinfor').removeClass('show').addClass('hidden'); $('#holder').empty(); loadMap(x,y,z); });
	});
	$(function() { $('#sidebar').on('click', 'dl', function() {
					var id = $(this).attr('id');
			$.ajax({url:'upgrade_action.php', type:"POST", data:{'upgrade':id,'type':'upgrade'},success: function(data)
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
		} ) })
	setInterval(blinker('.low', 1000));
})