<?php $title="Create Post"; include 'header.php'; ?>
<div class="container">
    <div class="create-post-container">
        <div id="alertMessage" class="alert"></div>
        <div id="postContainer"></div>
    </div>
</div><!--/.container-->

<script type="text/javascript">
    SampleSite =
    {
        Page:
        {
            Init: function()
            {
                VoiceStorm.currentUser().then(SampleSite.Page.createPost()).fail(SampleSite.UserNotSignedIn);     
            },
            guidelinesURL: function()
            {
                var $createPost = $('.voicestorm-createpost-widget');
                if ($createPost.length > 0)
                {
                    $(".voicestorm-createpost-select-type").change(function () {
                        $('.voicestorm-createpost-widget #template-help-text a').attr("href", "/guidelines.php");
                    });
                }
                else
                {
                    setTimeout(SampleSite.Page.guidelinesURL, 250);
                }

            },
            createPost: function()
            {
                SampleSite.headerBindings();
                $("#postContainer").VoiceStormCreatePost(
                {
                    submitButtonClass: "btn btn-primary",
                    submitCallback: function(result)
                    {
                        if(result.status=="success")
                        {
                            SampleSite.alertMessage("alertMessage", "success", "Posted successfully");
                            $("#postContainer").VoiceStormCreatePost ('refresh');
                        }
                        else
                        {
                            SampleSite.alertMessage("alertMessage", "danger", "Cannot be posted");
                        }
                    }
                });
                SampleSite.Page.guidelinesURL();
            }
        }
    }
</script>
<?php include 'footer.php'; ?>