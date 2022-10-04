<template>
  <div class="kh-post-pop kh-config-pop" :class="{ active: this.$parent.configActive }" @click="this.$parent.handleFormFocus">
          <form id="configForm" class="post-form" @submit.prevent="this.$parent.configSubmit">
            <label class="placehold-btn">
              <input type="checkbox" v-model="this.$parent.configActive"/>
              <span class="material-icons-outlined">close</span>
            </label>
            <p class="lead">Configuration</p>
            <p v-if="this.$parent.configErrors.length" class="error-box">
              <ul>
                <li v-for="error in this.$parent.configErrors" :key="error.key">{{ error }}</li>
              </ul>
            </p>
            <div class="field-group currency-field">
              Currency
              <div class="currency-field_selected">
                <button type="button" class="currency-name" @click="this.$parent.currencyDrop=true">
                  <span>{{this.$parent.selectedCurrency.code}}</span>
                  <span>{{this.$parent.selectedCurrency.symbol_native}}</span>
                </button>
              </div>
              <div class="currency-selector" :class="{active: this.$parent.currencyDrop}">
                <input type="search" class="currency-search" placeholder="Search..." v-model="this.$parent.currencyQuery"/>
                <div class="currency-list">
                  <label v-for="item in this.$parent.filteredCurrency" @click="this.$parent.selectedCurrency = item; this.$parent.currencyDrop=false" :key="item.key" :class="{  active: item.code == this.$parent.selectedCurrency.code }">
                    <span>{{item.code}}</span>
                    <span>{{item.symbol_native}}</span>
                  </label>
                </div>
              </div>
            </div>
            <label class="field-group">
              Currency Position
              <select v-model="this.$parent.selectedCurrencyPosition">
                <option value="before">Before</option>
                <option value="after">After</option>
              </select>
            </label>
            <button type="submit" :disabled='this.$parent.configBtnDisabled'>{{this.$parent.configStatus}}</button>
          </form>
        </div>
</template>

<script>
export default {
  name: 'ConfigurationPage',

}
</script>

<style>

</style>