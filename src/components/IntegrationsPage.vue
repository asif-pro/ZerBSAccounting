<template>
<div class="integrations-page" :style="{ display: this.$parent.sidebarPage == 'integrations' ? 'block' : 'none' }">
       <div class="kh-container" v-if="this.$parent.user">
       <div class="kh-row">
        <div class="kh-col">
            <h3 class="top-welecome">Integrate with</h3>
          </div>
        </div>
         <div class="kh-row kh-mt-2">
          <div class="kh-col-6">
            <div class="integration-box">
               <div class="integration-thumb">
                  <slot name="wooCommerceImage"></slot>
              </div>
               <div class="integration-content">
                <h4>WooCommerce</h4>
                <p>Integrate woocommerce to enjoy flexible earning and costing calculation on you store</p>
              </div>
              <div class="chart-overlay" @click="this.$parent.proPop=true">
                <span target="_blank" class="get-pro-btn"><span class="material-icons-outlined">lock</span> Upgrade Now</span>
              </div>
            </div>
          </div>
          <div class="kh-col-6">
            <div class="integration-box">
              <div class="integration-thumb">
                <slot name="easyDigitalDownloadImage"></slot>
              </div>
             <div class="integration-content">
                <h4>Easy Digital Downloads</h4>
                <p>You can also use with easy digital download when offering your digital product for download or subscription</p>
              </div>
              <div class="chart-overlay" @click="this.$parent.proPop=true">
                <span target="_blank" class="get-pro-btn"><span class="material-icons-outlined">lock</span> Upgrade Now</span>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
</template>

<script>
export default {
  name: 'IntegrationsPage',
  
}
</script>

<style>

</style>