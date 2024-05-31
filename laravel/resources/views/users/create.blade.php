@extends('dashboard')
@section('content')

<div class="card mt-2">
        <div class="card-header">
            <h1><i class="fa fa-solid fa-user"></i>
                Create New User</h1>
        </div>
        <div class="card-body">
            <form data="formData" class="users-form">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required
                            value="{{ old('name') }}" placeholder="Enter Name...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required
                            value="{{ old('email') }}" placeholder="Enter Email...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contact_number">Contact Number</label>
                        <input type="number" class="form-control" id="contact_number" name="contact_number" required
                            value="{{ old('contact_number') }}" placeholder="Enter Contact Number...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required
                            placeholder="Password...">
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success btn-sm" type="submit" value="Submit">Submit</button>
            <a href="/users" class="btn btn-secondary btn-sm">Cancel</a>
        </div>
        </form>
</div>
<script>
    document.getElementById('contact_number').addEventListener('input', function(event) {
    let input = event.target;
    let value = input.value;
    if (value.length > 11) {
        input.value = value.slice(0, 11); 
    }
});
</script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.users-form').addEventListener('submit', function(event) {
                event.preventDefault();

                let name = document.getElementById('name').value
                let email = document.getElementById('email').value
                let contactnumber = document.getElementById('contact_number').value
                let password = document.getElementById('password').value

                fetch('http://127.0.0.1:8000/api/users/create', {
                    method: 'POST',
                    body:
                    JSON.stringify({
                        name: name,
                        email: email,
                        contactnumber: contactnumber,
                        password: password,
                    }),
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    },

                }).then(res => {
                    console.log(res);
                    return res.json();
                }).then(res => {
                    console.log(res);
                    if (res.status) {
                        localStorage.setItem('token', 'res.token');
                        window.location.href = '/users';
                    } else {
                       console.log(res.errors)
                    }
                })
            });
        })
    </script>

@endsection