<template>
  <!-- <img alt="Vue logo" src="./assets/logo.png"> -->
  <!-- <HelloWorld msg="Welcome to Your Vue.js App"/> -->
   <div class="zbs-account" @click="handleOpenClick">
      <div class="zbs-sidebar" v-if="user">
     <ul class="zbs-sidebar-menu">
        <li v-bind:class="{active: sidebarPage == 'accounting'}" @click="sidebarPageChange('accounting')"><span class="material-icons-outlined">home</span><span class="sidebar-menu-title">Accounting</span></li>

           <li v-bind:class="{active: sidebarPage == 'debt'}" @click="sidebarPageChange('debt')"><span class="material-icons-outlined">calculate</span><span class="sidebar-menu-title">Debt Tracking</span></li>
         
         <li v-bind:class="{active: sidebarPage == 'overview'}" @click="sidebarPageChange('overview')"><span class="material-icons-outlined">layers</span><span class="sidebar-menu-title">Overview</span></li>

         <li v-bind:class="{active: sidebarPage == 'categories'}" @click="sidebarPageChange('categories'); newcat=''"><span class="material-icons-outlined">folder_special</span><span class="sidebar-menu-title">Categories</span></li>

         <li v-bind:class="{active: sidebarPage == 'integrations'}" @click="sidebarPageChange('integrations')"><span class="material-icons-outlined">extension</span><span class="sidebar-menu-title">Integrations</span></li>

         <li class="setting-item" :class="{active: configActive}" @click="viewConfigurationPage"><span class="material-icons-outlined">settings</span><span class="sidebar-menu-title">Configuration</span></li>
      </ul>
       <ul class="zbs-sidebar-menu zbs-sidebar-menu-bottom">
        <li v-bind:class="{active: configActive}" @click="viewConfigurationPage"><span class="material-icons-outlined">settings</span><span class="sidebar-menu-title">Configuration</span></li>
      </ul> 
           <!-- <li  :class="{active: sidebarPage == 'accounting'}" @click="sidebarPageChange('accounting')"><span class="material-icons-outlined">home</span><span class="sidebar-menu-title">Accounting</span></li> -->

         <!-- <li v-bind:class="{active: sidebarPage == 'debt'}" @click="sidebarPageChange('debt')"><span class="material-icons-outlined">calculate</span><span class="sidebar-menu-title">Debt Tracking</span></li> -->

         <!-- <li v-bind:class="{active: sidebarPage == 'overview'}" @click="sidebarPageChange('overview')"><span class="material-icons-outlined">layers</span><span class="sidebar-menu-title">Overview</span></li> -->

        <!-- <li v-bind:class="{active: sidebarPage == 'categories'}" @click="sidebarPageChange('categories'); newcat=''"><span class="material-icons-outlined">folder_special</span><span class="sidebar-menu-title">Categories</span></li> -->
      
        <!-- <li v-bind:class="{active: sidebarPage == 'integrations'}" @click="sidebarPageChange('integrations')"><span class="material-icons-outlined">extension</span><span class="sidebar-menu-title">Integrations</span></li> -->

         <!-- <li class="setting-item" :class="{active: configActive}" @click="configActive = true"><span class="material-icons-outlined">settings</span><span class="sidebar-menu-title">Configuration</span></li>
      </ul> -->
      <!-- <ul class="zbs-sidebar-menu zbs-sidebar-menu-bottom">
        <li v-bind:class="{active: configActive}" @click="configActive = true"><span class="material-icons-outlined">settings</span><span class="sidebar-menu-title">Configuration</span></li>
      </ul>  -->
    


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
                  <span>{{selectedCurrency.code}}</span>
                  <span>{{selectedCurrency.symbol_native}}</span>
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

  <div class="zbs-progress" :class="{ active: progressEnable }"><svg class="zbs-spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="circle" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg>
  </div>
    <div class="zbs-notification" :class="{ active: notificationEnable }">{{notification}}
    </div>

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

     <!-- <div class="accounting-page" v-bind:style="{ display: sidebarPage == 'accounting' ? 'block' : 'none' }">
      <div class="kh-container" v-if="user">
        <div class="kh-row">
            <div class="kh-col">
                <h3 class="top-welecome">Hi, {{user.data.display_name}}</h3>
            </div>
        </div>

        <div class="kh-mt-2">
          <div class="kh-row">
            <div class="kh-col-4">
              <div class="kh-card kh-card-flex">
                <div class="kh-card-content">
                    <p>Earning</p>
                    <h4>{{currencify(totalEarning, 2)}}</h4>
                </div>
              </div>
            </div>
            <div class="kh-col-4">
                <div class="kh-card kh-card-flex">
                    <div class="kh-card-content">
                        <p>Expense</p>
                        <h4>{{currencify(totalExpense, 2)}}</h4>
                    </div>
                </div>
            </div>
            <div class="kh-col-2">
              <div class="kh-card kh-card-flex kh-card-add kh-card-add-income" v-on:click="quickAdd" data-ttype="Earning">
                <svg class="card-top-right" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g opacity="0.6">
                  <path d="M11 21.3125C16.6954 21.3125 21.3125 16.6954 21.3125 11C21.3125 5.30456 16.6954 0.6875 11 0.6875C5.30456 0.6875 0.6875 5.30456 0.6875 11C0.6875 16.6954 5.30456 21.3125 11 21.3125Z" fill="#FFDD67"/>
                  <path d="M6.5313 7.15C6.5313 6.325 8.35318 6.70313 8.93755 7.2875C9.2813 6.70313 9.10943 6.1875 9.10943 6.1875C9.10943 6.1875 8.5938 5.80938 7.80318 5.67188V4.91563C7.18443 4.70938 6.49693 4.91563 6.49693 4.91563V5.6375C6.49693 5.6375 5.25943 5.87813 5.25943 7.15C5.25943 8.83438 7.80318 8.49063 7.80318 9.55625C7.80318 10.3469 6.08443 10.0031 5.25943 9.38438C4.98443 10.0031 5.25943 10.5531 5.25943 10.5531C5.87818 10.8281 6.49693 10.8969 6.49693 10.8969V11.5844C6.49693 11.5844 7.18443 11.7906 7.80318 11.5844V10.8625C7.80318 10.8625 9.24693 10.7938 9.24693 9.55625C9.2813 7.94063 6.5313 8.07813 6.5313 7.15Z" fill="#664E27"/>
                  <path d="M14.0938 7.15C14.0938 6.325 15.9157 6.70313 16.5001 7.2875C16.8438 6.70313 16.6719 6.1875 16.6719 6.1875C16.6719 6.1875 16.1563 5.80938 15.3657 5.67188V4.91563C14.7469 4.70938 14.0594 4.91563 14.0594 4.91563V5.6375C14.0594 5.6375 12.8219 5.87813 12.8219 7.15C12.8219 8.83438 15.3657 8.49063 15.3657 9.55625C15.3657 10.3469 13.6469 10.0031 12.8219 9.38438C12.5469 10.0031 12.8219 10.5531 12.8219 10.5531C13.4407 10.8281 14.0594 10.8969 14.0594 10.8969V11.5844C14.0594 11.5844 14.7469 11.7906 15.3657 11.5844V10.8625C15.3657 10.8625 16.8094 10.7938 16.8094 9.55625C16.8438 7.94063 14.0938 8.07813 14.0938 7.15Z" fill="#664E27"/>
                  <path d="M16.4656 13.0625H5.53438C5.29375 13.0625 5.15625 13.2344 5.15625 13.4062C5.15625 15.9156 7.21875 18.5625 11 18.5625C14.7812 18.5625 16.8438 15.9156 16.8438 13.4062C16.8438 13.2344 16.7063 13.0625 16.4656 13.0625Z" fill="#664E27"/>
                  <path d="M14.1625 15.125H7.8375C7.59687 15.125 7.5625 15.2281 7.5625 15.4V16.775C7.5625 19.8 9.10938 21.3125 11 21.3125C12.8906 21.3125 14.4375 19.8 14.4375 16.775V15.4C14.4375 15.2281 14.4031 15.125 14.1625 15.125Z" fill="#74E063"/>
                  <path d="M10.5532 17.0156C10.5532 16.4656 11.6876 16.7406 12.0657 17.1188C12.3064 16.7406 12.1689 16.3969 12.1689 16.3969C12.1689 16.3969 11.8251 16.1563 11.3439 16.0531V15.5375C10.9657 15.4 10.5189 15.5375 10.5189 15.5375V16.0188C10.5189 16.0188 9.72824 16.1563 9.72824 17.0156C9.72824 18.1156 11.3439 17.875 11.3439 18.5969C11.3439 19.1125 10.2782 18.9063 9.72824 18.4938C9.55637 18.9063 9.72824 19.25 9.72824 19.25C10.1064 19.4219 10.5189 19.4906 10.5189 19.4906V19.9375C10.5189 19.9375 10.9314 20.075 11.3439 19.9375V19.4563C11.3439 19.4563 12.2376 19.3875 12.2376 18.5969C12.3064 17.5313 10.5532 17.6344 10.5532 17.0156Z" fill="#449636"/>
                  <path d="M13.6123 15.125V16.3281C13.6123 19.1813 12.5811 20.4531 10.9998 20.4531C9.41855 20.4531 8.3873 19.2156 8.3873 16.3281V15.125H8.1123V16.3281C8.1123 19.3875 9.24668 20.7625 10.9998 20.7625C12.7529 20.7625 13.8873 19.3875 13.8873 16.3281V15.125H13.6123Z" fill="#449636"/>
                  </g>
                </svg>
                Add <br/>Earning
                <svg class="card-bottom-right" width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="12" r="10" fill="#D7F5EA"/>
                  <path d="M16.3125 11.25H12.75V7.6875C12.75 7.58437 12.6656 7.5 12.5625 7.5H11.4375C11.3344 7.5 11.25 7.58437 11.25 7.6875V11.25H7.6875C7.58437 11.25 7.5 11.3344 7.5 11.4375V12.5625C7.5 12.6656 7.58437 12.75 7.6875 12.75H11.25V16.3125C11.25 16.4156 11.3344 16.5 11.4375 16.5H12.5625C12.6656 16.5 12.75 16.4156 12.75 16.3125V12.75H16.3125C16.4156 12.75 16.5 12.6656 16.5 12.5625V11.4375C16.5 11.3344 16.4156 11.25 16.3125 11.25Z" fill="#014737"/>
                </svg>
              </div>
            </div>
            <div class="kh-col-2">
              <div class="kh-card kh-card-flex kh-card-add kh-card-add-expense" v-on:click="quickAdd" data-ttype="Expense">
                <svg class="card-top-right" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g opacity="0.6">
                  <path d="M0.6875 11C0.6875 16.7062 5.29375 21.3125 11 21.3125C16.7062 21.3125 21.3125 16.7062 21.3125 11C21.3125 5.29375 16.7062 0.6875 11 0.6875C5.29375 0.6875 0.6875 5.29375 0.6875 11Z" fill="#FDB2A1"/>
                  <path d="M16.397 12.925C16.397 15.8812 20.4188 15.8812 20.4188 12.925C20.4188 10.7594 18.4251 8.6625 18.4251 8.6625C18.4251 8.6625 16.397 10.7594 16.397 12.925Z" fill="#65B1EF"/>
                  <path d="M13.2344 13.75C14.1836 13.75 14.9531 12.9805 14.9531 12.0312C14.9531 11.082 14.1836 10.3125 13.2344 10.3125C12.2851 10.3125 11.5156 11.082 11.5156 12.0312C11.5156 12.9805 12.2851 13.75 13.2344 13.75Z" fill="#664E27"/>
                  <path d="M5.32812 13.75C6.27736 13.75 7.04688 12.9805 7.04688 12.0312C7.04688 11.082 6.27736 10.3125 5.32812 10.3125C4.37889 10.3125 3.60938 11.082 3.60938 12.0312C3.60938 12.9805 4.37889 13.75 5.32812 13.75Z" fill="#664E27"/>
                  <path d="M7.08135 6.84062C5.98135 7.76875 4.50322 8.18125 3.05947 7.90625C2.85322 7.87187 2.68135 8.59375 2.92197 8.6625C4.57197 8.97188 6.29072 8.49063 7.5626 7.425C7.73447 7.25313 7.21885 6.70312 7.08135 6.84062Z" fill="#917524"/>
                  <path d="M15.5035 7.87187C14.0597 8.1125 12.5816 7.73437 11.4816 6.80625C11.3441 6.66875 10.7941 7.21875 11.0003 7.39062C12.2722 8.49062 13.991 8.9375 15.641 8.62812C15.8816 8.55937 15.7097 7.8375 15.5035 7.87187Z" fill="#917524"/>
                  <path d="M13.0966 16.2594C11.1028 15.7438 8.97156 16.1219 7.28719 17.2906C6.87469 17.6 7.66531 18.6656 8.07781 18.3906C9.17781 17.6 10.9653 17.0844 12.7872 17.5656C13.2341 17.6688 13.6122 16.4313 13.0966 16.2594Z" fill="#664E27"/>
                  </g>
                </svg>
                Add <br/>Expense
                <svg class="card-bottom-right" width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="12" r="10" fill="#FFF1F2"/>
                  <path d="M17 14H8V11H17V14Z" fill="#B91C1C"/>
                </svg>
                </div>
            </div>
          </div>
        </div>

        <div class="kh-card kh-mt-3 kh-account-list">
          <div class="kh-card-header">
              <h3 class="kh-card-title">Recent Payment</h3>
              <label class="placehold-btn kh-card-btn" v-on:click="openNewPostForm">
                Add New
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.25781 6.09375H7.03125V3.86719C7.03125 3.80273 6.97852 3.75 6.91406 3.75H6.21094C6.14648 3.75 6.09375 3.80273 6.09375 3.86719V6.09375H3.86719C3.80273 6.09375 3.75 6.14648 3.75 6.21094V6.91406C3.75 6.97852 3.80273 7.03125 3.86719 7.03125H6.09375V9.25781C6.09375 9.32227 6.14648 9.375 6.21094 9.375H6.91406C6.97852 9.375 7.03125 9.32227 7.03125 9.25781V7.03125H9.25781C9.32227 7.03125 9.375 6.97852 9.375 6.91406V6.21094C9.375 6.14648 9.32227 6.09375 9.25781 6.09375Z"/>
                  <path d="M6.5625 0C2.93848 0 0 2.93848 0 6.5625C0 10.1865 2.93848 13.125 6.5625 13.125C10.1865 13.125 13.125 10.1865 13.125 6.5625C13.125 2.93848 10.1865 0 6.5625 0ZM6.5625 12.0117C3.55371 12.0117 1.11328 9.57129 1.11328 6.5625C1.11328 3.55371 3.55371 1.11328 6.5625 1.11328C9.57129 1.11328 12.0117 3.55371 12.0117 6.5625C12.0117 9.57129 9.57129 12.0117 6.5625 12.0117Z" />
                </svg>
              </label>
          </div> -->
          <div class="kh-post-pop" v-bind:class="{ active: postPop }" v-on:click="handleFormFocus">
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
                    <span class="cat-icon" v-bind:style="{ color: item.meta.color[0] ? item.meta.color[0] : 'rgb(103, 104, 108)' }"><span class="material-icons-outlined">{{item.meta.icon[0] ? item.meta.icon[0] : 'quiz'}}</span></span>
                    <span class="cat-name" v-html="item.name"></span>
                  </label>
                  <label type="button" v-on:click="catsubmit" v-if="!hasCat[0] && newcat">
                    <span class="cat-icon" v-bind:style="{ color: 'rgb(103, 104, 108)' }"><span class="material-icons-outlined">add</span></span>
                    <span class="cat-name">Add '{{newcat}}' as a new Category</span>
                  </label>
                </div>
              </label>
              <label class="field-group field-group-check"><input type="checkbox" v-model="addANote"><span>Add a note with this transaction</span></label>
              <label class="field-group" v-if="addANote">
                Note
                <textarea :placeholder="postformtype == 'editpostform' ? postObj.meta.transaction_note : 'Have any note...'" v-model="newnote"></textarea>
              </label>
              <input type="hidden" action="new_transaction"/>
              <button type="submit" :disabled='btnDisabled'>{{postStatus}}</button>
            </form>
          </div>
          <!-- <div class="account-table-responsive">
            <table class="kh-account-table">
                <tr class="kh-account-table-header">
                    <th class="tr-th"><span>Transaction</span></th>
                    <th class="type-th"><span>Type</span></th>
                    <th class="cat-th"><span>Category</span></th>
                    <th><span>Amount</span></th>
                    <th><span>&nbsp;</span></th>
                </tr>
                <tr class="kh-account-table-items" v-for="item in filteredPost" :key="item.id">
                    <td>
                      <span class="kh-t-title" v-html="item.title.rendered"></span>
                      <span class="kh-t-subtitle">{{item.formatted_date}}</span>
                    </td>
                    <td><span class="kh-type" v-bind:class="[item.meta.transaction_type == 'Expense' ? 'kh-type-expense' : '']">{{item.meta.transaction_type}}</span></td>
                    <td><span class="kh-t-category" v-if="item.category" v-html="item.category.name"></span></td>
                    <td><span class="kh-amount">{{item.meta.transaction_amount ? currencify(item.meta.transaction_amount, 0) : currencify('00', 0)}}</span></td>
                    <td class="postEditTd">
                      <label class="placehold-btn">
                        <input type="checkbox" v-model="item.expand"/>
                        <span class="material-icons-outlined post-existing-pop-toggle">more_horiz</span>
                      </label>
                      <div class="post-existing-pop" v-bind:class="{active: item.expand}">
                          <ul class="existing-post-dropdown">
                            <li v-on:click="enEditForm" :data-id="item.id">Edit Transaction</li>
                            <li v-on:click="createNewDuplication" :data-id="item.id">Duplicate Transaction</li>
                            <li v-on:click="deleteThisPost" :data-id="item.id" style="color: #B91C1C">Delete Transaction</li>
                          </ul>
                        </div>
                    </td>
                </tr>
            </table>
          </div>
          <div class="kh-pagination" v-if="paging.totalPage > 1">
            <span v-on:click="prevPage"><span class="material-icons-outlined">keyboard_arrow_left</span></span>
            <span v-for="index in paging.totalPage" v-bind:key="index"><span v-on:click="paging.currentPage = index" v-bind:class="{ current: paging.currentPage == index }">{{index}}</span></span>
            <span v-on:click="nextPage"><span class="material-icons-outlined">keyboard_arrow_right</span></span>
          </div>
      </div>
      </div>
      <div class="kh-container" v-else>
        <div class="kh-container-nopriv">
            <div class="kh-not-logged-in-notice">
                <h3>You are not logged in</h3>
                <p>Without being logged in you are not allowed to access the page of Zero BS Accounting. Log in and get yourselves organized for accounting matter...</p>
                <a :href="login_url">Log In</a>
            </div>
        </div>
      </div>
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

<!-- Debt-Tracking Page Start -->
      <!-- <div class="debt-page" v-bind:style="{ display: sidebarPage == 'debt' ? 'block' : 'none' }">
      <div class="kh-post-pop" v-bind:class="{ active: debtPop }" v-on:click="handleFormFocus">
          <form id="debtForm" class="post-form" @submit.prevent="debtSubmit">
            <label class="placehold-btn">
              <input type="checkbox" v-model="debtPop"/>
              <span class="material-icons-outlined">close</span>
            </label>
            <p class="lead">{{debtformtype == 'editpostform' ? `Edit ${debtForTransactionObj.title.rendered} person` : 'Add new person'}}</p>
            <p v-if="debterrors.length" class="error-box">
              <ul>
                <li v-for="error in debterrors" v-bind:key="error.key">{{ error }}</li>
              </ul>
            </p>
            <label class="field-group">
              Person Name
              <input type="text" :placeholder="debtformtype == 'editpostform' ? debtForTransactionObj.title.rendered : 'Write a name'" v-model="debttitle"/>
            </label>
            <label class="field-group">
              Phone Number
              <input type="tel" :placeholder="debtformtype == 'editpostform' ? debtForTransactionObj.meta.debt_phone : 'Write phone number'" v-model="deptPhoneNumber"/>
            </label>
            <label class="field-group">
              Email Address
              <input type="email" :placeholder="debtformtype == 'editpostform' ? debtForTransactionObj.meta.debt_email : 'Email Address'" v-model="deptEmailAddress"/>
            </label>
            <div v-if="debtformtype == 'newpostform'">
              <label class="field-group field-group-check"><input type="checkbox" v-model="addPrevToDebt"><span>Do want to add previous debt?</span></label>
              <label class="field-group" v-if="addPrevToDebt">
                Previous Debit/Credit
                <div class="box-radio-fields m-t-0">
                  <label>
                    <input type="radio" name="debtType" v-model="debtType" value="debit"/>
                    <span class="box-radio-label"><svg width="22" height="22" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 14.5312C11.3833 14.5312 14.5312 11.3833 14.5312 7.5C14.5312 3.61675 11.3833 0.46875 7.5 0.46875C3.61675 0.46875 0.46875 3.61675 0.46875 7.5C0.46875 11.3833 3.61675 14.5312 7.5 14.5312Z" fill="#FFDD67"/>
                    <path d="M4.45321 4.875C4.45321 4.3125 5.69539 4.57031 6.09383 4.96875C6.32821 4.57031 6.21102 4.21875 6.21102 4.21875C6.21102 4.21875 5.85946 3.96094 5.32039 3.86719V3.35156C4.89852 3.21094 4.42977 3.35156 4.42977 3.35156V3.84375C4.42977 3.84375 3.58602 4.00781 3.58602 4.875C3.58602 6.02344 5.32039 5.78906 5.32039 6.51562C5.32039 7.05469 4.14852 6.82031 3.58602 6.39844C3.39852 6.82031 3.58602 7.19531 3.58602 7.19531C4.00789 7.38281 4.42977 7.42969 4.42977 7.42969V7.89844C4.42977 7.89844 4.89852 8.03906 5.32039 7.89844V7.40625C5.32039 7.40625 6.30477 7.35937 6.30477 6.51562C6.32821 5.41406 4.45321 5.50781 4.45321 4.875Z" fill="#664E27"/>
                    <path d="M9.60946 4.875C9.60946 4.3125 10.8516 4.57031 11.2501 4.96875C11.4845 4.57031 11.3673 4.21875 11.3673 4.21875C11.3673 4.21875 11.0157 3.96094 10.4766 3.86719V3.35156C10.0548 3.21094 9.58602 3.35156 9.58602 3.35156V3.84375C9.58602 3.84375 8.74227 4.00781 8.74227 4.875C8.74227 6.02344 10.4766 5.78906 10.4766 6.51562C10.4766 7.05469 9.30477 6.82031 8.74227 6.39844C8.55477 6.82031 8.74227 7.19531 8.74227 7.19531C9.16414 7.38281 9.58602 7.42969 9.58602 7.42969V7.89844C9.58602 7.89844 10.0548 8.03906 10.4766 7.89844V7.40625C10.4766 7.40625 11.461 7.35937 11.461 6.51562C11.4845 5.41406 9.60946 5.50781 9.60946 4.875Z" fill="#664E27"/>
                    <path d="M11.2266 8.90625H3.77344C3.60938 8.90625 3.51562 9.02344 3.51562 9.14062C3.51562 10.8516 4.92188 12.6562 7.5 12.6562C10.0781 12.6562 11.4844 10.8516 11.4844 9.14062C11.4844 9.02344 11.3906 8.90625 11.2266 8.90625Z" fill="#664E27"/>
                    <path d="M9.65625 10.3125H5.34375C5.17969 10.3125 5.15625 10.3828 5.15625 10.5V11.4375C5.15625 13.5 6.21094 14.5312 7.5 14.5312C8.78906 14.5312 9.84375 13.5 9.84375 11.4375V10.5C9.84375 10.3828 9.82031 10.3125 9.65625 10.3125Z" fill="#74E063"/>
                    <path d="M7.19539 11.6015C7.19539 11.2265 7.96883 11.414 8.22664 11.6719C8.39071 11.414 8.29696 11.1797 8.29696 11.1797C8.29696 11.1797 8.06258 11.0156 7.73446 10.9453V10.5937C7.47664 10.5 7.17196 10.5937 7.17196 10.5937V10.9219C7.17196 10.9219 6.63289 11.0156 6.63289 11.6015C6.63289 12.3515 7.73446 12.1875 7.73446 12.6797C7.73446 13.0312 7.00789 12.8906 6.63289 12.6094C6.51571 12.8906 6.63289 13.125 6.63289 13.125C6.89071 13.2422 7.17196 13.289 7.17196 13.289V13.5937C7.17196 13.5937 7.45321 13.6875 7.73446 13.5937V13.2656C7.73446 13.2656 8.34383 13.2187 8.34383 12.6797C8.39071 11.9531 7.19539 12.0234 7.19539 11.6015Z" fill="#449636"/>
                    <path d="M9.28125 10.3125V11.1328C9.28125 13.0781 8.57812 13.9453 7.5 13.9453C6.42187 13.9453 5.71875 13.1016 5.71875 11.1328V10.3125H5.53125V11.1328C5.53125 13.2187 6.30469 14.1562 7.5 14.1562C8.69531 14.1562 9.46875 13.2187 9.46875 11.1328V10.3125H9.28125Z" fill="#449636"/>
                    </svg> Debit</span>
                  </label>
                  <label>
                    <input type="radio" name="debtType" v-model="debtType" value="credit"/>
                    <span class="box-radio-label"><svg width="22" height="22" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M0.40625 6.5C0.40625 9.87187 3.12812 12.5938 6.5 12.5938C9.87187 12.5938 12.5938 9.87187 12.5938 6.5C12.5938 3.12812 9.87187 0.40625 6.5 0.40625C3.12812 0.40625 0.40625 3.12812 0.40625 6.5Z" fill="#FDB2A1"/>
                      <path d="M9.68896 7.63752C9.68896 9.3844 12.0655 9.3844 12.0655 7.63752C12.0655 6.35784 10.8874 5.11877 10.8874 5.11877C10.8874 5.11877 9.68896 6.35784 9.68896 7.63752Z" fill="#65B1EF"/>
                      <path d="M7.82031 8.125C8.38123 8.125 8.83594 7.67029 8.83594 7.10938C8.83594 6.54846 8.38123 6.09375 7.82031 6.09375C7.2594 6.09375 6.80469 6.54846 6.80469 7.10938C6.80469 7.67029 7.2594 8.125 7.82031 8.125Z" fill="#664E27"/>
                      <path d="M3.14844 8.125C3.70935 8.125 4.16406 7.67029 4.16406 7.10938C4.16406 6.54846 3.70935 6.09375 3.14844 6.09375C2.58752 6.09375 2.13281 6.54846 2.13281 7.10938C2.13281 7.67029 2.58752 8.125 3.14844 8.125Z" fill="#664E27"/>
                      <path d="M4.18434 4.0422C3.53434 4.59064 2.66091 4.83439 1.80778 4.67189C1.68591 4.65158 1.58434 5.07814 1.72653 5.11876C2.70153 5.30158 3.71716 5.0172 4.46872 4.38751C4.57028 4.28595 4.26559 3.96095 4.18434 4.0422Z" fill="#917524"/>
                      <path d="M9.16087 4.65156C8.30775 4.79375 7.43431 4.57031 6.78431 4.02188C6.70306 3.94063 6.37806 4.26563 6.49994 4.36719C7.2515 5.01719 8.26712 5.28125 9.24212 5.09844C9.38431 5.05781 9.28275 4.63125 9.16087 4.65156Z" fill="#917524"/>
                      <path d="M7.73903 9.60782C6.56091 9.30314 5.30153 9.52657 4.30622 10.2172C4.06247 10.4 4.52966 11.0297 4.77341 10.8672C5.42341 10.4 6.47966 10.0953 7.55622 10.3797C7.82028 10.4406 8.04372 9.70939 7.73903 9.60782Z" fill="#664E27"/>
                      </svg> Credit</span>
                  </label>
                </div>
              </label>
              <label class="field-group amount-field" v-if="addPrevToDebt">
                <span class="styled-amount">
                  <input 
                    type="number" 
                    inputmode="decimal"
                    step="0.01" 
                    :placeholder="debtformtype == 'editpostform' ? debtForTransactionObj.meta.debt_amount : '00.0'"  
                    v-model="newdebtamount"
                    v-autowidth="{maxWidth: '100%', minWidth: '95px', comfortZone: 0}"
                  />
                  <span>{{selectedCurrency.code}}</span>
                </span>
                <span class="amount-label">Previous Amount</span>
              </label>
            </div>
            <label class="field-group field-group-check"><input type="checkbox" v-model="addANoteDebt"><span>Add a note with this person</span></label>
            <label class="field-group" v-if="addANoteDebt">
              Note
              <textarea :placeholder="debtformtype == 'editpostform' ? debtForTransactionObj.meta.debt_note : 'Have any note...'" v-model="newdebtnote"></textarea>
            </label>
            <button type="submit" :disabled='btnDebtDisabled'>{{debtStatus}}</button>
          </form>
        </div>
      <div v-if="debtForTransaction">
        <div class="kh-container" v-if="user">
          <div class="kh-row">
            <label class="placehold-btn kh-card-btn kh-card-btn-left" v-on:click="closeDebtForTransaction">
              <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.8 490.8"><path d="M362.7 490.8c-2.8 0-5.5-1.1-7.6-3.1L120.5 253c-4.2-4.2-4.2-10.9 0-15.1L355.1 3.3c4.1-4.2 10.8-4.4 15.1-0.3 4.2 4.1 4.4 10.8 0.3 15.1 -0.1 0.1-0.2 0.2-0.3 0.3L143.1 245.5l227.1 227.1c4.2 4.2 4.2 10.9 0 15.1C368.2 489.7 365.5 490.8 362.7 490.8z" fill="#F44336"/><path d="M362.7 490.8c-2.8 0-5.5-1.1-7.6-3.1L120.5 253c-4.2-4.2-4.2-10.9 0-15.1L355.1 3.3c4.1-4.2 10.8-4.4 15.1-0.3 4.2 4.1 4.4 10.8 0.3 15.1 -0.1 0.1-0.2 0.2-0.3 0.3L143.1 245.5l227.1 227.1c4.2 4.2 4.2 10.9 0 15.1C368.2 489.7 365.5 490.8 362.7 490.8z"/></svg>
              Back to Persons
            </label>
          </div>
          <div class="kh-row kh-mt-3">
            <div class="kh-col-12">
              <div class="kh-card kh-card-flex kh-card-person">
                <div class="kh-card-content">
                  <div class="kh-card-person-thumb"><img :src="getAvatar(debtForTransactionObj.meta.debt_email, 400)"/></div>
                  <div class="kh-card-person-detail">
                    <h4>
                      {{debtForTransactionObj.title.rendered}}
                      <div class="person-action-btn">
                        <label class="placehold-btn kh-card-btn" v-on:click="enDebtEditForm" :data-id="debtForTransactionObj.id">
                          Edit Person
                        </label>
                        <label class="placehold-btn kh-card-btn kh-card-btn-red" v-on:click="deleteDebtThisPost" :data-id="debtForTransactionObj.id">
                          Delete Person
                        </label>
                      </div>
                    </h4>
                    <p class="kh-card-contact">
                      <span v-if="debtForTransactionObj.meta.debt_phone"><span class="material-icons-outlined">call</span>{{debtForTransactionObj.meta.debt_phone}}</span>
                      <span v-if="debtForTransactionObj.meta.debt_email"><span class="material-icons-outlined">markunread</span>{{debtForTransactionObj.meta.debt_email}}</span>
                    </p> 
                  </div>
                  <div class="kh-card-person-detail-2">
                    <p class="kh-current-debt">{{debtForTransactionObj.debt_type == 'credit' ? `You owe to ${debtForTransactionObj.title.rendered} ` : `${debtForTransactionObj.title.rendered} owes you `}}<span class="kh-amount" v-bind:class="[debtForTransactionObj.debt_type == 'credit' ? 'kh-amount-expense' : '']">{{debtForTransactionObj.debt_amount ? currencify(debtForTransactionObj.debt_amount, 0) : currencify('00', 0)}}</span></p>
                    <p v-if="debtForTransactionObj.meta.debt_note">
                      <span v-if="debtForTransactionObj.meta.debt_note.length > 70">
                        <span v-if="!readMoreActivated">{{debtForTransactionObj.meta.debt_note.slice(0, 70)}}</span>
                        <a class="" v-if="!readMoreActivated" v-on:click="activateReadMore" href="#">Show more...</a>
                        <span v-if="readMoreActivated" v-html="debtForTransactionObj.meta.debt_note"></span>
                        <a class="" v-if="readMoreActivated" v-on:click="deactivateReadMore" href="#">Show less</a>
                      </span>
                      <span v-else>
                        <span v-html="debtForTransactionObj.meta.debt_note"></span>
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="kh-card kh-mt-3 kh-account-list">
            <div class="kh-card-header">
                <h3 class="kh-card-title">Recent transaction</h3>
                <label class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-add" v-on:click="() => {debtTransactionType = 'debit'; openNewDebtTransactionForm();}">
                  <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.4 341.4"><polygon points="192 149.4 192 0 149.4 0 149.4 149.4 0 149.4 0 192 149.4 192 149.4 341.4 192 341.4 192 192 341.4 192 341.4 149.4 "/></svg>
                </label>
                <label class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-remove" v-on:click="() => {debtTransactionType = 'credit'; openNewDebtTransactionForm();}">
                  <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.3 341.3"><rect y="149.3" width="341.3" height="42.7"/></svg>
                </label>
            </div>
            <div class="kh-post-pop" v-bind:class="{ active: debtTransactionPop }" v-on:click="handleFormFocus">
              <form id="debtTransactionForm" class="post-form" @submit.prevent="debtTransactionSubmit">
                <label class="placehold-btn">
                  <input type="checkbox" v-model="debtTransactionPop"/>
                  <span class="material-icons-outlined">close</span>
                </label>
                <p class="lead" v-if="debtTransactionType=='credit'">How much should be taken off {{debtForTransactionObj.title.rendered}}'s debt?</p>
                <p class="lead" v-else>How much should be added to {{debtForTransactionObj.title.rendered}}'s debt?</p>
                <p v-if="debttransactionerrors.length" class="error-box">
                  <ul>
                    <li v-for="error in debttransactionerrors" v-bind:key="error.key">{{ error }}</li>
                  </ul>
                </p>
                <label class="field-group amount-field">
                  <span class="styled-amount">
                    <input 
                      type="number" 
                      inputmode="decimal"
                      step="0.01" 
                      placeholder="0.00"
                      v-model="newdebttransactionamount"
                      v-autowidth="{maxWidth: '100%', minWidth: '95px', comfortZone: 0}"
                    />
                    <span>{{selectedCurrency.code}}</span>
                  </span>
                  <span class="amount-label">Amount</span>
                </label>
                <label class="field-group">
                  Why?
                  <textarea placeholder="Have any note..." v-model="newdebttransactionnote"></textarea>
                </label>
                <input type="hidden" action="new_debt_transaction"/>
                <button type="submit" :disabled='btnDebtTransactionDisabled'>{{debtTransactionStatus}}</button>
              </form>
            </div>
            <div class="account-table-responsive">
              <table class="kh-account-table">
                  <tr class="kh-account-table-header">
                      <th class="type-th"><span>Detail</span></th>
                      <th class="kh-amount-td"><span>Amount</span></th>
                      <th class="kh-debit-credit-td"><span>Debit/Credit</span></th>
                      <th><span>&nbsp;</span></th>
                  </tr>
                  <tr class="kh-account-table-items" v-for="item in filteredDebtTransactions" :key="item.id">
                      <td class="kh-account-date-td">
                        <span class="kh-t-title">{{localeDate(item.transaction_date)}}</span>
                        <span class="kh-t-subtitle" v-if="item.transaction_note" v-html="item.transaction_note"></span>
                        <span class="kh-amount" v-bind:class="[item.transaction_type == 'credit' ? 'kh-amount-expense' : '']">{{item.transaction_amount ? currencify(item.transaction_amount, 0) : currencify('00', 0)}}</span>
                      </td>
                      <td class="kh-amount-td"><span class="kh-amount" v-bind:class="[item.transaction_type == 'credit' ? 'kh-amount-expense' : '']">{{item.transaction_amount ? currencify(item.transaction_amount, 0) : currencify('00', 0)}}</span></td>
                      <td class="kh-debit-credit-td"><span class="kh-type" v-bind:class="[item.transaction_type == 'credit' ? 'kh-type-expense' : '']">{{item.transaction_type}}</span></td>
                      <td class="postEditTd">
                        <span v-on:click="deleteDebtTransactionThisPost" :data-id="item.id" class="debt-delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 407.5 407.5" width="20" height="20"><path d="M335.9 114.9H71.6c-2.9-0.2-5.7 0.7-7.8 2.6 -2.1 2-3.1 5-2.6 7.8l27.2 236.7c3.2 26.1 25.4 45.6 51.7 45.5h131.7c27 0.4 49.8-20.1 52.2-47l22.5-236.1c0.1-2.5-0.8-5-2.6-6.8C341.6 115.6 338.8 114.7 335.9 114.9zM303 359.5c-1.6 15.9-15.4 27.8-31.3 27.2H140c-15.7 0.6-29.2-11-30.8-26.6L83.1 135.8h241.4L303 359.5z"/><path d="M374.1 47H266.5V30.3c0.6-16.1-12-29.7-28.2-30.3 -0.5 0-1.1 0-1.6 0h-65.8c-16.2-0.3-29.5 12.6-29.8 28.7 0 0.5 0 1.1 0 1.6v16.7H33.4c-5.8 0-10.4 4.7-10.4 10.4s4.7 10.4 10.4 10.4h340.6c5.8 0 10.4-4.7 10.4-10.4S379.8 47 374.1 47zM245.6 30.3v16.7h-83.6V30.3c-0.6-4.6 2.6-8.8 7.2-9.4 0.5-0.1 1.1-0.1 1.7 0h65.8c4.6-0.3 8.6 3.1 8.9 7.7C245.6 29.2 245.6 29.8 245.6 30.3z"/></svg></span>
                      </td>
                  </tr>
              </table>
            </div>
            <div class="kh-pagination" v-if="debtTransactionPaging.totalPage > 1">
              <span v-on:click="debtTransactionPrevPage"><span class="material-icons-outlined">keyboard_arrow_left</span></span>
              <span v-for="index in debtTransactionPaging.totalPage" v-bind:key="index"><span v-on:click="debtTransactionPaging.currentPage = index" v-bind:class="{ current: debtTransactionPaging.currentPage == index }">{{index}}</span></span>
              <span v-on:click="debtTransactionNextPage"><span class="material-icons-outlined">keyboard_arrow_right</span></span>
            </div>
          </div>

          <div class="kh-row kh-mt-3">
            <label class="placehold-btn kh-card-btn kh-card-btn-left" v-on:click="closeDebtForTransaction">
              <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.8 490.8"><path d="M362.7 490.8c-2.8 0-5.5-1.1-7.6-3.1L120.5 253c-4.2-4.2-4.2-10.9 0-15.1L355.1 3.3c4.1-4.2 10.8-4.4 15.1-0.3 4.2 4.1 4.4 10.8 0.3 15.1 -0.1 0.1-0.2 0.2-0.3 0.3L143.1 245.5l227.1 227.1c4.2 4.2 4.2 10.9 0 15.1C368.2 489.7 365.5 490.8 362.7 490.8z" fill="#F44336"/><path d="M362.7 490.8c-2.8 0-5.5-1.1-7.6-3.1L120.5 253c-4.2-4.2-4.2-10.9 0-15.1L355.1 3.3c4.1-4.2 10.8-4.4 15.1-0.3 4.2 4.1 4.4 10.8 0.3 15.1 -0.1 0.1-0.2 0.2-0.3 0.3L143.1 245.5l227.1 227.1c4.2 4.2 4.2 10.9 0 15.1C368.2 489.7 365.5 490.8 362.7 490.8z"/></svg>
              Back to Persons
            </label>
          </div>
        </div>
      </div>
      <div v-else>
        <div class="kh-container" v-if="user">
          <div class="kh-row">
            <div class="kh-col debt-tracking-title">
              <h3 class="top-welecome">Debt Tracking</h3>
              <div class="profile-select">
                <span class="profile-selected">
                  <span>Using as self</span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.011 512.011"><path d="M505.755 123.592c-8.341-8.341-21.824-8.341-30.165 0L256.005 343.176 36.421 123.592c-8.341-8.341-21.824-8.341-30.165 0s-8.341 21.824 0 30.165l234.667 234.667c4.16 4.16 9.621 6.251 15.083 6.251s10.923-2.091 15.083-6.251l234.667-234.667c8.34-8.341 8.34-21.824-.001-30.165z"/></svg>
                </span>
                <div class="profile-selector" v-on:click="proPop=true">Add a new profile (Pro)</div>
              </div>
            </div>
          </div>

          <div class="kh-mt-2">
            <div class="kh-row">
              <div class="kh-col-6">
                <div class="kh-card kh-card-flex">
                  <div class="kh-card-content">
                      <p>Debit</p>
                      <h4>{{currencify(totalDebit, 2)}}</h4>
                  </div>
                </div>
              </div>
              <div class="kh-col-6">
                  <div class="kh-card kh-card-flex">
                      <div class="kh-card-content">
                          <p>Credit</p>
                          <h4>{{currencify(totalCredit, 2)}}</h4>
                      </div>
                  </div>
              </div>
            </div>
          </div>

          <div class="kh-card kh-mt-3 kh-account-list">
            <div class="kh-card-header">
                <h3 class="kh-card-title">Current Debts</h3>
                <label class="placehold-btn kh-card-btn" v-on:click="openNewDebtForm">
                  Add New Person
                  <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.25781 6.09375H7.03125V3.86719C7.03125 3.80273 6.97852 3.75 6.91406 3.75H6.21094C6.14648 3.75 6.09375 3.80273 6.09375 3.86719V6.09375H3.86719C3.80273 6.09375 3.75 6.14648 3.75 6.21094V6.91406C3.75 6.97852 3.80273 7.03125 3.86719 7.03125H6.09375V9.25781C6.09375 9.32227 6.14648 9.375 6.21094 9.375H6.91406C6.97852 9.375 7.03125 9.32227 7.03125 9.25781V7.03125H9.25781C9.32227 7.03125 9.375 6.97852 9.375 6.91406V6.21094C9.375 6.14648 9.32227 6.09375 9.25781 6.09375Z"/>
                    <path d="M6.5625 0C2.93848 0 0 2.93848 0 6.5625C0 10.1865 2.93848 13.125 6.5625 13.125C10.1865 13.125 13.125 10.1865 13.125 6.5625C13.125 2.93848 10.1865 0 6.5625 0ZM6.5625 12.0117C3.55371 12.0117 1.11328 9.57129 1.11328 6.5625C1.11328 3.55371 3.55371 1.11328 6.5625 1.11328C9.57129 1.11328 12.0117 3.55371 12.0117 6.5625C12.0117 9.57129 9.57129 12.0117 6.5625 12.0117Z" />
                  </svg>
                </label>
            </div>
            <div class="account-table-responsive">
              <table class="kh-account-table">
                  <tr class="kh-account-table-header">
                      <th class="type-th"><span>Name</span></th>
                      <th class="kh-amount-td"><span>Amount</span></th>
                      <th class="kh-dc-td"><span>Debit/Credit</span></th>
                      <th class="kh-person-add-td"><span>&nbsp;</span></th>
                      <th><span>&nbsp;</span></th>
                  </tr>
                  <tr class="kh-account-table-items" v-for="item in debts" :key="item.id">
                      <td class="kh-person-td">
                        <div class="person-list-info-wrap" v-on:click="openDebtForTransaction" :data-id="item.id">
                          <span class="person-avatar"><img :src="getAvatar(item.meta.debt_email, 40)"/></span>
                          <span class="person-list-info" :data-id="item.id">
                            <span class="kh-t-title" v-html="item.title.rendered"></span>
                            <span class="kh-t-subtitle" v-if="item.meta.debt_phone" v-html="item.meta.debt_phone"></span>
                            <span class="kh-t-subtitle" v-if="!item.meta.debt_phone && item.meta.debt_note" v-html="item.meta.debt_note"></span>
                            <div class="mobile-add-btn">
                              <label :data-id="item.id" class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-add" v-on:click="(e) => {debtTransactionType = 'debit'; openDebtForTransaction(e); openNewDebtTransactionForm(); debtTransactionPop = true;}">
                                <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.4 341.4"><polygon points="192 149.4 192 0 149.4 0 149.4 149.4 0 149.4 0 192 149.4 192 149.4 341.4 192 341.4 192 192 341.4 192 341.4 149.4 "/></svg>
                              </label>
                              <label :data-id="item.id" class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-remove" v-on:click="(e) => {debtTransactionType = 'credit'; openDebtForTransaction(e); openNewDebtTransactionForm(); debtTransactionPop = true;}">
                                <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.3 341.3"><rect y="149.3" width="341.3" height="42.7"/></svg>
                              </label>
                            </div>
                            <span class="kh-amount" v-bind:class="[item.debt_type == 'credit' ? 'kh-amount-expense' : '']">{{item.debt_amount ? currencify(item.debt_amount, 0) : currencify('00', 0)}}</span>
                          </span>
                        </div>
                      </td>
                      <td class="kh-amount-td"><span class="kh-amount" v-bind:class="[item.debt_type == 'credit' ? 'kh-amount-expense' : '']">{{item.debt_amount ? currencify(item.debt_amount, 0) : currencify('00', 0)}}</span></td>
                      <td class="kh-dc-td"><span class="kh-type" v-bind:class="[item.debt_type == 'credit' ? 'kh-type-expense' : '']">{{item.debt_type}}</span></td>
                      <td class="kh-person-add-td">
                        <label :data-id="item.id" class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-add" v-on:click="(e) => {debtTransactionType = 'debit'; openDebtForTransaction(e); openNewDebtTransactionForm(); debtTransactionPop = true;}">
                          <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.4 341.4"><polygon points="192 149.4 192 0 149.4 0 149.4 149.4 0 149.4 0 192 149.4 192 149.4 341.4 192 341.4 192 192 341.4 192 341.4 149.4 "/></svg>
                        </label>
                        <label :data-id="item.id" class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-remove" v-on:click="(e) => {debtTransactionType = 'credit'; openDebtForTransaction(e); openNewDebtTransactionForm(); debtTransactionPop = true;}">
                          <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.3 341.3"><rect y="149.3" width="341.3" height="42.7"/></svg>
                        </label>
                      </td>
                      <td class="postEditTd">
                        <span v-on:click="deleteDebtThisPost" :data-id="item.id" class="debt-delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 407.5 407.5" width="20" height="20"><path d="M335.9 114.9H71.6c-2.9-0.2-5.7 0.7-7.8 2.6 -2.1 2-3.1 5-2.6 7.8l27.2 236.7c3.2 26.1 25.4 45.6 51.7 45.5h131.7c27 0.4 49.8-20.1 52.2-47l22.5-236.1c0.1-2.5-0.8-5-2.6-6.8C341.6 115.6 338.8 114.7 335.9 114.9zM303 359.5c-1.6 15.9-15.4 27.8-31.3 27.2H140c-15.7 0.6-29.2-11-30.8-26.6L83.1 135.8h241.4L303 359.5z"/><path d="M374.1 47H266.5V30.3c0.6-16.1-12-29.7-28.2-30.3 -0.5 0-1.1 0-1.6 0h-65.8c-16.2-0.3-29.5 12.6-29.8 28.7 0 0.5 0 1.1 0 1.6v16.7H33.4c-5.8 0-10.4 4.7-10.4 10.4s4.7 10.4 10.4 10.4h340.6c5.8 0 10.4-4.7 10.4-10.4S379.8 47 374.1 47zM245.6 30.3v16.7h-83.6V30.3c-0.6-4.6 2.6-8.8 7.2-9.4 0.5-0.1 1.1-0.1 1.7 0h65.8c4.6-0.3 8.6 3.1 8.9 7.7C245.6 29.2 245.6 29.8 245.6 30.3z"/></svg></span>
                      </td>
                  </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div> -->
<!-- Debt-Tracking Page End -->
    <!-- Overview-page Start -->
     <!-- <div class="overview-page" v-bind:style="{ display: sidebarPage == 'overview' ? 'block' : 'none' }">
      <div class="kh-container" v-if="user">
        <div class="kh-row">
          <div class="kh-col">
            <h3 class="top-welecome">Overview</h3>
          </div>
        </div>
        <div class="kh-row kh-mt-2">
          <div class="kh-col-12">
            <div class="chart-box">
              <h4 class="chart-title">This month overview</h4>
              <div class="chart-body">
                <canvas 
                  class="chart-canvas" 
                  data-type="bar" 
                  data-labels='[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]'
                  data-label="Earning"
                  data-data='[2400, 2700, 2300, 750, 1950, 1300, 1400, 2500, 1900, 1400, 1000, 2200, 1200, 1150, 1300, 1500]'
                  data-backgroundColor='["#D7F5EA"]'
                  data-borderColor='["#014737"]'
                  data-borderWidth="1"
                  data-label2="Expense"
                  data-data2='[2300, 2780, 1900, 900, 1650, 1300, 1400, 1500, 2200, 1400, 1000, 1900, 1200, 1150, 1300, 1500]'
                  data-backgroundColor2='["#FCA5A5"]'
                  data-borderColor2='["#B91C1C"]'
                  data-borderWidth2="1"
                ></canvas>
              </div>
              <div class="chart-overlay" v-on:click="proPop=true">
                <span target="_blank" class="get-pro-btn"><span class="material-icons-outlined">lock</span> Upgrade Now</span>
              </div>
            </div>
          </div>
          <div class="kh-col-6">
            <div class="chart-box">
              <h4 class="chart-title">Earning Last 12 Month</h4>
              <div class="chart-body">
                <canvas 
                  class="chart-canvas" 
                  data-type="bar" 
                  data-label="Earning Last 12 Month"
                  data-labels='["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"]'
                  data-data='[12000, 12700, 13000, 12750, 12950, 13200, 14000, 14500, 13900, 14800, 14000, 14200]'
                  data-backgroundColor='["#D7F5EA"]'
                  data-borderColor='["#014737"]'
                  data-borderWidth="1"
                ></canvas>
              </div>
              <div class="chart-overlay" v-on:click="proPop=true">
                <span target="_blank" class="get-pro-btn"><span class="material-icons-outlined">lock</span> Upgrade Now</span>
              </div>
            </div>
          </div>
          <div class="kh-col-6">
            <div class="chart-box">
              <h4 class="chart-title">Expense Last 12 Month</h4>
              <div class="chart-body">
                <canvas 
                  class="chart-canvas" 
                  data-type="bar" 
                  data-label="Expense Last 12 Month"
                  data-labels='["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"]'
                  data-data='[12000, 12700, 13000, 12750, 12950, 13200, 14000, 14500, 13900, 14800, 14000, 14200]'
                  data-backgroundColor='["#FCA5A5"]'
                  data-borderColor='["#B91C1C"]'
                  data-borderWidth="1"
                ></canvas>
              </div>
              <div class="chart-overlay" v-on:click="proPop=true">
                <span target="_blank" class="get-pro-btn"><span class="material-icons-outlined">lock</span> Upgrade Now</span>
              </div>
            </div>
          </div>
          <div class="kh-col-6">
            <div class="chart-box">
              <h4 class="chart-title">Earning by category</h4>
              <div class="chart-body">
                <canvas 
                  class="chart-canvas" 
                  data-type="doughnut" 
                  data-label="Earning by category"
                  data-labels='["Salary", "Business", "Extra Income", "Loan", "Insurance Payment"]'
                  data-data='[12000, 15000, 2000, 10000, 2950]'
                  data-backgroundColor='["#1eb174", "#fda207", "#74c442", "#df6576", "#44a7e5"]'
                  data-borderColor='["transparent"]'
                  data-borderWidth="0"
                ></canvas>
              </div>
              <div class="chart-overlay" v-on:click="proPop=true">
                <span target="_blank" class="get-pro-btn"><span class="material-icons-outlined">lock</span> Upgrade Now</span>
              </div>
            </div>
          </div>
          <div class="kh-col-6">
            <div class="chart-box">
              <h4 class="chart-title">Expense by category</h4>
              <div class="chart-body">
                <canvas 
                  class="chart-canvas" 
                  data-type="doughnut" 
                  data-label="Earning by category"
                  data-labels='["Food &amp; Drink", "Shopping", "Transport", "Home", "Entertainment"]'
                  data-data='[7000, 5000, 2000, 10000, 2950]'
                  data-backgroundColor='["#fea800", "#e26aef", "#fbcc00", "#b5985b", "#fea800"]'
                  data-borderColor='["transparent"]'
                  data-borderWidth="0"
                ></canvas>
              </div>
              <div class="chart-overlay" v-on:click="proPop=true">
                <span target="_blank" class="get-pro-btn"><span class="material-icons-outlined">lock</span> Upgrade Now</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- Overview-page End -->
<!-- categories-page Start -->
 <!-- <div class="categories-page" v-bind:style="{ display: sidebarPage == 'categories' ? 'block' : 'none' }">
      <div class="kh-container" v-if="user">
        <div class="kh-row">
          <div class="kh-col category-title">
            <h3 class="top-welecome">Categories</h3>
            <label class="placehold-btn kh-card-btn" v-on:click="openNewCategoryForm">
              Add New Category
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.25781 6.09375H7.03125V3.86719C7.03125 3.80273 6.97852 3.75 6.91406 3.75H6.21094C6.14648 3.75 6.09375 3.80273 6.09375 3.86719V6.09375H3.86719C3.80273 6.09375 3.75 6.14648 3.75 6.21094V6.91406C3.75 6.97852 3.80273 7.03125 3.86719 7.03125H6.09375V9.25781C6.09375 9.32227 6.14648 9.375 6.21094 9.375H6.91406C6.97852 9.375 7.03125 9.32227 7.03125 9.25781V7.03125H9.25781C9.32227 7.03125 9.375 6.97852 9.375 6.91406V6.21094C9.375 6.14648 9.32227 6.09375 9.25781 6.09375Z"/>
                <path d="M6.5625 0C2.93848 0 0 2.93848 0 6.5625C0 10.1865 2.93848 13.125 6.5625 13.125C10.1865 13.125 13.125 10.1865 13.125 6.5625C13.125 2.93848 10.1865 0 6.5625 0ZM6.5625 12.0117C3.55371 12.0117 1.11328 9.57129 1.11328 6.5625C1.11328 3.55371 3.55371 1.11328 6.5625 1.11328C9.57129 1.11328 12.0117 3.55371 12.0117 6.5625C12.0117 9.57129 9.57129 12.0117 6.5625 12.0117Z" />
              </svg>
            </label>
          </div>
        </div>

        <div class="kh-post-pop" v-bind:class="{ active: newaddcatPop }" v-on:click="handleFormFocus">
            <form id="categoryForm" class="post-form" @submit.prevent="addCatsubmit">
              <label class="placehold-btn">
                <input type="checkbox" v-model="newaddcatPop"/>
                <span class="material-icons-outlined">close</span>
              </label>
              <p class="lead">Add new category</p>
              <label class="field-group">
                Category Name
                <input type="text" placeholder="eg. Travel" v-model="newaddcat"/>
              </label>
              <label class="field-group">
                Category Type
                <select v-model="newaddcattype">
                  <option value="both">Both</option>
                  <option value="earning">Earning</option>
                  <option value="expense">Expense</option>
                </select>
              </label>
              <label class="field-group">
                Category Color 
                <verte v-model="newaddcatcolor" model="rgb"><span class="verte-selected-color" v-bind:style="{ backgroundColor: newaddcatcolor }"></span></verte>
              </label>
              <div class="field-group icons-field">
                Category Icon
                <div class="icon-field_selected">
                  <span class="material-icons-outlined">{{newaddcaticon}}</span>
                  <button type="button" class="icon-name" v-on:click="iconDrop=true">{{newaddcaticon}}</button>
                </div>
                <div class="icon-selector" v-bind:class="{active: iconDrop}">
                  <input type="search" class="icon-search" placeholder="Search..." v-model="iconQuery"/>
                  <div class="icon-list">
                    <label v-for="item in filteredIcon" v-on:click="newaddcaticon = item; iconDrop=false" v-bind:key="item.key" v-bind:class="{  active: item == newaddcaticon }">
                      <span class="material-icons-outlined">{{item}}</span>
                    </label>
                  </div>
                </div>
              </div>
              <button type="submit" :disabled='btnDebtDisabled'>{{debtStatus}}</button>
            </form>
          </div>

        <div class="kh-mt-2">
          <ul class="category-list">
            <li class="category-list-item" v-on:click="newtype='Expense'" v-bind:class="{ active: newtype=='Expense' }">Expense</li>
            <li class="category-list-item" v-on:click="newtype='Earning'" v-bind:class="{ active: newtype=='Earning' }">Earning</li>
          </ul>
        </div>

        <div class="kh-row kh-category-list">
          <div class="kh-col-6" v-for="item in filteredCat" v-bind:key="item.id">
            <div class="kh-category-list-item">
              <span class="cat-icon" v-bind:style="{ color: item.meta.color[0] ? item.meta.color[0] : 'rgb(103, 104, 108)' }"><span class="material-icons-outlined">{{item.meta.icon[0] ? item.meta.icon[0] : 'quiz'}}</span></span>
              <span class="cat-name" v-html="item.name"></span>
            </div>
          </div>
        </div>
      </div>
    </div> -->
<!-- categories-page End -->
<!-- Integrations Page Start-->
    <!-- <div class="integrations-page" v-bind:style="{ display: sidebarPage == 'integrations' ? 'block' : 'none' }">
      <div class="kh-container" v-if="user">
        <div class="kh-row">
          <div class="kh-col">
            <h3 class="top-welecome">Integrate with</h3>
          </div>
        </div>
        <div class="kh-row kh-mt-2">
          <div class="kh-col-6">
            <div class="integration-box">
              <div class="integration-thumb">
                <img :src="getImgUrl('/images/woocommerce.png')">
              </div>
              <div class="integration-content">
                <h4>WooCommerce</h4>
                <p>Integrate woocommerce to enjoy flexible earning and costing calculation on you store</p>
              </div>
              <div class="chart-overlay" v-on:click="proPop=true">
                <span target="_blank" class="get-pro-btn"><span class="material-icons-outlined">lock</span> Upgrade Now</span>
              </div>
            </div>
          </div>
          <div class="kh-col-6">
            <div class="integration-box">
              <div class="integration-thumb">
                <img :src="getImgUrl('/images/edd.png')">
              </div>
              <div class="integration-content">
                <h4>Easy Digital Downloads</h4>
                <p>You can also use with easy digital download when offering your digital product for download or subscription</p>
              </div>
              <div class="chart-overlay" v-on:click="proPop=true">
                <span target="_blank" class="get-pro-btn"><span class="material-icons-outlined">lock</span> Upgrade Now</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- Integrations Page End-->


   </div>
</template>

<script>
import currency from '../assets/js/currency.json';
import HelloWorld from './components/HelloWorld.vue'
import AccountsPage from './components/AccountsPage.vue'
import DebtTrackingPage from './components/DebtTrackingPage.vue'
import IntegrationsPage from './components/IntegrationsPage.vue'
import CategoriesPage from './components/CategoriesPage.vue'
import Overview from './components/Overview.vue'
import ConfigurationPage from './components/ConfigurationPage.vue'


export default {
  name: 'App',
  components: {
    HelloWorld,
    AccountsPage,
    DebtTrackingPage,
    CategoriesPage,
    IntegrationsPage,
    Overview,
    ConfigurationPage
  },

   created(){
    if(this.user) {
      var date = new Date();
      var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
      if(window.location.hash){
        this.sidebarPage = window.location.hash.replace('#', '');
      }

      // Fetching transactions
      fetch(zbs_account.site + 'wp-json/wp/v2/transaction?_embed&modified_after='+firstDay.toISOString()+'&author=' + this.user.data.ID)
        .then((r) => {
          return r.json();
        })
        .then((res) => {
          this.totalEarning = 0;
          this.totalExpense = 0;
          res.map(item => {
            this.transactions.push({...item, expand: false});
            if(item.meta.transaction_type == 'Earning'){
              this.totalEarning += parseFloat(item.meta.transaction_amount);
            }
            if(item.meta.transaction_type == 'Expense'){
              this.totalExpense += parseFloat(item.meta.transaction_amount);
            }
          });
        })
        .then(() => {
          if((this.transactions.length / this.paging.pageSize) > parseInt(this.transactions.length / this.paging.pageSize)){
            this.paging.totalPage =  parseInt(this.transactions.length / this.paging.pageSize) + 1;
          } else {
            this.paging.totalPage =  parseInt(this.transactions.length / this.paging.pageSize);
          }
        });

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

      fetch(zbs_account.site + 'wp-json/wp/v2/settings', {
          credentials: 'same-origin',
          headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce' : zbs_account.nonce
          }
        })
        .then((r) => r.json())
        .then((res) => {
          this.siteSetting = res;
        }).then(() => {
          this.selectedCurrency = this.allCurrency.find((currency) => currency.code == this.siteSetting.zbs_currency);
          this.selectedCurrencyPosition = this.siteSetting.zbs_currency_position;
        });
    }
  },

   mounted(){
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

   data() {
    return {
      login_url: zbs_account.login_url,
      user: JSON.parse(zbs_account.user),
      plugin_url: zbs_account.plugin_dir_url,
      transactions: [],
      debts: [],
      paging: {
        pageSize: 20,
        currentPage: 1,
        totalPage: 1
      },
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
        if(index >= start && index < end) return true;
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
    }
  },
  methods: {
    getImgUrl: function(file){
      return this.plugin_url + file;
    },
    viewConfigurationPage(){
      this.configActive = true;
    },
     sidebarPageChange: function(page){
      this.sidebarPage = page;
      window.location.hash = page;
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
      if(comp.postformtype == 'editpostform'){
          var formData = {
            'title': this.title ? this.title : comp.postObj.title,
            'transaction_category': comp.newcat ? comp.cats.find(item => item.name == comp.newcat).id : comp.postObj.transaction_category[0],
            'meta': {
              'transaction_amount': this.newamount ? this.newamount : comp.postObj.transaction_amount,
              'transaction_note': this.newnote ? this.newnote : comp.postObj.transaction_note,
              'transaction_type': this.newtype ? this.newtype : comp.postObj.transaction_type
            }
          };

          var createPost = new XMLHttpRequest();
          createPost.open("POST", zbs_account.site + 'wp-json/wp/v2/transaction/' + comp.targetPost);
          createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
          createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
          createPost.send(JSON.stringify(formData));
          createPost.onreadystatechange = function() {
            if(createPost.readyState == 0){
              comp.btnDisabled = true;
              comp.postStatus = 'Processing request...';
            } else if (createPost.readyState == 1){
              comp.postStatus = 'Request sending...';
            } else if (createPost.readyState == 4){
              if(createPost.status == 200){
                comp.title = '';
                comp.newamount = '';
                comp.newnote = '';
                comp.newtype = 'Expense';
                comp.newcat = '';
                var returnData = JSON.parse(this.responseText);
                var indexOfEdited = comp.transactions.findIndex((data) => data.id == comp.targetPost);
                if(comp.transactions[indexOfEdited].meta.transaction_type == 'Earning'){
                  comp.totalEarning -= parseFloat(comp.transactions[indexOfEdited].meta.transaction_amount);
                }
                if(comp.transactions[indexOfEdited].meta.transaction_type == 'Expense'){
                  comp.totalExpense -= parseFloat(comp.transactions[indexOfEdited].meta.transaction_amount);
                }
                if(returnData.meta.transaction_type == 'Earning'){
                  comp.totalEarning += parseFloat(returnData.meta.transaction_amount);
                }
                if(returnData.meta.transaction_type == 'Expense'){
                  comp.totalExpense += parseFloat(returnData.meta.transaction_amount);
                }
                comp.transactions.splice(comp.transactions.findIndex((data) => data.id == comp.targetPost), 1, returnData);
                comp.postStatus = 'Successfully Posted';
                comp.postPop = false;
                comp.errors = [];
                comp.btnDisabled = false;
                comp.postStatus = 'Add to list';
                comp.progressEnable = false;
                comp.notificationPop('Transaction modified and list updated');
              } else {
                comp.postStatus = 'Error! Try again';
                comp.btnDisabled = false;
                comp.progressEnable = false;
                comp.notificationPop('There was a error. Try again.');
              }
            }
          }
      } else {
        comp.errors = [];
        if(comp.title != '' && comp.newamount != '' && comp.newcat && comp.hasCat[0]){
          var formData = {
            'title': this.title,
            'author': this.user.data.ID,
            'status': 'publish',
            'transaction_category': comp.cats.filter(item => item.name == comp.newcat)[0].id,
            'meta': {
              'transaction_amount': this.newamount,
              'transaction_note': this.newnote,
              'transaction_type': this.newtype
            }
          };

          var createPost = new XMLHttpRequest();
          createPost.open("POST", zbs_account.site + 'wp-json/wp/v2/transaction');
          createPost.setRequestHeader("X-WP-Nonce", zbs_account.nonce);
          createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
          createPost.send(JSON.stringify(formData));
          createPost.onreadystatechange = function() {
            if(createPost.readyState == 0){
              comp.btnDisabled = true;
              comp.postStatus = 'Processing request...';
            } else if (createPost.readyState == 1){
              comp.postStatus = 'Requesting sending...';
            } else if (createPost.readyState == 4){
              if(createPost.status == 201){
                comp.title = '';
                comp.newamount = '';
                comp.newnote = '';
                comp.newtype = 'Expense';
                comp.newcat = '';
                var returnData = JSON.parse(this.responseText);
                comp.transactions.unshift(returnData);
                if(returnData.meta.transaction_type == 'Earning'){
                  comp.totalEarning += parseFloat(returnData.meta.transaction_amount);
                }
                if(returnData.meta.transaction_type == 'Expense'){
                  comp.totalExpense += parseFloat(returnData.meta.transaction_amount);
                }
                comp.postStatus = 'Successfully Posted';
                comp.postPop = false;
                comp.errors = [];
                comp.btnDisabled = false;
                comp.postStatus = 'Add to list';
                comp.progressEnable = false;
                comp.notificationPop('Transaction added to the list');
              } else {
                comp.postStatus = 'Error! Try again';
                comp.btnDisabled = false;
                comp.progressEnable = false;
                comp.notificationPop('There was a error. Try again.');
              }
            }
          }
        } else {
          if (!comp.title) {
            comp.errors.push('Title required.');
            comp.notificationPop('Title required');
          }
          if (!comp.newamount) {
            comp.errors.push('Amount required.');
            comp.notificationPop('Amount required');
          }
          if(!comp.newcat){
            comp.errors.push('Category required.');
            comp.notificationPop('Category required');
          }
          if(comp.newcat && !comp.hasCat[0]){
            comp.errors.push('Category not valid.');
            comp.notificationPop('Category not valid');
          }
          comp.progressEnable = false;
        }
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

      activateReadMore: function(){
      this.readMoreActivated = true;
    },
    deactivateReadMore: function(){
      this.readMoreActivated = false;
    }

  },

}
</script>

<style>
/* #app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
} */
</style>
