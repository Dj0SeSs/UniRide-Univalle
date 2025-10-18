@extends('layouts.admin')

@section('titulo')
    <span>Usuarios</span>
    <a href="" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#createMdl">
        <i class="fas fa-plus"></i>
    </a>
@endsection

@section('contenido')

    @include('users.modals.create')
    @include('users.modals.update')
    @include('users.modals.delete')

    <div class="card">
        <div class="card-body">
            <table id="dt-users" class="table table-striped table-bordered dts">
                <thead>
                    <tr class="text-center">
                        <th>Nombre</th>
                        <th>Roles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="text-center">
                            <td>{{ $user->name }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-info">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="" class="edit-form-data" data-toggle="modal" data-target="#editMdl"
                                   onclick="editUser({{ $user }})">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="" class="delete-form-data" data-toggle="modal" data-target="#deleteMdl"
                                   onclick="deleteUser({{ $user->id }})">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function editUser(user){
        $("#editUserFrm").attr('action',`/users/${user.id}`);
        $("#editUserFrm #name").val(user.name);

        const roles = user.roles.map(r => r.id);
        $("#editUserFrm #roles").val(roles).trigger('change');
    }

    function deleteUser(id){
        $("#deleteUserFrm").attr('action',`/users/${id}`);
    }
</script>
@endpush
