<template>
  <div>
    <VueSlickCarousel v-bind="setting" v-if="image_flag && content.length > 0">
      <div v-for="item in content" v-html="item"></div>
      <template v-if="custom_arrow" #prevArrow="arrowOption">
        <div
          v-bind:class="{
            'custom-arrow': custom_arrow,
            'custom-arrow2': user_flag,
          }"
        ></div>
      </template>
      <template v-if="custom_arrow" #nextArrow="arrowOption">
        <div
          v-bind:class="{
            'custom-arrow': custom_arrow,
            'custom-arrow2': user_flag,
          }"
        ></div>
      </template>
    </VueSlickCarousel>
    <VueSlickCarousel
      v-bind="setting"
      v-if="product_flag && content.length > 0"
      class="pc-slider-list"
    >
      <div v-for="item in content">
        <product-item :item="item"></product-item>
      </div>

      <template v-if="custom_arrow" #prevArrow="arrowOption">
        <div
          v-bind:class="{
            'custom-arrow': custom_arrow,
            'custom-arrow2': user_flag,
          }"
        ></div>
      </template>
      <template v-if="custom_arrow" #nextArrow="arrowOption">
        <div
          v-bind:class="{
            'custom-arrow': custom_arrow,
            'custom-arrow2': user_flag,
          }"
        ></div>
      </template>
    </VueSlickCarousel>
    <VueSlickCarousel
      v-bind="setting"
      v-if="user_flag && content.length > 0"
      class="pc-slider-list"
    >
      <div v-if="user_flag" v-for="item in content">
        <user-item :item="item"></user-item>
      </div>

      <template v-if="custom_arrow" #prevArrow="arrowOption">
        <div
          v-bind:class="{
            'custom-arrow': custom_arrow,
            'custom-arrow2': user_flag,
          }"
        ></div>
      </template>
      <template v-if="custom_arrow" #nextArrow="arrowOption">
        <div
          v-bind:class="{
            'custom-arrow': custom_arrow,
            'custom-arrow2': user_flag,
          }"
        ></div>
      </template>
    </VueSlickCarousel>

    <div v-if="product_flag" class="sp-slider-list">
      <div class="product-items-container">
        <product-item
          v-for="item in content"
          :item="item"
          :key="item.id"
        ></product-item>
      </div>
    </div>
    <div class="user-items-container">
      <div v-if="user_flag" class="sp-slider-list">
        <user-item
          v-for="item in content"
          :item="item"
          :key="item.id"
        ></user-item>
      </div>
    </div>
  </div>
</template>
<script>
import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css";
// optional style for arrows & dots
import "vue-slick-carousel/dist/vue-slick-carousel-theme.css";

export default {
  props: ["settings", "contents", "type"],
  components: { VueSlickCarousel },
  data() {
    return {
      content: JSON.parse(this.contents),
      setting: JSON.parse(this.settings),
      custom_arrow:
        this.type == "product_slider" || this.type == "user_slider"
          ? true
          : false,
      image_flag: this.type == "top_slider" ? true : false,
      product_flag: this.type == "product_slider" ? true : false,
      user_flag: this.type == "user_slider" ? true : false,
    };
  },
};
</script>

<style>
.slick-prev:before,
.slick-next:before {
  color: black;
}

.top-slider-img {
  height: 300px;
}

@media (max-width: 768px) {
  .top-slider-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }
}

.slick-slide a {
  display: flex;
}

.slick-slide a img {
  margin: auto;
}

.slick-slide .top-slider-img {
  opacity: 50%;
}

.slick-slide.slick-active .top-slider-img {
  opacity: 100%;
}

.slick-dots {
  bottom: -40px;
}

.slick-dots li button:before {
  font-size: 14px;
}

.slider-item .custom-arrow {
  display: block;
  width: 46px;
  /* height: 300px; */
  height: 100%;
  background-color: #cfcfcf;
  opacity: 5%;
  top: 0;
  transform: translate(0, 0);
  z-index: 2;
  background-repeat: no-repeat;
  background-size: 18px;
  /* background-position: center 72px; */
  background-position: center 45%;
}

.slider-item .custom-arrow:hover {
  opacity: 70%;
}

.slider-item .custom-arrow.slick-prev {
  left: 0;
  background-image: url(/images/icons/slider-prev.svg);
}

.slider-item .custom-arrow.slick-next {
  right: 0;
  background-image: url(/images/icons/slider-next.svg);
}

.slider-item .custom-arrow.slick-prev:before,
.slider-item .custom-arrow.slick-next:before {
  content: none;
}

.slider-item .custom-arrow2 {
  height: 240px;
  background-size: 18px;
  background-position: center 64px;
}

.pc-slider-list {
  display: block;
}

.sp-slider-list {
  display: none;
}

@media (max-width: 768px) {
  .pc-slider-list {
    display: none !important;
  }

  .sp-slider-list {
    display: block;
  }
}

.slick-list {
  height: auto !important;
}
</style>