self.addEventListener('message', function (e) {
    var data = e.data;
    switch (data.cmd) {
        case 'start':
            var control;
            var hundredths = 0;
            var seconds = 0;
            var minutes = 0;
            var hours = 0;
            control = setInterval(printChronometer, 10);
            function printChronometer() {
                var hr=hours;
                var sec=seconds;
                var min=minutes;
                var hu=hundredths;
                if (hundredths < 99) {
                    hundredths++;
                    if (hundredths < 10) {
                        hundredths = "0" + hundredths
                    }
                    hu = hundredths;
                }
                if (hundredths == 99) {
                    hundredths = -1;
                }
                if (hundredths == 0) {
                    seconds++;
                    if (seconds < 10) {
                        seconds = "0" + seconds
                    }
                    sec = seconds;
                }
                if (seconds == 59) {
                    seconds = -1;
                }
                if ((hundredths == 0) && (seconds == 0)) {
                    minutes++;
                    if (minutes < 10) {
                        minutes = "0" + minutes
                    }
                    min = minutes;
                }
                if (minutes == 59) {
                    minutes = -1;
                }
                if ((hundredths == 0) && (seconds == 0) && (minutes == 0)) {
                    hours++;
                    if (hours < 10) {
                        hours = "0" + hours
                    }
                    hr = hours;
                }
                self.postMessage(hr + ":" + min + ":" + sec + ":" + hu);
            }
            break;
        case 'stop':
            self.close();
            break;
        default:
    }
    ;
}, false);

