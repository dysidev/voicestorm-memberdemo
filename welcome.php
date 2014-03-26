<?php $title="Welcome"; include 'header.php'; ?>
<ol class="welcomeWizard clearfix">
	<li class="first current">
		<div>
			<span>1</span>
		</div>
		<span id="outer-connector">
			<span id="inner-connector"><span></span></span>		
		</span>
	</li>
	<li class="">
		<div>
			<span>2</span>
		</div>
		<span id="outer-connector">
			<span id="inner-connector"><span></span></span>		
		</span>
	</li>
	<li class="last">
		<div>
			<span>3</span>
		</div>
		<span id="outer-connector">
			<span id="inner-connector"><span></span></span>		
		</span>
	</li>
</ol>
<div class="container welcomeSteps">
	<div class='contactContent'></div>
	<div class="topContent"></div>
	<div class="bottomContent"></div>
	<button class="btn btn-primary col-sm-offset-10" id="btnNext" data-bind="click: btnNext">Next &rarr;</button>
</div>

<script type="text/javascript">
    SampleSite =
    {
        Page:
        {
            Init: function()
            {
                VoiceStorm.currentUser().then(SampleSite.Page.welcomePag).fail(SampleSite.UserNotSignedIn);
            },
            welcomePag: function()
            {
            	$('.welcomeWizard li:nth-of-type(1)').addClass('current');
            	$('#btnNext').hide();
            	$('.contactContent').VoiceStormProfileContact(
            	{
            		submitButtonClass: "btn btn-primary",
            		submitCallback: function(result)
                    {
                        if(result.status=="success")
                        {
                        	$('.welcomeWizard li:nth-of-type(1)').removeClass('current');
                        	$('.welcomeWizard li:nth-of-type(2)').addClass('current');
                        	$('#btnNext').show();
                        	$(".contactContent").empty();
                        	$('.bottomContent').attr('id', 'addChannels');
                        	$('.topContent').attr('id', 'connectedChannels');
	                     	$('.bottomContent').VoiceStormProfileAddChannels(
                        	{
                        		submitCallback: function(result)
                    			{
			                        if(result.status=="success")
			                        {
			                        	SampleSite.alertMessage("alertMessage", "success", "Channel added successfully");
			                            $(".topContent").VoiceStormProfileChannels('refresh');
			                        }
			                        else
			                        {
			                            SampleSite.alertMessage("alertMessage", "danger", "Error adding the channel");
			                        }
			                    }
			                });
                        	$(".topContent").VoiceStormProfileChannels(
    						{
        						removeCallback: function(result)
        						{
			                        if(result.status=="success")
			                        {
			                            $(".topContent").VoiceStormProfileChannels('refresh');
			                        }
			                        else
			                        {
			                            SampleSite.alertMessage("alertMessage", "danger", "Cannot remove the channel");
			                        }
        						}
    						});
			            }
			        }
			    });
			    var AppViewModel=
			    {
			        userId: ko.observable(),
                    userEmail: ko.observable(''),
			    	btnNext: function()
			    	{
			    		$('.bottomContent').attr('id', 'bio');
                        $('.topContent').attr('id', 'photos');	
			    		$('.welcomeWizard li:nth-of-type(2)').removeClass('current');
			    		$('.welcomeWizard li:nth-of-type(3)').addClass('current');
			    		$('#btnNext').hide();
			    		$(".topContent").VoiceStormProfilePhoto();
			    		$(".bottomContent").VoiceStormProfilePublic(
			    			{
			    				submitButtonClass: "btn btn-primary",
			                    submitCallback: function(result)
			                    {
			                        if(result.status=="success")
			                        {
			                            SampleSite.alertMessage("alertMessage", "success", "Bio updated successfully");
			                            VoiceStorm.currentUser().then(function (user)
			                            {
			                                AppViewModel.userId(user.id);
			                                if (user.email) AppViewModel.userEmail(user.email);
			                            });
			                            if (AppViewModel.userEmail())
			                            {
			                                $.ajax(
						                        {
						                            url: 'register.php',
						                            type: 'POST',
						                            dataType: 'json',
						                            data: { 'activateId': AppViewModel.userId() }
						                        }).then(function (response) {
						                            if (response.result === 'error') SampleSite.alertMessage("alertMessage", "danger", response.msg);
						                            else if (response.result === 'success') {
						                                SampleSite.UserSignedIn();
						                            }
						                        }).fail(function () {
						                            SampleSite.alertMessage("alertMessage", "danger", "Please check your internet connection");
						                        });
			                            }
			                            else
			                            {
			                                SampleSite.UserSignedIn();
			                            }
			                        }
			                        else
			                        {
			                            SampleSite.alertMessage("alertMessage", "danger", "Error updating Bio");
			                        }
			                    }
			    			});
			    	}
			    }
			    ko.applyBindings(AppViewModel);			                   
            }
        }
    }
</script>
<?php include 'footer.php'; ?>