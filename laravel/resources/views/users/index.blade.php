@extends('dashboard')
@section('content')

<div class="card mt-2">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 col-12">
                    <h1><i class="fa fa-solid fa-user mt-2"></i> Users</h1>
                </div>
                <div class="col-md-6 col-12">
                    <a href="/users/create" class="float-right btn btn-primary mt-2"><i class="fa fa-solid fa-user"></i> Add
                        New User</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-stripped table-column" id="UsersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>OTP Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable">
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal -->
     <div class="card">
        <div class="card-body">
            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body"> Are you sure you want to delete this user?</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger btn-sm" id="confirmDelete">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
     </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            fetch('http://127.0.0.1:8000/api/userList', {
                method: 'GET',
                headers:{
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                },
            }).then((res)=>{
                console.log(res);
                return res.json();
            }).then(res => {
                console.log(res);
                for(var i=0; i< res.length; i++){
                    var row = "<tr>" +
                            "<td>" + res[i].name + "</td>" +
                            "<td>" + res[i].email + "</td>" +
                            "<td>" + res[i].contact_number + "</td>" +
                            "<td>" + res[i].otp_code + "</td>" +
                            "<td>" + 
                                `<a href="/users/${res[i].id}/edit" class='editUser btn btn-warning btn-sm' title='Edit Button'><i class='fa fa-solid fa-edit'></i> Edit</a> ` +
                                `<a class='deleteUser btn btn-danger btn-sm' data-user-id='${res[i].id}'  title='Delete Button' ><i class='fa fa-solid fa-trash'></i> Delete</a>` +
                            "</td>" +
                        "</tr>";
                        document.getElementById('usersTable').innerHTML += row;
                }
            })

            document.getElementById('usersTable').addEventListener('click', function(event) {
                    if (event.target.classList.contains('deleteUser')) { 
                        let userId = event.target.dataset.userId;
                        $('#deleteConfirmationModal').modal('show');
                        document.getElementById('confirmDelete').addEventListener('click', function() {
                            fetch(`http://127.0.0.1:8000/api/delete/users/${userId}`, {
                                method: 'DELETE',
                                headers: {
                                    Accept: 'application/json',
                                    'Content-Type': 'application/json',
                                    Authorization: 'Bearer ' + localStorage.getItem('token')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status) {
                                    console.log(data.message);
                                    window.location.href = '/users';
                                } else {
                                    console.error(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                        });
                    }
            });


        });


    </script>
@endsection