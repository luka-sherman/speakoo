$(document).ready(function() {
    console.log("Lecture 08 script loaded...");

    // when the button with the id 'fetch_pizza' is clocked...
    $('#fetch_pizza').click(get_status);
    
});


var get_status = function() {
    // get the value typed into the input field with the id 'customer_name'
    var $comment_text = $('#comment_text').val();
    var $video_id = $('#video_id').val();
    console.log("comment_text: " + $comment_text);


    $.ajax({
        url: '../cgi-bin/post_comment.py',  // lecture 8 script to query the pizza database

        data: {                       // the data to send
            comment_text: $comment_text,
            video_id: $video_id
        },

        type: "POST",                  // GET or POST

        dataType: "json",             // json format

        success: function( data ) {   // function to execute upon a successful request
            console.log("success!");
            console.log(data);
            $('#error').empty();
            $('#name').html('comment: ' + data.name);
            $('#emails').html('video_id: ' + data.email);

        },

        error: function(request) {   // function to call when the request fails
            console.log("error!");
            console.log(request);
            $('.order_data').empty();
            $('#error').html("<p>There has been an error fetching the order for, are you sure that this person has an outstanding order?</p>");
        }
    });
};