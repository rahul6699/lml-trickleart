<div class="d-flex">
<table id="datatable" class="table nowrap align-middle border" style="width:100%">
                        
                        <tbody>
                        <tr>
                                <th><h5>Client Information</h5></th>
                                <td></td>
                            </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $lead->Client->name }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $lead->Client->gender }}</td>
                        </tr>
                        <tr>
                            <th>Birthday</th>
                            <td>{{ $lead->Client->dob }}</td>
                        </tr>
                        <tr>
                            <th>Contact</th>
                            <td>{{ $lead->Client->contact_no }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $lead->Client->email }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $lead->Client->address }}</td>
                        </tr>

                        <tr>
                            <th><h5>Lead</h5></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Interested In</th>
                            <td>{{ $lead->interested_in }}</td>
                        </tr>
                        <tr>
                            <th>Lead Source</th>
                            <td>{{ $lead->Source->name }}</td>
                        </tr>
                        <tr>
                            <th>Remarks</th>
                            <td>{{ $lead->remark }}</td>
                        </tr>
                        <tr>
                            <th>Lead Status</th>
                            <td>{{ $lead->LeadStatus->name }}</td>
                        </tr>
                        <tr>
                            <th>Date Created</th>
                            <td>{{ $lead->created_at }}</td>
                        </tr>
                            
                        </tbody>
                    </table>
</div>