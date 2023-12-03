@extends('layouts.app')

@section('content')


<?php
$user = Auth::user();
$access_lvl = $user->access_level;
//var_dump($user->email);
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 container">

            <!-- user management -->
            <div class='row top-buffer'>
                <div class='col-lg-12'>
                    <div class="card">
                        <div class="card-header">Manage Users</div>
                        <div class="card-body">
                            <table id="userstable" class="table table-striped table-hover table-fw-widget">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Access Level</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function () {
                    $('#userstable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            url: "{{ route('ajax.getusers') }}",
                            error: function (reason) {
                                console.log(reason);
                            }
                        },
                        "columns": [
                            {"data": "id", "name": "id"},
                            {"data": "name", "name": "name", render(data, type, row) {
                                    return '<a href=" {{ url("/")}}/user/' + row.id + '/details">' + data + '</a>';
                                }
                            },
                            {"data": "email", "name": "email"},
                            {"data": "access_level.id", "name": "access_level", render(data, type, row) {
                                    level_name = row["access_level"].access;
                                    return level_name;
                                }
                            }
                        ]
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection