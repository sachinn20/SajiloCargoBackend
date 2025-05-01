@extends('layouts.admin')

@section('title', 'Payment Management')

@section('content')
<div class="container">
    <h2 class="mb-3">Payment Management</h2>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Booking ID</th>
                <th>User Name</th>
                <th>Payment Mode</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Transaction ID</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>BK-00123</td>
                <td>Sachin Gyawali</td>
                <td>Cash</td>
                <td>Rs. 1000</td>
                <td><span class="badge bg-success">Yes</span></td>
                <td>-</td>
                <td>2025-04-13</td>
            </tr>
            <tr>
                <td>2</td>
                <td>BK-00124</td>
                <td>Niwas Acharya</td>
                <td>Khalti</td>
                <td>Rs. 1500</td>
                <td><span class="badge bg-success">Yes</span></td>
                <td>TXN-ABC123XYZ</td>
                <td>2025-04-20</td>
            </tr>
            <tr>
                <td>3</td>
                <td>BK-00125</td>
                <td>Smirna Rijal</td>
                <td>Cash</td>
                <td>Rs. 800</td>
                <td><span class="badge bg-secondary">No</span></td>
                <td>-</td>
                <td>-</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
