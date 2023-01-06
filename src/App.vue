<template>
   <div class="zbs-account" @click="handleOpenClick">
      <div class="zbs-sidebar" v-if="user">
     <ul class="zbs-sidebar-menu">
        <li :class="{active: sidebarPage == 'accounting'}" @click="sidebarPageChange('accounting')"><span class="material-icons-outlined">home</span><span class="sidebar-menu-title">Accounting</span></li>

           <li :class="{active: sidebarPage == 'debt'}" @click="sidebarPageChange('debt')"><span class="material-icons-outlined">calculate</span><span class="sidebar-menu-title">Debt Tracking</span></li>
         
         <li :class="{active: sidebarPage == 'overview'}" @click="sidebarPageChange('overview')"><span class="material-icons-outlined">layers</span><span class="sidebar-menu-title">Overview</span></li>

         <li :class="{active: sidebarPage == 'categories'}" @click="sidebarPageChange('categories'); newcat=''"><span class="material-icons-outlined">folder_special</span><span class="sidebar-menu-title">Categories</span></li>

         <li :class="{active: sidebarPage == 'integrations'}" @click="sidebarPageChange('integrations')"><span class="material-icons-outlined">extension</span><span class="sidebar-menu-title">Integrations</span></li>

         <li class="setting-item" :class="{active: configActive}" @click="viewConfigurationPage"><span class="material-icons-outlined">settings</span><span class="sidebar-menu-title">Configuration</span></li>
      </ul>
       <ul class="zbs-sidebar-menu zbs-sidebar-menu-bottom">
        <li :class="{active: sidebarPage == 'manageAccountProfile'}" @click="sidebarPageChange('manageAccountProfile')"><span class="material-icons-outlined">wallet</span><span class="sidebar-menu-title">Manage Account Profile</span></li>
        <li :class="{active: configActive}" @click="viewConfigurationPage"><span class="material-icons-outlined">settings</span><span class="sidebar-menu-title">Configuration</span></li>
      </ul> 


      <!-- PostPopup Start -->
       <div class="kh-post-pop kh-config-pop" :class="{ active: configActive }" @click="handleFormFocus">
          <form id="configForm" class="post-form" @submit.prevent="configSubmit">
            <label class="placehold-btn">
              <input type="checkbox" v-model="configActive"/>
              <span class="material-icons-outlined">close</span>
            </label>
            <p class="lead">Configuration</p>
            <p v-if="configErrors.length" class="error-box">
              <ul>
                <li v-for="error in configErrors" :key="error.key">{{ error }}</li>
              </ul>
            </p>
            <div class="field-group currency-field">
              Currency
              <div class="currency-field_selected">
                <button type="button" class="currency-name" @click="currencyDrop=true">
                  <span>{{selectedCurrency.code || ''}}</span>
                  <span>{{selectedCurrency.symbol_native || ''}}</span>
                </button>
              </div>
              <div class="currency-selector" :class="{active: currencyDrop}">
                <input type="search" class="currency-search" placeholder="Search..." v-model="currencyQuery"/>
                <div class="currency-list">
                  <label v-for="item in filteredCurrency" @click="selectedCurrency = item; currencyDrop=false" :key="item.key" :class="{  active: item.code == selectedCurrency.code }">
                    <span>{{item.code}}</span>
                    <span>{{item.symbol_native}}</span>
                  </label>
                </div>
              </div>
            </div>
            <label class="field-group">
              Currency Position
              <select v-model="selectedCurrencyPosition">
                <option value="before">Before</option>
                <option value="after">After</option>
              </select>
            </label>
            <button type="submit" :disabled='configBtnDisabled'>{{configStatus}}</button>
          </form>
        </div>
    </div> 
<!-- PostPopup End -->

  <!-- <div class="zbs-progress" :class="{ active: progressEnable }"><svg class="zbs-spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="circle" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg>
  </div>
    <div class="zbs-notification" :class="{ active: notificationEnable }">{{notification}}
    </div>
    
          <div class="kh-post-pop" :class="{ active: postPop }" @click="handleFormFocus">
            <form id="postForm" class="post-form" @submit.prevent="submit">
              <label class="placehold-btn">
                <input type="checkbox" v-model="postPop"/>
                <span class="material-icons-outlined">close</span>
              </label>
              <input type="hidden" v-model="postformtype"/>
              <input type="hidden" v-model="targetPost"/>
              <p class="lead">Add new transaction</p>
              <p v-if="errors.length" class="error-box">
                <ul>
                  <li v-for="error in errors" v-bind:key="error.key">{{ error }}</li>
                </ul>
              </p>
             <label class="field-group">
                Description
                <input type="text" :placeholder="postformtype == 'editpostform' ? postObj.title.rendered : 'Write a description'" v-model="title"/>
              </label>
              <label class="field-group">
                <div class="box-radio-fields">
                  <label>
                    <input type="radio" name="earning-expense" v-model="newtype" value="Earning"/>
                    <span class="box-radio-label"><svg width="22" height="22" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 14.5312C11.3833 14.5312 14.5312 11.3833 14.5312 7.5C14.5312 3.61675 11.3833 0.46875 7.5 0.46875C3.61675 0.46875 0.46875 3.61675 0.46875 7.5C0.46875 11.3833 3.61675 14.5312 7.5 14.5312Z" fill="#FFDD67"/>
                    <path d="M4.45321 4.875C4.45321 4.3125 5.69539 4.57031 6.09383 4.96875C6.32821 4.57031 6.21102 4.21875 6.21102 4.21875C6.21102 4.21875 5.85946 3.96094 5.32039 3.86719V3.35156C4.89852 3.21094 4.42977 3.35156 4.42977 3.35156V3.84375C4.42977 3.84375 3.58602 4.00781 3.58602 4.875C3.58602 6.02344 5.32039 5.78906 5.32039 6.51562C5.32039 7.05469 4.14852 6.82031 3.58602 6.39844C3.39852 6.82031 3.58602 7.19531 3.58602 7.19531C4.00789 7.38281 4.42977 7.42969 4.42977 7.42969V7.89844C4.42977 7.89844 4.89852 8.03906 5.32039 7.89844V7.40625C5.32039 7.40625 6.30477 7.35937 6.30477 6.51562C6.32821 5.41406 4.45321 5.50781 4.45321 4.875Z" fill="#664E27"/>
                    <path d="M9.60946 4.875C9.60946 4.3125 10.8516 4.57031 11.2501 4.96875C11.4845 4.57031 11.3673 4.21875 11.3673 4.21875C11.3673 4.21875 11.0157 3.96094 10.4766 3.86719V3.35156C10.0548 3.21094 9.58602 3.35156 9.58602 3.35156V3.84375C9.58602 3.84375 8.74227 4.00781 8.74227 4.875C8.74227 6.02344 10.4766 5.78906 10.4766 6.51562C10.4766 7.05469 9.30477 6.82031 8.74227 6.39844C8.55477 6.82031 8.74227 7.19531 8.74227 7.19531C9.16414 7.38281 9.58602 7.42969 9.58602 7.42969V7.89844C9.58602 7.89844 10.0548 8.03906 10.4766 7.89844V7.40625C10.4766 7.40625 11.461 7.35937 11.461 6.51562C11.4845 5.41406 9.60946 5.50781 9.60946 4.875Z" fill="#664E27"/>
                    <path d="M11.2266 8.90625H3.77344C3.60938 8.90625 3.51562 9.02344 3.51562 9.14062C3.51562 10.8516 4.92188 12.6562 7.5 12.6562C10.0781 12.6562 11.4844 10.8516 11.4844 9.14062C11.4844 9.02344 11.3906 8.90625 11.2266 8.90625Z" fill="#664E27"/>
                    <path d="M9.65625 10.3125H5.34375C5.17969 10.3125 5.15625 10.3828 5.15625 10.5V11.4375C5.15625 13.5 6.21094 14.5312 7.5 14.5312C8.78906 14.5312 9.84375 13.5 9.84375 11.4375V10.5C9.84375 10.3828 9.82031 10.3125 9.65625 10.3125Z" fill="#74E063"/>
                    <path d="M7.19539 11.6015C7.19539 11.2265 7.96883 11.414 8.22664 11.6719C8.39071 11.414 8.29696 11.1797 8.29696 11.1797C8.29696 11.1797 8.06258 11.0156 7.73446 10.9453V10.5937C7.47664 10.5 7.17196 10.5937 7.17196 10.5937V10.9219C7.17196 10.9219 6.63289 11.0156 6.63289 11.6015C6.63289 12.3515 7.73446 12.1875 7.73446 12.6797C7.73446 13.0312 7.00789 12.8906 6.63289 12.6094C6.51571 12.8906 6.63289 13.125 6.63289 13.125C6.89071 13.2422 7.17196 13.289 7.17196 13.289V13.5937C7.17196 13.5937 7.45321 13.6875 7.73446 13.5937V13.2656C7.73446 13.2656 8.34383 13.2187 8.34383 12.6797C8.39071 11.9531 7.19539 12.0234 7.19539 11.6015Z" fill="#449636"/>
                    <path d="M9.28125 10.3125V11.1328C9.28125 13.0781 8.57812 13.9453 7.5 13.9453C6.42187 13.9453 5.71875 13.1016 5.71875 11.1328V10.3125H5.53125V11.1328C5.53125 13.2187 6.30469 14.1562 7.5 14.1562C8.69531 14.1562 9.46875 13.2187 9.46875 11.1328V10.3125H9.28125Z" fill="#449636"/>
                    </svg> Earning</span>
                  </label>
                  <label>
                    <input type="radio" name="earning-expense" v-model="newtype" value="Expense"/>
                    <span class="box-radio-label"><svg width="22" height="22" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.40625 6.5C0.40625 9.87187 3.12812 12.5938 6.5 12.5938C9.87187 12.5938 12.5938 9.87187 12.5938 6.5C12.5938 3.12812 9.87187 0.40625 6.5 0.40625C3.12812 0.40625 0.40625 3.12812 0.40625 6.5Z" fill="#FDB2A1"/>
                    <path d="M9.68896 7.63752C9.68896 9.3844 12.0655 9.3844 12.0655 7.63752C12.0655 6.35784 10.8874 5.11877 10.8874 5.11877C10.8874 5.11877 9.68896 6.35784 9.68896 7.63752Z" fill="#65B1EF"/>
                    <path d="M7.82031 8.125C8.38123 8.125 8.83594 7.67029 8.83594 7.10938C8.83594 6.54846 8.38123 6.09375 7.82031 6.09375C7.2594 6.09375 6.80469 6.54846 6.80469 7.10938C6.80469 7.67029 7.2594 8.125 7.82031 8.125Z" fill="#664E27"/>
                    <path d="M3.14844 8.125C3.70935 8.125 4.16406 7.67029 4.16406 7.10938C4.16406 6.54846 3.70935 6.09375 3.14844 6.09375C2.58752 6.09375 2.13281 6.54846 2.13281 7.10938C2.13281 7.67029 2.58752 8.125 3.14844 8.125Z" fill="#664E27"/>
                    <path d="M4.18434 4.0422C3.53434 4.59064 2.66091 4.83439 1.80778 4.67189C1.68591 4.65158 1.58434 5.07814 1.72653 5.11876C2.70153 5.30158 3.71716 5.0172 4.46872 4.38751C4.57028 4.28595 4.26559 3.96095 4.18434 4.0422Z" fill="#917524"/>
                    <path d="M9.16087 4.65156C8.30775 4.79375 7.43431 4.57031 6.78431 4.02188C6.70306 3.94063 6.37806 4.26563 6.49994 4.36719C7.2515 5.01719 8.26712 5.28125 9.24212 5.09844C9.38431 5.05781 9.28275 4.63125 9.16087 4.65156Z" fill="#917524"/>
                    <path d="M7.73903 9.60782C6.56091 9.30314 5.30153 9.52657 4.30622 10.2172C4.06247 10.4 4.52966 11.0297 4.77341 10.8672C5.42341 10.4 6.47966 10.0953 7.55622 10.3797C7.82028 10.4406 8.04372 9.70939 7.73903 9.60782Z" fill="#664E27"/>
                    </svg> Expense</span>
                  </label>
                </div>
              </label>
               <label class="field-group amount-field">
                <span class="styled-amount">
                  <input 
                    type="number" 
                    inputmode="decimal"
                    step="0.01" 
                    :placeholder="postformtype == 'editpostform' ? postObj.meta.transaction_amount : '00.0'"  
                    v-model="newamount"
                    v-autowidth="{maxWidth: '100%', minWidth: '95px', comfortZone: 0}"
                  />
                  <span>{{selectedCurrency.code}}</span>
                </span>
                <span class="amount-label">Amount</span>
              </label>

              <label class="field-group cat-field-group">
                Category
                <div class="cat-with-icon">
                  <span class="material-icons-outlined" v-if="hasCat[0]">{{filteredCat[0].meta.icon[0]}}</span>
                  <span class="material-icons-outlined" v-else>add</span>
                  <input class="catinput" v-on:focus="catDrop=true" type="text" :placeholder="postformtype == 'editpostform' && postObj.category ? postObj.category.name : 'Category'" v-model="newcat"/>
                </div>
                <div class="cat-list" v-bind:class="{active: catDrop}">
                  <label v-for="item in filteredCat" v-on:click="newcat = item.name; catDrop=false" v-bind:key="item.id">
                    <span class="cat-icon" v-bind:style="{ color: item.meta && item.meta.color && item.meta.color.length && item.meta.color[0] ? item.meta.color[0] : 'rgb(103, 104, 108)' }"><span class="material-icons-outlined">{{item.meta && item.meta.color && item.meta.color.length && item.meta.icon[0] ? item.meta.icon[0] : 'quiz'}}</span></span>
                    <span class="cat-name" v-html="item.name"></span>
                  </label>
                  <label type="button" v-on:click="catsubmit" v-if="!hasCat[0] && newcat">
                    <span class="cat-icon" v-bind:style="{ color: 'rgb(103, 104, 108)' }"><span class="material-icons-outlined">add</span></span>
                    <span class="cat-name">Add '{{newcat}}' as a new Category</span>
                  </label>
                </div>
              </label>
              <label class="field-group field-group-check"><input type="checkbox" :checked="postformtype == 'editpostform' ? postObj.showNote : addANote" @change.prevent="postformtype == 'editpostform' ? postObj.showNote = !postObj.showNote : addANote = !addANote"><span>Add a note with this transaction</span></label>
              <label class="field-group" v-if="postformtype == 'editpostform' ? postObj.showNote : addANote">
                Note
                <textarea :placeholder="postformtype == 'editpostform' ? postObj.meta.transaction_note : 'Have any note...'" v-model="newnote"></textarea>
              </label>
              <input type="hidden" action="new_transaction"/>
              <button type="submit" :disabled='btnDisabled'>{{postStatus}}</button>
            </form>
          </div> -->
          
    <!-- ProPopUp Start -->
    <div class="kh-pro-pop" :class="{ active: proPop }" @click="handleProFocus">
      <form class="pro-form" @submit.prevent="emailsubmit">
        <label class="placehold-btn">
          <input type="checkbox" v-model="proPop"/>
          <span class="material-icons-outlined">close</span>
        </label>
        <p class="lead">Features yet to come</p>
        <p v-if="sub_error.length" class="error-box">
          <ul>
            <li v-for="error in sub_error" :key="error.key">{{ error }}</li>
          </ul>
        </p>
        <p class="subtitle" v-html="sub_status" :style="{color: sub_submitted ? '#014737' : '#9CA3AF'}"></p>
        <input v-if="!sub_submitted" type="email" v-model="sub_email" placeholder="youremail@example.com">
        <button v-if="!sub_submitted" type="submit" class="get-pro-btn">Subscribe for Pro</button>
      </form>
    </div>
    <!-- ProPopUp End -->


    <div v-if="sidebarPage == 'accounting'">
  <AccountsPage>
  </AccountsPage>
</div>

<div v-if="sidebarPage == 'debt'">
  <DebtTrackingPage>
  </DebtTrackingPage>
</div>

<div v-if="sidebarPage == 'overview'">
  <Overview>
  </Overview>
</div>

<div v-if="sidebarPage == 'categories'">
  <CategoriesPage>
  </CategoriesPage>
</div>

<div v-if="sidebarPage == 'integrations'">
    <IntegrationsPage>
      <template v-slot:wooCommerceImage>
        <img :src="getImgUrl('/images/woocommerce.png')">
      </template>
      <template v-slot:easyDigitalDownloadImage>
        <img :src="getImgUrl('/images/edd.png')">
      </template>
    </IntegrationsPage>
</div>

<div v-if="configActive">
  <ConfigurationPage>
  </ConfigurationPage>
</div>

<div v-if="sidebarPage == 'manageAccountProfile'">
  <ManageAccountProfile>
  </ManageAccountProfile>
</div>

   </div>
</template>

<script>
import currency from '../assets/js/currency.json';
import AccountsPage from './components/AccountsPage.vue'
import DebtTrackingPage from './components/DebtTrackingPage.vue'
import IntegrationsPage from './components/IntegrationsPage.vue'
import CategoriesPage from './components/CategoriesPage.vue'
import Overview from './components/Overview.vue'
import ConfigurationPage from './components/ConfigurationPage.vue'
import ManageAccountProfile from './components/ManageAccountProfile.vue'
import axios from 'axios'


export default {
  name: 'App',
  components: {
    AccountsPage,
    DebtTrackingPage,
    CategoriesPage,
    IntegrationsPage,
    Overview,
    ConfigurationPage,
    ManageAccountProfile
  },

   created(){
    if(this.user) {
      var date = new Date();
      var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
      if(window.location.hash){
        this.sidebarPage = window.location.hash.replace('#', '');
      }

      this.fetchTransactions();

      //Fetching Debt
      fetch(zbs_account.site + 'wp-json/wp/v2/debt?_embed&author=' + this.user.data.ID)
        .then((r) => {
          return r.json();
        })
        .then((res) => {
          this.totalDebit = 0;
          this.totalCredit = 0;
          res.map(item => {
            let itemTransactions = JSON.parse(item.meta.debt_transactions);
            let itemAmount = 0;
            let itemType = 'no-debt';
            
            itemTransactions.forEach(trans => {
              if(trans.transaction_type == 'debit'){
                itemAmount += parseInt(trans.transaction_amount);
              }
              if(trans.transaction_type == 'credit'){
                itemAmount -= parseInt(trans.transaction_amount);
              }
            });

            if(itemAmount > 0){
              itemType = 'debit';
              this.totalDebit += itemAmount;
            }

            if(itemAmount < 0){
              itemType = 'credit';
              this.totalCredit += itemAmount;
            }

            this.debts.push({...item, debt_amount: itemAmount, debt_type: itemType, expand: false});
          });
        });

      fetch(zbs_account.site + 'wp-json/wp/v2/transaction_category?per_page=100&orderby=id')
        .then((r) => r.json())
        .then((res) => {
          res.map(item => {
            if(item.slug == 'earning'){
              this.catEarning = item.id;
            }
            if(item.slug == 'expense'){
              this.catExpense = item.id;
            }
            if(item.slug != 'earning' && item.slug != 'expense'){
              this.cats.push(item);
            }            
          })
        });

      fetch(zbs_account.ajaxurl + '?action=zbs_get_profile_settings', {
          credentials: 'same-origin',
          headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce' : zbs_account.nonce
          }
        })
        .then((r) => r.json())
        .then((res) => { 
          const data = res.data;
          this.selectedCurrency = this.allCurrency.find((currency) => currency.code == data.currency);
          this.selectedCurrencyPosition = data.currency_position;
        }).catch(error => {
          console.log("Settings Error", error); 
        })
    }
  },

   mounted(){

     this.chartLoad()
     this.displayProfile();
  
  },

   data() {
    return {
      login_url: zbs_account.login_url,
      user: JSON.parse(zbs_account.user),
      plugin_url: zbs_account.plugin_dir_url,
      default_profile: zbs_account.default_profile,
      transactions: [],
      debts: [],
      paging: {
        pageSize: 20,
        currentPage: 1,
        totalPage: 1
      },
      accountName: '',
      profiles: [],
      debtTransactionPaging:{
        pageSize: 3,
        currentPage: 1,
        totalPage: 1
      },
      cats: [],
      postPop: false,
      debtPop: false,
      postformtype: 'newpostform',
      debtformtype: 'newpostform',
      targetPost: null,
      targetDebt: null,
      postObj: null,
      debtObj: null,
      btnDisabled: false,
      btnDebtDisabled: false,
      postStatus: 'Add to list',
      debtStatus: 'Go',
      title: '',
      debttitle: '',
      newamount: '',
      newdebtamount: '',
      newcat: '',
      debtType: 'debit',
      addPrevToDebt: false,
      addANote: false,
      addANoteDebt: false,
      newnote: '',
      newdebtnote: '',
      newtype: 'Expense',
      totalEarning: 0,
      totalExpense: 0,
      totalDebit: 0,
      totalCredit: 0,
      catEarning: 0,
      catExpense: 0,
      catDrop: false,
      errors: [],
      debterrors: [],
      sidebarPage: 'accounting',
      deptPhoneNumber: '',
      deptEmailAddress: '',
      debtForTransaction: null,
      debtForTransactionObj: null,
      debtForTransactionTransactions: [],
      debtTransactionPop: false,
      debttransactionerrors: [],
      debtTransactionType: 'debit',
      newdebttransactionamount: '',
      newdebttransactionnote: '',
      btnDebtTransactionDisabled: false,
      debtTransactionStatus: 'Go',
      proPop: false,
      sub_email: '',
      sub_error: [],
      sub_submitted: false,
      sub_status: 'All the great features including these are yet to come. Subscribe to get notified when pro version is released.',
      notification: '',
      notificationEnable: false,
      progressEnable: false,
      readMoreActivated: false,
      newaddcat: '',
      newaddcattype: 'both',
      newaddcatcolor: 'rgb(22, 160, 133)',
      newaddcaticon: 'quiz',
      newaddcatPop: false,
      icons: ['ac_unit', 'access_alarm', 'access_alarms', 'access_time', 'accessibility', 'accessible', 'account_balance', 'account_balance_wallet', 'account_box', 'account_circle', 'adb', 'add', 'add_a_photo', 'add_alarm', 'add_alert', 'add_box', 'add_circle', 'add_circle_outline', 'add_location', 'add_shopping_cart', 'add_to_photos', 'add_to_queue', 'adjust', 'airline_seat_flat', 'airline_seat_flat_angled', 'airline_seat_individual_suite', 'airline_seat_legroom_extra', 'airline_seat_legroom_normal', 'airline_seat_legroom_reduced', 'airline_seat_recline_extra', 'airline_seat_recline_normal', 'airplanemode_active', 'airplanemode_inactive', 'airplay', 'airport_shuttle', 'alarm', 'alarm_add', 'alarm_off', 'alarm_on', 'album', 'all_inclusive', 'all_out', 'android', 'announcement', 'apps', 'archive', 'arrow_back', 'arrow_downward', 'arrow_drop_down', 'arrow_drop_down_circle', 'arrow_drop_up', 'arrow_forward', 'arrow_upward', 'art_track', 'aspect_ratio', 'assessment', 'assignment', 'assignment_ind', 'assignment_late', 'assignment_return', 'assignment_returned', 'assignment_turned_in', 'assistant', 'assistant_photo', 'attach_file', 'attach_money', 'attachment', 'audiotrack', 'autorenew', 'av_timer', 'backspace', 'backup', 'battery_alert', 'battery_charging_full', 'battery_full', 'battery_std', 'battery_unknown', 'beach_access', 'beenhere', 'block', 'bluetooth', 'bluetooth_audio', 'bluetooth_connected', 'bluetooth_disabled', 'bluetooth_searching', 'blur_circular', 'blur_linear', 'blur_off', 'blur_on', 'book', 'bookmark', 'bookmark_border', 'border_all', 'border_bottom', 'border_clear', 'border_color', 'border_horizontal', 'border_inner', 'border_left', 'border_outer', 'border_right', 'border_style', 'border_top', 'border_vertical', 'branding_watermark', 'brightness_1', 'brightness_2', 'brightness_3', 'brightness_4', 'brightness_5', 'brightness_6', 'brightness_7', 'brightness_auto', 'brightness_high', 'brightness_low', 'brightness_medium', 'broken_image', 'brush', 'bubble_chart', 'bug_report', 'build', 'burst_mode', 'business', 'business_center', 'cached', 'cake', 'call', 'call_end', 'call_made', 'call_merge', 'call_missed', 'call_missed_outgoing', 'call_received', 'call_split', 'call_to_action', 'camera', 'camera_alt', 'camera_enhance', 'camera_front', 'camera_rear', 'camera_roll', 'cancel', 'card_giftcard', 'card_membership', 'card_travel', 'casino', 'cast', 'cast_connected', 'center_focus_strong', 'center_focus_weak', 'change_history', 'chat', 'chat_bubble', 'chat_bubble_outline', 'check', 'check_box', 'check_box_outline_blank', 'check_circle', 'chevron_left', 'chevron_right', 'child_care', 'child_friendly', 'chrome_reader_mode', 'class', 'clear', 'clear_all', 'close', 'closed_caption', 'cloud', 'cloud_circle', 'cloud_done', 'cloud_download', 'cloud_off', 'cloud_queue', 'cloud_upload', 'code', 'collections', 'collections_bookmark', 'color_lens', 'colorize', 'comment', 'compare', 'compare_arrows', 'computer', 'confirmation_number', 'contact_mail', 'contact_phone', 'contacts', 'content_copy', 'content_cut', 'content_paste', 'control_point', 'control_point_duplicate', 'copyright', 'create', 'create_new_folder', 'credit_card', 'crop', 'crop_16_9', 'crop_3_2', 'crop_5_4', 'crop_7_5', 'crop_din', 'crop_free', 'crop_landscape', 'crop_original', 'crop_portrait', 'crop_rotate', 'crop_square', 'dashboard', 'data_usage', 'date_range', 'dehaze', 'delete', 'delete_forever', 'delete_sweep', 'description', 'desktop_mac', 'desktop_windows', 'details', 'developer_board', 'developer_mode', 'device_hub', 'devices', 'devices_other', 'dialer_sip', 'dialpad', 'directions', 'directions_bike', 'directions_boat', 'directions_bus', 'directions_car', 'directions_railway', 'directions_run', 'directions_subway', 'directions_transit', 'directions_walk', 'disc_full', 'dns', 'do_not_disturb', 'do_not_disturb_alt', 'do_not_disturb_off', 'do_not_disturb_on', 'dock', 'domain', 'done', 'done_all', 'donut_large', 'donut_small', 'drafts', 'drag_handle', 'drive_eta', 'dvr', 'edit', 'edit_location', 'eject', 'email', 'enhanced_encryption', 'equalizer', 'error', 'error_outline', 'euro_symbol', 'ev_station', 'event', 'event_available', 'event_busy', 'event_note', 'event_seat', 'exit_to_app', 'expand_less', 'expand_more', 'explicit', 'explore', 'exposure', 'exposure_neg_1', 'exposure_neg_2', 'exposure_plus_1', 'exposure_plus_2', 'exposure_zero', 'extension', 'face', 'fast_forward', 'fast_rewind', 'favorite', 'favorite_border', 'featured_play_list', 'featured_video', 'feedback', 'fiber_dvr', 'fiber_manual_record', 'fiber_new', 'fiber_pin', 'fiber_smart_record', 'file_download', 'file_upload', 'filter', 'filter_1', 'filter_2', 'filter_3', 'filter_4', 'filter_5', 'filter_6', 'filter_7', 'filter_8', 'filter_9', 'filter_9_plus', 'filter_b_and_w', 'filter_center_focus', 'filter_drama', 'filter_frames', 'filter_hdr', 'filter_list', 'filter_none', 'filter_tilt_shift', 'filter_vintage', 'find_in_page', 'find_replace', 'fingerprint', 'first_page', 'fitness_center', 'flag', 'flare', 'flash_auto', 'flash_off', 'flash_on', 'flight', 'flight_land', 'flight_takeoff', 'flip', 'flip_to_back', 'flip_to_front', 'folder', 'folder_open', 'folder_shared', 'folder_special', 'font_download', 'format_align_center', 'format_align_justify', 'format_align_left', 'format_align_right', 'format_bold', 'format_clear', 'format_color_fill', 'format_color_reset', 'format_color_text', 'format_indent_decrease', 'format_indent_increase', 'format_italic', 'format_line_spacing', 'format_list_bulleted', 'format_list_numbered', 'format_paint', 'format_quote', 'format_shapes', 'format_size', 'format_strikethrough', 'format_textdirection_l_to_r', 'format_textdirection_r_to_l', 'format_underlined', 'forum', 'forward', 'forward_10', 'forward_30', 'forward_5', 'free_breakfast', 'fullscreen', 'fullscreen_exit', 'functions', 'g_translate', 'gamepad', 'games', 'gavel', 'gesture', 'get_app', 'gif', 'golf_course', 'gps_fixed', 'gps_not_fixed', 'gps_off', 'grade', 'gradient', 'grain', 'graphic_eq', 'grid_off', 'grid_on', 'group', 'group_add', 'group_work', 'hd', 'hdr_off', 'hdr_on', 'hdr_strong', 'hdr_weak', 'headset', 'headset_mic', 'healing', 'hearing', 'help', 'help_outline', 'high_quality', 'highlight', 'highlight_off', 'history', 'home', 'hot_tub', 'hotel', 'hourglass_empty', 'hourglass_full', 'http', 'https', 'image', 'image_aspect_ratio', 'import_contacts', 'import_export', 'important_devices', 'inbox', 'indeterminate_check_box', 'info', 'info_outline', 'input', 'insert_chart', 'insert_comment', 'insert_drive_file', 'insert_emoticon', 'insert_invitation', 'insert_link', 'insert_photo', 'invert_colors', 'invert_colors_off', 'iso', 'keyboard', 'keyboard_arrow_down', 'keyboard_arrow_left', 'keyboard_arrow_right', 'keyboard_arrow_up', 'keyboard_backspace', 'keyboard_capslock', 'keyboard_hide', 'keyboard_return', 'keyboard_tab', 'keyboard_voice', 'kitchen', 'label', 'label_outline', 'landscape', 'language', 'laptop', 'laptop_chromebook', 'laptop_mac', 'laptop_windows', 'last_page', 'launch', 'layers', 'layers_clear', 'leak_add', 'leak_remove', 'lens', 'library_add', 'library_books', 'library_music', 'lightbulb_outline', 'line_style', 'line_weight', 'linear_scale', 'link', 'linked_camera', 'list', 'live_help', 'live_tv', 'local_activity', 'local_airport', 'local_atm', 'local_bar', 'local_cafe', 'local_car_wash', 'local_convenience_store', 'local_dining', 'local_drink', 'local_florist', 'local_gas_station', 'local_grocery_store', 'local_hospital', 'local_hotel', 'local_laundry_service', 'local_library', 'local_mall', 'local_movies', 'local_offer', 'local_parking', 'local_pharmacy', 'local_phone', 'local_pizza', 'local_play', 'local_post_office', 'local_printshop', 'local_see', 'local_shipping', 'local_taxi', 'location_city', 'location_disabled', 'location_off', 'location_on', 'location_searching', 'lock', 'lock_open', 'lock_outline', 'looks', 'looks_3', 'looks_4', 'looks_5', 'looks_6', 'looks_one', 'looks_two', 'loop', 'loupe', 'low_priority', 'loyalty', 'mail', 'mail_outline', 'map', 'markunread', 'markunread_mailbox', 'memory', 'menu', 'merge_type', 'message', 'mic', 'mic_none', 'mic_off', 'mms', 'mode_comment', 'mode_edit', 'monetization_on', 'money_off', 'monochrome_photos', 'mood', 'mood_bad', 'more', 'more_horiz', 'more_vert', 'motorcycle', 'mouse', 'move_to_inbox', 'movie', 'movie_creation', 'movie_filter', 'multiline_chart', 'music_note', 'music_video', 'my_location', 'nature', 'nature_people', 'navigate_before', 'navigate_next', 'navigation', 'near_me', 'network_cell', 'network_check', 'network_locked', 'network_wifi', 'new_releases', 'next_week', 'nfc', 'no_encryption', 'no_sim', 'not_interested', 'note', 'note_add', 'notifications', 'notifications_active', 'notifications_none', 'notifications_off', 'notifications_paused', 'offline_pin', 'ondemand_video', 'opacity', 'open_in_browser', 'open_in_new', 'open_with', 'pages', 'pageview', 'palette', 'pan_tool', 'panorama', 'panorama_fish_eye', 'panorama_horizontal', 'panorama_vertical', 'panorama_wide_angle', 'party_mode', 'pause', 'pause_circle_filled', 'pause_circle_outline', 'payment', 'people', 'people_outline', 'perm_camera_mic', 'perm_contact_calendar', 'perm_data_setting', 'perm_device_information', 'perm_identity', 'perm_media', 'perm_phone_msg', 'perm_scan_wifi', 'person', 'person_add', 'person_outline', 'person_pin', 'person_pin_circle', 'personal_video', 'pets', 'phone', 'phone_android', 'phone_bluetooth_speaker', 'phone_forwarded', 'phone_in_talk', 'phone_iphone', 'phone_locked', 'phone_missed', 'phone_paused', 'phonelink', 'phonelink_erase', 'phonelink_lock', 'phonelink_off', 'phonelink_ring', 'phonelink_setup', 'photo', 'photo_album', 'photo_camera', 'photo_filter', 'photo_library', 'photo_size_select_actual', 'photo_size_select_large', 'photo_size_select_small', 'picture_as_pdf', 'picture_in_picture', 'picture_in_picture_alt', 'pie_chart', 'pie_chart_outlined', 'pin_drop', 'place', 'play_arrow', 'play_circle_filled', 'play_circle_outline', 'play_for_work', 
 'playlist_add', 'playlist_add_check', 'playlist_play', 'plus_one', 'poll', 'polymer', 'pool', 'portable_wifi_off', 'portrait', 'power', 'power_input', 'power_settings_new', 'pregnant_woman', 'present_to_all', 'print', 'priority_high', 'public', 'publish', 'query_builder', 'question_answer', 'queue', 'queue_music', 'queue_play_next', 'radio', 'radio_button_checked', 'radio_button_unchecked', 'rate_review', 'receipt', 'recent_actors', 'record_voice_over', 'redeem', 'redo', 'refresh', 'remove', 'remove_circle', 'remove_circle_outline', 'remove_from_queue', 'remove_red_eye', 'remove_shopping_cart', 'reorder', 'repeat', 'repeat_one', 'replay', 'replay_10', 'replay_30', 'replay_5', 'reply', 'reply_all', 'report', 'report_problem', 'restaurant', 'restaurant_menu', 'restore', 'restore_page', 'ring_volume', 'room', 'room_service', 'rotate_90_degrees_ccw', 'rotate_left', 'rotate_right', 'rounded_corner', 'router', 'rowing', 'rss_feed', 'rv_hookup', 'satellite', 'save', 'scanner', 'schedule', 'school', 'screen_lock_landscape', 'screen_lock_portrait', 'screen_lock_rotation', 'screen_rotation', 'screen_share', 'sd_card', 'sd_storage', 'search', 'security', 'select_all', 'send', 'sentiment_dissatisfied', 'sentiment_neutral', 'sentiment_satisfied', 'sentiment_very_dissatisfied', 'sentiment_very_satisfied', 'settings', 'settings_applications', 'settings_backup_restore', 'settings_bluetooth', 'settings_brightness', 'settings_cell', 'settings_ethernet', 'settings_input_antenna', 'settings_input_component', 'settings_input_composite', 'settings_input_hdmi', 'settings_input_svideo', 'settings_overscan', 'settings_phone', 'settings_power', 'settings_remote', 'settings_system_daydream', 'settings_voice', 'share', 'shop', 'shop_two', 'shopping_basket', 'shopping_cart', 'short_text', 'show_chart', 'shuffle', 'signal_cellular_4_bar', 'signal_cellular_connected_no_internet_4_bar', 'signal_cellular_no_sim', 'signal_cellular_null', 'signal_cellular_off', 'signal_wifi_4_bar', 'signal_wifi_4_bar_lock', 'signal_wifi_off', 'sim_card', 'sim_card_alert', 'skip_next', 'skip_previous', 'slideshow', 'slow_motion_video', 'smartphone', 'smoke_free', 'smoking_rooms', 'sms', 'sms_failed', 'snooze', 'sort', 'sort_by_alpha', 'spa', 'space_bar', 'speaker', 'speaker_group', 'speaker_notes', 'speaker_notes_off', 'speaker_phone', 'spellcheck', 'star', 'star_border', 'star_half', 'stars', 'stay_current_landscape', 'stay_current_portrait', 'stay_primary_landscape', 'stay_primary_portrait', 'stop', 'stop_screen_share', 'storage', 'store', 'store_mall_directory', 'straighten', 'streetview', 'strikethrough_s', 'style', 'subdirectory_arrow_left', 'subdirectory_arrow_right', 'subject', 'subscriptions', 'subtitles', 'subway', 'supervisor_account', 'surround_sound', 'swap_calls', 'swap_horiz', 'swap_vert', 'swap_vertical_circle', 'switch_camera', 'switch_video', 'sync', 'sync_disabled', 'sync_problem', 'system_update', 'system_update_alt', 'tab', 'tab_unselected', 'tablet', 'tablet_android', 'tablet_mac', 'tag_faces', 'tap_and_play', 'terrain', 'text_fields', 'text_format', 'textsms', 'texture', 'theaters', 'thumb_down', 'thumb_up', 'thumbs_up_down', 'time_to_leave', 'timelapse', 'timeline', 'timer', 'timer_10', 'timer_3', 'timer_off', 'title', 'toc', 'today', 'toll', 'tonality', 'touch_app', 'toys', 'track_changes', 'traffic', 'train', 'tram', 'transfer_within_a_station', 'transform', 'translate', 'trending_down', 'trending_flat', 'trending_up', 'tune', 'turned_in', 'turned_in_not', 'tv', 'unarchive', 'undo', 'unfold_less', 'unfold_more', 'update', 'usb', 'verified_user', 'vertical_align_bottom', 'vertical_align_center', 'vertical_align_top', 'vibration', 'video_call', 'video_label', 'video_library', 'videocam', 'videocam_off', 'videogame_asset', 'view_agenda', 'view_array', 'view_carousel', 'view_column', 'view_comfy', 'view_compact', 'view_day', 'view_headline', 'view_list', 'view_module', 'view_quilt', 'view_stream', 'view_week', 'vignette', 'visibility', 'visibility_off', 'voice_chat', 'voicemail', 'volume_down', 'volume_mute', 'volume_off', 'volume_up', 'vpn_key', 'vpn_lock', 'wallpaper', 'warning', 'watch', 'watch_later', 'wb_auto', 'wb_cloudy', 'wb_incandescent', 'wb_iridescent', 'wb_sunny', 'wc', 'web', 'web_asset', 'weekend', 'whatshot', 'widgets', 'wifi', 'wifi_lock', 'wifi_tethering', 'work', 'wrap_text', 'youtube_searched_for', 'zoom_in', 'zoom_out', 'zoom_out_map'],
      iconDrop: false,
      iconQuery: '',
      siteSetting: null,
      configActive: false,
      configErrors: [],
      configBtnDisabled: false,
      configStatus: 'Save Config',
      currencyDrop: false,
      currencyQuery: '',
      allCurrency: currency,
      selectedCurrency: {
        "symbol": "$",
        "name": "US Dollar",
        "symbol_native": "$",
        "decimal_digits": 2,
        "rounding": 0,
        "code": "USD",
        "name_plural": "US dollars"
      },
      selectedCurrencyPosition: 'before'
    }
  },
  computed: {
    filteredPost(){
      return this.transactions
      .filter((row, index) => {
        let start = (this.paging.currentPage-1)*this.paging.pageSize;
        let end = this.paging.currentPage*this.paging.pageSize;
        if((index >= start && index < end) && this.default_profile === row.meta.transaction_profile) return true;
      });
    },
    filteredDebtTransactions(){
      return this.debtForTransactionTransactions
      .filter((row, index) => {
        let start = (this.debtTransactionPaging.currentPage-1)*this.debtTransactionPaging.pageSize;
        let end = this.debtTransactionPaging.currentPage*this.debtTransactionPaging.pageSize;
        if(index >= start && index < end) return true;
      })
    },
    filteredCat() {
      return this.cats
      .filter((data) => {
        if(this.newtype == 'Expense'){
          return data.parent != this.catEarning && data.name.toLowerCase().startsWith(this.newcat.toLowerCase());
        }   
        if(this.newtype == 'Earning'){
          return data.parent != this.catExpense && data.name.toLowerCase().startsWith(this.newcat.toLowerCase());
        }      
      });
    },
    filteredIcon() {
      return this.icons
      .filter((data) => {
        return data.toLowerCase().indexOf(this.iconQuery.toLowerCase()) !== -1;     
      });
    },
    hasCat() {
      return this.filteredCat.map((data) => {
        if(data.name.toLowerCase() == this.newcat.toLowerCase()){
          return true;
        } 
        return false;
      });
    },
    filteredCurrency() {
      return this.allCurrency.filter(data => data.code.toLowerCase().startsWith(this.currencyQuery.toLowerCase()));
    },

    totalEarning () {
      return this.transactions.filter(data => data.meta.transaction_type == 'Earning').reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0);
    },

    totalExpense () {
      return this.transactions.filter(data => data.meta.transaction_type == 'Expense').reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0);
    },

    profileEarning () {
      return this.transactions.filter(data => data.meta.transaction_type == 'Earning' && data.meta.transaction_profile == this.default_profile).reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0);
    },

    profileExpense () {
      return this.transactions.filter(data => data.meta.transaction_type == 'Expense' && data.meta.transaction_profile == this.default_profile).reduce((acc, data) => acc + Number(data.meta.transaction_amount), 0);
    },
  },
  methods: {
    getImgUrl: function(file){
      return this.plugin_url + file;
    },
    chartLoad(){
      var ctxes = document.querySelectorAll('.chart-canvas');
    ctxes.forEach((item, index) => {
      var ctx = item.getContext('2d'),
          type = item.getAttribute('data-type'),
          label = item.getAttribute('data-label'),
          data = JSON.parse(item.getAttribute('data-data')),
          backgroundColor = JSON.parse(item.getAttribute('data-backgroundColor')),
          borderColor = JSON.parse(item.getAttribute('data-borderColor')),
          borderWidth = item.getAttribute('data-borderWidth'),
          labels = JSON.parse(item.getAttribute('data-labels'));

      var datasets = [{
        label,
        data,
        backgroundColor,
        borderColor,
        borderWidth
      }];

      if(item.getAttribute('data-label2')){
        var label2 = item.getAttribute('data-label2'),
            data2 = JSON.parse(item.getAttribute('data-data2')),
            backgroundColor2 = JSON.parse(item.getAttribute('data-backgroundColor2')),
            borderColor2 = JSON.parse(item.getAttribute('data-borderColor2')),
            borderWidth2 = item.getAttribute('data-borderWidth2');

        datasets.push({label: label2, data: data2, backgroundColor: backgroundColor2, borderColor: borderColor2, borderWidth: borderWidth2});
      }

      new Chart(ctx, {
          type,
          data: {
              labels,
              datasets
          },
          options: {
              legend: {
                  display: false
              },
              plugins: {
                  title: {
                      display: false
                  }
              },
              scales: {
                  x: {
                    grid: {
                      display: false
                    },
                    ticks: {
                          display: type == 'bar' ? true : false
                      }
                  },
                  y: {
                      display: false,
                      ticks: {
                          display: false
                      }
                  }
              }
          }
      });
    });
    },
    viewConfigurationPage(){
      this.configActive = true;
    },
     sidebarPageChange: function(page){
      this.sidebarPage = page;
      window.location.hash = page;
      if (page == 'overview'){
        setTimeout(()=>{this.chartLoad()
        },100)
      }
    },
     handleProFocus: function(event){
      if(event.target.classList.contains('kh-pro-pop')){
        this.proPop = false;
      }
    },
        handleOpenClick: function(e){
      if(!e.target.classList.contains('.post-existing-pop-toggle')){
        this.filteredPost.map(item => item.expand = false);
      }
      if(!e.target.classList.contains('catinput')){
        this.catDrop = false;
      }
      if(!e.target.classList.contains('icon-name') &&  !e.target.classList.contains('icon-search')){
        this.iconDrop = false;
      }
      if(!e.target.classList.contains('currency-name') &&  !e.target.classList.contains('currency-search')){
        this.currencyDrop = false;
      }
    },
      handleFormFocus: function(event){
      if(event.target.classList.contains('kh-post-pop')){
        this.postPop = false;
        this.debtPop = false;
      }
    },
      openNewCategoryForm: function(){
      this.newaddcatPop = true;
    },
    addCatsubmit: function() {
      var comp = this;
      comp.progressEnable = true;
      if(comp.newaddcat != ''){
        var formData = {
          name: comp.newaddcat,
          meta: {
              color: comp.newaddcatcolor ? comp.newaddcatcolor : 'rgb(103, 104, 108)',
              icon: comp.newaddcaticon ? comp.newaddcaticon : 'quiz'
          }
        };

        if(comp.newaddcattype == 'earning'){
          formData.parent = comp.catEarning;
        }

        if(comp.newaddcattype == 'expense'){
          formData.parent = comp.catExpense;
        }
        
        var createCat = new XMLHttpRequest();
        createCat.open("POST", zbs_account.site + 'wp-json/wp/v2/transaction_category');
        createCat.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
        createCat.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        createCat.send(JSON.stringify(formData));
        createCat.onreadystatechange = function() {
          if (createCat.readyState == 4){
            if(createCat.status == 201){
              var returnData = JSON.parse(this.responseText);
              comp.cats.push(returnData);
              comp.progressEnable = false;
              comp.newaddcatPop = false;
              comp.newaddcat = '';
              comp.newaddcatcolor = 'rgb(103, 104, 108)';
              comp.newaddcaticon = 'quiz';
              comp.newaddcattype = 'both';
              comp.notificationPop('New category added');
            } else {
              comp.progressEnable = false;
              comp.notificationPop('There was a error. Try again');
            }
          } 
        }
      } else {
        comp.progressEnable = false;
        comp.notificationPop('Category title is required');
      }    
    },
    filteredCat() {
      return this.cats
      .filter((data) => {
        if(this.newtype == 'Expense'){
          return data.parent != this.catEarning && data.name.toLowerCase().startsWith(this.newcat.toLowerCase());
        }   
        if(this.newtype == 'Earning'){
          return data.parent != this.catExpense && data.name.toLowerCase().startsWith(this.newcat.toLowerCase());
        }      
      });
    },
    submit: function() {
      var comp = this;
      comp.progressEnable = true;
      comp.errors = [];
      const isOld = comp.postformtype == 'editpostform' ? true : false;
      const isValid = isOld ? 
      (comp.postObj 
        && comp.postObj.id 
        && comp.postObj.title 
        && comp.postObj.title.rendered 
        && comp.postObj.meta.transaction_amount 
        && comp.postObj.meta.transaction_type
        && comp.postObj.transaction_category
        && comp.postObj.transaction_category.length > 0 
         )
      : (
        comp.newtype 
        && comp.newamount 
        && comp.newcat  
        && comp.newamount > 0 
      );

      if(isValid) {

        // console.log(comp.postObj.title);

      var formData = {
        id: comp.postObj && comp.postObj.id ? comp.postObj.id : '',
        title: this.title || (comp.postObj && comp.postObj.title && comp.postObj.title.rendered ? comp.postObj.title.rendered : comp.postObj.title),
        category: comp.cats.find(item => comp.newcat ? item.name == comp.newcat : item.id == comp.postObj.transaction_category[0]).id,
        amount : this.newamount || comp.postObj.meta.transaction_amount,
        note: this.newnote || isOld ? comp.postObj.meta.transaction_note : '',
        type: this.newtype || comp.postObj.meta.transaction_type,
        
      }; 

      // console.log(formData);

      comp.btnDisabled = true;
      comp.postStatus = 'Processing request...';
        
      axios.post(zbs_account.ajaxurl + '?action=zbs_update_transaction', formData, {
        headers: {
          'X-WP-Nonce': zbs_account.nonce,
          'Content-Type': 'application/json;charset=UTF-8'
        }
      }).then(function (response) { 

        // console.log(formData, data);
        comp.title = '';
        comp.newamount = '';
        comp.newnote = '';
        comp.newtype = 'Expense';
        comp.newcat = ''; 
          
        comp.postStatus = 'Successfully' + (isOld ? ' updated' : ' added') + ' transaction';
        comp.postPop = false;
        comp.errors = [];
        comp.btnDisabled = false;
        comp.postStatus = 'Add to list';
        comp.progressEnable = false;
        comp.notificationPop(`Transaction ${isOld ? 'updated' : 'added'}`);

        comp.fetchTransactions();

      }) 
      


      } else {
        if (!comp.title || (comp.postObj && !comp.postObj.title)) {
          comp.errors.push('Title required.');
          comp.notificationPop('Title required');
        }
        if (!comp.newamount || (comp.postObj && !comp.postObj.transaction_amount)) {
          comp.errors.push('Amount required.');
          comp.notificationPop('Amount required');
        }
        if(!comp.newcat || (comp.postObj && !comp.postObj.transaction_category[0])){
          comp.errors.push('Category required.');
          comp.notificationPop('Category required');
        } 
         
        comp.progressEnable = false;
      }
 
      
    },
    enEditForm: function(e){
      this.errors = [];
      this.postPop = true;
      this.postStatus = 'Update the item';
      this.postformtype = 'editpostform';
      this.targetPost = e.target.getAttribute('data-id');
      this.postObj = this.transactions.find((data) => data.id == this.targetPost);
      this.newtype = this.postObj.meta.transaction_type;
      this.transactions.find((data) => data.id == this.targetPost).expand = false;
    },
      quickAdd: function(e){
      this.newtype = e.target.getAttribute('data-ttype');
      this.errors = [];
      this.postPop = true;
    },
     currencify(amount, toFix){
      let amo = parseInt(amount);
      if(toFix > 0){
        amo = amo.toFixed(toFix);
      }
      if(this.selectedCurrencyPosition == 'after'){
        if(amo == 0){
          return '00' + this.selectedCurrency.symbol_native;
        }
        if(amo < 0){
          if(toFix > 0){
            return '-' + Math.abs(amo).toFixed(toFix) + this.selectedCurrency.symbol_native;
          } else {
            return '-' + Math.abs(amo) + this.selectedCurrency.symbol_native;
          }
        }
        return amo + this.selectedCurrency.symbol_native;
      } else {
        if(amo == 0){
          return this.selectedCurrency.symbol_native + '00';
        }
        if(amo < 0){
          if(toFix > 0){
            return '-' + this.selectedCurrency.symbol_native + Math.abs(amo).toFixed(toFix);
          } else {
            return '-' + this.selectedCurrency.symbol_native + Math.abs(amo)
          }
        }
        return this.selectedCurrency.symbol_native + amo;
      }
    },
     configSubmit: function() {
      var comp = this;
      comp.progressEnable = true;
      comp.configErrors = [];
      var formData = {
        'zbs_currency': comp.selectedCurrency.code ? comp.selectedCurrency.code : 'USD',
        'zbs_currency_position': comp.selectedCurrencyPosition ? comp.selectedCurrencyPosition : 'before'
      };

      var createPost = new XMLHttpRequest();
      createPost.open("POST", zbs_account.site + 'wp-json/wp/v2/settings');
      //createPost.open("POST", zbs_account.ajaxurl + '?action=wp_ajax_zbs_updated_profile_settings');
      createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
      createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      createPost.send(JSON.stringify(formData));
      createPost.onreadystatechange = function() {
        if(createPost.readyState == 0){
          comp.configBtnDisabled = true;
          comp.configStatus = 'Processing request...';
        } else if (createPost.readyState == 1){
          comp.configStatus = 'Requesting sending...';
        } else if (createPost.readyState == 4){
          if(createPost.status == 200){
            var returnData = JSON.parse(this.responseText);
            comp.siteSetting = returnData;
            comp.configStatus = 'Save Config';
            comp.configActive = false;
            comp.configErrors = [];
            comp.configBtnDisabled = false;
            comp.progressEnable = false;
            comp.notificationPop('Configuration saved');
          } else {
            comp.configStatus = 'Error! Try again';
            comp.configBtnDisabled = false;
            comp.progressEnable = false;
            comp.notificationPop('There was a error. Try again');
          }
        }
      }      
    },
      closeDebtForTransaction: function(){
      this.debtForTransaction = null;
      this.debtForTransactionObj = null;
      this.debtformtype = 'newpostform';
    },
    enDebtEditForm: function(e){
      this.debterrors = [];
      this.debtPop = true;
      this.debtStatus = 'Update the item';
      this.debtformtype = 'editpostform';
      this.targetDebt = e.target.getAttribute('data-id');
      this.debtObj = this.debts.find((data) => data.id == this.targetDebt);
      this.debtType = this.debtObj.meta.debt_type;
      this.debts.find((data) => data.id == this.targetDebt).expand = false;
    },
    deleteDebtThisPost: function(e){
      var comp = this;
      var targetId = e.target.getAttribute('data-id');
      var formData = {};
      var createPost = new XMLHttpRequest();
      createPost.open("DELETE", zbs_account.site + 'wp-json/wp/v2/debt/' + targetId, true);
      createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
      createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      createPost.send(JSON.stringify(formData));
      createPost.onreadystatechange = function() {
        if (createPost.readyState == 4){
          if(createPost.status == 200){
            comp.debtformtype = 'newpostform';
            comp.debtForTransactionObj = null;
            comp.debtForTransaction = null;
            fetch(zbs_account.site + 'wp-json/wp/v2/debt?_embed&author=' + comp.user.data.ID)
            .then((r) => r.json())
            .then((res) => {
              comp.debts = [];
              comp.totalDebit = 0;
              comp.totalCredit = 0;
              res.map(item => {
                var itemTransactions = JSON.parse(item.meta.debt_transactions);
                let itemAmount = 0;
                let itemType = 'no-debt';          
                itemTransactions.forEach(trans => {
                  if(trans.transaction_type == 'debit'){
                    itemAmount += parseInt(trans.transaction_amount);
                  }
                  if(trans.transaction_type == 'credit'){
                    itemAmount -= parseInt(trans.transaction_amount);
                  }
                });

                if(itemAmount > 0){
                  itemType = 'debit';
                  comp.totalDebit += itemAmount;
                }

                if(itemAmount < 0){
                  itemType = 'credit';
                  comp.totalCredit += itemAmount;
                }
                comp.debts.push({...item, debt_amount: itemAmount, debt_type: itemType, expand: false});
              });
              comp.notificationPop('Debt deleted and list updated');
            });
          }
        }
      }
    },
     debtTransactionSubmit: function(){
      var comp = this;
      comp.progressEnable = true;
      if(comp.newdebttransactionamount != '' && comp.debtTransactionType != ''){        
        var newTransactionData = [{
          'id': comp.debtForTransactionTransactions.length ? comp.debtForTransactionTransactions.length + 1 : 1,
          'transaction_amount': comp.newdebttransactionamount,
          'transaction_note': comp.newdebttransactionnote ? comp.newdebttransactionnote : '',
          'transaction_type': comp.debtTransactionType,
          'transaction_date': new Date()
        }, ...JSON.parse(comp.debtForTransactionObj.meta.debt_transactions)];

        var formData = {
          'meta': {
            'debt_transactions': JSON.stringify(newTransactionData)
          }
        };

        var createPost = new XMLHttpRequest();
        createPost.open("POST", zbs_account.site + 'wp-json/wp/v2/debt/' + comp.debtForTransaction);
        createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
        createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        createPost.send(JSON.stringify(formData));
        createPost.onreadystatechange = function() {
          if(createPost.readyState == 0){
            comp.btnDebtTransactionDisabled = true;
            comp.debtTransactionStatus = 'Processing request...';
          } else if (createPost.readyState == 1){
            comp.debtTransactionStatus = 'Request sending...';
          } else if (createPost.readyState == 4){
            if(createPost.status == 200){              
              fetch(zbs_account.site + 'wp-json/wp/v2/debt?_embed&author=' + comp.user.data.ID)
                .then((r) => {
                  return r.json();
                })
                .then((res) => {
                  comp.debts = [];
                  comp.totalDebit = 0;
                  comp.totalCredit = 0;
                  res.map(item => {
                    let itemTransactions = JSON.parse(item.meta.debt_transactions);
                    let itemAmount = 0;
                    let itemType = 'no-debt';
                    
                    itemTransactions.forEach(trans => {
                      if(trans.transaction_type == 'debit'){
                        itemAmount += parseInt(trans.transaction_amount);
                      }
                      if(trans.transaction_type == 'credit'){
                        itemAmount -= parseInt(trans.transaction_amount);
                      }
                    });

                    if(itemAmount > 0){
                      itemType = 'debit';
                      comp.totalDebit += itemAmount;
                    }

                    if(itemAmount < 0){
                      itemType = 'credit';
                      comp.totalCredit += itemAmount;
                    }

                    comp.debts.push({...item, debt_amount: itemAmount, debt_type: itemType, expand: false});   
                    if(comp.debtForTransaction == item.id){
                      comp.debtForTransactionObj = {...item, debt_amount: itemAmount, debt_type: itemType, expand: false};
                      comp.debtForTransactionTransactions = itemTransactions;
                    }                 
                  });
                }).then(() => {
                  if((comp.debtForTransactionTransactions.length / comp.debtTransactionPaging.pageSize) > parseInt(comp.debtForTransactionTransactions.length / comp.debtTransactionPaging.pageSize)){
                    comp.debtTransactionPaging.totalPage =  parseInt(comp.debtForTransactionTransactions.length / comp.debtTransactionPaging.pageSize) + 1;
                  } else {
                    comp.debtTransactionPaging.totalPage =  parseInt(comp.debtForTransactionTransactions.length / comp.debtTransactionPaging.pageSize);
                  }
                });
              comp.newdebttransactionamount = '';
              comp.newdebttransactionnote = 'Borrowed';
              comp.debtTransactionType = 'debit';
              comp.debtTransactionStatus = 'Successfully Posted';
              comp.debtTransactionPop = false;
              comp.debttransactionerrors = [];
              comp.btnDebtTransactionDisabled = false;
              comp.debtTransactionStatus = 'Go';
              comp.progressEnable = false;
              comp.notificationPop('Transaction added and list updated');
            } else {
              comp.debtTransactionStatus = 'Error! Try again';
              comp.btnDebtTransactionDisabled = false;
              comp.progressEnable = false;
              comp.notificationPop('There was a error. Try again.');
            }
          }
        }
      } else {
        if (!comp.debtTransactionType) {
          comp.progressEnable = false;
          comp.debttransactionerrors.push('Type required.');
          comp.notificationPop('Type required');
        }
        if (!comp.newdebttransactionamount) {
          comp.progressEnable = false;
          comp.debttransactionerrors.push('Amount required.');
          comp.notificationPop('Amount required');
        }
      }
    },
      deleteDebtTransactionThisPost: function(e){
      var comp = this;
      var newTransactionData = comp.debtForTransactionTransactions.filter(trans => trans.id != e.target.getAttribute('data-id'));
      var formData = {
        'meta': {
          'debt_transactions': JSON.stringify(newTransactionData)
        }
      };

      var createPost = new XMLHttpRequest();
      createPost.open("POST", zbs_account.site + 'wp-json/wp/v2/debt/' + comp.debtForTransaction);
      createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
      createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      createPost.send(JSON.stringify(formData));
      createPost.onreadystatechange = function() {
        if (createPost.readyState == 4){
          if(createPost.status == 200){              
            fetch(zbs_account.site + 'wp-json/wp/v2/debt?_embed&author=' + comp.user.data.ID)
              .then((r) => {
                return r.json();
              })
              .then((res) => {
                comp.debts = [];
                comp.totalDebit = 0;
                comp.totalCredit = 0;
                res.map(item => {
                  let itemTransactions = JSON.parse(item.meta.debt_transactions);
                  let itemAmount = 0;
                  let itemType = 'no-debt';
                  
                  itemTransactions.forEach(trans => {
                    if(trans.transaction_type == 'debit'){
                      itemAmount += parseInt(trans.transaction_amount);
                    }
                    if(trans.transaction_type == 'credit'){
                      itemAmount -= parseInt(trans.transaction_amount);
                    }
                  });

                  if(itemAmount > 0){
                    itemType = 'debit';
                    comp.totalDebit += itemAmount;
                  }

                  if(itemAmount < 0){
                    itemType = 'credit';
                    comp.totalCredit += itemAmount;
                  }

                  comp.debts.push({...item, debt_amount: itemAmount, debt_type: itemType, expand: false});
                  if(comp.debtForTransaction == item.id){
                    comp.debtForTransactionObj = {...item, debt_amount: itemAmount, debt_type: itemType, expand: false};
                    comp.debtForTransactionTransactions = itemTransactions;
                  }
                });
              }).then(() => {
                if((comp.debtForTransactionTransactions.length / comp.debtTransactionPaging.pageSize) > parseInt(comp.debtForTransactionTransactions.length / comp.debtTransactionPaging.pageSize)){
                  comp.debtTransactionPaging.totalPage =  parseInt(comp.debtForTransactionTransactions.length / comp.debtTransactionPaging.pageSize) + 1;
                } else {
                  comp.debtTransactionPaging.totalPage =  parseInt(comp.debtForTransactionTransactions.length / comp.debtTransactionPaging.pageSize);
                }
              });
            comp.notificationPop('Transaction deleted and list updated');
          } else {
            comp.notificationPop('There was a error. Try again.');
          }
        }
      }
    },
      debtTransactionPrevPage:function() {
      if(this.debtTransactionPaging.currentPage > 1) this.debtTransactionPaging.currentPage--;
    },
    debtTransactionNextPage:function() {
      if((this.debtTransactionPaging.currentPage*this.debtTransactionPaging.pageSize) < this.debtForTransactionTransactions.length) this.debtTransactionPaging.currentPage++;
    },
    openNewDebtForm: function(){
      if(this.debts.length < 10){
        this.debtformtype = 'newpostform';
        this.debtStatus = 'Go';
        this.targetDebt = null;
        this.debtObj = null;
        this.debterrors = [];
        this.debtPop = true; 
      } else {
        this.notificationPop('Upto 10 debt allowed. Get pro for unlimited.');
      }
    },
    openDebtForTransaction: function(e){
      this.debtForTransaction = e.target.getAttribute('data-id');
      this.debtForTransactionObj = this.debts.find((data) => data.id == this.debtForTransaction);
      this.debtForTransactionTransactions = JSON.parse(this.debtForTransactionObj.meta.debt_transactions);
      if((this.debtForTransactionTransactions.length / this.debtTransactionPaging.pageSize) > parseInt(this.debtForTransactionTransactions.length / this.debtTransactionPaging.pageSize)){
        this.debtTransactionPaging.totalPage =  parseInt(this.debtForTransactionTransactions.length / this.debtTransactionPaging.pageSize) + 1;
      } else {
        this.debtTransactionPaging.totalPage =  parseInt(this.debtForTransactionTransactions.length / this.debtTransactionPaging.pageSize);
      }
      this.readMoreActivated = false;
    },
     nextPage:function() {
      if((this.paging.currentPage*this.paging.pageSize) < this.transactions.length) this.paging.currentPage++;
    },
     prevPage:function() {
      if(this.paging.currentPage > 1) this.paging.currentPage--;
    },
      deleteThisPost: function(e){
      var comp = this;
      var targetId = e.target.getAttribute('data-id');
      var targetToDelete = this.transactions.find((data) => data.id == targetId);
      var formData = {};
      var createPost = new XMLHttpRequest();
      createPost.open("DELETE", zbs_account.site + 'wp-json/wp/v2/transaction/' + targetId, true);
      createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
      createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      createPost.send(JSON.stringify(formData));
      createPost.onreadystatechange = function() {
        if (createPost.readyState == 4){
          if(createPost.status == 200){
            if(targetToDelete.meta.transaction_type == 'Earning'){
              comp.totalEarning -= parseFloat(targetToDelete.meta.transaction_amount);
            }
            if(targetToDelete.meta.transaction_type == 'Expense'){
              comp.totalExpense -= parseFloat(targetToDelete.meta.transaction_amount);
            }
            fetch(zbs_account.site + 'wp-json/wp/v2/transaction?_embed&author=' + comp.user.data.ID)
            .then((r) => r.json())
            .then((res) => {
              comp.transactions = [];
              comp.totalEarning = 0;
              comp.totalExpense = 0;
              res.map(item => {
                comp.transactions.push({...item, expand: false});
                if(item.meta.transaction_type == 'Earning'){
                  comp.totalEarning += parseFloat(item.meta.transaction_amount);
                }
                if(item.meta.transaction_type == 'Expense'){
                  comp.totalExpense += parseFloat(item.meta.transaction_amount);
                }
              });
              comp.notificationPop('Transaction deleted and list updated');
            });
          }
        }
      }
    },
     createNewDuplication: function(e){
      var comp = this;
      var targetToDuplicate = this.transactions.find((data) => data.id == e.target.getAttribute('data-id'));
      this.transactions.find((data) => data.id == e.target.getAttribute('data-id')).expand = false;
      var formData = {
        'title': targetToDuplicate.title.rendered,
        'author': this.user.data.ID,
        'status': 'publish',
        'transaction_category': targetToDuplicate.transaction_category[0],
        'meta': {
          'transaction_amount': targetToDuplicate.meta.transaction_amount,
          'transaction_note': targetToDuplicate.meta.transaction_note,
          'transaction_type': targetToDuplicate.meta.transaction_type
        }
      };

      var createPost = new XMLHttpRequest();
      createPost.open("POST", zbs_account.site + 'wp-json/wp/v2/transaction');
      createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
      createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      createPost.send(JSON.stringify(formData));
      createPost.onreadystatechange = function() {
        if (createPost.readyState == 4){
          if(createPost.status == 201){
            var returnData = JSON.parse(this.responseText);
            comp.transactions.unshift(returnData);
            if(returnData.meta.transaction_type == 'Earning'){
              comp.totalEarning += parseFloat(returnData.meta.transaction_amount);
            }
            if(returnData.meta.transaction_type == 'Expense'){
              comp.totalExpense += parseFloat(returnData.meta.transaction_amount);
            }
            comp.notificationPop('A duplicate transaction created');
          }
        }
      }
    },
    emailsubmit: function(){
      var comp = this;
      comp.sub_error = [];
      if(!comp.sub_email){
        this.sub_error.push('Email required.');
        comp.notificationPop('Email required');
      } else if(!this.validEmail(comp.sub_email)){
        this.sub_error.push('Valid email required.');
        comp.notificationPop('Enter valid email');
      } else {
        jQuery.ajax({
          url: zbs_account.ajaxurl,
          dataType: 'json',
          type: 'post',
          data: {
            'action': 'zbs_subscribe',
            'email': comp.sub_email,
            'nonce': zbs_account.ajaxnonce
          },
          beforeSend: function( xhr ) {
            comp.sub_status = 'Be patient. Your email is being submitted...';
          },
          success:function(data) {
            res = data.json();
            comp.sub_status = res.responseText;
            comp.sub_email = '';
            comp.sub_submitted = true;
            comp.notificationPop('Subscription Successful');
          },
          error: function(err){
            comp.sub_status = err.responseText;
            comp.sub_email = '';
            comp.sub_submitted = true;
            comp.notificationPop(err.responseText);
          }
        });
      }
    },
      debtSubmit: function() {
      var comp = this;
      comp.progressEnable = true;
      comp.debterrors = [];
      if(comp.debtformtype == 'editpostform'){
        let name = comp.debttitle;
        if(name){
          if(!comp.validFullName(comp.debttitle)){
            comp.debterrors.push('Name is not valid.');
            comp.notificationPop('Name is not valid');
            comp.progressEnable = false;
            return false;
          }
        } else {
          name = comp.debtForTransactionObj.id;
        }

        if(comp.deptPhoneNumber){
          if(isNaN(comp.deptPhoneNumber)){
            comp.debterrors.push('Phone number is not valid.');
            comp.notificationPop('Phone number is not valid.');
            comp.progressEnable = false;
            return false;
          }
        }

        var formData = {
          'title': name,
          'author': comp.user.data.ID,
          'meta': {
            'debt_transactions': JSON.stringify(transactionData),
            'debt_note': comp.newdebtnote ? comp.newdebtnote : comp.debtForTransactionObj.meta.debt_note,
            'debt_phone': comp.deptPhoneNumber ? comp.deptPhoneNumber : comp.debtForTransactionObj.meta.debt_phone,
            'debt_email': comp.deptEmailAddress? comp.deptEmailAddress : comp.debtForTransactionObj.meta.debt_email
          }
        };

        var createPost = new XMLHttpRequest();
        createPost.open("POST", zbs_account.site + 'wp-json/wp/v2/debt/' + comp.debtForTransactionObj.id);
        createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
        createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        createPost.send(JSON.stringify(formData));
        createPost.onreadystatechange = function() {
          if(createPost.readyState == 0){
            comp.btnDebtDisabled = true;
            comp.debtStatus = 'Processing request...';
          } else if (createPost.readyState == 1){
            comp.debtStatus = 'Requesting sending...';
          } else if (createPost.readyState == 4){
            if(createPost.status == 200){
              comp.debttitle = '';
              comp.newdebtamount = '';
              comp.newdebtnote = '';
              comp.deptPhoneNumber = '';
              comp.deptEmailAddress = '';
              var returnData = JSON.parse(this.responseText);
              comp.debts.map((data, index) => {
                if(data.id == comp.debtForTransactionObj.id){
                  comp.debts[index].title.rendered = returnData.title.rendered;
                  comp.debts[index].meta.debt_email = returnData.meta.debt_email;
                  comp.debts[index].meta.debt_note = returnData.meta.debt_note;
                  comp.debts[index].meta.debt_phone = returnData.meta.debt_phone;
                  comp.debtForTransactionObj = comp.debts[index];
                }
              });
              comp.debtStatus = 'Successfully Posted';
              comp.debtPop = false;
              comp.debterrors = [];
              comp.btnDebtDisabled = false;
              comp.debtStatus = 'Go';
              comp.progressEnable = false;
              comp.notificationPop('Debt detail updated');
            } else {
              comp.debtStatus = 'Error! Try again';
              comp.btnDebtDisabled = false;
              comp.progressEnable = false;
              comp.notificationPop('There was a error. Try again');
            }
          }
        }
      } else {
        if( comp.debttitle != '' && comp.validFullName(comp.debttitle) ){

          if(comp.deptPhoneNumber){
            if(isNaN(comp.deptPhoneNumber)){
              comp.debterrors.push('Phone number is not valid.');
              comp.notificationPop('Phone number is not valid.');
              comp.progressEnable = false;
              return false;
            }
          }

          var transactionData = [];
          if(comp.addPrevToDebt){
            transactionData = [{
              'id': 1,
              'transaction_amount': this.newdebtamount ? this.newdebtamount : 0,
              'transaction_note': 'Prevous Debt',
              'transaction_type': this.debtType ? this.debtType : 'debit',
              'transaction_date': new Date()
            }];
          }
          var formData = {
            'title': comp.debttitle,
            'author': comp.user.data.ID,
            'status': 'publish',
            'meta': {
              'debt_transactions': JSON.stringify(transactionData),
              'debt_note': comp.newdebtnote,
              'debt_phone': comp.deptPhoneNumber ? comp.deptPhoneNumber : '',
              'debt_email': comp.deptEmailAddress? comp.deptEmailAddress : ''
            }
          };

          var createPost = new XMLHttpRequest();
          createPost.open("POST", zbs_account.site + 'wp-json/wp/v2/debt');
          createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
          createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
          createPost.send(JSON.stringify(formData));
          createPost.onreadystatechange = function() {
            if(createPost.readyState == 0){
              comp.btnDebtDisabled = true;
              comp.debtStatus = 'Processing request...';
            } else if (createPost.readyState == 1){
              comp.debtStatus = 'Requesting sending...';
            } else if (createPost.readyState == 4){
              if(createPost.status == 201){
                comp.debttitle = '';
                comp.newdebtamount = '';
                comp.newdebtnote = '';
                comp.deptPhoneNumber = '';
                comp.deptEmailAddress = '';
                var returnData = JSON.parse(this.responseText);
                var itemTransactions = JSON.parse(returnData.meta.debt_transactions);
                let itemAmount = 0;
                let itemType = 'no-debt';           
                itemTransactions.forEach(trans => {
                  if(trans.transaction_type == 'debit'){
                    itemAmount += parseInt(trans.transaction_amount);
                  }
                  if(trans.transaction_type == 'credit'){
                    itemAmount -= parseInt(trans.transaction_amount);
                  }
                });

                if(itemAmount > 0){
                  itemType = 'debit';
                  comp.totalDebit += itemAmount;
                }

                if(itemAmount < 0){
                  itemType = 'credit';
                  comp.totalCredit += itemAmount;
                }
                comp.debts.unshift({...returnData, debt_amount: itemAmount, debt_type: itemType, expand: false});
                comp.debtStatus = 'Successfully Posted';
                comp.debtPop = false;
                comp.debterrors = [];
                comp.btnDebtDisabled = false;
                comp.debtStatus = 'Go';
                comp.progressEnable = false;
                comp.notificationPop('Debt added to the list');
              } else {
                comp.debtStatus = 'Error! Try again';
                comp.btnDebtDisabled = false;
                comp.progressEnable = false;
                comp.notificationPop('There was a error. Try again');
              }
            }
          }
        } else {
          if (!comp.debttitle) {
            comp.debterrors.push('Name required.');
            comp.notificationPop('Name required');
          }
          if(!comp.validFullName(comp.debttitle)){
            comp.debterrors.push('Name is not valid.');
            comp.notificationPop('Name is not valid');
          }
          comp.progressEnable = false;
        }
      }     
      
    },
     validFullName: function (name) {
      var re = /^[a-zA-Z ]+$/ ;
      return re.test(name);
    },
    validEmail: function (email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    catsubmit: function() {
      var comp = this;
      if(comp.newcat != ''){
        var formData = {
          'name': comp.newcat,
          'meta': {
              'color': 'rgb(103, 104, 108)',
              'icon': 'quiz'
          }
        };

        var createCat = new XMLHttpRequest();
        createCat.open("POST", zbs_account.site + 'wp-json/wp/v2/transaction_category');
        createCat.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
        createCat.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        createCat.send(JSON.stringify(formData));
        createCat.onreadystatechange = function() {
          if (createCat.readyState == 4){
            if(createCat.status == 201){
              var returnData = JSON.parse(this.responseText);
              comp.cats.push(returnData);
              comp.notificationPop('New category added');
            } 
          } 
        }
      }       
    },
       openNewPostForm: function(){
      this.postformtype = 'newpostform';
      this.postStatus = 'Add to list';
      this.targetPost = null;
      this.postObj = null;
      this.errors = [];
      this.postPop = true; 
    },
    openNewDebtTransactionForm: function(){
      this.debtTransactionStatus = 'Go';
      this.debttransactionerrors = [];
      this.debtTransactionPop = true; 
    },
     quickDebtAdd: function(e){
      if(this.debts.length < 10){
        this.debtType = e.target.getAttribute('data-ttype');
        this.debterrors = [];
        this.debtPop = true;
      } else {
        this.notificationPop('Upto 10 debt allowed. Get pro for unlimited.');
      }
    },
    notificationPop: function(msg){
      this.notification = msg;
      this.notificationEnable = true;
      setTimeout(() => this.notificationEnable = false, 2000);
    },
       localeDate: function(date){
      let ddate = new Date(date);
      return ddate.toLocaleString('en-US', {
        day: '2-digit', 
        year: 'numeric', 
        month: 'short', 
        hour: 'numeric',
        minute: 'numeric', 
        second: 'numeric'
      })
    },
     getAvatar: function(email, size){
      var base = "http://www.gravatar.com/avatar/";
      var hash = this.jsMD5(email);
      var fullUrl = base+hash +"jpg?s="+size;
      return fullUrl;
    },
    jsMD5: function (string) {
    
      function RotateLeft(lValue, iShiftBits) {
        return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
      }
    
      function AddUnsigned(lX,lY) {
        var lX4,lY4,lX8,lY8,lResult;
        lX8 = (lX & 0x80000000);
        lY8 = (lY & 0x80000000);
        lX4 = (lX & 0x40000000);
        lY4 = (lY & 0x40000000);
        lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
        if (lX4 & lY4) {
          return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
        }
        if (lX4 | lY4) {
          if (lResult & 0x40000000) {
            return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
          } else {
            return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
          }
        } else {
          return (lResult ^ lX8 ^ lY8);
        }
      }
    
      function F(x,y,z) { return (x & y) | ((~x) & z); }
      function G(x,y,z) { return (x & z) | (y & (~z)); }
      function H(x,y,z) { return (x ^ y ^ z); }
      function I(x,y,z) { return (y ^ (x | (~z))); }
    
      function FF(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
      };
    
      function GG(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
      };
    
      function HH(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
      };
    
      function II(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
      };
    
      function ConvertToWordArray(string) {
        var lWordCount;
        var lMessageLength = string.length;
        var lNumberOfWords_temp1=lMessageLength + 8;
        var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
        var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
        var lWordArray=Array(lNumberOfWords-1);
        var lBytePosition = 0;
        var lByteCount = 0;
        while ( lByteCount < lMessageLength ) {
          lWordCount = (lByteCount-(lByteCount % 4))/4;
          lBytePosition = (lByteCount % 4)*8;
          lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
          lByteCount++;
        }
        lWordCount = (lByteCount-(lByteCount % 4))/4;
        lBytePosition = (lByteCount % 4)*8;
        lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
        lWordArray[lNumberOfWords-2] = lMessageLength<<3;
        lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
        return lWordArray;
      };
    
      function WordToHex(lValue) {
        var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
        for (lCount = 0;lCount<=3;lCount++) {
          lByte = (lValue>>>(lCount*8)) & 255;
          WordToHexValue_temp = "0" + lByte.toString(16);
          WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
        }
        return WordToHexValue;
      };
    
      function Utf8Encode(string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
    
        for (var n = 0; n < string.length; n++) {
    
          var c = string.charCodeAt(n);
    
          if (c < 128) {
            utftext += String.fromCharCode(c);
          }
          else if((c > 127) && (c < 2048)) {
            utftext += String.fromCharCode((c >> 6) | 192);
            utftext += String.fromCharCode((c & 63) | 128);
          }
          else {
            utftext += String.fromCharCode((c >> 12) | 224);
            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
            utftext += String.fromCharCode((c & 63) | 128);
          }
    
        }
    
        return utftext;
      };
    
      var x=Array();
      var k,AA,BB,CC,DD,a,b,c,d;
      var S11=7, S12=12, S13=17, S14=22;
      var S21=5, S22=9 , S23=14, S24=20;
      var S31=4, S32=11, S33=16, S34=23;
      var S41=6, S42=10, S43=15, S44=21;
    
      string = Utf8Encode(string);
    
      x = ConvertToWordArray(string);
    
      a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
    
      for (k=0;k<x.length;k+=16) {
        AA=a; BB=b; CC=c; DD=d;
        a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
        d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
        c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
        b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
        a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
        d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
        c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
        b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
        a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
        d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
        c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
        b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
        a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
        d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
        c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
        b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
        a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
        d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
        c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
        b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
        a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
        d=GG(d,a,b,c,x[k+10],S22,0x2441453);
        c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
        b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
        a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
        d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
        c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
        b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
        a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
        d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
        c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
        b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
        a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
        d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
        c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
        b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
        a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
        d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
        c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
        b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
        a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
        d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
        c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
        b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
        a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
        d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
        c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
        b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
        a=II(a,b,c,d,x[k+0], S41,0xF4292244);
        d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
        c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
        b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
        a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
        d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
        c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
        b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
        a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
        d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
        c=II(c,d,a,b,x[k+6], S43,0xA3014314);
        b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
        a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
        d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
        c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
        b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
        a=AddUnsigned(a,AA);
        b=AddUnsigned(b,BB);
        c=AddUnsigned(c,CC);
        d=AddUnsigned(d,DD);
      }
    
      var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);
    
      return temp.toLowerCase();
    },
    
    inserProfile: async function(){
 
          const response = await axios.post(zbs_account.ajaxurl + "?action=zbs_insertProfile", { 
            accountName: this.accountName
          })
          console.log(response.data);
          this.displayProfile();

    },
    updateProfile: function(){
      jQuery.post(zbs_account.ajaxurl,
                    { 'action':'zbs_updateProfile','id': 0,'updatedName':'Aname' }, 
                    function(data)
                    {
                      //console.log(data);
                    }
                    );
    },
    deleteProfile: async function(id){
      if(confirm("Are You sure to delete this Account Profile ?")){
      const response = await axios.post(zbs_account.ajaxurl + "?action=zbs_deleteProfile", { 
        id: id
      });
      console.log(response.data);
      this.displayProfile();}
    },
    displayProfile: function(){
     fetch(zbs_account.ajaxurl + '?action=zbs_displayProfile')
      .then((r) => {
        return r.json()
      })
      .then((data) => {
        this.profiles = data.data || [];
      })
    },
    async setDefaultProfile (profileID){
        const response = await axios.post(zbs_account.ajaxurl + "?action=zbs_set_default_profile", { 
          profileID: profileID
        });
        // console.log(response.data);
        if(response.data.success) {
          this.default_profile = profileID;
        }
        this.displayProfile();
    },

    activateReadMore: function(){
      this.readMoreActivated = true;
    },
    deactivateReadMore: function(){
      this.readMoreActivated = false;
    },


    async fetchTransactions(){

      var date = new Date();
      var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
      if(window.location.hash){
        this.sidebarPage = window.location.hash.replace('#', '');
      }

      fetch(zbs_account.site + 'wp-json/wp/v2/transaction?_embed&author=' + this.user.data.ID)
        .then((r) => {
          return r.json();
        })
        .then((res) => {
          this.totalEarning = 0;
          this.totalExpense = 0;

          //console.log(res[0]);
          this.transactions = [];

          res.forEach(item => {
            this.transactions.push({...item, expand: false, showNote: item.meta.transaction_note ? true : false});
            // if(item.meta.transaction_type == 'Earning'){
            //   this.totalEarning += parseFloat(item.meta.transaction_amount);
            // }
            // if(item.meta.transaction_type == 'Expense'){
            //   this.totalExpense += parseFloat(item.meta.transaction_amount);
            // }
          });

          if((this.transactions.length / this.paging.pageSize) > parseInt(this.transactions.length / this.paging.pageSize)){
            this.paging.totalPage =  parseInt(this.transactions.length / this.paging.pageSize) + 1;
          } else {
            this.paging.totalPage =  parseInt(this.transactions.length / this.paging.pageSize);
          }

        }) 
    }
    

  },

}
</script>

<style>

</style>
