<template>
  <div>
    <form @submit.prevent="this.$parent.inserProfile">
      <input type="text" required v-model="this.$parent.accountName">
      <br>
      <button type="submit">Insert</button>
    </form>
  </div>
  <div>
    <div class="manage_account_block">
            <h2 class="block-heading">Manage Account Profiles</h2>
            <div class="search_btn_wrapper">
                <form>
                    <input type="text" placeholder="Search Accounts..." />
                    <button class="search_btn">
                        <span class="material-icons-outlined"> search </span>
                    </button>
                </form>
                <button class="add-new">
                    <span class="material-icons-outlined"> note_add </span>
                    Add New
                </button>
            </div>
            <div class="table-wrapper">
                <div class="table-head">
                    <div class="table-cell">
                        <span class="heading-title">Name</span>
                    </div>
                    <div class="table-cell">
                        <span class="heading-title">Total Earning</span>
                    </div>
                    <div class="table-cell">
                        <span class="heading-title">Total Expense</span>
                    </div>
                    <div class="table-cell">
                        <span class="heading-title">Action</span>
                    </div>
                </div>
                <div class="table-cells" v-for="profile in this.$parent.profiles" :key="profile.id">
                    <div class="table-cell">
                        <span class="heading-title">{{profile.name}}</span>
                    </div>
                    <div class="table-cell">{{ this.$root.transactions.filter(data => data.meta.transaction_type == 'Earning' && data.meta.transaction_profile == profile.id).reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0) }}</div>
                    <div class="table-cell">{{ this.$root.transactions.filter(data => data.meta.transaction_type == 'Expense' && data.meta.transaction_profile == profile.id).reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0) }}</div>
                    <div class="table-cell">
                        <div class="settingBtns">
                            <button>
                                <span class="material-icons-outlined">
                                    edit
                                </span>
                            </button>
                            <button @click.prevent="this.$root.deleteProfile(profile.id)">
                                <span class="material-icons-outlined">
                                    delete
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
  </div>

</template>

<script>
export default {
    name: 'ManageAccountProfile',

}
</script>

<style>
  <style>
            .manage_account_block .block-heading {
                text-align: left;
                font-size: 22px;
                font-weight: 600;
                margin-bottom: 40px;
            }
            .search_btn_wrapper {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                margin-bottom: 40px;
            }
            .search_btn_wrapper form {
                position: relative;
                max-width: 290px;
                width: 100%;
            }
            .search_btn_wrapper form input[type="text"] {
                padding: 8px 10px;
                border: 1px solid gray;
                border-radius: 5px;
                font-size: 20px;
                outline: none;
                box-shadow: none;
                max-width: 290px;
                width: 100%;
                box-shadow: rgba(17, 17, 26, 0.05) 0px 4px 16px,
                    rgba(17, 17, 26, 0.05) 0px 8px 32px;
            }
            .search_btn_wrapper form input[type="text"]:focus {
                outline: none;
                box-shadow: rgba(17, 17, 26, 0.05) 0px 4px 16px,
                    rgba(17, 17, 26, 0.05) 0px 8px 32px;
                border: 1px solid gray;
            }
            .search_btn_wrapper form button {
                border: none;
                outline: none;
                background-color: transparent;
                box-shadow: none;
                position: absolute;
                right: -20px;
                top: 50%;
                transform: translateY(-50%);
                padding: 4.5px;
                background: white;
                cursor: pointer;
            }
            .search_btn_wrapper form button:focus {
                outline: none;
                box-shadow: none;
                border: none;
            }
            .search_btn_wrapper .add-new {
                border: none;
                outline: none;
                box-shadow: none;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                cursor: pointer;
                background: blue;
                color: white;
                padding: 8px 15px;
                border-radius: 25px;
            }
            .search_btn_wrapper .add-new span {
                margin-right: 5px;
                font-size: 18px;
            }
            .search_btn_wrapper .add-new:focus {
                outline: none;
                box-shadow: none;
                border: none;
            }
            .table-wrapper {
                width: 100%;
            }
            .table-head {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                border-top: 1px solid green;
                border-bottom: 1px solid green;
            }
            .table-cell {
                padding: 5px 3px;
            }
            .table-head .table-cell .heading-title {
                color: blue;
                font-weight: 600;
            }
            .table-cells {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                border-bottom: 1px solid green;
            }
            .table-cell .settingBtns button {
                border: none;
                outline: none;
                background-color: transparent;
                box-shadow: none;
                padding: 0;
                margin: 0 5px;
                cursor: pointer;
            }
            .table-cell .settingBtns button:focus {
                outline: none;
                box-shadow: none;
                border: none;
            }
            .table-cells .table-cell .heading-title {
                color: blue;
                font-weight: 600;
            }
            .material-icons-outlined {
                font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0,
                    "opsz" 48;
            }
​
            .material-icons-outlined {
                font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0,
                    "opsz" 48;
            }
​
            .material-icons-outlined {
                font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0,
                    "opsz" 48;
            }
​
            .material-icons-outlined {
                font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0,
                    "opsz" 48;
            }
</style>