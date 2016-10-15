var ajaxPending = false;
$(document).ready(function ()
{
	var apiUrl = '/manage/api.php?';

	// Team create
	var teamNameInput = $('#team-add-input');
	var teamCreateButton = $('#team-create');
	teamCreateButton.on('click', function()
	{
		var apiCall = apiUrl;
		apiCall += 'method=team';
		apiCall += '&action=add';
		apiCall += '&team_name=' + teamNameInput.val();
		runAjax(apiCall);
	});

	// Team remove
	var teamRemoveSelector = $('#team-remove-select');
	var teamRemoveButton = $('#team-remove');
	teamRemoveButton.on('click', function()
	{
		var apiCall = apiUrl;
		apiCall += 'method=team';
		apiCall += '&action=remove';
		apiCall += '&team_name=' + teamRemoveSelector.val();
		if (window.confirm('are you sure?'))
		{
			runAjax(apiCall);
		}
	});

	// Points
	var teamSelector = $('#team-selector');
	var pointsActionSelector = $('#points-action-select');
	var pointsButton = $('#points-button');
	var pointsAmountInput = $('#points-amount-input');
	pointsButton.on('click', function()
	{
		var apiCall = apiUrl;
		apiCall += 'method=points';
		apiCall += '&action=' + pointsActionSelector.val();
		apiCall += '&value=' + pointsAmountInput.val();
		apiCall += '&team_name=' + teamSelector.val();
		runAjax(apiCall);
	});
});

function runAjax(ajaxUrl)
{
	if (!ajaxPending)
	{
		ajaxPending = true;
		$.getJSON(ajaxUrl, function(data)
		{
			runAjaxCallback(data);
		});
	}
}

function runAjaxCallback(data)
{
	if (data.status < 200)
	{
		window.location.reload();
	}
	else if (data.status > 500)
	{
		showAlert(data.message);
	}
	ajaxPending = false;
}

function showAlert(message)
{
	var alert = $('#alert-message');
	alert.text(message);
	alert.show();
}