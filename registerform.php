<?php $title="Register"; include 'header.php'; ?>
<div class="container">
	<div>
		<form class="form-horizontal" role="form">
			<legend>Registration</legend>
			<div id="alertMessage" class="alert"></div>
		  	<div class="form-group">
				<label class="col-sm-2 control-label">Email Address</label>
				<div class="col-sm-6">
				  <p class="form-control-static" id="tokenRegEmail"></p>
				</div>
		  	</div>
		  	<div class="form-group">
				<label for="tokenRegPassword" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-6">
				  <input type="password" class="form-control" id="tokenRegPassword" placeholder="Password" data-bind="value: tokenRegPassword">
				</div>
		  	</div>
		  	<div class="form-group">
				<label for="tokenConfirmPassword" class="col-sm-2 control-label">Confirm Password</label>
				<div class="col-sm-6">
				  <input type="password" class="form-control" id="tokenConfirmPassword" placeholder="Confirm Password" data-bind="value: tokenConfirmPassword">
				</div>
		  	</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-6">
					<div class="checkbox">
						<label><input type="checkbox"  data-bind="checked: regTerms">I agree to the <a href="#">Terms of Service and Privacy Policy</a></label>
					</div>
				</div>
			</div>
		  	<div class="form-group">
				<div class="col-sm-offset-2 col-sm-6">
			  		<button type="submit" class="btn btn-primary" data-bind="click: tokenRegister">Register</button>
				</div>
		  	</div>
		</form>
	</div>
</div><!--/container-->
<script type="text/javascript">
    SampleSite =
    {
        Page:
        {
            Init: function()
            {
                VoiceStorm.currentUser().then(SampleSite.UserSignedIn).fail(SampleSite.Page.tokenReg());
            },
            tokenReg: function()
            {
            	var tokenValue = purl().param('code');
            	if(!tokenValue)
				{
					SampleSite.UserNotSignedIn();
				}
				else
				{
					options={token:tokenValue};
	                VoiceStorm.api("POST", "register/validateinvitationtoken", options).then(function (result)
	                {
	                	$('#tokenRegEmail').text(result.email);
	                	var AppViewModel=
					    {
					        tokenRegPassword: ko.observable(""),
					        tokenConfirmPassword: ko.observable(""),
					        regTerms: ko.observable(false),
					        isValid: function()
					        {
					            if((AppViewModel.tokenRegPassword() !== "") && (AppViewModel.tokenConfirmPassword() !== ""))
					            {
					                if(AppViewModel.tokenRegPassword() === AppViewModel.tokenConfirmPassword())
					                {
					                    if(AppViewModel.regTerms()=== true)
					                    {
					                        return true;
					                    }
					                    else
					                    {
					                        SampleSite.alertMessage("alertMessage","danger","You must accept the Terms of Service and Privacy Policy before you can continue");
					                        return false; 
					                    }
					                }
					                else
					                {
					                    SampleSite.alertMessage("alertMessage","danger","Passwords do not match");
					                    return false;
					                }
					            }
					            else 
					            {
					                SampleSite.alertMessage("alertMessage", "danger", "Please fill the required fields");                
					                return false;
					            }
					        },
					        tokenRegister: function()
					        {
					            if(AppViewModel.isValid())
					            {
					                $.ajax(
					                {
					                    url: 'register.php',
					                    type: 'POST',
					                    dataType: 'json',
					                    data: {'email' : result.email, 'password' : AppViewModel.tokenRegPassword(), 'invitationKey' : tokenValue}
					                }).then(function(response)
					                { 
					                    if(response.result === 'error') SampleSite.alertMessage("alertMessage", "danger", response.msg); 
					                    else if (response.result === 'success')
					                    {
					                        VoiceStorm.loginWithToken(response.token, response.expiration).then(SampleSite.UserWelcome).fail(SampleSite.UserSignedIn);
					                    }
					                }).fail(function() 
					                { 
					                    SampleSite.alertMessage("alertMessage", "danger", "Please check your internet connection"); 
					                });
					            }
					        }
					    }
						ko.applyBindings(AppViewModel);
	                }).fail(SampleSite.UserNotSignedIn);
	            }
            }
        }
    }
</script>
<?php include 'footer.php'; ?>