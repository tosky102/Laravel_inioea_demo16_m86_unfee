<template>
    <div class="list-page-wrapper" ref="list_page_wrapper">
      <div class="list-page-title" style="margin: 0 70px">検索</div>
  
      <!-- <div
        class="list-page-content card login-card"
        style="padding: 1.5rem"
        :style="{ width: suggestWidth + 'px' }"
      > -->
      <div class="list-page-content card login-card">
        <div class="list-page-search px-0 py-0 mb-0">
          <form action="/user" class="form" method="get">
            <input type="hidden" name="type" :value="config.type" />
            <div class="form-wrapper row">
              <div class="col-6 col-md-4 mb-2">
                <label for="" class="d-flex align-items-center">
                  <select
                    v-model="config.category"
                    name="category"
                    class="form-control login-input"
                    id=""
                  >
                    <option value="">カテゴリーを選択してください</option>
                    <option
                      v-for="(category, key) in config.categories"
                      :key="key"
                      :value="key"
                    >
                      {{ category }}
                    </option>
                  </select>
                </label>
              </div>
              <div class="col-6 col-md-4 mb-2">
                <label for="" class="d-flex align-items-center">
                  <select
                    v-model="config.area"
                    name="area"
                    class="form-control login-input"
                    id="area"
                  >
                    <option value="">活動エリアを選択してください</option>
                    <option
                      v-for="(area, key) in config.areas"
                      :key="key"
                      :value="key"
                    >
                      {{ area }}
                    </option>
                  </select>
                </label>
              </div>
              <div class="col-6 col-md-4 mb-2">
                <label for="" class="d-flex align-items-center">
                  <select
                    v-model="config.gender"
                    name="gender"
                    class="form-control login-input"
                    id="area"
                  >
                    <option value="">性別を選択してください</option>
                    <option
                      v-for="(gender, key) in config.genders"
                      :key="key"
                      :value="key"
                    >
                      {{ gender }}
                    </option>
                  </select>
                </label>
              </div>
              <div class="col-6 col-md-2 mb-2 d-flex align-items-center justify-content-start">
                <label for="is_picked" class="form-check-label d-flex align-items-center justify-content-start ml-4 mb-2">
                  <input type="checkbox" v-model="config.isEmergency" name="is_picked" id="is_picked" class="form-check-input" :value="config.isEmergency" />
                  <span>認定</span>
                </label>
              </div>
              <!-- <div class="col-12 col-md-6 mb-2">
                <input
                  type="text"
                  name="keyword"
                  class="form-control login-input list-page-search-input"
                  placeholder="キーワードを入力"
                  :value="config.keyword"
                />
              </div> -->
            </div>
            <button
              type="submit"
              class="btn btn-primary w-100 list-page-search-button"
              style="
                background: linear-gradient(90deg, #ef0505, #e38300);
                border-radius: 10px;
                border: none;
              "
            >
              検索
            </button>
          </form>
        </div>
      </div>
      <!-- <div
        class="list-page-content"
        ref="list_page_content"
        :style="{ width: suggestWidth + 'px' }"
      > -->
      <div class="list-page-content" ref="list_page_content">
        <list-breadcrumb :breadcrumbs="breadcrumbs"></list-breadcrumb>
        <h2 class="list-page-title">
          {{ title }}
        </h2>
        <div class="list-page-header">
          <h2 class="list-page-count">
            <span class="span-list-page-count">{{ config.total }}</span
            >件
          </h2>
          <div class="list-page-actions">
            <a
              href="javascript:void(0)"
              @click="changeOrder('new')"
              class="list-page-action-link"
              v-bind:class="{ selected: config.order == 'new' }"
              >新着順</a
            >
            <a
              href="javascript:void(0)"
              @click="changeOrder('view')"
              class="list-page-action-link"
              v-bind:class="{ selected: config.order == 'view' }"
              >人気順</a
            >
            <select
              name="pageMax"
              class="list-page-action-select"
              v-model="listCount"
              @change="changeCount()"
            >
              <option value="0">表示件数</option>
              <option value="25">25件</option>
              <option value="50">50件</option>
              <option value="100">100件</option>
            </select>
          </div>
          <div class="clearfix"></div>
        </div>
  
        <h2 class="sp-list-page-title">
          {{ title }}
  
          <select
            name="pageMax"
            class="sp-list-page-action-select"
            v-model="listCount"
            @change="changeCount()"
          >
            <option value="0">表示件数</option>
            <option value="25">25件</option>
            <option value="50">50件</option>
            <option value="100">100件</option>
          </select>
        </h2>
  
        <div class="sp-list-page-header">
          <div class="sp-list-page-count">{{ config.total }}件</div>
          <div class="sp-list-page-actions">
            <a
              href="javascript:void(0)"
              @click="changeOrder('new')"
              class="sp-list-page-action-link"
              v-bind:class="{ selected: config.order == 'new' }"
              >新着順</a
            >
            <a
              href="javascript:void(0)"
              @click="changeOrder('view')"
              class="sp-list-page-action-link"
              v-bind:class="{ selected: config.order == 'view' }"
              >人気順</a
            >
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="product-items-container">
            <user-item
              v-for="user in content"
              :user="user"
              :key="user.id"
            ></user-item>
        </div>
      </div>
  
      <form action="/user" id="listForm">
        <input
          type="hidden"
          name="category"
          id="listFormCategory"
          :value="config.category"
        />
        <input type="hidden" name="tag" id="listFormTag" :value="config.tag" />
        <input
          type="hidden"
          name="keyword"
          id="listFormKeyword"
          :value="config.keyword"
        />
        <input
          type="hidden"
          name="order"
          id="listFormOrder"
          :value="config.order"
        />
        <input
          type="hidden"
          name="count"
          id="listFormCount"
          :value="config.count"
        />
        <input
          type="hidden"
          name="seller"
          id="listFormSeller"
          :value="config.seller"
        />
        <input type="hidden" name="type" id="listFormType" :value="type" />
      </form>
    </div>
  </template>
  
  <script>
  export default {
    props: ["breadcrumbs", "title", "contents", "configs"],
    computed: {
      numbers() {
        let numbers = [];
        for (let i = 1000; i <= 3000; i += 100) {
          numbers.push(i);
        }
        return numbers;
      },
    },
    data() {
      return {
        config: JSON.parse(this.configs),
        content: JSON.parse(this.contents),
        suggestWidth: null,
        csrf: document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
        listCount: 0,
        // prefs: [],
        // cities: [],
        // address1: "",
      };
    },
    mounted() {
      this.handleResize();
  
      // this.prefs = Object.keys(this.config.prefs).map((key) => {
      //   return {
      //     id: key,
      //     name: this.config.prefs[key].name,
      //     city: this.config.prefs[key].city,
      //   };
      // });
    },
    methods: {
      // clickAddress1(e) {
      //   const prefName = e.target.value;
      //   this.cities = this.prefs.find((pref) => pref.id === prefName).city;
      // },
      handleResize() {
        let window_width = window.innerWidth;
  
        if (this.$refs.list_page_wrapper == undefined) return;
  
        if (window_width >= 768) {
          let wrapper_width = this.$refs.list_page_wrapper.clientWidth;
          let iWidth = 210;
          let suggestWidth = iWidth;
          for (var i = 1; i < 100; i++) {
            iWidth = 195 * i + 210;
            if (iWidth >= wrapper_width) break;
            suggestWidth = iWidth;
          }
          this.suggestWidth = suggestWidth;
        } else {
          let wrapper_width = this.$refs.list_page_wrapper.clientWidth;
          this.suggestWidth = wrapper_width;
        }
      },
      changeOrder(order) {
        $("#listFormOrder").val(order);
        $("#listForm").submit();
      },
      changeCount() {
        if (this.listCount > 0) {
          $("#listFormCount").val(this.listCount);
          $("#listForm").submit();
        }
      },
    },
    created() {
      window.addEventListener("resize", this.handleResize);
      this.handleResize();
      this.listCount = this.config.count;
    },
    destroyed() {
      window.removeEventListener("resize", this.handleResize);
    },
  };
  </script>
  
  <style scoped>
  .list-page-wrapper {
    width: 100%;
  }
  
  .list-page-content {
    margin-left: auto;
    margin-right: auto;
    overflow: hidden;
  }
  
  .list-page-content {
    padding-left: 15px;
    padding-right: 0;
    padding: 1.5rem;
    margin: 10px 3%;
  }
  
  @media (max-width: 768px) {
    .list-page-title {
      display: none;
    }
  
    .list-page-header {
      display: none;
    }
  
    .list-page-content {
      padding-left: 8px;
      padding-right: 8px;
    }
  }
  
  .list-page-title {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 60px;
  }
  
  .list-page-header {
    margin-bottom: 25px;
    overflow: hidden;
  }
  
  .list-page-count {
    font-size: 16px;
    float: left;
  }
  
  .span-list-page-count {
    font-size: 22px;
  }
  
  .list-page-actions {
    float: right;
    font-size: 17px;
  }
  
  .list-page-actions .list-page-action-link {
    margin-right: 20px;
  }
  
  .list-page-actions .list-page-action-link,
  .list-page-actions .list-page-action-link:visited {
    color: #000;
    text-decoration: none;
  }
  
  .list-page-actions .list-page-action-link:hover {
    color: #000;
    text-decoration: underline;
  }
  
  .list-page-actions .list-page-action-link.selected {
    text-decoration: underline;
  }
  
  .list-page-action-select {
    padding-right: 12px;
    outline: none;
    border: none;
    margin-right: 20px;
    cursor: pointer;
  }
  
  .sp-list-page-title {
    display: none;
  }
  
  .sp-list-page-action-select {
    display: none;
  }
  
  .sp-list-page-header {
    display: none;
  }
  
  @media (max-width: 768px) {
    .sp-list-page-title {
      display: block;
      margin-top: 30px;
      margin-bottom: 45px;
      font-size: 22px;
    }
  
    .sp-list-page-action-select {
      display: block;
      padding-right: 12px;
      outline: none;
      border: none;
      margin-right: 10px;
      float: right;
      font-size: 15px;
    }
  
    .sp-list-page-header {
      display: block;
      margin-bottom: 20px;
    }
  
    .sp-list-page-count {
      font-size: 15px;
      float: left;
    }
  
    .sp-list-page-actions {
      float: right;
      font-size: 15px;
    }
  
    .sp-list-page-actions .sp-list-page-action-link {
      margin-right: 10px;
    }
  
    .sp-list-page-actions .sp-list-page-action-link,
    .sp-list-page-actions .sp-list-page-action-link:visited {
      color: #000;
      text-decoration: none;
    }
  
    .sp-list-page-actions .sp-list-page-action-link:hover {
      color: #000;
      text-decoration: underline;
    }
  
    .sp-list-page-actions .sp-list-page-action-link.selected {
      text-decoration: underline;
    }
  }
  </style>