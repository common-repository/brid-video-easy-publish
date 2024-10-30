if(window['bridPlayersSelected']==undefined){
	//Store selected players by every wdiget instance
	window['bridPlayersSelected'] = [];
	window['bridChannelsSelected'] = [];
}
//Push widget selected info for each widget instance
function pushBridPlayer(playerName, selected){

	window['bridPlayersSelected'].push({ 'name' : playerName, 'selected' : selected});

}
function pushBridChannel(channelWidgetId, selected){

	window['bridChannelsSelected'].push({ 'name' : channelWidgetId, 'selected' : selected});

}
//Populate slecteboxes for widgets with already loaded players
function populatePlayers(){

		for(var i in bridPlayersSelected){
	      	var playersBridSelect = jQuery('#'+bridPlayersSelected[i].name);
	      	var playersBridSelected = bridPlayersSelected[i].selected;
	      	var a = '';
	      	for(var i in bridPlayers){
	      		var selected = '';
	      		
	      		if(playersBridSelected==bridPlayers[i]['Player']['id'])
	      			selected = 'selected';

	      		a += '<option value="'+bridPlayers[i]['Player']['id']+'" '+selected+'>'+bridPlayers[i]['Player']['name']+'</option>';
	      	}
	      	playersBridSelect.html('');
	      	playersBridSelect.append(a);

      	}
}

//Load and populate brid players
if(window['bridPlayers']==undefined)
{	
	
	window['bridPlayers'] = [], playersLoadInProgress = false;

	(function(){

		if(!playersLoadInProgress){
			playersLoadInProgress = true;

			jQuery.ajax({
		          url : ajaxurl,
		          type : 'POST',
		          data : 'action=playersList',
		      }).done(function(response){

		      	window['bridPlayers'] = response;

			    populatePlayers();
		      
		    }).fail(function(){

		    });

		}
		
	})();
}
jQuery(document).on('widget-updated', function(e, widget){

    populatePlayers();
    populateChannels();

});
