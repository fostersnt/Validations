<!--Full calendar.js-->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<script>
    var events = [
        {
            title: 'Event 1',
            start: '2024-02-14T10:00:00',
            end: '2024-02-14T12:00:00',
            description: 'Details of Event 1'
        },
        {
            title: 'Event 2',
            start: '2024-02-15T14:00:00',
            end: '2024-02-15T16:00:00',
            description: 'Details of Event 2'
        },
        // Add more events as needed
    ];

    document.addEventListener('DOMContentLoaded', function() {
        //Ensure you target the right id in the html document
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
            eventClick: function(info) {
                alert('Event Clicked\nTitle: ' + info.event.title + '\nDetails: ' + info.event.extendedProps.description);
            },
            eventMouseEnter: function(info) {
                console.log('Mouse Enter Event:', info.event.title);
            },
            eventMouseLeave: function(info) {
                console.log('Mouse Leave Event:', info.event.title);
            },
            dayClick: function(info) {
                alert('Day Clicked\nDate: ' + info.dateStr);
            },
            eventRender: function(info) {
                console.log('Event Rendered:', info.event.title);
            },
            eventResizeStart: function(info) {
                console.log('Event Resize Start:', info.event.title);
            },
            eventResize: function(info) {
                console.log('Event Resized:', info.event.title);
            },
            eventResizeStop: function(info) {
                console.log('Event Resize Stop:', info.event.title);
            },
            eventDragStart: function(info) {
                console.log('Event Drag Start:', info.event.title);
            },
            eventDrag: function(info) {
                console.log('Event Dragged:', info.event.title);
            },
            eventDragStop: function(info) {
                console.log('Event Drag Stop:', info.event.title);
            },
            select: function(info) {
                alert('Date Range Selected\nStart: ' + info.startStr + '\nEnd: ' + info.endStr);
            },
            selectAllow: function(selectInfo) {
                // You can customize whether a date range is allowed to be selected
                return true; // Allow all selections
            },
            selectOverlap: function(event) {
                alert('Selection Overlaps Event\nTitle: ' + event.title);
                return false; // Prevent selection overlap
            },
        });
        calendar.render();
    });
</script>
