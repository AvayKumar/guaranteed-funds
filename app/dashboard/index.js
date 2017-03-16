define(['durandal/app', 'durandal/system', 'flipdown'], function (app, system) {
    return {
		attached : function() {
	       $('#timer').flipcountdown({size:"lg"});
        }
    }
});
