$(document).ready(function () {
    chronometer();
    function chronometer() {
        var hundredths = 0;
        var seconds = 0;
        var minutes = 0;
        var hours = 0;
        var control;
        var taskName
        $(".chronometer .start").click(function (e) {
            taskName = $("input[name='taskName']").val().trim();
            if (taskName) {
                control = setInterval(printChronometer, 10);
                $(this).prop("disabled", true);
                $(".chronometer .stop").prop("disabled", false);
            } else {
                alert("Enter the name of the task");
            }
        });
        $(".chronometer .stop").click(function (e) {
            clearInterval(control);
            $(this).prop("disabled", true);
            $(".chronometer .start").prop("disabled", false);
            $("#formChronometer").submit();
        });
        $("#formChronometer").submit(function (e) {
            var taskTime = parseInt(hours) * 60 + parseInt(minutes);
            $.ajax({
                type: "post",
                url: 'controller/formChronometer.php',
                data: {taskName: taskName, taskTime: taskTime},
                success: function (response) {
                    if (response == "ok") {
                        alert("Task saved");
                    } else {
                        alert("Error");
                    }
                    $('#chronometer').load(document.URL + ' #chronometer >*', function () {
                       chronometer();
                    });
                }
            });
            return false;
        });
        function printChronometer() {
            if (hundredths < 99) {
                hundredths++;
                if (hundredths < 10) {
                    hundredths = "0" + hundredths
                }
                $(".chronometer .hundredths").html(hundredths)
            }
            if (hundredths == 99) {
                hundredths = -1;
            }
            if (hundredths == 0) {
                seconds++;
                if (seconds < 10) {
                    seconds = "0" + seconds
                }
                $(".chronometer .seconds").html(seconds)
            }
            if (seconds == 59) {
                seconds = -1;
            }
            if ((hundredths == 0) && (seconds == 0)) {
                minutes++;
                if (minutes < 10) {
                    minutes = "0" + minutes
                }
                $(".chronometer .minutes").html(minutes)
            }
            if (minutes == 59) {
                minutes = -1;
            }
            if ((hundredths == 0) && (seconds == 0) && (minutes == 0)) {
                hours++;
                if (hours < 10) {
                    hours = "0" + hours
                }
                $(".chronometer .hours").html(hours)
            }
        }
    }

});