function checkAllItems() {
    $('.item_list_delete').prop('checked', true);
}

function submitDelete() {
    var t = $('.item_list_delete:checked').length;
    if (t > 0) {
        $('#item_all_del_form').submit();
    } else {
        alert('求人を選択してください');
    }
}

function uploadUserImage() {
    $('#user_image_file_name').trigger('click');
}

function deleteUserImage() {
    $('#userImageDelForm').submit();
}

$(document).ready(function () {
    if (document.getElementById('main_category')) {
        document.getElementById('main_category').addEventListener('change', function() {
            // 選択された都道府県のコードを取得します
            const mainCategoryCode = this.value;
            const categories = JSON.parse(document.getElementById('categories').value);
            // カテゴリコードを元に市区町村の一覧を取得します
            const subCategories = categories[mainCategoryCode]['sub_categories'];
            // 選択肢をリセットします
            const subCategorySelect = document.getElementById('sub_category');
            subCategorySelect.innerHTML = '';
            // 選択肢を生成します
            for (const subCategory of subCategories) {
                const option = document.createElement('option');
                option.value = subCategory['id'];
                option.textContent = subCategory['name'];
                subCategorySelect.appendChild(option);
            }
        });
    }
    if (document.getElementById('pref')) {
        document.getElementById('pref').addEventListener('change', function() {
            // 選択された都道府県のコードを取得します
            const prefCode = this.value;
            const prefs = JSON.parse(document.getElementById('prefs').value);
            // カテゴリコードを元に市区町村の一覧を取得します
            const cities = prefs[prefCode]['city'];
            // 選択肢をリセットします
            const citySelect = document.getElementById('city');
            citySelect.innerHTML = '';
            // 選択肢を生成します
            for (const city of cities) {
                const option = document.createElement('option');
                option.value = city['citycode'];
                option.textContent = city['city'];
                citySelect.appendChild(option);
            }
        });
    }
    $('#message-content').on('change', function () {
        if ($(this).val().length > 0) {
            $('#send-button').attr('disabled', false);
        } else {
            $('#send-button').attr('disabled', true);
        }
    });

    $('#user_image_file_name').change(function(e) {
        var max_size = $('#user_image_max_size').val();
        var file_size = this.files[0].size;
        if (file_size > max_size * 1024 * 1024) {
            alert(max_size + 'MB以上の画像はアップロードできません。');
        } else {
            $('#userImageFileForm').submit();
        }

        // $('#userImageFileForm').submit();
    });

    $("form").submit(function(event) {

        $("button", this).prop('disabled', true)

    })
    // $("form").submit(function(){
    //     var input = $("input[type=submit]", $(this));
    //     var button = $("buton[type=submit]", $(this));
    //
    // });
});