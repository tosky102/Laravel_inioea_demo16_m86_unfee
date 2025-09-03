<template>
  <div id="detail-wrapper" v-if="p_item">
    <div id="detail-container">
      <div class="container-lg" style="margin: auto">
        <list-breadcrumb :breadcrumbs="breadcrumbs"></list-breadcrumb>

        <h2 class="detail-page-title">案件情報</h2>

        <div class="row detail-page-container" style="margin: 0">
          <div class="card login-card col-md-12" style="margin: 0; padding-bottom: 3%;">
            <span class="emergency-badge" v-if="p_item.is_emergency">急募</span>

            <h2 style="text-align: center; margin: 50px 5% 30px;">
              {{ p_item.title }}
            </h2>

            <div class="detail-col-image">
              <div
                class="detail-main-image"
                :style="{ height: detailMainImageHeight + 'px' }"
              >
                <img
                  :src="p_item.mainImage"
                  @click="openShowLightBox"
                />
              </div>
              <div class="detail-sub-images-container">
                <div class="detail-sub-image" v-for="subImage in p_item.subImages" :style="{
                    width: detailSubImageWidth + 'px',
                    height: detailSubImageHeight + 'px',
                  }"
                  @click="selectSubImage(subImage)"
                  style="min-width: 100px; min-height: 100px"
                >
                  <img :src="subImage" v-if="subImage" />
                </div>
              </div>
            </div>

            <div v-if="p_item.user_id === p_item.sellerId || p_item.public_flag === 1">
              <div class="detail-action-container">
                <a
                  v-if="p_item.user_id !== p_item.sellerId && p_item.newOrderUrl"
                  class="btn w-100 mx-2"
                  :class="p_item.is_entried ? 'btn-disabled' : 'btn-pill btn-call btn-danger'"
                  @click="entry()"
                  >応募する</a>
                <a
                  v-if="p_item.user_id == p_item.sellerId && p_item.editItemUrl"
                  class="btn btn-call btn-pill w-100 btn-danger mx-2"
                  :href="p_item.editItemUrl"
                  style="background: linear-gradient(90deg, #ef0505, #e38300)"
                  >編集する</a>
                <a
                  class="btn btn-detail btn-pill w-100 mx-2"
                  v-if="!p_item.favorited"
                  @click="favoriteItem()"
                >
                  お気に入りする
                </a>
                <a
                  class="btn btn-detail btn-pill w-100 mx-2"
                  v-else
                  @click="favoriteItem()"
                >
                  お気に入り解除
                </a>
              </div>
              <div v-if="p_user.role === 'influencer'" class="detail-action-container">
                <button
                  @click="sendNewMessage()"
                  class="btn btn-message btn-pill w-100 mx-2"
                  >メッセージを送る
                </button>
              </div>
            </div>
          </div>

          <div class="detail-col-content">
            <div class="detail-container">
              <div class="detail-content" style="padding-top: 10px;">
                <div class="detail-content-sub-container">
                  <div v-if="p_item.youtube" style="margin: 5% 0">
                    <h2 style="margin: 5% 0">案件情報</h2>
                    <div
                      class="row card login-card"
                      style="margin: 1px; padding: 50px 10%"
                    >
                      <div class="video-container">
                        <iframe
                          :src="'https://www.youtube.com/embed/' + youtubeVideoId"
                          frameborder="0"
                          allow="autoplay; encrypted-media"
                          allowfullscreen
                        ></iframe>
                      </div>
                    </div>
                  </div>

                  <h2 class="detail-page-title">案件情報</h2>
                  <div
                    class="row card login-card"
                    style="margin: 1rem 0; padding: 50px 10%; display: block;"
                  >
                    <div class="detail-item">
                      <div class="detail-item-label">案件タイトル</div>
                      <div class="detail-item-value">
                        {{ p_item.title }}
                      </div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">お仕事ジャンル</div>
                      <div class="detail-item-value">{{ p_item.genre }}</div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">本来の提供価格</div>
                      <div class="detail-item-value">
                        {{ p_item.price }}
                      </div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">同伴者への提供</div>
                      <div class="detail-item-value">
                        {{ p_item.is_offering }}
                      </div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">提供商品の詳細</div>
                      <div class="detail-item-value" style="white-space: pre-wrap" v-html="p_item.description">
                      </div>
                    </div>

                    <div class="detail-item" v-if="p_item.website">
                      <div class="detail-item-label">参考URL</div>
                      <div class="detail-item-value" style="white-space: pre-wrap"><a v-bind:href="p_item.website" target="_blank" style="display: block; word-break: break-all; white-space: pre-wrap; ">{{ p_item.website }}</a></div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">エリア / 最寄駅</div>
                      <div class="detail-item-value" style="overflow-wrap: anywhere">
                        {{ p_item.station }}
                      </div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">住所</div>
                      <div class="detail-item-value" style="overflow-wrap: anywhere" v-html="p_item.address">
                      </div>
                    </div>
                  </div>

                  <h2 class="detail-page-title">希望PR投稿</h2>
                  <div
                    class="row card login-card"
                    style="margin: 1rem 0; padding: 50px 10%; display: block;"
                  >
                    <div class="detail-item">
                      <div class="detail-item-label">Instagram/TikTok/Facebook/X/そのほか</div>
                      <div class="detail-item-value">
                        {{ p_item.post_sns }}
                      </div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">投稿形式</div>
                      <div class="detail-item-value">
                        {{ p_item.post_type }}
                      </div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">ハッシュタグ</div>
                      <div class="detail-item-value">
                        {{ p_item.hash_tag }}
                      </div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">PR投稿に載せる指定アカウント</div>
                      <div class="detail-item-value">
                        {{ p_item.pr_account }}
                      </div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">PR投稿の流れ</div>
                      <div class="detail-item-value" v-html="p_item.pr_flow"></div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">PR投稿ルール</div>
                      <div class="detail-item-value" style="white-space: pre-wrap" v-html="p_item.pr_rule"></div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">使用条件</div>
                      <div class="detail-item-value" style="white-space: pre-wrap" v-html="p_item.condition"></div>
                    </div>
                  </div>

                  <h2 class="detail-page-title">応募条件</h2>
                  <div
                    class="row card login-card"
                    style="margin: 1rem 0; padding: 50px 10%; display: block;"
                  >
                    <div class="detail-item">
                      <div class="detail-item-label">SNS名</div>
                      <div class="detail-item-value">{{ p_item.entry_sns }}</div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">フォロワー数</div>
                      <div class="detail-item-value">{{ p_item.entry_follower }}</div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">性別</div>
                      <div class="detail-item-value">{{p_item.gender}}</div>
                    </div>

                    <div class="detail-item">
                      <div class="detail-item-label">応募方法</div>
                      <div class="detail-item-value" style="white-space: pre-wrap">
                        <span style="white-space: pre-wrap" v-html="p_item.entry_method"></span>
                      </div>
                    </div>
                  </div>

                  <div
                    class="row card login-card"
                    style="margin: 3rem 0 1rem; padding: 50px 10%; display: block;"
                  >
                    <div class="company-container">
                      <div class="company-icon">
                        <img :src="p_item.user.image_url" :alt="p_item.user.name">
                      </div>

                      <div class="company-info">
                        <a :href="p_item.partnerUrl">
                          <h3>{{ p_item.user.name }}</h3>
                        </a>
                        <div class="company-category">
                          <span>{{ p_item.user.main_category_label }}</span>
                          <span>｜</span>
                          <span>{{ p_item.user.pref_label }}</span>
                          <span>{{ p_item.user.city }}</span>
                        </div>
                        <div style="white-space: pre-wrap" v-html="p_item.user.comment"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div v-if="p_item.user_id === p_item.sellerId || p_item.public_flag === 1" style="padding: 20px 35px; border-radius: 0px;">
                  <div>
                    <div class="detail-action-container">
                      <a
                        v-if="p_item.user_id !== p_item.sellerId && p_item.newOrderUrl"
                        class="btn btn-call btn-pill w-100 btn-danger mx-2"
                        @click="entry()"
                        style="background: linear-gradient(90deg, #ef0505, #e38300)"
                        >応募する</a>
                      <a
                        class="btn btn-detail btn-pill w-100 mx-2"
                        v-if="!p_item.favorited"
                        @click="favoriteItem()"
                      >
                        お気に入りする
                      </a>
                      <a
                        class="btn btn-detail btn-pill w-100 mx-2"
                        v-else
                        @click="favoriteItem()"
                      >
                        お気に入り解除
                      </a>
                    </div>
                    <div v-if="p_user.role === 'influencer'" class="detail-action-container">
                      <a
                        @click="sendNewMessage()"
                        class="btn btn-message btn-pill w-100 mx-2"
                        >メッセージを送る</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
              おすすめ案件
              <!-- <span class="detail-section-item-link"
                ><a :href="p_item.productUrl1">もっと見る</a></span
              > -->
            </h2>

            <div class="product-items-container mt-4">
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

    <form :action="`/mypage/item/${p_item.id}/entry`" method="post" id="entry-form">
      <input type="hidden" name="_token" :value="csrf">
    </form>

    <!-- <div class="detail-relation-container even">
      <div class="container-relation">
        <div
          class="container-inner-relation"
          :style="{ width: suggestWidth + 'px' }"
        >
          <div class="detail-section-item">
            <h2>
              この企業の人気案件
              <span class="detail-section-item-link"
                ><a :href="p_item.productUrl2">もっと見る</a></span
              >
            </h2>

            <div class="product-items-container mt-4">
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
              最近閲覧した案件
              <span class="detail-section-item-link"
                ><a :href="p_item.productUrl3">もっと見る</a></span
              >
            </h2>
            <div class="product-items-container mt-4">
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
    </div> -->

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
    "user",
    "product",
    "relationproducts",
    // "sellerproducts",
    // "lastbrowseproducts",
  ],
  components: {
    StarRating,
    VueImageLightboxCarousel,
  },
  computed: {
    youtubeVideoId() {
      if (this.p_item.youtube) {
        const urlParts = this.p_item.youtube.split('v=');
        if (urlParts.length > 1) {
          const videoIdParts = urlParts[1].split('&');
          if (videoIdParts.length > 0) {
            return videoIdParts[0];
          }
        }
      }
      return null; // Return null or a default value if the video ID cannot be extracted
    }
  },
  data() {
    return {
      suggestWidth: null,
      detailMainImageHeight: null,
      detailSubImageWidth: null,
      detailSubImageHeight: null,
      p_user: JSON.parse(this.user),
      p_item: JSON.parse(this.product),
      r_products: JSON.parse(this.relationproducts),
      // s_products: JSON.parse(this.sellerproducts),
      // l_products: JSON.parse(this.lastbrowseproducts),
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
    entry() {
      if (this.p_item.is_entried) {
        return;
      }
      document.getElementById('entry-form').submit();
    },
    favoriteItem() {
      axios
        .post("/item/favorite", {
          user_id: this.p_item.user_id,
          item_id: this.p_item.id,
        })
        .then((response) => {
          let status = response.data.status;
          if (status == 0) {
            alert("お気に入りに登録しました。");
            this.p_item.favorited = true;
          } else if (status == -1 || status == -2) {
            alert("お気に入りに登録失敗しました。");
          } else if (status == -3) {
            alert("お気に入りにから解除しました。");
            this.p_item.favorited = false;
          } else if (status == -4) {
            alert("自分の求人をお気に入りに登録できません。");
          } else if (status == -5) {
            alert("ログインしてください。");
          }
        });
    },
    getStringFromArray(str) {
      let array = JSON.parse(str);
      if (array) {
        return array.join(", ");
      } else {
        return "";
      }
    },
    openShowLightBox() {
      this.showLightbox = true;
    },
    goto(refName) {
      var element = this.$refs[refName];
      var top = element.offsetTop;

      window.scrollTo({
        top: top,
        behavior: "smooth",
      });
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
        this.images.push({
          path: subImage,
        });
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
          this.p_item.favorited = true;
        } else if (status == -1 || status == -2) {
          alert("お気に入りに登録失敗しました。");
        } else if (status == -3) {
          alert("お気に入りにから解除しました。");
          this.p_item.favorited = false;
        } else if (status == -4) {
          alert("自分の求人をお気に入りに登録できません。");
        } else if (status == -5) {
          alert("ログインしてください。");
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
          this.p_item.following = true;
        } else if (status == -1) {
          alert("自分をフォローできません。");
        } else if (status == -2) {
          alert("フォローするためにはログインが必要です。");
        } else if (status == -3) {
          alert("フォロー解除しました。");
          this.p_item.following = false;
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
        window.location.href = this.p_item.messageUrl;
      }
    },
    // concernMessage() {
    //   if (this.p_item.user_id == this.p_item.sellerId) {
    //     alert("自分にはメッセージを送信できません。");
    //   } else {
    //     location.href = this.p_item.concernUrl;
    //   }
    // },
    // review() {
    //   if (this.p_item.user_id == 0) {
    //     alert("レビューするためにはログインが必要です。");
    //   } else {
    //     if (this.commentRating == 0) {
    //       alert("評価を選択してください");
    //       return;
    //     }
    //     if (this.commentText == "") {
    //       alert("コメントを入力してください");
    //       return;
    //     }

    //     $("#reviewForm").submit();
    //   }
    // },
  },
  // created() {
  //   window.addEventListener("resize", this.handleResize);
  //   this.handleResize();
  // },
  // destroyed() {
  //   window.removeEventListener("resize", this.handleResize);
  // },
};
</script>

<style lang="scss" scoped>
.btn-call {
  background: linear-gradient(90deg, #ef0505, #e38300);
  border-radius: 10px;
  margin-top: 10px;
  text-decoration: none;
  color: white !important;
  margin-bottom: 10px;
  border: none;
  padding: 10px;
  margin: 10px;
  width: 80%;
  &:hover {
    text-decoration: none;
    color: white;
  }
}

.btn-disabled {
  border-radius: 10px;
  color: #fff;
  background: #b3b3b3;
  cursor: not-allowed !important;
  margin-top: 10px;
  margin-bottom: 10px;
  padding: 10px;
}

.btn-call > a {
  text-decoration: none;
  color: #fff;
}

.btn-detail {
  background: #ffffff;
  min-width: 100px;
  width: 80%;
  border-radius: 10px;
  border: 1px solid #000000;
  color: #000;
  text-decoration: none;

  margin: 10px;
  padding: 10px;
  &:hover {
    text-decoration: none;
    color: #000;
  }
}
.btn-detail > a {
  text-decoration: none;
  color: #000;
}

.video-container {
  position: relative;
  width: 100%;
  padding-bottom: 56.25%; /* 16:9 アスペクト比 */
  height: 0;
  overflow: hidden;
}

.video-container iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border: 0;
}

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
  margin: 40px 0;
}

@media (max-width: 768px) {
  .detail-page-title {
    font-size: 22px;
    margin-bottom: 30px;
  }
}

.detail-main-image {
  width: 90%;
  background-color: #E6E6E6;
  position: relative;
  margin: auto;
  /* margin-bottom: 16px; */
}

.detail-main-image img {
  cursor: zoom-in;
  width: 100%;
  height: 100%;
  object-fit: contain;
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
  margin-top: 8px;
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
  width: 100%;
}

.detail-col-content {
  width: 100%;
  padding-left: 0;
  margin: auto;
}

@media (max-width: 1200px) {
  .detail-col-content {
    width: 100%;
    padding-left: 20px;
    padding-right: 20px;
  }
}

@media (max-width: 992px) {
  .detail-col-image {
    padding-left: 15px;
    padding-right: 15px;
  }

  .detail-col-content {
    width: 100%;
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

<style lang="scss" scoped>
.detail-content-sub-container {
  table {
    th,
    td {
      padding: 12px 10px;
      border-bottom: 1px solid black;
    }
    tr {
      th {
        width: 140px;
      }
      td {
        white-space: wrap;
        word-break: break-all;
      }
      &:first-child {
        border-top: 1px solid black;
      }
      &:hover {
        th,
        td {
          background: #f5f5f5;
        }
      }
    }
  }
}

.favorite-btn {
  width: 30px;
  height: 30px;
  font-size: 1.2em;
  color: red;
  margin: 0 10px;
  text-align: center;
}
.favorite-btn :hover {
  transform: scale(1.2);
  animation: 0.2s;
}

.detail-page-container {
  position: relative;
}

.emergency-badge {
  position: absolute;
  top: -20px;
  left: 10%;
  background-color: #E12220;
  color: #fff;
  font-size: 18px;
  padding: 10px 15px;
  border-radius: 5px;
}

.detail-action-container {
  width: 100%;
  max-width: 600px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
  grid: 20px;
}

.btn-message {
  background: #4B4B4B;
  color: #fff;
  border: 1px solid #4B4B4B;
  border-radius: 10px;
  margin-top: 10px;
  text-decoration: none;
  color: white !important;
  margin-bottom: 10px;
  border: none;

  padding: 10px;
  margin: 10px;
}

.detail-item {
  display: flex;
  gap: 10px;
  border-bottom: 1px solid #ccc;
  padding-top: 20px;
  padding-bottom: 20px;
}
.detail-item:first-child {
  border-top: 1px solid #ccc;
}

.detail-item div {
  font-size: 16px !important;
}

.detail-item-label {
  width: 30%;
  font-weight: bold;
  line-height: 1.5;
  height: fit-content;
}

.detail-item-value {
  flex: 1;
  line-height: 1.5;
  height: fit-content;
}

@media (max-width: 768px) {
  .detail-item{
    flex-direction: column;
  }
  .detail-item-label {
    width: 100%;
  }
  .detail-item-value {
    width: 100%;
  }
}

.company-container {
  display: flex;
  align-items: flex-start;
  gap: 30px;

  .company-icon {
    width: 125px;
    height: 125px;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }
  }

  .company-info {
    flex: 1;
    
    a {
      color: #212529;
      text-decoration: underline;

      &:hover {
        text-decoration: none;
      }

      h3 {
        font-size: 18px;
      }
    }

    .company-category {
      display: flex;

      span {
        padding: 5px;
      }
    }
  }
}
</style>