var SearchResults = 
{
	init: function()
	{
		var detailsLinks = document.getElementsByClassName('viewDetails');
		for (var count = detailsLinks.length, i = 0; i < count; i++)
		{
			detailsLinks[i].addEventListener('click', SearchResults.viewResult, false);
		}
	},
	
	viewResult: function()
	{
		var route = this.parentNode.getElementsByTagName('ol')[0];
		if (!route)
			return;
		
		route.style.display = 'block';
	}
};