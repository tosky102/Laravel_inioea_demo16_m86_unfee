<template>
  <div id="detail-wrapper">
    <div id="detail-container">
      <div class="container-lg">
        <list-breadcrumb :breadcrumbs="breadcrumbs"></list-breadcrumb>

        <h2 class="detail-page-title">{{ p_item.title }}</h2>

        <div class="row justify-content-center">
          <div class="col-md-8">
            <form action="/item/password" method="post">
              <p class="text-center">
                <input type="hidden" name="_token" :value="csrf" />
                <input type="hidden" name="id" :value="p_item.id" />
                <input type="text" name="password" class="form-control" />
                <input
                  type="submit"
                  class="btn btn-primary mt-4"
                  value="パスワードを認証する"
                />
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="detail-relation-container">
      <div class="container-relation" ref="list_page_wrapper">
        <div
          class="container-inner-relation"
          :style="{ width: suggestWidth + 'px' }"
        >
          <div class="detail-section-item">
            <h2>
              よく見られている求人
              <span class="detail-section-item-link"
                ><a :href="p_item.productUrl1">もっと見る</a></span
              >
            </h2>

            <div class="product-items-container">
              <product-item
                v-for="(r_product, index) in r_products"
                :item="r_product"
                :key="index"
              ></product-item>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="detail-relation-container even">
      <div class="container-relation">
        <div
          class="container-inner-relation"
          :style="{ width: suggestWidth + 'px' }"
        >
          <div class="detail-section-item">
            <h2>
              この店舗の人気求人
              <span class="detail-section-item-link"
                ><a :href="p_item.productUrl2">もっと見る</a></span
              >
            </h2>

            <div class="product-items-container">
              <product-item
                v-for="(s_product, index) in s_products"
                :item="s_product"
                :key="index"
              ></product-item>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="detail-relation-container">
      <div class="container-relation">
        <div
          class="container-inner-relation"
          :style="{ width: suggestWidth + 'px' }"
        >
          <div class="detail-section-item">
            <h2>
              最近閲覧した求人
              <span class="detail-section-item-link"
                ><a :href="p_item.productUrl3">もっと見る</a></span
              >
            </h2>
            <div class="product-items-container">
              <product-item
                v-for="(l_product, index) in l_products"
                :item="l_product"
                :key="index"
              ></product-item>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

    <vue-image-lightbox-carousel
      ref="lightbox"
      :show="showLightbox"
      @close="showLightbox = false"
      :images="images"
      :showCaption="false"
    >
    </vue-image-lightbox-carousel>

    <to-top></to-top>
  </div>
</template>

<script>
import StarRating from "vue-star-rating";
import VueImageLightboxCarousel from "vue-image-lightbox-carousel";

export default {
  props: [
    "breadcrumbs",
    "product",
    "relationproducts",
    "sellerproducts",
    "lastbrowseproducts",
  ],
  components: {
    StarRating,
    VueImageLightboxCarousel,
  },
  data() {
    return {
      suggestWidth: null,
      detailMainImageHeight: null,
      detailSubImageWidth: null,
      detailSubImageHeight: null,
      p_item: JSON.parse(this.product),
      r_products: JSON.parse(this.relationproducts),
      s_products: JSON.parse(this.sellerproducts),
      l_products: JSON.parse(this.lastbrowseproducts),
      detailSellerDescriptionMin: false,
      havingSellerDescriptionMin: false,
      commentRating: 0,
      itemsDisplay: 0,
      commentText: "",
      windowWidth: 0,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      showLightbox: false,
      images: [],
    };
  },
  mounted() {
    this.handleResize();
    this.handleImages();
  },
  methods: {
    openShowLightBox() {
      this.showLightbox = true;
    },
    goto(refName) {
      var element = this.$refs[refName];
      var top = element.offsetTop;

      window.scrollTo({ top: top, behavior: "smooth" });
    },
    selectSubImage(subImage) {
      if (subImage) {
        this.p_item.mainImage = subImage;
      }
    },
    openSellerDescription() {
      this.detailSellerDescriptionMin = false;
    },
    closeSellerDescription() {
      this.detailSellerDescriptionMin = true;
    },
    handleImages() {
      // this.images.push({path: this.p_item.mainImage});
      for (var i in this.p_item.subImages) {
        var subImage = this.p_item.subImages[i];
        this.images.push({ path: subImage });
      }
    },
    handleResize() {
      let detailMainImageWidth = $(".detail-main-image").width();
      if (detailMainImageWidth) {
        this.detailMainImageHeight = (detailMainImageWidth / 3) * 2;
        this.detailSubImageWidth = (detailMainImageWidth - 32) / 5;
        this.detailSubImageHeight = (this.detailSubImageWidth / 3) * 2;
      }

      if (
        this.$refs.detail_seller_desc &&
        window.innerWidth != this.windowWidth
      ) {
        this.windowWidth = window.innerWidth;
        this.openSellerDescription();
        let detail_seller_desc_height =
          this.$refs.detail_seller_desc.clientHeight;
        if (detail_seller_desc_height > 37) {
          this.detailSellerDescriptionMin = true;
          this.havingSellerDescriptionMin = true;
        } else {
          this.detailSellerDescriptionMin = false;
          this.havingSellerDescriptionMin = false;
        }
      }

      let window_width = window.innerWidth;
      if (this.$refs.list_page_wrapper) {
        if (window_width >= 768) {
          let wrapper_width = this.$refs.list_page_wrapper.clientWidth;

          let iWidth = 210;
          let suggestWidth = iWidth;
          for (var i = 1; i < 100; i++) {
            iWidth = 195 * i + 210;
            if (iWidth > wrapper_width) break;
            suggestWidth = iWidth;
          }
          this.suggestWidth = suggestWidth;
          this.itemsDisplay = i;
        } else {
          let wrapper_width = this.$refs.list_page_wrapper.clientWidth;
          this.suggestWidth = wrapper_width;
          this.itemsDisplay = 2;
        }
      }
    },
    cartItem() {
      if (this.p_item.user_id == this.p_item.sellerId) {
        alert("自分の求人は購入できません");
      } else {
        if (this.p_item.status == 0) {
          alert("一時停止された求人です。販売者にお問い合わせください");
        } else {
          location.href = this.p_item.cartUrl;
        }
      }
    },
    favoriteItem() {
      let data = {};
      data.user_id = this.p_item.user_id;
      data.item_id = this.p_item.id;
      axios.post("/item/favorite", data).then((response) => {
        let status = response.data.status;
        if (status == 0) {
          alert("お気に入りに登録しました。");
        } else if (status == -1 || status == -2) {
          alert("お気に入りに登録失敗しました。");
        } else if (status == -3) {
          alert("既にお気に入りに登録済みです。");
        } else if (status == -4) {
          alert("自分の求人をお気に入りに登録できません。");
        }
      });
    },
    followUser() {
      let data = {};
      data.user_id = this.p_item.user_id;
      data.follow_user_id = this.p_item.sellerId;
      axios.post("/item/follow", data).then((response) => {
        let status = response.data.status;
        if (status == 0) {
          alert("フォローしました。");
        } else if (status == -1) {
          alert("自分をフォローできません。");
        } else if (status == -2) {
          alert("フォローするためにはログインが必要です。");
        } else if (status == -3) {
          alert("既にフォローしています。");
        }
      });
    },
    twitterOpen() {
      window.open(this.p_item.twitterUrl, this.p_item.twitterSetting, 0);
    },
    sendNewMessage() {
      if (this.p_item.user_id == this.p_item.sellerId) {
        alert("自分にはメッセージを送信できません。");
      } else {
        location.href = this.p_item.newMessageUrl;
      }
    },
    concernMessage() {
      if (this.p_item.user_id == this.p_item.sellerId) {
        alert("自分にはメッセージを送信できません。");
      } else {
        location.href = this.p_item.concernUrl;
      }
    },
    review() {
      if (this.p_item.user_id == 0) {
        alert("レビューするためにはログインが必要です。");
      } else {
        if (this.commentRating == 0) {
          alert("評価を選択してください");
          return;
        }
        if (this.commentText == "") {
          alert("コメントを入力してください");
          return;
        }

        $("#reviewForm").submit();
      }
    },
  },
  created() {
    window.addEventListener("resize", this.handleResize);
    this.handleResize();
  },
  destroyed() {
    window.removeEventListener("resize", this.handleResize);
  },
};
</script>

<style>
#detail-container {
  padding-top: 60px;
  padding-bottom: 40px;
}

@media (max-width: 768px) {
  #detail-container {
    padding-top: 20px;
  }
}

.detail-page-title {
  font-size: 27px;
  margin-bottom: 30px;
}

@media (max-width: 768px) {
  .detail-page-title {
    font-size: 22px;
    margin-bottom: 30px;
  }
}

.detail-main-image {
  width: 100%;
  /* background-color: #e6e6e6; */
  position: relative;
  margin-bottom: 16px;
}

.detail-main-image img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  max-width: 100%;
  max-height: 100%;
  height: auto;
  cursor: zoom-in;
}

.detail-sub-images-container {
  margin: 20px 10% 0;
}

.detail-sub-image {
  float: left;
  margin-right: 8px;
  position: relative;
  /* background-color: #e6e6e6; */
  margin-bottom: 8px;
}

.detail-sub-image img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  max-width: 100%;
  height: auto;
  max-height: 100%;
}

.detail-sub-image img:hover {
  cursor: pointer;
}

.detail-content {
  margin-top: 6px;
  margin-bottom: 100px;
}

@media (max-width: 768px) {
  .detail-content {
    margin-bottom: 20px;
  }
}

.detail-content-sub-container {
  margin-bottom: 20px;
}
.detail-content-span {
  font-size: 12px;
  padding: 4px 12px;
  background-color: #f5f5f5;
  border: 1px solid #b3b3b3;
  border-radius: 16px;
  color: #333333;
}

.detail-content-text {
  font-size: 15px;
  margin-top: 10px;
  color: #666666;
}

.detail-content-link {
  font-size: 15px;
  color: #666666;
  text-decoration: underline;
}

.detail-content-link:hover {
  text-decoration: none;
  color: #666666;
}

.detail-content-link:visited {
  color: #666666;
}

.detail-content-category {
  margin-top: 10px;
}

.detail-content-category .detail-content-link + .detail-content-link {
  margin-left: 16px;
}

.detail-content-review .detail-content-link {
  font-size: 13px;
}

.detail-rating-container {
  float: left;
  margin-top: -2px;
}

.detail-price {
  margin-bottom: 16px;
}

.detail-price p {
  font-size: 30px;
}

.detail-price span {
  font-size: 17px;
  margin-left: 3px;
}

.detail-cart-button {
  width: 100%;
  height: 54px;
  color: #ffffff;
  background-color: #f08c1e;
  border-radius: 3px;
  font-size: 18px;
  display: block;
  padding: 12px;
  text-align: center;
  margin-bottom: 20px;
  text-decoration: none;
}

.detail-cart-button:hover,
.detail-cart-button:visited {
  color: #ffffff;
  text-decoration: none;
  opacity: 0.5;
}

.detail-cart-button i {
  background-image: url(/images/icons/cart.svg);
  width: 24px;
  height: 24px;
  display: inline-block;
  background-repeat: no-repeat;
  background-position: center center;
  margin-right: 8px;
  overflow: hidden;
  vertical-align: sub;
}

.detail-actions {
  margin-bottom: 30px;
}

.detail-actions-link {
  background-color: #fcfcfc;
  border: 1px solid #b3b3b3;
  border-radius: 30px;

  display: inline-block;
  font-size: 13px;
  height: 54px;
  width: 127px;
  padding-left: 36px;
}

.detail-actions-link,
.detail-actions-link:visited {
  color: #333333;
  text-decoration: none;
}

.detail-actions-link:hover {
  color: #333333;
  text-decoration: none;
  opacity: 0.5;
}

.detail-action-span-favorite {
  display: inline-block;
  line-height: 15px;
  padding-top: 12px;
}

.detail-action-span-point {
  display: inline-block;
  line-height: 18px;
  padding-top: 18px;
}

.detail-action-link-favorite {
  background-image: url("/images/icons/list2.svg");
  background-size: 18px 18px;
  background-repeat: no-repeat;
  background-position: 13px 18px;
}

@media (max-width: 1200px) {
  .detail-action-link-favorite {
    float: right;
  }
}

.detail-action-link-point {
  background-image: url("/images/icons/point2.svg");
  background-size: 18px 18px;
  background-repeat: no-repeat;
  background-position: 12px 18px;
  /*margin-left: 12px;*/
}

.detail-seller-links {
  margin-bottom: 22px;
}

.detail-seller-link {
  font-size: 14px;
  margin-right: 28px;
  text-decoration: underline;
}

@media (max-width: 1200px) {
  .detail-seller-links {
    font-size: 12px;
  }
  .detail-seller-link {
    font-size: 12px;
    margin-right: 18px;
  }
}

.detail-seller-link,
.detail-seller-link:hover,
.detail-seller-link:visited {
  color: #666666;
}

.detail-seller-link:hover {
  text-decoration: none;
}

.detail-seller-sns-link img {
  width: 22px;
  height: 22px;
}

.detail-seller-block {
  background-color: #f5f5f5;
  border-radius: 3px;
  padding: 20px 27px;
  margin-bottom: 12px;
}

.detail-seller-block-title {
  font-size: 13px;
  margin-bottom: 10px;
}

.detail-seller-block-image-container {
  text-align: center;
}
.detail-seller-block-image-container img {
  /*width: 100%;*/
  border-radius: 50%;
  /*min-width: 64px;*/
  width: 64px;
  height: 64px;
  object-fit: cover;
}

.detail-seller-block-content-title {
  font-size: 18px;
  margin-bottom: 12px;
  overflow: hidden;
  display: block;
  -webkit-line-clamp: 1;
  word-break: break-word;
  text-overflow: ellipsis;
  display: -webkit-box;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-box-orient: vertical;
}

.detail-seller-block-content-title a {
  color: black;
}

.detail-seller-block-content-level {
  font-size: 12px;
  margin-bottom: 8px;
}

.detail-seller-block-link {
  font-size: 13px;
  color: #666666;
  text-decoration: underline;
}

.detail-seller-block-link:hover {
  text-decoration: none;
  color: #666666;
}

.detail-seller-block-link:visited {
  color: #666666;
}

.detail-seller-follower-button {
  margin-top: 12px;
  font-size: 13px;
  color: #333333;
  line-height: 17px;
  padding-top: 11px;
  padding-bottom: 11px;
  background-color: #ffffff;
  border: 1px solid #b3b3b3;
  border-radius: 30px;
  width: 100%;
  display: inline-block;
  text-align: center;
  min-width: 140px;
  text-decoration: none;
}

.detail-seller-follower-button:hover {
  color: #333333;
  text-decoration: none;
  opacity: 0.5;
}

.detail-seller-follower-button:visited {
  color: #333333;
}

.detail-seller-follower-button i {
  background-image: url("/images/icons/user.svg");
  width: 15px;
  height: 15px;
  display: inline-block;
  vertical-align: sub;
  background-repeat: no-repeat;
}

.detail-seller-product-link {
  text-align: right;
  font-size: 15px;
  margin-bottom: 30px;
}

.detail-seller-product-link a {
  color: #333333;
  text-decoration: underline;
}

.detail-seller-product-link a:hover,
.detail-seller-product-link a:visited {
  color: #333333;
}

.detail-seller-product-link a:hover {
  text-decoration: none;
}

.detail-seller-desc {
  color: #333333;
  font-size: 13px;
  padding: 0 6px;
  line-height: 18px;
  margin-bottom: 16px;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  /*white-space: pre;*/
}

.detail-seller-minimize-desc {
  height: 36px;
  -webkit-line-clamp: 2;
}

.detail-seller-desc-more-link {
  text-align: right;
  position: relative;
  padding-right: 18px;
}

.detail-seller-desc-more-link a,
.detail-seller-desc-more-link a:hover,
.detail-seller-desc-more-link a:visited {
  color: #333333;
  text-decoration: none;
}
.more-link-icon {
  display: block;
  position: absolute;
  top: 8px;
  right: 0;
  bottom: 0;
  width: 8px;
  height: 8px;
  border-right: 2px solid #363636;
  border-bottom: 2px solid #363636;
  transform: translateY(-2px) rotate(45deg);
  transition: transform 0.2s ease;
}

.less-link-icon {
  display: block;
  position: absolute;
  top: 11px;
  right: 0;
  bottom: 0;
  width: 8px;
  height: 8px;
  border-right: 2px solid #363636;
  border-bottom: 2px solid #363636;
  transform: translateY(-2px) rotate(-135deg);
  transition: transform 0.2s ease;
}

.detail-seller-desc-container {
  margin-bottom: 30px;
}

.detail-seller-review-container {
  color: #333333;
}

.detail-seller-review-title {
  font-size: 16px;
  margin-bottom: 16px;
}

.detail-seller-review-rating {
  margin-bottom: 12px;
}
.detail-seller-review-rating label {
  font-size: 13px;
  margin-left: 12px;
}

.detail-seller-review-comment-title {
  font-size: 13px;
  margin-bottom: 12px;
}

.detail-seller-review-comment-button {
  text-align: right;
  padding-right: 16px;
  margin-top: 15px;
}

.detail-seller-review-comment-button input[type="submit"] {
  border-radius: 3px;
  font-size: 16px;
  line-height: 20px;
  padding: 9px;
  background-color: #f9f9f9;
  border: 1px solid #b3b3b3;
  color: #333333;
}

.detail-relation-container {
  padding: 50px 0;
  background: transparent;
}

.detail-relation-container.even {
  background-color: #f7f7f7;
}

.detail-section-item {
  padding-left: 15px;
}

.detail-section-item h2 {
  font-size: 16px;
  margin-bottom: 12px;
  overflow: hidden;
}

@media (max-width: 768px) {
  .detail-section-item {
    margin-bottom: 40px;
    overflow: hidden;
    padding-bottom: 5px;
    border-bottom: 1px solid #b3b3b3;
    padding-left: 8px;
    padding-right: 8px;
  }

  .detail-section-item:last-child {
    border-bottom: none;
  }
}

.detail-section-item h2 span.detail-section-item-link {
  float: right;
  font-size: 16px;
  margin-top: 8px;
  margin-right: 30px;
}

.detail-section-item h2 span.detail-section-item-link a {
  color: #000;
  text-decoration: underline;
}

.detail-section-item h2 span.detail-section-item-link a:hover,
.detail-section-item h2 span.detail-section-item-link a:visited {
  color: #000;
}

.detail-section-item h2 span.detail-section-item-link a:hover {
  text-decoration: none;
}

@media (max-width: 768px) {
  .detail-section-item h2 span.detail-section-item-link {
    margin-right: 18px;
    margin-top: 5px;
    font-size: 13px;
  }

  .detail-section-item h2 span.detail-section-item-link a {
    text-decoration: none;
  }

  .detail-section-item h2 span.detail-section-item-link a:after {
    content: ">";
    margin-left: 8px;
    font-size: 13px;
  }
}

.container-relation {
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  overflow: hidden;
}

@media (min-width: 1400px) {
  .container-relation {
    max-width: 1380px;
  }
}

.container-inner-relation {
  margin-left: auto;
  margin-right: auto;
}

#detail-wrapper {
  padding-bottom: 250px;
  position: relative;
}

@media (max-width: 768px) {
  #detail-wrapper {
    padding-bottom: 100px;
  }
}
.detail-col-image {
  /* width: 583px; */
  width: 100%;
}

.detail-col-content {
  /* width: 543px; */
  padding-left: 30px;
}

@media (max-width: 1200px) {
  .detail-col-image {
    width: 497px;
  }

  .detail-col-content {
    width: 462px;
    padding-left: 20px;
  }
}

@media (max-width: 992px) {
  .detail-col-image {
    width: 55%;
    padding-left: 15px;
    padding-right: 15px;
  }

  .detail-col-content {
    width: 45%;
    padding-left: 15px;
    padding-right: 15px;
  }
}

@media (max-width: 768px) {
  .detail-col-image {
    width: 100%;
    padding-left: 15px;
    padding-right: 15px;
  }

  .detail-col-content {
    width: 100%;
    padding-left: 15px;
    padding-right: 15px;
  }
}
</style>