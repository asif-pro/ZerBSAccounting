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
      <tbody v-for="account in this.accounts">
        <tr>
          <td>{{account.account_name}}</td>
          <td>{{account.user_id}}</td>
        </tr>
      </tbody>
    </table>
    <button @click="this.$parent.displayProfile">Fetch</button>
  </div>

</template>

<script>
export default {
    name: 'ManageAccountProfile',
    mounted(){
      this.accounts=this.$parent.displayProfile();
      //this.accounts = this.$parent.accounts;

    },
    data(){
      return{
        accounts:[],

      }
    }

}
</script>

<style>

</style>