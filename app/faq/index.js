define(['durandal/app', 'knockout','durandal/system', 'plugins/router', 'settings'], function (app, ko, system, router, settings) {

	return {
		func:function()
		{
			$(document).ready(function(){
				$('#f1').text('1');
				$('#f1').attr("visibility", "visible");

			})
		}	


	};
});