{{--
    Created by PhpStorm.
    User: amplemind
    Date: 5/17/18
    Time: 4:24 PM
--}}

@extends('layouts.master')

@section('content')
    <p id="power">0</p>
    <div id="messages">pusher</div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Send message</div>
                <form action="/" method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="message" class="message" >
                    <input type="submit" value="send" class="send">
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script src="http://localhost:3000/socket.io/socket.io.js"></script>

    <script>

        var socket = io('http://localhost:3000');

        socket.on("test-channel:App\\Events\\EventName", function(message){
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        });

        socket.on("chat:App\\Events\\ChatEvent", function(message){
            let m = message.data.message;

            $( "#messages" ).append( "<p>"+m+"</p>" );
        });
    </script>

    <script>

        $('input.send').click(function(e){
            e.preventDefault();
            search();
        });

        function search() {
            var message = $('input.message').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "sendmessage",
                data: {/* "_token": $('meta[name="csrf-token"]').attr('content'),*/ "message": message},
                cache: false,
                success: function(results){
                }
            });
        }

    </script>
@stop