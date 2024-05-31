@extends('dashboard')
@section('content')


    
    <div class="chat">
        <div class="top">
        <img src="" alt="Andre-image" srcset="">
            <p>Andre</p>
            <small>Online</small>
        </div>
        <div class="messages">
            @include('home.receive', ['message' => "Hey wassup!"])
        </div>
        <div class="bottom">
            <form>
                <input type="text" name="message" id="message" placeholder="Enter Message...." autocomplete="off">
                <button class="btn btn-sm btn-primary" type="submit"></button>
            </form>
        </div>
    </div>
<!-- <script>
        const pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'eu'});

        const channel = pusher.subscribe('public');

            //Receive Messages//
            channel.bind('chat', function (data){
                $.post("/home-receive", {
                _token: '{{csrf_token()}}',
                message: data.message,
                
                })

                .done(function (res){
                    $(".messages > .message").last().after(res);
                $(document).scrollTop($(document).height());
                });
            }


            //Broadcast Messages//
            $("form").submit(function(event){
                event.preventDefault();

                $.ajax({
                    url:"/home-broadcast",
                    method: 'POST',
                    headers:{
                    'X-Socket-Id':pusher.connection.socket_id
                    },
            data: {
                _token:'{{csrf_token()}}',
                message: $("form #message").val(),
            }
                }).done(function(res){
                    $(".message > .message").last().after(res);
                $("form #message").val('');
            $(document).scrollTop($(document).height());
                });
            });
</script> -->
   
<script>
    // Initialize Pusher
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: 'eu',
        encrypted: true
    });

    // Subscribe to the 'public' channel
    const channel = pusher.subscribe('public');

    // Receive Messages
    channel.bind('chat', function(data) {
        $.post("/home-receive", {
            _token: '{{ csrf_token() }}',
            message: data.message
        })
        .done(function(res) {
            $(".messages").append(res);
            $(document).scrollTop($(document).height());
        })
        .fail(function(xhr, status, error) {
            console.error('Error receiving message:', error);
        });
    });

    // Broadcast Messages
    $("form").submit(function(event) {
        event.preventDefault();

        const message = $("form #message").val();

        if (message.trim() === "") {
            return;
        }

        $.ajax({
            url: "/home-broadcast",
            method: 'POST',
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            },
            data: {
                _token: '{{ csrf_token() }}',
                message: message
            }
        })
        .done(function(res) {
            $(".messages").append(res);
            $("form #message").val('');
            $(document).scrollTop($(document).height());
        })
        .fail(function(xhr, status, error) {
            console.error('Error broadcasting message:', error);
        });
    });

</script>
@endsection