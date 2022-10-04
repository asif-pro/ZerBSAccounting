<template>
  <div class="debt-page" :style="{ display: this.$parent.sidebarPage == 'debt' ? 'block' : 'none' }">
      <div class="kh-post-pop" :class="{ active: this.$parent.debtPop }" @click="this.$parent.handleFormFocus">
          <form id="debtForm" class="post-form" @submit.prevent="this.$parent.debtSubmit">
            <label class="placehold-btn">
              <input type="checkbox" v-model="this.$parent.debtPop"/>
              <span class="material-icons-outlined">close</span>
            </label>
            <p class="lead">{{this.$parent.debtformtype == 'editpostform' ? `Edit ${this.$parent.debtForTransactionObj.title.rendered} person` : 'Add new person'}}</p>
            <p v-if="this.$parent.debterrors.length" class="error-box">
              <ul>
                <li v-for="error in this.$parent.debterrors" :key="error.key">{{ error }}</li>
              </ul>
            </p>
            <label class="field-group">
              Person Name
              <input type="text" :placeholder="this.$parent.debtformtype == 'editpostform' ? this.$parent.debtForTransactionObj.title.rendered : 'Write a name'" v-model="this.$parent.debttitle"/>
            </label>
            <label class="field-group">
              Phone Number
              <input type="tel" :placeholder="this.$parent.debtformtype == 'editpostform' ? this.$parent.debtForTransactionObj.meta.debt_phone : 'Write phone number'" v-model="this.$parent.deptPhoneNumber"/>
            </label>
            <label class="field-group">
              Email Address
              <input type="email" :placeholder="this.$parent.debtformtype == 'editpostform' ? this.$parent.debtForTransactionObj.meta.debt_email : 'Email Address'" v-model="this.$parent.deptEmailAddress"/>
            </label>
            <div v-if="this.$parent.debtformtype == 'newpostform'">
              <label class="field-group field-group-check"><input type="checkbox" v-model="this.$parent.addPrevToDebt"><span>Do want to add previous debt?</span></label>
              <label class="field-group" v-if="this.$parent.addPrevToDebt">
                Previous Debit/Credit
                <div class="box-radio-fields m-t-0">
                  <label>
                    <input type="radio" name="debtType" v-model="this.$parent.debtType" value="debit"/>
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
                    <input type="radio" name="debtType" v-model="this.$parent.debtType" value="credit"/>
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
              <label class="field-group amount-field" v-if="this.$parent.addPrevToDebt">
                <span class="styled-amount">
                  <input 
                    type="number" 
                    inputmode="decimal"
                    step="0.01" 
                    :placeholder="this.$parent.debtformtype == 'editpostform' ? this.$parent.debtForTransactionObj.meta.debt_amount : '00.0'"  
                    v-model="this.$parent.newdebtamount"
                    v-autowidth="{maxWidth: '100%', minWidth: '95px', comfortZone: 0}"
                  />
                  <span>{{this.$parent.selectedCurrency.code}}</span>
                </span>
                <span class="amount-label">Previous Amount</span>
              </label>
            </div>
            <label class="field-group field-group-check"><input type="checkbox" v-model="this.$parent.addANoteDebt"><span>Add a note with this person</span></label>
            <label class="field-group" v-if="this.$parent.addANoteDebt">
              Note
              <textarea :placeholder="this.$parent.debtformtype == 'editpostform' ? this.$parent.debtForTransactionObj.meta.debt_note : 'Have any note...'" v-model="this.$parent.newdebtnote"></textarea>
            </label>
            <button type="submit" :disabled='this.$parent.btnDebtDisabled'>{{this.$parent.debtStatus}}</button>
          </form>
        </div>
      <div v-if="this.$parent.debtForTransaction">
        <div class="kh-container" v-if="this.$parent.user">
          <div class="kh-row">
            <label class="placehold-btn kh-card-btn kh-card-btn-left" @click="this.$parent.closeDebtForTransaction">
              <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.8 490.8"><path d="M362.7 490.8c-2.8 0-5.5-1.1-7.6-3.1L120.5 253c-4.2-4.2-4.2-10.9 0-15.1L355.1 3.3c4.1-4.2 10.8-4.4 15.1-0.3 4.2 4.1 4.4 10.8 0.3 15.1 -0.1 0.1-0.2 0.2-0.3 0.3L143.1 245.5l227.1 227.1c4.2 4.2 4.2 10.9 0 15.1C368.2 489.7 365.5 490.8 362.7 490.8z" fill="#F44336"/><path d="M362.7 490.8c-2.8 0-5.5-1.1-7.6-3.1L120.5 253c-4.2-4.2-4.2-10.9 0-15.1L355.1 3.3c4.1-4.2 10.8-4.4 15.1-0.3 4.2 4.1 4.4 10.8 0.3 15.1 -0.1 0.1-0.2 0.2-0.3 0.3L143.1 245.5l227.1 227.1c4.2 4.2 4.2 10.9 0 15.1C368.2 489.7 365.5 490.8 362.7 490.8z"/></svg>
              Back to Persons
            </label>
          </div>
          <div class="kh-row kh-mt-3">
            <div class="kh-col-12">
              <div class="kh-card kh-card-flex kh-card-person">
                <div class="kh-card-content">
                  <div class="kh-card-person-thumb"><img :src="getAvatar(this.$parent.debtForTransactionObj.meta.debt_email, 400)"/></div>
                  <div class="kh-card-person-detail">
                    <h4>
                      {{this.$parent.debtForTransactionObj.title.rendered}}
                      <div class="person-action-btn">
                        <label class="placehold-btn kh-card-btn" @click="this.$parent.enDebtEditForm" :data-id="this.$parent.debtForTransactionObj.id">
                          Edit Person
                        </label>
                        <label class="placehold-btn kh-card-btn kh-card-btn-red" @click="this.$parent.deleteDebtThisPost" :data-id="this.$parent.debtForTransactionObj.id">
                          Delete Person
                        </label>
                      </div>
                    </h4>
                    <p class="kh-card-contact">
                      <span v-if="this.$parent.debtForTransactionObj.meta.debt_phone"><span class="material-icons-outlined">call</span>{{this.$parent.debtForTransactionObj.meta.debt_phone}}</span>
                      <span v-if="this.$parent.debtForTransactionObj.meta.debt_email"><span class="material-icons-outlined">markunread</span>{{this.$parent.debtForTransactionObj.meta.debt_email}}</span>
                    </p> 
                  </div>
                  <div class="kh-card-person-detail-2">
                    <p class="kh-current-debt">{{this.$parent.debtForTransactionObj.debt_type == 'credit' ? `You owe to ${this.$parent.debtForTransactionObj.title.rendered} ` : `${this.$parent.debtForTransactionObj.title.rendered} owes you `}}<span class="kh-amount" :class="[this.$parent.debtForTransactionObj.debt_type == 'credit' ? 'kh-amount-expense' : '']">{{this.$parent.debtForTransactionObj.debt_amount ? currencify(this.$parent.debtForTransactionObj.debt_amount, 0) : currencify('00', 0)}}</span></p>
                    <p v-if="this.$parent.debtForTransactionObj.meta.debt_note">
                      <span v-if="this.$parent.debtForTransactionObj.meta.debt_note.length > 70">
                        <span v-if="!this.$parent.readMoreActivated">{{this.$parent.debtForTransactionObj.meta.debt_note.slice(0, 70)}}</span>
                        <a class="" v-if="!this.$parent.readMoreActivated" @click="this.$parent.activateReadMore" href="#">Show more...</a>
                        <span v-if="this.$parent.readMoreActivated" v-html="this.$parent.debtForTransactionObj.meta.debt_note"></span>
                        <a class="" v-if="this.$parent.readMoreActivated" @click="this.$parent.deactivateReadMore" href="#">Show less</a>
                      </span>
                      <span v-else>
                        <span v-html="this.$parent.debtForTransactionObj.meta.debt_note"></span>
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
                <label class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-add" @click="() => {this.$parent.debtTransactionType = 'debit'; this.$parent.openNewDebtTransactionForm();}">
                  <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.4 341.4"><polygon points="192 149.4 192 0 149.4 0 149.4 149.4 0 149.4 0 192 149.4 192 149.4 341.4 192 341.4 192 192 341.4 192 341.4 149.4 "/></svg>
                </label>
                <label class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-remove" @click="() => {this.$parent.debtTransactionType = 'credit'; this.$parent.openNewDebtTransactionForm();}">
                  <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.3 341.3"><rect y="149.3" width="341.3" height="42.7"/></svg>
                </label>
            </div>
            <div class="kh-post-pop" :class="{ active: this.$parent.debtTransactionPop }" @click="this.$parent.handleFormFocus">
              <form id="debtTransactionForm" class="post-form" @submit.prevent="this.$parent.debtTransactionSubmit">
                <label class="placehold-btn">
                  <input type="checkbox" v-model="this.$parent.debtTransactionPop"/>
                  <span class="material-icons-outlined">close</span>
                </label>
                <p class="lead" v-if="this.$parent.debtTransactionType=='credit'">How much should be taken off {{this.$parent.debtForTransactionObj.title.rendered}}'s debt?</p>
                <p class="lead" v-else>How much should be added to {{this.$parent.debtForTransactionObj.title.rendered}}'s debt?</p>
                <p v-if="this.$parent.debttransactionerrors.length" class="error-box">
                  <ul>
                    <li v-for="error in this.$parent.debttransactionerrors" :key="error.key">{{ error }}</li>
                  </ul>
                </p>
                <label class="field-group amount-field">
                  <span class="styled-amount">
                    <input 
                      type="number" 
                      inputmode="decimal"
                      step="0.01" 
                      placeholder="0.00"
                      v-model="this.$parent.newdebttransactionamount"
                      v-autowidth="{maxWidth: '100%', minWidth: '95px', comfortZone: 0}"
                    />
                    <span>{{this.$parent.selectedCurrency.code}}</span>
                  </span>
                  <span class="amount-label">Amount</span>
                </label>
                <label class="field-group">
                  Why?
                  <textarea placeholder="Have any note..." v-model="this.$parent.newdebttransactionnote"></textarea>
                </label>
                <input type="hidden" action="new_debt_transaction"/>
                <button type="submit" :disabled='this.$parent.btnDebtTransactionDisabled'>{{this.$parent.debtTransactionStatus}}</button>
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
                  <tr class="kh-account-table-items" v-for="item in this.$parent.filteredDebtTransactions" :key="item.id">
                      <td class="kh-account-date-td">
                        <span class="kh-t-title">{{this.$parent.localeDate(item.transaction_date)}}</span>
                        <span class="kh-t-subtitle" v-if="item.transaction_note" v-html="item.transaction_note"></span>
                        <span class="kh-amount" :class="[item.transaction_type == 'credit' ? 'kh-amount-expense' : '']">{{item.transaction_amount ? this.$parent.currencify(item.transaction_amount, 0) : this.$parent.currencify('00', 0)}}</span>
                      </td>
                      <td class="kh-amount-td"><span class="kh-amount" :class="[item.transaction_type == 'credit' ? 'kh-amount-expense' : '']">{{item.transaction_amount ? this.$parent.currencify(item.transaction_amount, 0) : currencify('00', 0)}}</span></td>
                      <td class="kh-debit-credit-td"><span class="kh-type" :class="[item.transaction_type == 'credit' ? 'kh-type-expense' : '']">{{item.transaction_type}}</span></td>
                      <td class="postEditTd">
                        <span @click="this.$parent.deleteDebtTransactionThisPost" :data-id="item.id" class="debt-delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 407.5 407.5" width="20" height="20"><path d="M335.9 114.9H71.6c-2.9-0.2-5.7 0.7-7.8 2.6 -2.1 2-3.1 5-2.6 7.8l27.2 236.7c3.2 26.1 25.4 45.6 51.7 45.5h131.7c27 0.4 49.8-20.1 52.2-47l22.5-236.1c0.1-2.5-0.8-5-2.6-6.8C341.6 115.6 338.8 114.7 335.9 114.9zM303 359.5c-1.6 15.9-15.4 27.8-31.3 27.2H140c-15.7 0.6-29.2-11-30.8-26.6L83.1 135.8h241.4L303 359.5z"/><path d="M374.1 47H266.5V30.3c0.6-16.1-12-29.7-28.2-30.3 -0.5 0-1.1 0-1.6 0h-65.8c-16.2-0.3-29.5 12.6-29.8 28.7 0 0.5 0 1.1 0 1.6v16.7H33.4c-5.8 0-10.4 4.7-10.4 10.4s4.7 10.4 10.4 10.4h340.6c5.8 0 10.4-4.7 10.4-10.4S379.8 47 374.1 47zM245.6 30.3v16.7h-83.6V30.3c-0.6-4.6 2.6-8.8 7.2-9.4 0.5-0.1 1.1-0.1 1.7 0h65.8c4.6-0.3 8.6 3.1 8.9 7.7C245.6 29.2 245.6 29.8 245.6 30.3z"/></svg></span>
                      </td>
                  </tr>
              </table>
            </div>
            <div class="kh-pagination" v-if="this.$parent.debtTransactionPaging.totalPage > 1">
              <span @click="debtTransactionPrevPage"><span class="material-icons-outlined">keyboard_arrow_left</span></span>
              <span v-for="index in this.$parent.debtTransactionPaging.totalPage" :key="index"><span @click="this.$parent.debtTransactionPaging.currentPage = index" :class="{ current: this.$parent.debtTransactionPaging.currentPage == index }">{{index}}</span></span>
              <span @click="this.$parent.debtTransactionNextPage"><span class="material-icons-outlined">keyboard_arrow_right</span></span>
            </div>
          </div>

          <div class="kh-row kh-mt-3">
            <label class="placehold-btn kh-card-btn kh-card-btn-left" @click="this.$parent.closeDebtForTransaction">
              <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.8 490.8"><path d="M362.7 490.8c-2.8 0-5.5-1.1-7.6-3.1L120.5 253c-4.2-4.2-4.2-10.9 0-15.1L355.1 3.3c4.1-4.2 10.8-4.4 15.1-0.3 4.2 4.1 4.4 10.8 0.3 15.1 -0.1 0.1-0.2 0.2-0.3 0.3L143.1 245.5l227.1 227.1c4.2 4.2 4.2 10.9 0 15.1C368.2 489.7 365.5 490.8 362.7 490.8z" fill="#F44336"/><path d="M362.7 490.8c-2.8 0-5.5-1.1-7.6-3.1L120.5 253c-4.2-4.2-4.2-10.9 0-15.1L355.1 3.3c4.1-4.2 10.8-4.4 15.1-0.3 4.2 4.1 4.4 10.8 0.3 15.1 -0.1 0.1-0.2 0.2-0.3 0.3L143.1 245.5l227.1 227.1c4.2 4.2 4.2 10.9 0 15.1C368.2 489.7 365.5 490.8 362.7 490.8z"/></svg>
              Back to Persons
            </label>
          </div>
        </div>
      </div>
      <div v-else>
        <div class="kh-container" v-if="this.$parent.user">
          <div class="kh-row">
            <div class="kh-col debt-tracking-title">
              <h3 class="top-welecome">Debt Tracking</h3>
              <div class="profile-select">
                <span class="profile-selected">
                  <span>Using as self</span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.011 512.011"><path d="M505.755 123.592c-8.341-8.341-21.824-8.341-30.165 0L256.005 343.176 36.421 123.592c-8.341-8.341-21.824-8.341-30.165 0s-8.341 21.824 0 30.165l234.667 234.667c4.16 4.16 9.621 6.251 15.083 6.251s10.923-2.091 15.083-6.251l234.667-234.667c8.34-8.341 8.34-21.824-.001-30.165z"/></svg>
                </span>
                <div class="profile-selector" @click="this.$parent.proPop=true">Add a new profile (Pro)</div>
              </div>
            </div>
          </div>

          <div class="kh-mt-2">
            <div class="kh-row">
              <div class="kh-col-6">
                <div class="kh-card kh-card-flex">
                  <div class="kh-card-content">
                      <p>Debit</p>
                      <h4>{{this.$parent.currencify(this.$parent.totalDebit, 2)}}</h4>
                  </div>
                </div>
              </div>
              <div class="kh-col-6">
                  <div class="kh-card kh-card-flex">
                      <div class="kh-card-content">
                          <p>Credit</p>
                          <h4>{{this.$parent.currencify(this.$parent.totalCredit, 2)}}</h4>
                      </div>
                  </div>
              </div>
            </div>
          </div>

          <div class="kh-card kh-mt-3 kh-account-list">
            <div class="kh-card-header">
                <h3 class="kh-card-title">Current Debts</h3>
                <label class="placehold-btn kh-card-btn" @click="this.$parent.openNewDebtForm">
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
                  <tr class="kh-account-table-items" v-for="item in this.$parent.debts" :key="item.id">
                      <td class="kh-person-td">
                        <div class="person-list-info-wrap" @click="this.$parent.openDebtForTransaction" :data-id="item.id">
                        
                           <span class="person-avatar">
                               <img :src="this.$parent.getAvatar(item.meta.debt_email, 40)"/>
                               </span>
                          <span class="person-list-info" :data-id="item.id">
                            <span class="kh-t-title" v-html="item.title.rendered"></span>
                            <span class="kh-t-subtitle" v-if="item.meta.debt_phone" v-html="item.meta.debt_phone"></span>
                            <span class="kh-t-subtitle" v-if="!item.meta.debt_phone && item.meta.debt_note" v-html="item.meta.debt_note"></span>
                            <div class="mobile-add-btn">
                              <label :data-id="item.id" class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-add" @click="(e) => {this.$parent.debtTransactionType = 'debit'; this.$parent.openDebtForTransaction(e); this.$parent.openNewDebtTransactionForm(); this.$parent.debtTransactionPop = true;}">
                                <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.4 341.4"><polygon points="192 149.4 192 0 149.4 0 149.4 149.4 0 149.4 0 192 149.4 192 149.4 341.4 192 341.4 192 192 341.4 192 341.4 149.4 "/></svg>
                              </label>
                              <label :data-id="item.id" class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-remove" @click="(e) => {this.$parent.debtTransactionType = 'credit'; this.$parent.openDebtForTransaction(e); this.$parent.openNewDebtTransactionForm(); this.$parent.debtTransactionPop = true;}">
                                <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.3 341.3"><rect y="149.3" width="341.3" height="42.7"/></svg>
                              </label>
                            </div>
                            <span class="kh-amount" :class="[item.debt_type == 'credit' ? 'kh-amount-expense' : '']">{{item.debt_amount ? this.$parent.currencify(item.debt_amount, 0) : this.$parent.currencify('00', 0)}}</span>
                          </span>
                        </div>
                      </td>
                      <td class="kh-amount-td"><span class="kh-amount" :class="[item.debt_type == 'credit' ? 'kh-amount-expense' : '']">{{item.debt_amount ? this.$parent.currencify(item.debt_amount, 0) : this.$parent.currencify('00', 0)}}</span></td>
                      <td class="kh-dc-td"><span class="kh-type" :class="[item.debt_type == 'credit' ? 'kh-type-expense' : '']">{{item.debt_type}}</span></td>
                      <td class="kh-person-add-td">
                        <label :data-id="item.id" class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-add" @click="(e) => {this.$parent.debtTransactionType = 'debit'; this.$parent.openDebtForTransaction(e); this.$parent.openNewDebtTransactionForm(); this.$parent.debtTransactionPop = true;}">
                          <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.4 341.4"><polygon points="192 149.4 192 0 149.4 0 149.4 149.4 0 149.4 0 192 149.4 192 149.4 341.4 192 341.4 192 192 341.4 192 341.4 149.4 "/></svg>
                        </label>
                        <label :data-id="item.id" class="placehold-btn kh-card-btn kh-card-btn-round kh-card-btn-remove" @click="(e) => {this.$parent.debtTransactionType = 'credit'; this.$parent.openDebtForTransaction(e); this.$parent.openNewDebtTransactionForm(); this.$parent.debtTransactionPop = true;}">
                          <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.3 341.3"><rect y="149.3" width="341.3" height="42.7"/></svg>
                        </label>
                      </td>
                      <td class="postEditTd">
                        <span @click="this.$parent.deleteDebtThisPost" :data-id="item.id" class="debt-delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 407.5 407.5" width="20" height="20"><path d="M335.9 114.9H71.6c-2.9-0.2-5.7 0.7-7.8 2.6 -2.1 2-3.1 5-2.6 7.8l27.2 236.7c3.2 26.1 25.4 45.6 51.7 45.5h131.7c27 0.4 49.8-20.1 52.2-47l22.5-236.1c0.1-2.5-0.8-5-2.6-6.8C341.6 115.6 338.8 114.7 335.9 114.9zM303 359.5c-1.6 15.9-15.4 27.8-31.3 27.2H140c-15.7 0.6-29.2-11-30.8-26.6L83.1 135.8h241.4L303 359.5z"/><path d="M374.1 47H266.5V30.3c0.6-16.1-12-29.7-28.2-30.3 -0.5 0-1.1 0-1.6 0h-65.8c-16.2-0.3-29.5 12.6-29.8 28.7 0 0.5 0 1.1 0 1.6v16.7H33.4c-5.8 0-10.4 4.7-10.4 10.4s4.7 10.4 10.4 10.4h340.6c5.8 0 10.4-4.7 10.4-10.4S379.8 47 374.1 47zM245.6 30.3v16.7h-83.6V30.3c-0.6-4.6 2.6-8.8 7.2-9.4 0.5-0.1 1.1-0.1 1.7 0h65.8c4.6-0.3 8.6 3.1 8.9 7.7C245.6 29.2 245.6 29.8 245.6 30.3z"/></svg></span>
                      </td>
                  </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

</template>

<script>
export default {
    name: 'DebtTrackingPage',

}
</script>

<style>

</style>