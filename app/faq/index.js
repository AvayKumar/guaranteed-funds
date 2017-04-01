define(['durandal/app', 'knockout','durandal/system', 'plugins/router', 'settings'], function (app, ko, system, router, settings) {

	return {
		drop:function()
		{
			
			var that = event.target;
			that.classList.toggle("active");
			
			var panel = that.nextElementSibling;
			if(panel.style.display == 'block'){
				panel.style.display = "none";
			}
			else{
				panel.style.display = "block";
			}


			if (panel.style.maxHeight){
      			panel.style.maxHeight = null;
    		} 
    		else {
      		panel.style.maxHeight = panel.scrollHeight + "px";
    		} 

		}	

	};
});