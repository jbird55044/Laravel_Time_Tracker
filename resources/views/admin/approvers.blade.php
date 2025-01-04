@extends('layouts.default')
@section('title', 'Admin - Time Approvers')
@section('content')
@php
    $user_id = request()->get('user');
    $user = \App\Models\User::find($user_id);
@endphp


<div class="header-container">
    <h2>Time Approvers for: {{ $user->name }}</h2>
    <small class="inline">User ID: {{$user->id}}</small>
</div>

<div id="app">

     <!-- Validation Message -->
     <div v-if="conflictMessage" class="error-conflict">
        @{{ conflictMessage }}  
        {{-- The @ symbol tells Blade to output the raw without interpreting it as PHP. --}}
    </div>

    <div class="selector-box">
        <!-- First Dialog: Select Approvers -->
        <h3>Manage Approvers for {{ $user->name }}</h3>
        <multiselect 
            v-model="selectedApprovers" 
            :options="approvers" 
            :multiple="true" 
            :close-on-select="false" 
            :clear-on-select="false" 
            placeholder="Select approvers..."
            track-by="id" 
            label="name">
        </multiselect>
        <button type="button" @click="updateApprovers" class="btn btn-primary">Save Approvers</button>
    </div>
    
    <div class="selector-box">
        <!-- Second Dialog: Select Users This User Can Approve -->
        <h3>Manage Users {{ $user->name }} Can Approve</h3>
        <multiselect 
            v-model="selectedApprovedUsers" 
            :options="approvedUsers" 
            :multiple="true" 
            :close-on-select="false" 
            :clear-on-select="false" 
            placeholder="Select users..."
            track-by="id" 
            label="name">
        </multiselect>
        <button type="button" @click="updateApprovedUsers" class="btn btn-primary">Save Approved Users</button>
    </div>    
</div>

<button type="button" onclick="location.href='/admin'">Back to Admin</button>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-multiselect@2.1.6"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-multiselect@2.1.6/dist/vue-multiselect.min.css">

<script>
new Vue({
    el: "#app",
    components: {
        Multiselect: window.VueMultiselect.default
    },
    data() {
        return {
            approvers: [], // Eligible approvers
            selectedApprovers: [], // Currently selected approvers for this user
            approvedUsers: [], // Users this user can approve
            selectedApprovedUsers: [], // Currently selected users this user can approve
            conflictMessage: '' // Message to display validation errors
        };
    },
    mounted() {
        this.fetchApprovers();
        this.fetchApprovedUsers();
    },
    methods: {
        fetchApprovers() {
            fetch(`/api/approvers/eligible?user_id={{ $user_id }}`)
                .then(response => response.json())
                .then(data => {
                    this.approvers = data.approvers;
                    this.selectedApprovers = data.selectedApprovers;
                })
                .catch(error => console.error('Error fetching approvers:', error));
        },
        updateApprovers() {
            // Check for conflicts
            const conflicts = this.selectedApprovers.some(approver =>
                this.selectedApprovedUsers.map(a => a.id).includes(approver.id)
            );

            if (conflicts) {
                this.conflictMessage = 'Conflict detected: A user cannot be both an approver and approved by the same user.';
                return;
            }

            // If no conflicts, proceed
            this.conflictMessage = '';
            fetch(`/api/approvers/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_id: {{ $user_id }},
                    approvers: this.selectedApprovers.map(a => a.id)
                })
            })
            .then(response => response.json())
            .then(data => {
                alert('Approvers updated successfully!');
                this.fetchApprovers();
            })
            .catch(error => console.error('Error updating approvers:', error));
        },
        fetchApprovedUsers() {
            fetch(`/api/approvers/approved-users?user_id={{ $user_id }}`)
                .then(response => response.json())
                .then(data => {
                    this.approvedUsers = data.approvedUsers;
                    this.selectedApprovedUsers = data.selectedApprovedUsers;
                })
                .catch(error => console.error('Error fetching approved users:', error));
        },
        updateApprovedUsers() {
            // Check for conflicts
            const conflicts = this.selectedApprovedUsers.some(user =>
                this.selectedApprovers.map(a => a.id).includes(user.id)
            );

            if (conflicts) {
                this.conflictMessage = 'Conflict detected: A user cannot be both an approver and approved by the same user.';
                return;
            }

            // If no conflicts, proceed
            this.conflictMessage = '';
            fetch(`/api/approvers/update-approved-users`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_id: {{ $user_id }},
                    approvedUsers: this.selectedApprovedUsers.map(a => a.id)
                })
            })
            .then(response => response.json())
            .then(data => {
                alert('Approved users updated successfully!');
                this.fetchApprovedUsers();
            })
            .catch(error => console.error('Error updating approved users:', error));
        }
    }
});
</script>
@endsection
