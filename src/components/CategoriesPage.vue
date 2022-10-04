<template>
  <div class="categories-page" :style="{ display: this.$parent.sidebarPage == 'categories' ? 'block' : 'none' }">
      <div class="kh-container" v-if="this.$parent.user">
        <div class="kh-row">
          <div class="kh-col category-title">
            <h3 class="top-welecome">Categories</h3>
            <label class="placehold-btn kh-card-btn" @click="this.$parent.openNewCategoryForm">
              Add New Category
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.25781 6.09375H7.03125V3.86719C7.03125 3.80273 6.97852 3.75 6.91406 3.75H6.21094C6.14648 3.75 6.09375 3.80273 6.09375 3.86719V6.09375H3.86719C3.80273 6.09375 3.75 6.14648 3.75 6.21094V6.91406C3.75 6.97852 3.80273 7.03125 3.86719 7.03125H6.09375V9.25781C6.09375 9.32227 6.14648 9.375 6.21094 9.375H6.91406C6.97852 9.375 7.03125 9.32227 7.03125 9.25781V7.03125H9.25781C9.32227 7.03125 9.375 6.97852 9.375 6.91406V6.21094C9.375 6.14648 9.32227 6.09375 9.25781 6.09375Z"/>
                <path d="M6.5625 0C2.93848 0 0 2.93848 0 6.5625C0 10.1865 2.93848 13.125 6.5625 13.125C10.1865 13.125 13.125 10.1865 13.125 6.5625C13.125 2.93848 10.1865 0 6.5625 0ZM6.5625 12.0117C3.55371 12.0117 1.11328 9.57129 1.11328 6.5625C1.11328 3.55371 3.55371 1.11328 6.5625 1.11328C9.57129 1.11328 12.0117 3.55371 12.0117 6.5625C12.0117 9.57129 9.57129 12.0117 6.5625 12.0117Z" />
              </svg>
            </label>
          </div>
        </div>

        <div class="kh-post-pop" :class="{ active: this.$parent.newaddcatPop }" @click="this.$parent.handleFormFocus">
            <form id="categoryForm" class="post-form" @submit.prevent="this.$parent.addCatsubmit">
              <label class="placehold-btn">
                <input type="checkbox" v-model="this.$parent.newaddcatPop"/>
                <span class="material-icons-outlined">close</span>
              </label>
              <p class="lead">Add new category</p>
              <label class="field-group">
                Category Name
                <input type="text" placeholder="eg. Travel" v-model="this.$parent.newaddcat"/>
              </label>
              <label class="field-group">
                Category Type
                <select v-model="this.$parent.newaddcattype">
                  <option value="both">Both</option>
                  <option value="earning">Earning</option>
                  <option value="expense">Expense</option>
                </select>
              </label>
              <label class="field-group">
                Category Color 
                <verte v-model="this.$parent.newaddcatcolor" model="rgb"><span class="verte-selected-color" :style="{ backgroundColor: this.$parent.newaddcatcolor }"></span></verte>
              </label>
              <div class="field-group icons-field">
                Category Icon
                <div class="icon-field_selected">
                  <span class="material-icons-outlined">{{this.$parent.newaddcaticon}}</span>
                  <button type="button" class="icon-name" @click="this.$parent.iconDrop=true">{{this.$parent.newaddcaticon}}</button>
                </div>
                <div class="icon-selector" :class="{active: this.$parent.iconDrop}">
                  <input type="search" class="icon-search" placeholder="Search..." v-model="this.$parent.iconQuery"/>
                  <div class="icon-list">
                    <label v-for="item in this.$parent.filteredIcon" @click="this.$parent.newaddcaticon = item; this.$parent.iconDrop=false" :key="item.key" :class="{  active: this.$parent.item == newaddcaticon }">
                      <span class="material-icons-outlined">{{item}}</span>
                    </label>
                  </div>
                </div>
              </div>
              <button type="submit" :disabled='this.$parent.btnDebtDisabled'>{{this.$parent.debtStatus}}</button>
            </form>
          </div>

        <div class="kh-mt-2">
          <ul class="category-list">
            <li class="category-list-item" @click="this.$parent.newtype='Expense'" :class="{ active: this.$parent.newtype=='Expense' }">Expense</li>
            <li class="category-list-item" @click="this.$parent.newtype='Earning'" :class="{ active: this.$parent.newtype=='Earning' }">Earning</li>
          </ul>
        </div>

        <div class="kh-row kh-category-list">
          <div class="kh-col-6" v-for="item in this.$parent.filteredCat" :key="item.id">
            <div class="kh-category-list-item">
              <span class="cat-icon" :style="{ color: item.meta.color[0] ? item.meta.color[0] : 'rgb(103, 104, 108)' }"><span class="material-icons-outlined">{{item.meta.icon[0] ? item.meta.icon[0] : 'quiz'}}</span></span>
              <span class="cat-name" v-html="item.name"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    name: 'CategoriesPage',

}
</script>

<style>

</style>