<template>
   <div class="overview-page" :style="{ display: this.$parent.sidebarPage == 'overview' ? 'block' : 'none' }">
      <div class="kh-container" v-if="this.$parent.user">
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
              <div class="chart-overlay" @click="this.$parent.proPop=true">
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
              <div class="chart-overlay" @click="this.$parent.proPop=true">
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
              <div class="chart-overlay" @click="this.$parent.proPop=true">
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
              <div class="chart-overlay" @click="this.$parent.proPop=true">
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
    name: 'Overview',

}
</script>

<style>

</style>