<template>
  <div>
    <h2>Manage Account Profiles</h2>
    <form @submit.prevent="this.$parent.inserProfile">
      <input type="text" required v-model="this.$parent.accountName">
      <br>
      <button type="submit">Insert</button>
    </form>
  </div>
  <div class="" >
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Earning</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody v-for="profile in this.$parent.profiles" :key="profile.id">
        <tr>
          <td>{{profile.id}}</td>
          <td>{{profile.name}}</td>
          <td>{{ this.$root.transactions.filter(data => data.meta.transaction_type == 'Earning' && data.meta.transaction_profile == profile.id).reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0) }}</td>
          <td><button @click.prevent="this.$root.deleteProfile(profile.id)">Delete</button> || 
          <button @click.prevent="">Update</button></td>
        </tr>
      </tbody>
    </table>
  </div>

</template>

<script>
export default {
    name: 'ManageAccountProfile',

}
</script>

<style>

</style>