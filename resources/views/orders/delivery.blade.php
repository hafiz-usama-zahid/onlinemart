@extends('layout')

@section('section2')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-center">Address</h2>

<div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Province</th>
                        <th>City</th>
                        <th>Building</th>
                        <th>Area</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        @if($deliverie != null)
                            <td>{{ $deliverie->name }}</td>
                            <td>{{ $deliverie->phone }}</td>
                            <td>{{ $deliverie->province }}</td>
                            <td>{{ $deliverie->city }}</td>
                            <td>{{ $deliverie->building }}</td>
                            <td>{{ $deliverie->area }}</td>
                            <td>{{ $deliverie->address }}</td>
                        @endif
                    </tr>
                </tbody>
            </table>    
                
</div>
@endsection
