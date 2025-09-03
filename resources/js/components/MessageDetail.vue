<template>
  <div>
    <div v-if="item.status >= 0" class="order-status-container">
      <template v-for="(label, i) in statuses">
        <div class="order-status-item" :class="{ active: i === item.status, pass: i < item.status }">
          <div class="order-status-item-label">{{ label }}</div>
        </div>
        <div v-if="i < statuses.length - 1" class="order-status-symbol"></div>
      </template>
    </div>

    <template v-if="item.status === 0">
      <template v-if="userType === 'company'">
        <div v-if="item.item" class="order-status-action-container">
          <button class="btn btn-request" @click="request">依頼する</button>
          <button class="btn btn-reject" @click="reject">依頼しない</button>
        </div>
      </template>
    </template>
    <template v-if="item.status === 1">
      <template v-if="userType === 'company'">
        <div v-if="item.item" class="order-status-action-container">
          <button class="btn btn-request" @click="shopping">来店完了</button>
        </div>
      </template>
    </template>
    <template v-if="item.status === 2">
      <template v-if="userType === 'influencer'">
        <div v-if="item.item" class="order-status-action-container">
          <div class="order-status-post-url-container">
            <button class="btn btn-post" :disabled="post_url.length === 0" @click="post">投稿完了</button>
            <div>
              <label for="post_url" style="display: block;">投稿完了のURL</label>
              <input type="text" class="form-control" v-model="post_url" id="post_url">
            </div>
          </div>
        </div>
      </template>
    </template>
    <template v-if="item.status === 3">
      <template v-if="userType === 'company'">
        <div v-if="item.item" class="order-status-action-container">
          <div class="order-status-rating-container">
            <div class="rating">
              <select name="rating" id="rating" v-model="rating" class="form-control">
                <option v-for="(label, value) in arrRating" :value="value">{{ label }}</option>
              </select>
            </div>
  
            <div class="review">
              <label for="review">レビューと投稿確認をお願いします。</label>
              <textarea name="review" id="review" class="form-control" v-model="review"></textarea>
              <button class="btn btn-request mt-1" :disabled="review.length === 0 || rating === undefined" @click="complete">依頼を完了する</button>
            </div>
          </div>
        </div>
      </template>
    </template>
    <template v-if="item.status === 5">
      <div v-if="item.item" class="order-status-action-container">
        <div v-if="userType === 'influencer'" class="order-status-cancel-container">
          <p>応募がキャンセルされました。</p>
        </div>
        <div v-else class="order-status-cancel-container">
          <p>案件依頼をキャンセルしました。</p>
        </div>
      </div>
    </template>
    <template v-if="item.status === -3">
      <div class="order-status-action-container">
        <button v-if="userType === 'company'" class="btn btn-request" @click="vote">案件を起票する</button>
      </div>
    </template>
    <template v-if="item.status === -2">
      <div v-if="item.item" class="order-status-action-container">
        <div class="order-status-vote-container">
          <a :href="`/item/${item.item_id}`" target="_blank">
            <div class="order-status-vote-item">
              <img :src="item.item?.main_image_url ?? '/storage/mallento.png'" :alt="item.item?.title ?? ''">
            </div>
          </a>
          <div v-if="userType === 'company'">
            案件起票完了しました。<br>
            インフルエンサーからの案件受け取りをお待ちください。
          </div>
          <div v-else>
            <button class="btn btn-request" :disabled="isExpired" @click="accept">案件を受ける</button>
          </div>
        </div>
      </div>
    </template>
    <template v-if="item.status === -1">
      <template v-if="userType === 'company'">
        <div v-if="item.item" class="order-status-action-container">
          <div class="order-status-vote-container">
            <button class="btn btn-request" @click="confirm">応募確認する</button>
          </div>
        </div>
      </template>
    </template>

    <div class="order-status-history-container">
      <div class="user-part">
        <div class="user-item">
          <div class="user-item-icon">
            <img :src="item.to_user.image_url" :alt="item.to_user.name">
          </div>
          <div class="user-item-name">
            <a :href="`/partner/${item.to_user.id}`">{{ item.to_user.name }}</a>
          </div>
        </div>
        <div class="user-item">
          <div class="user-item-icon">
            <img :src="item.user.image_url" :alt="item.user.nickname">
          </div>
          <div class="user-item-name">
            <a :href="`/user/${item.user.id}`">{{ item.user.nickname }}</a>
          </div>
        </div>
      </div>
      <div class="history-part">
        <div class="history-item">
          <p class="history-label">応募開始</p>
          <p class="history-time">{{ item.started_at_date }}</p>
        </div>
        <div class="history-item">
          <p class="history-label">依頼完了</p>
          <p class="history-time">{{ item.requested_at_date }}</p>
        </div>
        <div class="history-item">
          <p class="history-label">案件完了</p>
          <p class="history-time">{{ item.completed_at_date }}</p>
        </div>
      </div>
    </div>

    <div class="order-status-history-container" v-if="ratingValue !== ''">
      <div class="review-label">評価</div>
      <div class="review-rating">{{ ratingValue }}</div>
      <div class="review-value" v-html="reviewValue"></div>
    </div>

    <div class="card login-card" style="margin:0">
      <div class="card-body">
        <div class="item-list show-scroller" ref="messageList">
          <template v-for="row in messages">
            <div v-if="row.role_type === 'all' || row.role_type === userType" class="message-title">
              <p class="title-color display-table o-textNote__title f14" v-html="linkify(row.comment)"></p>
            </div>
            <div v-else-if="row.role_type === null" :class="(row.user_id === partnerObj.id || row.user_id === 0) || !row.fromUser ? 'partner' : 'self'">
              <div class="o-gridNote__body padding-top-none">
                <img v-if="row.fromUser" :src="row.fromUser.image_url" />
                <div v-else class="message-admin">
                  <img src="/images/users/mallento.png" />
                  <span class="message-sender-name">アンフィー<br/>事務局</span>
                </div>
                <div class="message-detail-text">
                  <h5 class="title-color display-table o-textNote__title f14">{{ formatDate(row.created_at) }}</h5>
                  <p class="f14 display-table o-textNote__description" style="margin-top: 4px; text-align: left" v-html="linkify(row.comment)"></p>
                </div>
              </div>
            </div>
            <div class="clearfix" style="margin-bottom:8px"></div>
          </template>
        </div>
      </div>

      <template v-if="!item || item.status < 4">
        <div class="item-list">
          <div class="message-input">
            <form @submit.prevent="sendMessage" id="message-form">
              <textarea
                class="form-control"
                v-model="commentText"
                style="background-color: rgb(243, 243, 243); color: rgb(0, 21, 29); min-height: 40px; width: 90%; margin: auto;"
                placeholder="テキストを入力"
                rows="4"
              ></textarea>
              
              <div style="width: 90%; margin: auto; margin-top: 10px; display: flex; justify-content: flex-start; gap: 20px;" v-if="item && (item.status === 0 && userType === 'company' || item.status === 1 || item.status === 2 && userType === 'influencer')">
                <label for="is_template" class="order-status-template-label">
                  <input type="checkbox" id="is_template" v-model="is_template">
                  <span>{{ template.label }}</span>
                </label>
                <label v-if="item.status === 0" for="is_cancel" class="order-status-template-label">
                  <input type="checkbox" id="is_cancel" v-model="is_cancel">
                  <span>お見送り定型文を挿入する</span>
                </label>
              </div>
              
              <div class="text-center mt-3">
                <button
                  type="submit"
                  class="btn btn-primary register-button"
                  style="min-width: 200px; margin-right: 0.2rem; margin:0.5rem; padding:1rem;"
                  :disabled="commentText.length === 0"
                >送信する</button>
              </div>
            </form>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  props: ['orderItem', 'statuses', 'userType', 'messages', 'partner', 'userId', 'template', 'cancelTemplate', 'arrRating'],
  data() {
    return {
      item: (typeof this.orderItem === 'string') ? JSON.parse(this.orderItem) : this.orderItem,
      is_template: 0,
      is_cancel: 0,
      post_url: '',
      rating: 3,
      review: '',
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      commentText: '',
      currentTime: new Date(),
      timer: null
    }
  },
  mounted() {
    this.timer = setInterval(() => {
      this.currentTime = new Date();
    }, 1000);
    // 初期表示時にスクロールを一番下へ
    this.scrollToBottom();
  },
  beforeDestroy() {
    clearInterval(this.timer);
  },
  methods: {
    scrollToBottom() {
      this.$nextTick(() => {
        const el = this.$refs.messageList;
        if (el) {
          el.scrollTop = el.scrollHeight;
        }
      });
    },
    vote() {
      $('#voteModal').modal('show');
    },
    accept() {
      if (this.isExpired) {
        alert('案件が期限切れになりました。');
        return;
      }
      axios.post('/order/' + this.item.id, {
        status: -1,
      }).then(response => {
        if (response.data.result == 1) {
          window.location.reload();
        } else {
          console.log(response.data.error);
          alert('操作が失敗しました');
        }
      }).catch(error => {
          console.log(error);
          alert('操作が失敗しました');
      })
    },
    confirm() {
      axios.post('/order/' + this.item.id, {
        status: 0,
      }).then(response => {
        if (response.data.result == 1) {
          window.location.reload();
        } else {
          console.log(response.data.error);
          alert('操作が失敗しました');
        }
      }).catch(error => {
          console.log(error);
          alert('操作が失敗しました');
      })
    },
    request() {
      axios.post('/order/' + this.item.id, {
        status: 1,
      }).then(response => {
        if (response.data.result == 1) {
          window.location.reload();
        } else {
          console.log(response.data.error);
          alert('操作が失敗しました');
        }
      }).catch(error => {
        console.log(error);
        alert('操作が失敗しました');
      });
    },
    reject() {
      axios.post('/order/' + this.item.id, {
        status: 5,
      }).then(response => {
        if (response.data.result == 1) {
          window.location.reload();
        } else {
          console.log(response.data.error);
          alert('操作が失敗しました');
        }
      }).catch(error => {
        console.log(error);
        alert('操作が失敗しました');
      });
    },
    shopping() {
      axios.post('/order/' + this.item.id, {
        status: 2,
      }).then(response => {
        if (response.data.result == 1) {
          window.location.reload();
        } else {
          console.log(response.data.error);
          alert('操作が失敗しました');
        }
      }).catch(error => {
        console.log(error);
        alert('操作が失敗しました');
      });
    },
    post() {
      axios.post('/order/' + this.item.id, {
        status: 3,
        post_url: this.post_url,
      }).then(response => {
        if (response.data.result == 1) {
          window.location.reload();
        } else {
          console.log(response.data.error);
          alert('操作が失敗しました');
        }
      }).catch(error => {
        console.log(error);
        alert('操作が失敗しました');
      });
    },
    complete() {
      axios.post('/order/' + this.item.id, {
        status: 4,
        rating: this.rating,
        comment: this.review,
      }).then(response => {
        if (response.data.result == 1) {
          window.location.reload();
        } else {
          console.log(response.data.error);
          alert('操作が失敗しました');
        }
      }).catch(error => {
        console.log(error);
        alert('操作が失敗しました');
      });
    },
    formatDate(dateStr) {
      const d = new Date(dateStr);
      const mm = (`0${d.getMonth() + 1}`).slice(-2);
      const dd = (`0${d.getDate()}`).slice(-2);
      const hh = (`0${d.getHours()}`).slice(-2);
      const ii = (`0${d.getMinutes()}`).slice(-2);
      return `${d.getFullYear()}.${mm}.${dd} ${hh}:${ii}`;
    },
    linkify(text) {
      if (!text) return '';
      const urlRegex = /(https?:\/\/[-\w\.]+(:\d+)?(\/[\w/_\.\#-]*(\?\S+)?[^\.\s])?)/g;
      const withLinks = text.replace(urlRegex, '<a href="$1" target="_blank">$1<\/a>');
      return withLinks.replace(/\n/g, '<br>');
    },
    sendMessage() {
      if (this.commentText.length === 0) return;
      axios.post('/order/send/message', {
        order_item_id: this.item.id,
        user_id: this.userId,
        to_user_id: this.partnerObj.id,
        comment: this.commentText,
        _token: this.csrf,
      }).then(response => {
        if (response.data.result == 1 || response.data.success) {
          window.location.reload();
        } else {
          alert('メッセージ送信に失敗しました');
        }
      }).catch(() => {
        alert('メッセージ送信に失敗しました');
      });
      // 送信後にスクロールを一番下へ
      this.scrollToBottom();
    },
  },
  computed: {
    messagesList() {
      return (typeof this.messages === 'string') ? JSON.parse(this.messages) : this.messages;
    },
    partnerObj() {
      return (typeof this.partner === 'string') ? JSON.parse(this.partner) : this.partner;
    },
    ratingValue() {
      return this.arrRating[this.item.user.reviews.find(review => review.item_id === this.item.item_id)?.rating] || '';
    },
    reviewValue() {
      return this.item.user.reviews.find(review => review.item_id === this.item.item_id)?.comment;
    },
    isExpired() {
      if (!this.item.item) {
        return false;
      }
      return new Date(this.item.item.expired_at) < this.currentTime;
    }
  },
  watch: {
    messagesList() {
      // メッセージ配列が更新されたらスクロール
      this.scrollToBottom();
    },
    is_template(newVal) {
      // is_template が選択されたら is_cancel を解除し、定型文をセット
      if (newVal) {
        if (this.is_cancel) this.is_cancel = 0;
        this.commentText = this.template ? this.template.value : '';
      } else {
        // is_template が解除された場合、is_cancel が選択されていればそちらの定型文を適用
        if (this.is_cancel) {
          this.commentText = this.cancelTemplate || '';
        } else {
          this.commentText = '';
        }
      }
    },
    is_cancel(newVal) {
      // is_cancel が選択されたら is_template を解除し、キャンセル定型文をセット
      if (newVal) {
        if (this.is_template) this.is_template = 0;
        this.commentText = this.cancelTemplate || '';
      } else {
        // is_cancel が解除された場合、is_template が選択されていればそちらの定型文を適用
        if (this.is_template) {
          this.commentText = this.template ? this.template.value : '';
        } else {
          this.commentText = '';
        }
      }
    }
  }
}
</script>

<style scoped>
.order-status-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin: 35px auto;
    width: 100%;
}

.order-status-item {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    background-color: #D9D9D9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 6px 0 rgba(0, 0, 0, 0.3);
}

.order-status-item-label {
    font-size: 14px;
    font-weight: bold;
}

.order-status-symbol {
    width: 9.4px;
    height: 11px;
    border-left: 9.4px solid #212529;
    border-right: 0;
    border-top: 5.5px solid transparent;
    border-bottom: 5.5px solid transparent;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
}

.order-status-item.active {
    background-color: #FFBF00;
    color: #FFFFFF;
}
.order-status-item.pass {
    opacity: 0.2;
}

.order-status-template-label {
  width: fit-content;
  text-align: left;
}

.order-status-action-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin: 10px auto 30px;
    width: 100%;
}

.btn {
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: bold;
  color: #FFFFFF;
}
.btn:hover {
   opacity: 0.6;
}
.btn-request {
    background-color: #FF0000;
}
.btn-reject {
    background-color: #FFFFFF;
    border: 1px solid #FF0000;
    color: #FF0000;
}
.btn-post {
  background-color: #FFAA00;
}
.btn-post:disabled {
  background-color: #D9D9D9;
  color: #FFFFFF;
}
.btn-rating {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 3px;
  padding: 8px 10px;
  background-color: #FFFFFF;
  border: 1px solid #b9bdc1;
  color: #212529;
  border-radius: 5px;
}
.btn-rating:hover {
  opacity: 0.6;
}
.btn-rating.active {
  background-color: #d5ecf7;
  border: 1px solid #6ab5d8;
}
.btn-request:disabled {
  background-color: #D9D9D9;
  color: #FFFFFF;
}

.order-status-post-url-container {
  width: 100%;
  max-width: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.rating {
  margin-bottom: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}
.rating label {
  margin-bottom: 0;
  color: #212529;
  font-size: 12px;
  cursor: pointer;
}
.rating .icon-good {
  color: #ef5185;
  cursor: pointer;
}
  
.rating .icon-bad {
color: #6ab5d8;
    cursor: pointer;
}

.rating input {
  cursor: pointer;
}

.review {
  display: flex;
  flex-direction: column;
  gap: 5px;
  margin-top: 10px;
}

.message-title {
  display: flex;
  justify-content: center;
  margin: 30px 0;
}

.message-title p {
  padding: 5px 10px;
  border-radius: 4px;
  background-color: #3e454d;
  color: #FFFFFF;
}

.mypage_row .message-title p a {
  color: #FFFFFF !important;
}

.order-status-vote-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 30px;
  margin: 35px auto 5px;
  width: 100%;
  max-width: 640px;
}

.order-status-vote-item {
  width: 200px;
  height: 100px;
}

.message-body .order-status-vote-item img {
  width: 200px !important;
  height: 100px !important;
  object-fit: contain;
  background-color: #f0f0f0;
  border-radius: 5px !important;
  margin-top: 0 !important;
  box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
}

.order-status-history-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  padding: 10px 50px;

  .user-part {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
    width: 100%;
    border-right: 1px solid #212529;
    
    .user-item {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 8px;
      margin-right: 0;
      margin-bottom: 0;
    
      img {
        margin-top: 0;
      }
    }
  }

  .history-part {
    width: 100%;
    padding-left: 20px;

    .history-item {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 8px;

      p {
        margin-bottom: 8px;
      }
    }
  }

  .review-label {
    width: 60px;
    text-align: center;
    padding-bottom: 20px;
  }
  
  .review-rating {
    width: 200px;
    text-align: center;
    padding-bottom: 20px;
  }

  .review-value {
    flex: 1;
    padding: 0 20px 20px;
    white-space: pre-line;
  }
}
</style>