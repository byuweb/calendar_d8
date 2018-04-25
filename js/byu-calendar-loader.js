(function($) {
    $(document).ready(function() {
        var colTemplate = $('#calendar-event-column-template');
        if (colTemplate.length() < 1) {
            return;
        }
        var eventTemplate = $('#calendar-event-event-template');
        var linksDiv = $('div.feature-column.column-links');

        eventTemplate.detach();
        eventTemplate.attr('id', '');
        colTemplate.detach();
        colTemplate.attr('id', '');
        colTemplate.css({'display': ''});

        var now = new Date();
        //slightly hacky way to make "toISOString" show current LOCAL date, even
        //if GMT has already crossed to tomorrow's date: subtract timezone offset
        //(converted from minutes to milliseconds)
        var offsetTimestamp = now.getTime() - (now.getTimezoneOffset() * 1000 * 60);
        var start = new Date(offsetTimestamp);
        var end = new Date(offsetTimestamp);
        end.setDate(end.getDate() + 29);
        var url = byuCalendarEventsUrl.replace('START_DATE', start.toISOString().slice(0, 10)).replace('END_DATE', end.toISOString().slice(0, 10));
        $.get(url, function(data) {
            var lastDate = '';
            var colCount = 0;
            var evtCount = 0;
            var column = false;
            var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            for (var i in data) {
                if (!data[i]['StartDateTime']) {
                    continue;
                }
                //Manually parsing date, since input is not full ISO8601 and we
                //need to avoid timezone wackiness
                var start = data[i]['StartDateTime'];
                var year = parseInt(start.slice(0, 4));
                var month = parseInt(start.slice(5, 7));
                var day = parseInt(start.slice(8, 10));
                var hour = parseInt(start.slice(11, 13));
                var minute = start.slice(14, 16); //Not parseInt, keeping leading "0"
                var ampm = 'AM';
                if (hour >= 12) {
                    ampm = 'PM';
                }
                if (hour > 12) {
                    hour = hour - 12;
                }

                var date = new Date(year, month - 1, day); //"- 1" on month because 0-indexed month
                var dateString = '' + year + month + day;
                if (dateString === lastDate) {
                    if (evtCount === 2) {
                        //We already have 2 events for this date
                        continue;
                    }
                } else {
                    colCount++;
                    if (colCount > 4) {
                        //4 complete columns, that's all we want
                        break;
                    }
                    evtCount = 0;
                    lastDate = dateString;
                    column = colTemplate.clone();
                    column.addClass('column-' + colCount);
                    column.html(column.html()
                        .replace('DATE_WEEKDAY', days[date.getDay()])
                        .replace('DATE_MONTH_DAY', months[date.getMonth()] + ' ' + date.getDate()));
                    column.insertBefore(linksDiv);
                }
                var eventTime = 'All Day';
                if (data[i]['AllDay'] === 'false') {
                    eventTime = '' + hour + ':' + minute + ' ' + ampm;
                }
                var event = eventTemplate.clone();
                var cleanLocation;
                event.addClass('event-' + evtCount);
                if (data[i]['LocationName'] == null) {
                    cleanLocation = '';
                } else {
                    cleanLocation = data[i]['LocationName'];
                }
                event.html(event.html()
                    .replace('EVENT_HREF', data[i]['FullUrl'])
                    .replace('EVENT_TITLE', data[i]['Title'])
                    .replace('EVENT_LOCATION', cleanLocation)
                    .replace('EVENT_TIME', eventTime));


                //TODO: fill in data
                column.append(event);
                evtCount++;
            }
        });
    });
})(jQuery);
