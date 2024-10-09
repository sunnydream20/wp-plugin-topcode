jQuery(document).ready(function($) {
    function getAllTasks() {
        // Perform AJAX request
        $.ajax({
            url: ajaxObj.ajaxurl, // Use localized variable for AJAX URL
            type: 'GET', // Method type
            data: {
                action: 'list_todo', // AJAX action hook
                nonce: ajaxObj.nonce // Data to send
            },
            success: function(response) {
                if (response.success) {
                    var result = "<table>";
                    for (var i = 0; i < response.data.length; i ++) {
                        result += "<tr>";
                        result += "<td>" + response.data[i].id + "</td>";
                        result += "<td>" + response.data[i].title + "</td>";
                        result += "<td>" + response.data[i].status + "</td>";
                        result += "</tr>";
                    }
                    result += "</table>";
                    $("#todoList").html(result);
                }
            }
        });
    }

    function addTask() {
        // Perform AJAX request
        $.ajax({
            url: ajaxObj.ajaxurl, // Use localized variable for AJAX URL
            type: 'POST', // Method type
            data: {
                action: 'add_todo', // AJAX action hook
                nonce: ajaxObj.nonce, // Data to send
                title: 'test-ajax',
                status: 'complete',
            },
            success: function(response) {
            }
        });
    }

    $("#loadBtn").click(function() {
        getAllTasks();
    });

    $("#saveBtn").click(function() {
        addTask();
    });
});
