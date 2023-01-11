<template>
  <div>
    <form id="nameInput" @submit.prevent="this.$parent.inserProfile">
      <input type="text" required v-model="this.$parent.accountName">
      <br>
      <button type="submit">Insert</button>
    </form>
  </div>
  <div class="kh-container">
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
                    Add New Profile
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
                    <div class="table-cell">+{{ this.$root.transactions.filter(data => data.meta.transaction_type == 'Earning' && data.meta.transaction_profile == profile.id).reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0) }}</div>
                    <div class="table-cell">-{{ this.$root.transactions.filter(data => data.meta.transaction_type == 'Expense' && data.meta.transaction_profile == profile.id).reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0) }}</div>
                    <div class="table-cell">
                        <div class="settingBtns">
                            <button @click.prevent="updateAccountName(profile.id, profile.name)">
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
<div class="kh-container">
  <div class="account-table-responsive">
              <table class="kh-account-table">
                  <tr class="kh-account-table-header">
                      <th class="type-th"><span>Name</span></th>
                      <th class="kh-amount-td"><span>Total Earning</span></th>
                      <th class="kh-dc-td"><span>Total Expense</span></th>
                      <th class="kh-person-add-td"><span>&nbsp;</span></th>
                  </tr>
                  <tr class="kh-account-table-items" v-for="profile in this.$parent.profiles" :key="profile.id">
                    <td class="kh-amount-td"><span class="kh-amount">{{profile.name}}</span></td>
                      <td class="kh-dc-td"><span class="kh-type" >+{{ this.$root.transactions.filter(data => data.meta.transaction_type == 'Earning' && data.meta.transaction_profile == profile.id).reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0) }}</span></td>
                      <td class="kh-dc-td"><span class="kh-type kh-card-btn-round kh-card-btn-remove" >-{{ this.$root.transactions.filter(data => data.meta.transaction_type == 'Expense' && data.meta.transaction_profile == profile.id).reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0) }}</span></td>
                      <td class="kh-person-add-td">
                        <label class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-add" @click.prevent="updateAccountName(profile.id, profile.name)">
                          <span class="material-icons-outlined">
                                    edit
                          </span>
                        </label>
                        <label class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-remove" @click.prevent="this.$root.deleteProfile(profile.id)">
                          <span class="material-icons-outlined">
                                    delete
                          </span>
                        </label>
                      </td>
                  </tr>
              </table>
            </div>
</div>

<div v-if="showUpdatemodel">
    <input type="text" required v-model="this.updatedName">
      <br>
      <button type="submit" @click.prevent="callUpdate">Update</button>
</div>

<!-- <div v-if="showUpdatemodel">
    <transition name="model">
     <div class="modal-mask">
      <div class="modal-wrapper">
       <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" @click="showUpdatemodel=false"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Here goes Title</h4>
         </div>
         <div class="modal-body">
          <div class="form-group">
           <label>Enter First Name</label>
           <input type="text" class="form-control" v-model="updatedName" />
          </div>
          <div class="form-group">
           <label>Enter Last Name</label>
           <input type="text" class="form-control"/>
          </div>
          <br />
          <div align="center">
           <input type="hidden" v-model="profileId" />
           <input type="button" class="btn btn-success btn-xs" />
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </transition>
</div> -->
</template>

<script>
export default {
    name: 'ManageAccountProfile',

    data(){
        return{
        showUpdatemodel: false,
        profileId:null,
        updatedName:""
        }
    },
    methods :{
        updateAccountName(id, name){
            this.showUpdatemodel = !this.showUpdatemodel;
            this.updatedName = name;
            this.profileId = id;
            console.log(this.updatedName);

            
        },
        callUpdate(){
            this.$root.updateProfile(this.profileId, this.updatedName);
        }
    }

}
</script>

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
                border: 1px solid rgb(224, 230, 237);
                border-radius: 5px;
                font-size: 20px;
                outline: none;
                box-shadow: none;
                max-width: 290px;
                width: 100%;
                box-shadow: rgba(31, 45, 61, 0.1) 2px 5px 17px 0px;
            }
            .search_btn_wrapper form input[type="text"]:focus {
                outline: none;
                box-shadow: rgba(31, 45, 61, 0.1) 2px 5px 17px 0px;
                border: 1px solid rgb(224, 230, 237);
            }
            .search_btn_wrapper form button {
                border: none;
                outline: none;
                background-color: transparent;
                box-shadow: none;
                position: absolute;
                right: 05px;
                top: 50%;
                transform: translateY(-50%);
                padding: 4.5px;
                background: white;
                pointer-events: none;
            }
            .search_btn_wrapper form button span {
                color: rgb(224, 230, 237);
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
                background: #3498DB;
                color: white;
                padding: 8px 15px;
                border-radius: 25px;
                transition: all 0.3s ease;
                text-transform: capitalize;
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
            .search_btn_wrapper .add-new:hover {
                margin-top: -5px;
            }
            .table-wrapper {
                width: 100%;
            }
            .table-head {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                border-top: 1px solid rgb(224, 230, 237);
                border-bottom: 1px solid rgb(224, 230, 237);
                background-color: #dee9f5;
            }
            .table-cell {
                padding: 8px 5px;
                transition: all 0.3s ease;
            }
            .table-head .table-cell .heading-title {
                color: rgb(81, 81, 86);
                font-weight: 600;
            }
            .table-cells {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                border-bottom: 1px solid rgb(224, 230, 237);
            }
            .table-cells:hover .table-cell {
                transform: translateY(-1px) scale(1.01);
            }
            .table-cells:hover button .material-icons-outlined {
                color: red;
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
                color: rgb(136, 136, 141);
                font-weight: 600;
            }
            .table-cells:hover .heading-title {
                color: rgb(0, 0, 0);
            }
            .table-cells:hover .table-cell {
              color: rgb(0, 0, 0);
            }

            /* .modal-mask {
     position: fixed;
     z-index: 9998;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0, 0, 0, .5);
     display: table;
     transition: opacity .3s ease;
   }

   .modal-wrapper {
     display: table-cell;
     vertical-align: middle;
   } */
</style>