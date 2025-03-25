<h1>Timesheets de {{$user->name}}!!!</h1>
<br>
<table class="table-auto">
    <thead>
        <th>Calendario</th>
        <th>Tipo</th>
        <th>Ingreso</th>
        <th>Salida</th>
    </thead>
    <tbody>
        @foreach ($timesheets as $timesheet)
        <tr>
            <td>{{ $timesheet->calendar->name }}</td>
            <td>{{ $timesheet->type }}</td>
            <td>{{ $timesheet->day_in }}</td>
            <td>{{ $timesheet->day_out }}</td>
        </tr>
        @endforeach
    </tbody>
</table>