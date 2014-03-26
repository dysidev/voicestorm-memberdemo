<?php $title="Leaderboard"; include 'header.php'; ?>
<div class="container">
    <div id="leaderboard" data-voicestorm-widget="leaderboard" data-voicestorm-id="1"></div>
</div><!--/.container-->
<script type="text/javascript">
    SampleSite =
    {
        Page:
        {
            Init: function()
            {
               VoiceStorm.currentUser().then(SampleSite.headerBindings()).fail(SampleSite.UserNotSignedIn);
            }
        }
    }
</script>
<?php include 'footer.php'; ?>