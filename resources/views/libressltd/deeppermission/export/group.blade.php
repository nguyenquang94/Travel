<html>
	<tr>
		<td>name</td>
		<td>code</td>
	</tr>
	@foreach (App\Models\Permission_group::all() as $group)
	<tr>
    <td>{{ $group->name }}</td>
    <td>{{ $group->code }}</td>
    </tr>
    @endforeach
</html>