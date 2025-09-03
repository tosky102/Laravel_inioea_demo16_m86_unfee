<template>
  <div v-if="u_item" class="user-item">
    <div class="user-item-image">
      <a :href="u_item.url">
        <img :src="u_item.img" />
      </a>
      <span
        class="favorite-btn"
        v-if="!u_item.followed"
        @click="followUser()"
      >
        <i class="icon-favorite"></i>
      </span>
      <span v-else class="favorite-btn" @click="followUser()">
        <i class="icon-favorited"></i>
      </span>
    </div>
    <div class="user-item-info">
      <h2 class="title text-center">
        <a :href="u_item.url">{{ u_item.name }}</a>
      </h2>

      <div>
        <p class="user-item-info-item">
          <span class="user-item-info-item-label">勤務エリア：</span>
          <span class="user-item-info-item-value">{{ u_item.area }}</span>
        </p>
        <p class="user-item-info-item">
          <span class="user-item-info-item-label">活動SNS：</span>
        </p>
        <p class="user-item-info-item sns-list" v-if="u_item.sns && u_item.sns.length > 0">
          <a v-for="(sns, index) in u_item.sns" :key="index" :href="sns.url">
            <img v-if="sns.name !== '他'" :src="sns.icon" />
            <span v-else>{{ sns.name }}</span>
          </a>
        </p>
        <p class="user-item-info-item">
          <span class="user-item-info-item-label">得意ジャンル：</span>
          <span class="user-item-info-item-value">{{ u_item.admin_pickup_category }}</span>
        </p>
      </div>

      <!-- <a
        v-if="u_item.newMessageUrl"
        class="btn btn-call btn-pill w-100 btn-danger"
        :href="u_item.newMessageUrl"
        >お話ししてみる</a
      > -->
      <a class="btn btn-detail btn-pill w-100 btn-success" :href="u_item.url"
        >詳細を見る</a
      >
    </div>
    <span v-if="u_item.is_picked" class="user-item-status" :class="u_item.status_class">認定</span>
  </div>
</template>

<script>
export default {
  props: ["user", "type"],
  data() {
    return {
      u_item: this.user,
    };
  },
  mounted() {
    if (this.u_item) {
      console.log(this.u_item);
    }
  },
  watch: {
    user(newVal) {
      this.u_item = newVal;
    }
  },
  methods: {
    followUser() {
      if (!this.u_item) {
        return;
      }
      axios
        .post("/user/follow", {
          follow_user_id: this.u_item.id,
        })
        .then((response) => {
          let status = response.data.status;
          if (status == 0) {
            alert("お気に入りに登録しました。");
            this.u_item.followed = true;
          } else if (status == -1 || status == -2) {
            alert("お気に入りに登録失敗しました。");
          } else if (status == -3) {
            alert("お気に入りにから解除しました。");
            this.u_item.followed = false;
            if (this.type == 'favorite') {
                window.location.reload();
            }
          } else if (status == -4) {
            alert("自分の求人をお気に入りに登録できません。");
          } else if (status == -5) {
            alert("ログインしてください。");
          }
        });
    },
  },
};
</script>

<style>
.user-item {
  position: relative;
  width: 180px;
  border: 1px solid #e3e3e3;
  border-radius: 3px;
  margin-right: 15px;
  margin-bottom: 30px;
  border: none;
}

.user-item-image {
  height: 178px;
  width: 178px;
  position: relative;
  background-color: #e3e3e3;
  border-radius: 15px 15px 0 0;
  overflow: hidden;
}

@media (max-width: 768px) {
  .user-item {
    width: calc(50% - 4px);
    display: inline-block;
    margin-bottom: 15px;
  }

  .user-item-image {
    width: 100%;
    height: 160px;
  }

  .user-items-container .user-item:nth-child(even) {
    margin-right: 0;
  }

  .user-items-container .user-item:nth-child(odd) {
    margin-right: 8px;
  }
}

.user-item-image:hover {
  opacity: 0.5;
}

.user-item-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.user-item-info {
  padding: 8px 8px 6px 8px;
  background-color: #fefefe;
}

.user-item-info h2 {
  font-size: 15px;
  line-height: 19px;
  height: 38px;
  margin-bottom: 0;
}

.user-item-info p.price {
  text-align: right;
  font-size: 18px;
  line-height: 24px;
  font-weight: bold;
  margin-top: 16px;
  margin-bottom: 6px;
}

.user-item-info p.price span.price-status {
  font-size: 14px;
}

.user-item-info a,
.user-item-info a:hover,
.user-item-info a:visited {
  color: #000;
}

.user-item-info a {
  text-decoration: none;
}

.user-item-info a:hover {
  text-decoration: underline;
}

.user-item-info .seller {
  font-size: 12px;
  margin-bottom: 0;
}

.user-item-info .seller img {
  width: 20px;
  height: 20px;
  border-radius: 10px;
  margin-right: 8px;
}

.user-item-info .seller a,
.user-item-info .seller a:visited {
  color: #939393;
  text-decoration: underline;
}

.user-item-info .seller a:hover {
  color: #939393;
  text-decoration: none;
}

.user-item-status {
  position: absolute;
  left: 8px;
  top: 8px;
  padding: 3px 8px;
  text-align: center;
  font-size: 15px;
  font-weight: bold;
  color: #fff;
  background-color: #E1AE20;
  border-radius: 10px;
}

.sale-status-first {
  font-size: 14px;
  line-height: 24px;
  width: 23px;
  color: #fff;
  background-color: #f2c21d;
}

.sale-status-second {
  font-size: 14px;
  line-height: 24px;
  width: 23px;
  color: #fff;
  background-color: #d0d0d0;
}

.sale-status-third {
  font-size: 14px;
  line-height: 24px;
  width: 23px;
  color: #fff;
  background-color: #c09262;
}

.sale-status-other {
  font-size: 14px;
  line-height: 24px;
  width: 23px;
  color: #fff;
  background-color: #969696;
}

@media (max-width: 768px) {
  .sale-status-first,
  .sale-status-second,
  .sale-status-third,
  .sale-status-other {
    left: 0;
    top: 0;
  }
}
</style>

<style lang="scss" scoped>
.btn-call {
  background: linear-gradient(90deg, #ef0505, #e38300);
  border-radius: 10px;
  color: #fff;
  border: 1px solid #f5485e;
  margin-top: 10px;
  text-decoration: none;
  color: white !important;
  margin-bottom: 10px;
  border: none;
  &:hover {
    text-decoration: none;
    color: white;
  }
}

.btn-call > a {
  text-decoration: none;
  color: #fff;
}

.btn-detail {
  background: #ffffff;
  min-width: 100px;
  border-radius: 10px;
  border: 1px solid #000000;
  color: #000;
  text-decoration: none;
  &:hover {
    text-decoration: none;
    color: #000;
  }
}
.btn-detail > a {
  text-decoration: none;
  color: #000;
}

.user-item-info {
  padding: 10px;
  border-radius: 0 0 15px 15px;
  h2 {
    font-weight: bold;
    height: auto;
    margin-top: 5px;
    margin-bottom: 5px;
  }
}

.user-item-info table th {
  word-break: keep-all;
}

.favorite-btn {
  width: 20px;
  height: 20px;
  font-size: 1em;
  color: red;
  position: absolute;
  z-index: 10;
  right: 10px;
  top: 10px;
}
.favorite-btn :hover {
  transform: scale(1.2);
  animation: 0.2s;
}

.sns-list a {
  display: block;
  width: calc(100% / 6 - 2px);
  height: 100%;
}

.sns-list a:hover {
  opacity: 0.5;
}

.sns-list img {
  width: 100%;
  height: auto;
  object-fit: contain;
}

.user-item-info-item {
  font-size: 0.9em;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  margin-bottom: 5px;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
.user-item-info-item.sns-list {
  display: flex;
  gap: 5px;
  padding: 0 10px;
  flex-wrap: nowrap;
  align-items: center;
  justify-content: flex-start;
}

.user-item-info-item-label {
  font-weight: bold;
}

.user-item-info-item-value {
  flex: 1;
}
</style>