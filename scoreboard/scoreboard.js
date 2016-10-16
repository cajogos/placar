var el = {};
$(document).ready(function()
{
	el.scoreboard = $('div.scoreboard');
	updateScoreboard();
	setInterval(function()
	{
		updateScoreboard();
	}, 500);
});

function updateScoreboard()
{
	$.getJSON('../teams.php', function(data)
	{
		updateScoreboardCallback(data);
	});	
}

function updateScoreboardCallback(data)
{
	data.sort(function(a, b) { return b.points - a.points; });
	var html = '<ul>';
	for (var i = 0; i < data.length; i++)
	{
		counter = i + 1;
		html += '<li>';
		html += '<span class="position">' + counter + '</span>';
		html += '<span class="name">' + data[i].name + '</span>';
		html += '<span class="points">' + data[i].points + '</span>';
		html += '</li>';
	}
	html += '</ul>';
	el.scoreboard.html(html);
}