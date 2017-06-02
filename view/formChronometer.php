<?php require_once('header.php'); ?>
<script src="view/js/chronometer.js" type="text/javascript"></script>
<div class="container" id="chronometer">
    <h1>Time your task</h1>
    <form id="formChronometer">
        <div class="lines">
            <input type="text"  maxlength=50 placeholder="Name of the task" name="taskName">     
            <div class="lines">
                <div class="chronometer">
                    <div class="box">
                        <div class="clock"><span class="hours">00</span>: </div>
                        <div class="clock"><span class="minutes">00</span>: </div>
                        <div class="clock"><span class="seconds">00</span>: </div>
                        <div class="clock"><span class="hundredths">00</span></div>
                    </div>
                    <input type="button" class="start" value="Start &#9658;">
                    <input type="button" class="stop" value="Stop &#8718;"  disabled>
                </div>
            </div>
    </form>
</div>
<?php require_once('footer.php'); ?>