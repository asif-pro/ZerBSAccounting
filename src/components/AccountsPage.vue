<template>
  <div class="accounting-page" :style="{ display: this.$parent.sidebarPage == 'accounting' ? 'block' : 'none' }">
      <div class="kh-container" v-if="this.$parent.user">
        <div class="kh-row">
            <div class="kh-col">
                <h3 class="top-welecome">Hi, {{this.$parent.user.data.display_name}}</h3>
            </div>
        </div>

        <div class="kh-mt-2">
          <div class="kh-row">
            <div class="kh-col-4">
              <div class="kh-card kh-card-flex">
                <div class="kh-card-content">
                    <p>Earning</p>
                    <h4>{{this.$parent.currencify(this.$parent.totalEarning, 2)}}</h4>
                </div>
              </div>
            </div>
            <div class="kh-col-4">
                <div class="kh-card kh-card-flex">
                    <div class="kh-card-content">
                        <p>Expense</p>
                        <h4>{{this.$parent.currencify(this.$parent.totalExpense, 2)}}</h4>
                    </div>
                </div>
            </div>
            <div class="kh-col-2">
              <div class="kh-card kh-card-flex kh-card-add kh-card-add-income" @click="this.$parent.quickAdd" data-ttype="Earning">
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
              <div class="kh-card kh-card-flex kh-card-add kh-card-add-expense" @click="this.$parent.quickAdd" data-ttype="Expense">
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
              <label class="placehold-btn kh-card-btn" @click="this.$parent.openNewPostForm">
                Add New
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.25781 6.09375H7.03125V3.86719C7.03125 3.80273 6.97852 3.75 6.91406 3.75H6.21094C6.14648 3.75 6.09375 3.80273 6.09375 3.86719V6.09375H3.86719C3.80273 6.09375 3.75 6.14648 3.75 6.21094V6.91406C3.75 6.97852 3.80273 7.03125 3.86719 7.03125H6.09375V9.25781C6.09375 9.32227 6.14648 9.375 6.21094 9.375H6.91406C6.97852 9.375 7.03125 9.32227 7.03125 9.25781V7.03125H9.25781C9.32227 7.03125 9.375 6.97852 9.375 6.91406V6.21094C9.375 6.14648 9.32227 6.09375 9.25781 6.09375Z"/>
                  <path d="M6.5625 0C2.93848 0 0 2.93848 0 6.5625C0 10.1865 2.93848 13.125 6.5625 13.125C10.1865 13.125 13.125 10.1865 13.125 6.5625C13.125 2.93848 10.1865 0 6.5625 0ZM6.5625 12.0117C3.55371 12.0117 1.11328 9.57129 1.11328 6.5625C1.11328 3.55371 3.55371 1.11328 6.5625 1.11328C9.57129 1.11328 12.0117 3.55371 12.0117 6.5625C12.0117 9.57129 9.57129 12.0117 6.5625 12.0117Z" />
                </svg>
              </label>
          </div>
          <!-- <div class="kh-post-pop" :class="{ active: this.$parent.postPop }" @click="this.$parent.handleFormFocus">
            <form id="postForm" class="post-form" @submit.prevent="submit">
              <label class="placehold-btn">
                <input type="checkbox" v-model="this.$parent.postPop"/>
                <span class="material-icons-outlined">close</span>
              </label>
              <input type="hidden" v-model="this.$parent.postformtype"/>
              <input type="hidden" v-model="this.$parent.targetPost"/>
              <p class="lead">Add new transaction</p>
              <p v-if="this.$parent.errors.length" class="error-box">
                <ul>
                  <li v-for="error in this.$parent.errors" :key="error.key">{{ error }}</li>
                </ul>
              </p>
             <label class="field-group">
                Description
                <input type="text" :placeholder="this.$parent.postformtype == 'editpostform' ? this.$parent.postObj.title.rendered : 'Write a description'" v-model="this.$parent.title"/>
              </label>
              <label class="field-group">
                <div class="box-radio-fields">
                  <label>
                    <input type="radio" name="earning-expense" v-model="this.$parent.newtype" value="Earning"/>
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
                    <input type="radio" name="earning-expense" v-model="this.$parent.newtype" value="Expense"/>
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
                    :placeholder="this.$parent.postformtype == 'editpostform' ? this.$parent.postObj.meta.transaction_amount : '00.0'"  
                    v-model="this.$parent.newamount"
                    v-autowidth="{maxWidth: '100%', minWidth: '95px', comfortZone: 0}"
                  />
                  <span>{{this.$parent.selectedCurrency.code}}</span>
                </span>
                <span class="amount-label">Amount</span>
              </label>

              <label class="field-group cat-field-group">
                Category
                <div class="cat-with-icon">
                  <span class="material-icons-outlined" v-if="this.$parent.hasCat[0]">{{this.$parent.filteredCat[0].meta.icon[0]}}</span>
                  <span class="material-icons-outlined" v-else>add</span>
                  <input class="catinput" v-on:focus="this.$parent.catDrop=true" type="text" :placeholder="this.$parent.postformtype == 'editpostform' && this.$parent.postObj.category ? this.$parent.postObj.category.name : 'Category'" v-model="this.$parent.newcat"/>
                </div>
                <div class="cat-list" :class="{active: this.$parent.catDrop}">
                  <label v-for="item in this.$parent.filteredCat" @click="this.$parent.newcat = item.name; this.$parent.catDrop=false" :key="item.id">
                    <span class="cat-icon" :style="{ color: item.meta.color[0] ? item.meta.color[0] : 'rgb(103, 104, 108)' }"><span class="material-icons-outlined">{{item.meta.icon[0] ? item.meta.icon[0] : 'quiz'}}</span></span>
                    <span class="cat-name" v-html="item.name"></span>
                  </label>
                  <label type="button" @click="catsubmit" v-if="!this.$parent.hasCat[0] && this.$parent.newcat">
                    <span class="cat-icon" :style="{ color: 'rgb(103, 104, 108)' }"><span class="material-icons-outlined">add</span></span>
                    <span class="cat-name">Add '{{this.$parent.newcat}}' as a new Category</span>
                  </label>
                </div>
              </label>
              <label class="field-group field-group-check"><input type="checkbox" v-model="this.$parent.addANote"><span>Add a note with this transaction</span></label>
              <label class="field-group" v-if="this.$parent.addANote">
                Note
                <textarea :placeholder="this.$parent.postformtype == 'editpostform' ? this.$parent.postObj.meta.transaction_note : 'Have any note...'" v-model="this.$parent.newnote"></textarea>
              </label>
              <input type="hidden" action="new_transaction"/>
              <button type="submit" :disabled='this.$parent.btnDisabled'>{{this.$parent.postStatus}}</button>
            </form>
          </div> -->
          <div class="account-table-responsive">
            <table class="kh-account-table">
                <tr class="kh-account-table-header">
                    <th class="tr-th"><span>Transaction</span></th>
                    <th class="type-th"><span>Type</span></th>
                    <th class="cat-th"><span>Category</span></th>
                    <th><span>Amount</span></th>
                    <th><span>&nbsp;</span></th>
                </tr>
                <tr class="kh-account-table-items" v-for="item in this.$parent.filteredPost" :key="item.id">
                    <td>
                      <span class="kh-t-title" v-html="item.title.rendered"></span>
                      <span class="kh-t-subtitle">{{item.formatted_date}}</span>
                    </td>
                    <td><span class="kh-type" :class="[item.meta.transaction_type == 'Expense' ? 'kh-type-expense' : '']">{{item.meta.transaction_type}}</span></td>
                    <td><span class="kh-t-category" v-if="item.category" v-html="item.category.name"></span></td>
                    <td><span class="kh-amount">{{item.meta.transaction_amount ? this.$parent.currencify(item.meta.transaction_amount, 0) : this.$parent.currencify('00', 0)}}</span></td>
                    <td class="postEditTd">
                      <label class="placehold-btn">
                        <input type="checkbox" v-model="item.expand"/>
                        <span class="material-icons-outlined post-existing-pop-toggle">more_horiz</span>
                      </label>
                      <div class="post-existing-pop" :class="{active: item.expand}">
                          <ul class="existing-post-dropdown">
                            <li @click="this.$parent.enEditForm" :data-id="item.id">Edit Transaction</li>
                            <li @click="this.$parent.createNewDuplication" :data-id="item.id">Duplicate Transaction</li>
                            <li @click="this.$parent.deleteThisPost" :data-id="item.id" style="color: #B91C1C">Delete Transaction</li>
                          </ul>
                        </div>
                    </td>
                </tr>
            </table>
          </div>
          <div class="kh-pagination" v-if="this.$parent.paging.totalPage > 1">
            <span @click="this.$parent.prevPage"><span class="material-icons-outlined">keyboard_arrow_left</span></span>
            <span v-for="index in this.$parent.paging.totalPage" :key="index"><span @click="this.$parent.paging.currentPage = index" :class="{ current: this.$parent.paging.currentPage == index }">{{index}}</span></span>
            <span @click="this.$parent.nextPage"><span class="material-icons-outlined">keyboard_arrow_right</span></span>
          </div>
      </div>
      </div>
      <div class="kh-container" v-else>
        <div class="kh-container-nopriv">
            <div class="kh-not-logged-in-notice">
                <h3>You are not logged in</h3>
                <p>Without being logged in you are not allowed to access the page of Zero BS Accounting. Log in and get yourselves organized for accounting matter...</p>
                <a :href="this.$parent.login_url">Log In</a>
            </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    name: 'AccountsPage',

}
</script>

<style>

</style>