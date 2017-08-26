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
									success: function(data) {
			
									if(data == 1)
									{
										$('#cMenu').empty().html("<img src='assets/ajax-loader.gif' id='loader'>");
										$('#cMenu').load('context_menu.php', function() { upgrade(); });
										$('#holder').empty();
										$('#holder').html("<img src='assets/ajax-loader.gif' id='loader'>");
													$('#holder').load('sinfor.php',{sid:id}, function() 
													{ 
														CMA(id);
													});
										$('#sinfor #exit a').on('click',function() {
											$('#sinfor').addClass('hidden');
											$('#sinfor #holder').empty();
											loadMap(x,y,z);
											 });
									}
									}
								});
							})	
}
function upgrade()
{
	bresource();
	$('#upgrade_holder').off('click', '.upgrade');
	$('#upgrade_holder').on('click', '.upgrade', 
		function() { 
		var id = $(this).attr('id');
			$.ajax({url:'upgrade.php', type:"POST", data:{'upgrade':id}, success: function(data) {
				if(data == 'true')
				{
					$('#cMenu').empty().html("<img src='assets/ajax-loader.gif' id='loader'>");
					$('#cMenu').load('context_menu.php', function() { upgrade(); });	
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
				$('#cMenu').load('context_menu.php', function() { upgrade(); });		
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
function loadMap(x, y,z)
{
	bresource();
	$('#map').load('map.php', {'x':x,'y':y,'z':z}, function() { 
	$('#map .star').on('click',
	function() 
		{
			
			var id = $(this).attr('id');
			$('#sinfor').removeClass('hidden').draggable();
			$('#holder').html("<img src='assets/ajax-loader.gif id='loader''>");
						$('#holder').load('sinfor.php',{sid:id}, function() 
						{ 
							CMA(id);
							upgrade();
						});
			$('#sinfor #exit a').on('click',function() { 
				$('#sinfor').addClass('hidden');
				$('#sinfor #holder').empty();
				 });
		})})
}
function resource()
{
	$('#bresource').on('click', this, function(){ 
		$('#dres').removeClass('hide'); 
		$('#bresource').on('click', this, function () { 
			$('#dres').addClass('hide'); resource(); });
		});
	
}
$(document).ready(function() {
	loadMap(x, y,z);
	if(z != 0)
	{
		$('#map').addClass('hell');	
	}
	upgrade();
});
