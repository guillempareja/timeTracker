$(document).ready(function () {
    chronometer();
    function chronometer() {
        var minutesf = 0;
        var hoursf = 0;
        var taskName;
        var worker = new Worker('view/js/workerChronometer.js');
        $(".chronometer .start").click(function (e) {
            taskName = $("input[name='taskName']").val().trim();
            if (taskName) {
                worker.postMessage({'cmd': 'start'});
                $(this).prop("disabled", true);
                $(".chronometer .stop").prop("disabled", false);
            } else {
                alert("Enter the name of the task");
            }
        });
        $(".chronometer .stop").click(function (e) {
            worker.postMessage({'cmd': 'stop'});
            $(this).prop("disabled", true);
            $(".chronometer .start").prop("disabled", false);
            $("#formChronometer").submit();
        });
        $("#formChronometer").submit(function (e) {
            var taskTime = hoursf * 60 + minutesf;
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
        worker.addEventListener('message', function (e) {
            var time = e.data;
            console.log(time);
            time = time.split(":");
            var hundredths = time[3];
            var seconds = time[2];
            var minutes = time[1];
            var hours = time[0];
            if (hundredths < 99) {
                $(".chronometer .hundredths").html(hundredths)
            }
            if (hundredths == 0) {
                $(".chronometer .seconds").html(seconds)
            }
            if ((hundredths == 0) && (seconds == 0)) {
                minutesf = parseInt(minutes);
                $(".chronometer .minutes").html(minutes)
            }
            if ((hundredths == 0) && (seconds == 0) && (minutes == 0)) {
                hoursf = parseInt(hours);
                $(".chronometer .hours").html(hours)
            }
        }, false);
    }

});