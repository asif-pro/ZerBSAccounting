<template>
  <div>
    <h2>Manage Account Profile</h2>
    <form @submit.prevent="this.$parent.inserProfile">
      <input type="text" required v-model="this.$parent.accountName">
      <br>
      <button type="submit">Insert</button>
    </form>
    <button >Update</button>
    <button >Delete</button>
  </div>
  <div class="" >
    <table>
      <thead>
        <tr>
          <th>Account Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody v-for="account in this.$parent.accounts">
        <tr>
          <td>{{account}}</td>
          <td>{{account}}</td>
        </tr>
      </tbody>
    </table>
    <button @click="this.$parent.displayProfile">Fetch</button>
  </div>

</template>

<script>
export default {
    name: 'ManageAccountProfile',

}
</script>

<style>

</style>