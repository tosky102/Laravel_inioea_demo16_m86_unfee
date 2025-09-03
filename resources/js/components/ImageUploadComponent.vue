<template>
    <vue-upload-multiple-image-drawing
            @upload-success="uploadImageSuccess"
            @before-remove="beforeRemove"
            @edit-image="editImage"
            :data-images="images"
            :max-size="max_size"
    ></vue-upload-multiple-image-drawing>
</template>

<script>
    import axios from 'axios'
    export default {
        props: ['max_size', 'type'],
        data () {
            return {
                images: []
            }
        },
        mounted() {
            this.handleImages();
        },
        methods: {
            uploadImageSuccess(formData, index, fileList) {
                // console.log('data', formData, index, fileList)
                this.uploadImage(formData, index, fileList);
                // Upload image api

            },
            beforeRemove(index, done, fileList) {
                console.log('index', index, fileList)
                var r = confirm("画像を削除しますか。")
                if (r == true) {
                    for (var i = index; i < 5; i++) {
                        var next_i = i + 1;
                        if (next_i < 5) {
                            $('#images_' + i + '_url').val($('#images_' + next_i + '_url').val());
                            $('#images_' + i + '_path').val($('#images_' + next_i + '_path').val());
                        }
                    }
                    $('#images_4_url').val('');
                    $('#images_4_path').val('');

                    done()
                } else {
                }
            },
            editImage(formData, index, fileList) {
                // console.log('edit data', formData, index, fileList)
                this.uploadImage(formData, index, fileList);
            },
            uploadImage(formData, index, fileList) {
                let file = formData.get('file');
                if (file != undefined) {
                    let size = file.size;
                    if (size > this.max_size * 1024 * 1024) {
                        alert(this.max_size + 'MB以上の画像はアップロードできません。');
                    } else {
                        axios.post(`${this.type == 'profile' ? '/mypage/user_image' : '/mypage/item_image'}`, formData).then(response => {
                            let file_url = response.data.file_url;
                            let file_path = response.data.file_path;
                            $('#images_' + index + '_url').val(file_url);
                            $('#images_' + index + '_path').val(file_path);
                        })
                    }

                }

            },
            handleImages() {
                let first = 1;
                for (var i = 0; i < 5; i++) {
                    let url = $('#images_' + i + '_url').val();

                    if (url) {
                        let image = {
                            default: first,
                            drawing: 1,
                            highlight: first,
                            path: url,
                            name: i + '.png'
                        }
                        this.images.push(image);
                        first = 0;
                    }
                }
            }
        }
    }
</script>
