@extends('layouts.app')
@section('content')
<style>
    table, th, td {
  border: 1px solid;
  margin-left: -80px;
}
</style>
<h1 style="text-align: center">Danh sách nhân viên</h1>
    <table >
        <thead>
            <tr >
                <th>BusinessEntityID</th>
                <th>NationnalIDNumber</th>
                <th>loginID</th>
                <th>OrganizationNode</th>
                <th>OrganizationLevel</th>
                <th>Jobtitle</th>
                <th>BirthDate</th>
                <th>MaritalStatus</th>
                <th>Gender</th>
                <th>HireDate</th>
                <th>VacationHours</th>
                <th>SickLeaveHours</th>
                <th>ModifiedDate</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employees)
            <tr>
                <td>{{ $employees->BusinessEntityID }}</td>
                <td>{{ $employees->NationnallDNumber }}</td>
                <td>{{ $employees->loginID }}</td>
                <td>{{ $employees->OrganizationNode }}</td>
                <td>{{ $employees->OrganizationLever }}</td>
                <td>{{ $employees->Jobtitle }}</td>
                <td>{{ $employees->BirthDate }}</td>
                <td>{{ $employees->MaritalStatus }}</td>
                <td>{{ $employees->Gender }}</td>
                <td>{{ $employees->HireDate }}</td>
                <td>{{ $employees->VacationHours }}</td>
                <td>{{ $employees->SickLeaveHours }}</td>
                <td>{{ $employees->ModifiedDate }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection