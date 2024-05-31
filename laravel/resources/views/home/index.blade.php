@extends('dashboard')
@section('content')


    
    <div class="chat">
        <div class="top">
            <img src="{{asset('assets/image/user2.jpg')}}" alt="Andre-image" srcset="">
            <p>Andre</p>
            <small>Online</small>
        </div>

        <div class="messages">
            @include('home.receive', ['message' => "Hey wassup!"])
            @include('home.receive', ['message' => "Ask a friend to open this link and you can chat with them!"])
        </div>

        <div class="col-md-6 bottom">
            <form>
                <input type="text" name="message" id="message" placeholder="Enter Message...." autocomplete="off">
                <button class="btn btn-sm btn-primary" type="submit"></button>
            </form>
        </div>
    </div>

<script>
    const pusherKey = "{{ $pusherKey ?? ''}}";
    const pusherCluster = "{{ $pusherCluster ?? ''}}";
    console.log(pusherKey);
    console.log(pusherCluster);
    
    // Initialize Pusher
    const pusher = new Pusher(pusherKey, {
        cluster: pusherCluster,
        encrypted: true
    });

    // Subscribe to the 'public' channel
    const channel = pusher.subscribe('public');

     //Receive messages
    channel.bind('chat', function (data) {
        $.post("/users-receive", {
        _token: '{{csrf_token()}}',
        message: data.message,
        })
        .done(function (res) {
        $(".messages > .message").last().after(res);
        $(document).scrollTop($(document).height());
        });
    });

    //Broadcast messages
    $("form").submit(function (event) {
        event.preventDefault();

        $.ajax({
        url:     "/users-broadcast",
        method:  'POST',
        headers: {
            'X-Socket-Id': pusher.connection.socket_id
        },
        data:    {
            _token:  '{{csrf_token()}}',
            message: $("form #message").val(),
        }
        }).done(function (res) {
        $(".messages > .message").last().after(res);
        $("form #message").val('');
        $(document).scrollTop($(document).height());
        });
    });

</script>
@endsection