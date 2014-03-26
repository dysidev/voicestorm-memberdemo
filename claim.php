<?php $title="Claim"; include 'header.php'; ?>
<div class="container">
    <div class="index-content">
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="#signIn" data-toggle="tab">Sign In</a></li>
            <li><a href="#signUp" data-toggle="tab">Claim Account</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div id="alertMessage" class="alert"></div>
            <div class="tab-pane active" id="signIn">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="loginEmail" class="col-sm-2 control-label">Email Address</label>
                        <div class="col-sm-6">
                          <input type="email" class="form-control" id="loginEmail" placeholder="Email" data-bind="value: userName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" id="loginPassword" placeholder="Password" data-bind="value: userPassword">
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                            <div class="checkbox">
                                <label><input type="checkbox"> Remember me</label>
                            </div>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                            <button class="btn btn-primary" data-bind="click: btnLogin">Log in</button>
                        </div>
                    </div>
                    <div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
					  		<a href="forgotpassword.php">Trouble signing in?</a>
						</div>
				  	</div>
                </form>
            </div>
            <div class="tab-pane" id="signUp">
            <h3>DS and Gmail domains were whitelisted</h3></br>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="claimEmail" class="col-sm-2 control-label">Email Address</label>
                        <div class="col-sm-6">
                          <input type="email" class="form-control" id="claimEmail" placeholder="Email" data-bind="value: claimEmail">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                            <button type="submit" class="btn btn-primary" data-bind="click: btnClaim">Claim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--/container-->
<script type="text/javascript">
    SampleSite =
    {
        Page:
        {
            Init: function()
            {
                VoiceStorm.currentUser().then(SampleSite.UserSignedIn).fail(SampleSite.Page.claimSign());
            },
            claimSign: function()
            {
                var AppViewModel = 
                {
                    userName: ko.observable(),
                    userPassword: ko.observable(),
                    claimEmail: ko.observable(),
                    btnLogin: function()
                    {
                        VoiceStorm.login(AppViewModel.userName(), AppViewModel.userPassword()).then(SampleSite.UserSignedIn).fail(function(error)
                        {
                            SampleSite.alertMessage("alertMessage","danger","Invalid login");
                        });
                    },
                    btnClaim: function()
                    {
                        options={email:AppViewModel.claimEmail()};
                        VoiceStorm.api("POST", "claimaccount", options).then(function (result)
                        {
                            SampleSite.alertMessage("alertMessage","success","Thanks for registering please check your email");
                            AppViewModel.claimEmail("");  
                        }).fail(function (er)
                        {
                            SampleSite.alertMessage("alertMessage", "danger", er.messages);
                        }); 
                    }
                }
                ko.applyBindings(AppViewModel);
            }
        }
    }
</script>
<?php include 'footer.php'; ?>
