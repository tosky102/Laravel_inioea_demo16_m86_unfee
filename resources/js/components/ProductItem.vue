<template>
    <div class="product-item">
        <span v-if="p_item.is_emergency" class="product-item-status" :class="p_item.status_class">急募</span>
        <span
            class="favorite-btn"
            v-if="!p_item.favorited"
            @click="favoriteItem()"
        >
            <i class="icon-favorite"></i>
        </span>
        <span v-else class="favorite-btn" @click="favoriteItem()">
            <i class="icon-favorited"></i>
        </span>
        <div class="product-item-type-mark">
            募集
        </div>
        <a :href="p_item.url">
            <div class="product-item-image">
                <img :src="p_item.img" />
            </div>
        </a>
        <div class="product-item-info">
            <h4 class="product-item-name">{{ p_item.user.facility_name }}</h4>
            <p class="product-item-station"><span class="label">エリア / 最寄駅：</span><span>{{ p_item.station }}</span></p>
            <p class="product-item-followers"><span class="label">応募フォロワー数：</span><span>{{ p_item.entry_follower }}人以上</span></p>
            <h2 class="product-item-title">{{ p_item.title }}</h2>
        </div>

        <a :href="p_item.url" class="product-btn">詳細を見る</a>
    </div>
</template>

<script>
export default {
  props: ["item", "type"],
  data() {
    return {
      p_item: this.item,
      status_flag: this.item.status_text ? true : false,
    };
  },
  methods: {
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
    .product-item {
        float: left;
        position: relative;
        width: 200px;
        border: 1px solid #E3E3E3;
        border-radius: 12px;
        margin-right: 20px;
        margin-bottom: 30px;
        background-color: #FEFEFE;
        padding: 15px 13px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .product-item-status {
        position: absolute;
        left: 9px;
        top: -15px;
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        color: #fff;
        background-color: #E12220;
        padding: 3px 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-radius: 20px;
    }

    .product-item-type-mark {
        width: fit-content;
        margin: 0 auto;
        background-color: #E12220;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        padding: 3px 12px;
        border-radius: 6px;
    }

    .product-item-image {
        width: 100%;
        aspect-ratio: 1.4;
        position: relative;
        background-color: #E3E3E3;
        margin-top: 10px;
    }

    .product-item-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .product-item-info {
        margin-top: 10px;
        min-height: 120px;
        color: #333;
    }

    .product-item-name {
        font-size: 13px;
        font-weight: bold;
        color: #8a8a8a;
    }

    .product-item-station {
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        font-size: 13px;
        margin-bottom: 4px;
        color: #8a8a8a;
    }

    .label {
        color: #333;
        font-weight: bold;
    }

    .product-item-followers {
        font-size: 13px;
        color: #8a8a8a;
        margin-bottom: 4px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .product-item-title {
        font-size: 16px;
        margin-top: 10px;
        text-align: left;
        color: #333;
        font-weight: bold;
    }

    .product-btn {
        display: block;
        width: 100%;
        margin-top: 10px;
        border: 1px solid #000;
        border-radius: 6px;
        padding: 5px;
        font-size: 14px;
        text-align: center;
        color: #000;
    }
    .product-btn:hover {
        border: 1px solid #E12220;
        background-color: #E12220;
        color: #ffffff;
        text-decoration: none;
        transition: 0.5s;
    }

    .favorite-btn {
        width: 20px;
        height: 20px;
        /* color: white; */
        font-size: 1em;
        color: red;
        position: absolute;
        z-index: 10;
        right: 10px;
        top: 18px;
        cursor: pointer;
    }
    .favorite-btn :hover {
        transform: scale(1.2);
        animation: 0.2s;
    }

    .product-item-info a, .product-item-info a:visited {
        color: #000; text-decoration: none;
        width: 100%;
        text-align: left;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.5;
        line-break: anywhere;
        word-break: break-all;
        height: 3;
    }

    .product-item-info a:hover {
        color: #000; text-decoration: underline;
    }

    @media (max-width: 768px) {
        .product-item {
            width: calc(50% - 4px);
            display: inline-block;
            margin-bottom: 15px;
        }

        .product-items-container .product-item:nth-child(even) {
            margin-right: 0;
        }

        .product-items-container .product-item:nth-child(odd) {
            margin-right: 8px;
        }

        .product-item-status {
            left: 9px;
            top: -10px;
            font-size: 14px;
            padding: 3px 12px;
        }
    }

    @media (max-width: 420px) {
        .product-item-type-mark {
            width: 60px;
        }
    }
</style>