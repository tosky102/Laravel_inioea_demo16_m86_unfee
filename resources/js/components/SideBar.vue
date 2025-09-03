<template>
<div class="sidebar">
    <div class="side-categories">
        <div class="side-categories-title">
            <a href="/item?type=0">
                企業一覧
                <span class="right-arrow-icon"></span>
            </a>
        </div>
        <div v-if="p_user && p_user.type == 0" class="side-categories-title">
            <a href="/item?type=1">
                受注者/求職者一覧
                <span class="right-arrow-icon"></span>
            </a>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['auth'],
    data() {
        return {
            p_user: JSON.parse(this.auth)
        }
    },
    methods: {},
    mounted () {
        console.error(this.auth)
    }
}
</script>

<style>
.side-action-panel {
    background: #444444;
}

.side-action-panel-title {
    font-size: 14px;
    line-height: 24px;
    color: #ffffff;
    height: 40px;
    padding: 8px 27px;
    font-weight: bold;
    position: relative;
}

.side-action-panel-title .right-arrow-icon {
    border-right: 2px solid #ffffff;
    border-bottom: 2px solid #ffffff;
}

.side-action-panel-actions {
    border-top: 1px solid #808080;
    padding: 10px;
}

.side-action-panel-actions a {
    width: 100%;
    border-radius: 3px;
    padding: 12px 30px 12px 60px;
    font-size: 15px;
    line-height: 24px;
    display: block;
}

.side-action-panel-actions a+a {
    margin-top: 5px;
}

.side-action-panel-actions .purchase-point {
    color: white;
    background-color: #F08C1E;
    background-image: url("/images/icons/point.svg");
    background-repeat: no-repeat;
    background-size: 18px;
    background-position: 32px;
    text-decoration: none;
}

.side-action-panel-actions .purchase-point:hover,
.side-action-panel-actions .purchase-point:visited {
    color: white;
    text-decoration: none;
}

.side-action-panel-actions .purchase-point:hover {
    opacity: 0.5;
}

.side-action-panel-actions .upload-product {
    color: #333333;
    background-color: #FAFAFA;
    background-image: url("/images/icons/upload.svg");
    background-repeat: no-repeat;
    background-size: 18px;
    background-position: 32px;
    text-decoration: none;
}

.side-action-panel-actions .upload-product:hover,
.side-action-panel-actions .upload-product:visited {
    color: #333333;
    text-decoration: none;
}

.side-action-panel-actions .upload-product:hover {
    opacity: 0.5;
}

.side-categories a,
.side-categories a:hover,
.side-categories a:visited {
    color: #000;
}

.side-categories>.side-categories-title {
    font-size: 14px;
    line-height: 24px;

    background-color: #EFEFEF;
    height: 40px;
    padding: 8px 27px;
    font-weight: bold;
    position: relative;
}

.side-categories-title .right-arrow-icon {
    border-right: 2px solid #000;
    border-bottom: 2px solid #000;
}

.side-categories-title a,
.side-categories-title a:hover,
.side-categories-title a:visited {
    color: #000;
}

.side-categories-item {
    font-size: 14px;
    line-height: 24px;
    height: 40px;
    padding: 8px 27px;
    position: relative;
    cursor: pointer;
}

.side-categories-item .sub-menu {
    display: none;
    position: absolute;
    background-color: #ffffff;
    width: 180px;
    top: 0;
    left: 100%;
    border-radius: 3px;
    border: 1px solid #EFEFEF;
    box-shadow: 0 0 3px rgb(0 0 0 /20%);
    color: #000;
    z-index: 500;
    padding: 18px 0;
}

.side-categories-item .right-arrow-icon {
    border-right: 2px solid #969696;
    border-bottom: 2px solid #969696;
}

.side-categories-item:hover {
    background-color: #EFEFEF;
    text-decoration: underline;
}

.side-categories-item:hover a,
.side-categories-item:hover a:hover,
.side-categories-item:hover a:visited {
    color: #B0B0B0;
}

.side-categories-item .sub-menu a,
.side-categories-item .sub-menu a:hover,
.side-categories-item .sub-menu a:visited,
.side-categories-item:hover .sub-menu a,
.side-categories-item:hover .sub-menu a:hover,
.side-categories-item:hover .sub-menu a:visited {
    color: #000;
}

.side-categories-item:hover .right-arrow-icon {
    border-right: 2px solid #E3E3E3;
    border-bottom: 2px solid #E3E3E3;
}

.side-categories-item:hover .sub-menu {
    display: block;
}

.side-categories-item .sub-menu p {
    font-size: 14px;
    line-height: 24px;
    padding: 2px 20px;
    margin: 0;
}

.side-categories-item .sub-menu p:hover {
    background-color: #EFEFEF;

    text-decoration: underline;
}

.side-categories-item .sub-menu p:hover a,
.side-categories-item .sub-menu p:hover a:hover,
.side-categories-item .sub-menu p:hover a:visited {
    color: #B0B0B0;
}
</style>