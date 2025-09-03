<template>
    <div class="file-upload-container">
        <label for="itemUploadFile" class="file-upload-label btn btn-secondary">アップロード</label>
        <input type="file" id="itemUploadFile" @change="uploadFile" ref="itemUploadFile" style="display: none">

        <table class="table table-bordered">
            <tr>
                <th>ファイル名</th>
                <td>{{ fileName }}</td>
            </tr>
            <tr>
                <th>タイプ</th>
                <td>{{ fileType }}</td>
            </tr>
            <tr>
                <th>サイズ</th>
                <td>{{ fileSize }}</td>
            </tr>
        </table>
    </div>
</template>

<script>

    export default {
        props: ['max_size'],
        mounted() {
            this.handleFile();
        },
        data() {
            return {
                url: '/mypage/item_file',
                fileName: '',
                fileType: '',
                fileSize: '',
            }
        },
        methods: {
            uploadFile() {
                let data = new FormData;

                if (this.$refs.itemUploadFile.files.length > 0) {
                    data.append('file', this.$refs.itemUploadFile.files[0]);
                    let size = this.$refs.itemUploadFile.files[0].size;
                    if (size > this.max_size * 1024 * 1024) {
                        alert(this.max_size + 'MB以上のファイルはアップロードできません。');
                        return;
                    }
                    axios.post(
                        this.url,
                        data,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .then((response) => {
                            $('#file_name').val(response.data.file_name);
                            $('#file_path').val(response.data.file_path);
                            $('#file_type').val(response.data.file_type);
                            $('#file_extension').val(response.data.file_extension);
                            $('#file_size').val(response.data.file_size);

                            this.fileName = response.data.file_name;
                            this.fileType = response.data.file_type;
                            this.fileSize = response.data.file_size + 'Byte';

                        })
                }
            },
            handleFile() {
                this.fileName = $('#file_name').val();
                this.fileType = $('#file_type').val();
                this.fileSize = $('#file_size').val();
                if (this.fileName == '') this.fileName = '未登録';
            }
        },

    }
</script>

<style>
    .file-upload-container {

    }

    .file-upload-label {
        cursor: pointer;
        text-align: center;
    }
</style>