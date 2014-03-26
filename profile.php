<?php $title="Profile"; include 'header.php'; ?>
<div class="container">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a href="#dashboard" data-toggle="tab">Dashboard</a></li>
      <li><a href="#bio" data-toggle="tab">Bio</a></li>
      <li><a href="#photos" data-toggle="tab">Photos</a></li>
      <li><a href="#channels" data-toggle="tab">Channels</a></li>
      <li><a href="#settings" data-toggle="tab">Settings</a></li>
    </ul>
    <div class="tab-content">
        <div id="alertMessage" class="alert"></div>
        <div class="tab-pane active" id="dashboard">
            <legend>About Me</legend>
            <div data-bind="text: aboutMe"></div>
            <button class="btn btn-primary" data-bind="click: btnEditBio">Edit Bio</button>
            <legend>User Posts</legend><div id="userPosts" data-voicestorm-widget="userposts" data-voicestorm-shareButtonClass="btn btn-primary"></div>
            <legend>User Comments</legend><div id="userComments" data-voicestorm-widget="usercomments" data-voicestorm-shareButtonClass="btn btn-primary"></div>
        </div>
        <div class="tab-pane" id="bio"></div>
        <div class="tab-pane" id="photos"></div>
        <div class="tab-pane" id="channels">
            <legend>Connected Channels</legend><div id="connectedChannels"></div>
            <legend>Available Channels</legend><div id="addChannels"></div>
        </div>
        <div class="tab-pane" id="settings">
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs" id="sideTab">
                    <li class="active"><a href="#contactInformation" data-toggle="tab">Contact Information</a></li>
                    <li><a href="#notificationSettings" data-toggle="tab">Notification Settings</a></li>
                    <li><a href="#changePassword" data-toggle="tab">Change Password</a></li>
                    <li><a href="#deleteAccount" data-toggle="tab">Delete Account</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="contactInformation"></div>
                    <div class="tab-pane" id="notificationSettings"></div>
                    <div class="tab-pane" id="changePassword"></div>
                    <div class="tab-pane" id="deleteAccount">
                        <div>By deleting your account, you are choosing to opt out of Sample App.</div>
                        <ul class="deleteAccount">
                            <li>You will no longer receive recurring communications from Sample App.</li>
                            <li>Your profile and social activity will be deleted.</li>
                            <li>If you have questions or concerns, please email abc@xyz.com.</li>
                        </ul>
                        <button class="btn btn-primary col-sm-offset-6" data-toggle="modal" data-target="#confirmModal">Delete Account</button>
                        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Delete Account</h4>
                                    </div>
                                    <div class="modal-body">Are you absolutely certain you want to delete this account?</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal" data-bind="click: btnDelete">Ok</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="share-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Share a Post</h4>
                    </div>
                    <h4 id="share-modal-loading" style="display: none; margin-left: 20px;"><span class="glyphicon glyphicon-refresh"></span> Loading...</h4>
                    <div id="share-modal-sharepost-container" class="modal-body"></div>
                </div><!--/.modal-content-->
            </div><!--/.modal-dialog-->
        </div><!--/.share-modal-->
    </div>
</div><!--/.container-->
<script type="text/javascript">
    SampleSite =
    {
        Page:
        {
            Init: function()
            {
               VoiceStorm.currentUser().then(SampleSite.Page.myProfile()).fail(SampleSite.UserNotSignedIn);
            },
            AppViewModel: null,
            getUser: function()
            {
                VoiceStorm.currentUser().then(function (user)
                {
                    SampleSite.Page.AppViewModel.aboutMe(user.aboutMe);
                    SampleSite.headerHelpers.userDisplayName(user.displayName);
                    SampleSite.Page.AppViewModel.userId(user.id);
                });

            },
            postRenderLoop: function()
            {
                var $profileChannels = $('.voicestorm-profilechannels-widget');
                if ($profileChannels.length > 0)
                {
                    $profileChannels.find('.voicestorm-profilechannels-removechannel').empty().addClass('glyphicon glyphicon-remove-circle').show();
                }
                else
                {
                    setTimeout(SampleSite.Page.postRenderLoop, 250);
                } 
            },
            myProfile: function()
            {
                SampleSite.Page.AppViewModel =
                {
                    aboutMe: ko.observable(),
                    userId: ko.observable(0),
                    btnEditBio: function()
                    {
                        $('#myTab a[href="#bio"]').tab('show');
                    },
                    btnDelete: function()
                    {
                        $.ajax(
                        {
                            url: 'delete.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {'userId' : SampleSite.Page.AppViewModel.userId}
                        }).then(function(response)
                        { 
                            if(response.result === 'error') SampleSite.alertMessage("alertMessage", "danger", response.msg); 
                            else if (response.result === 'success')
                            {
                                SampleSite.headerHelpers.btnLogout(); 
                            }
                        }).fail(function() 
                        { 
                           SampleSite.alertMessage("alertMessage", "danger", "Please check your internet connection"); 
                        });
                    }
                };

                SampleSite.Page.getUser();
                $("#bio").VoiceStormProfilePublic (
                {
                    submitButtonClass: "btn btn-primary",
                    submitCallback: function(result)
                    {
                        if(result.status=="success")
                        {
                            SampleSite.alertMessage("alertMessage", "success", "Bio updated successfully");
                            SampleSite.Page.getUser();
                            $('#userPosts').VoiceStormUserPosts('refresh');
                            $('#userComments').VoiceStormUserComments('refresh');

                        }
                        else
                        {
                            SampleSite.alertMessage("alertMessage", "danger", "Error updating Bio");
                        }
                    }
                });
                $("#photos").VoiceStormProfilePhoto(
                {
                    submitButtonClass: "btn btn-primary",
                    submitCallback: function(result)
                    {
                        if(result.status=="success")
                        {
                            SampleSite.alertMessage("alertMessage", "success", "Photo updated successfully");
                        }
                        else
                        {
                            SampleSite.alertMessage("alertMessage", "danger", "Error updating picture");
                        }
                    }
                });
                $("#connectedChannels").VoiceStormProfileChannels(
                {
                    removeCallback: function(result)
                    {
                        if(result.status=="success")
                        {
                             $("#connectedChannels").empty().VoiceStormProfileChannels('refresh');
                            SampleSite.Page.postRenderLoop();
                        }
                        else
                        {
                            SampleSite.alertMessage("alertMessage", "danger", "Cannot remove the channel");
                        }
                    }
                });
                $("#addChannels").VoiceStormProfileAddChannels(
                {
                    submitCallback: function(result)
                    {
                        if(result.status=="success")
                        {
                            SampleSite.alertMessage("alertMessage", "success", "Channel added successfully");
                             $("#connectedChannels").empty().VoiceStormProfileChannels('refresh');
                            SampleSite.Page.postRenderLoop();
                        }
                        else
                        {
                            SampleSite.alertMessage("alertMessage", "danger", "Error adding the channel");
                        }
                    }
                });
                $("#contactInformation").VoiceStormProfileContact(
                {
                    submitButtonClass: "btn btn-primary",
                    submitCallback: function(result)
                    {
                        if(result.status=="success")
                        {
                            SampleSite.alertMessage("alertMessage", "success", "Contact information updated successfully");
                            SampleSite.Page.getUser();
                            $("#bio").VoiceStormProfilePublic ('refresh');
                            $('#userPosts').VoiceStormUserPosts('refresh');
                            $('#userComments').VoiceStormUserComments('refresh');
                        }
                        else
                        {
                            SampleSite.alertMessage("alertMessage", "danger", "Error updating contact information");
                        }
                    }
                });
                $("#notificationSettings").VoiceStormProfileNotification(
                {
                    submitButtonClass: "btn btn-primary",
                    submitCallback: function(result)
                    {
                        if(result.status=="success")
                        {
                            SampleSite.alertMessage("alertMessage", "success", "Notifications updated successfully");
                        }
                        else
                        {
                            SampleSite.alertMessage("alertMessage", "danger", "Error updating notifications");
                        }
                    }
                });    
                $("#changePassword").VoiceStormProfileChangePassword(
                {
                    submitButtonClass: "btn btn-primary",
                    submitCallback: function(result)
                    {
                        if(result.status=="success")
                        {
                            SampleSite.alertMessage("alertMessage", "success", "Password changed successfully");
                            $("#changePassword").VoiceStormProfileChangePassword('refresh');
                        }
                        else
                        {
                            SampleSite.alertMessage("alertMessage", "danger", "Error updating password");
                        }
                    }
                }); 
                SampleSite.Page.postRenderLoop();          
                ko.applyBindings(SampleSite.Page.AppViewModel);
                SampleSite.lightBoxContainer();
            }
        }
    }
</script>
<?php include 'footer.php'; ?>