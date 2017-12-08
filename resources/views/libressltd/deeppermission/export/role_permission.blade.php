<html>
	<tr>
    <td>role</td>
    <td>permission</td>
    </tr>
	@foreach (App\Models\Role_permission::with("role", "permission")->get() as $rp)
	<tr>
    <td>{{ $rp->role->code }}</td>
    <td>{{ $rp->permission->code }}</td>
    </tr>
    @endforeach
</html>