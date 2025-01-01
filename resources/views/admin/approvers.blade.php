@extends('layouts.default')
@section('title', 'Admin - Time Approvers')
@section('content')
@php
    $user_id = request()->get('user');
    $user = \App\Models\User::find($user_id);
@endphp

<h2>Time Approvers for: {{ $user->name }}</h2>
<small>User ID: {{$user_id}}</small>

<div id="app">
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
            approvers: [], // All eligible approvers
            selectedApprovers: [] // Currently selected approvers for this user
        };
    },
    mounted() {
        // Fetch all eligible approvers and currently selected approvers
        this.fetchApprovers();
    },
    methods: {
        fetchApprovers() {
            fetch(`/api/approvers/eligible?user_id={{ $user_id }}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Check the structure of the response
                    this.approvers = data.approvers;
                    this.selectedApprovers = data.selectedApprovers;
                })
                .catch(error => console.error('Error fetching approvers:', error));
        },
        updateApprovers() {
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
            })
            .catch(error => console.error('Error updating approvers:', error));
        }
    }
});

</script>
@endsection
