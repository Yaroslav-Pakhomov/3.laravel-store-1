$(document).ready(function ($) {
    // alert($('meta[name="csrf-token"]').attr('content'));

    /*
     * Общие настройки ajax-запросов, отправка на сервер csrf-токена
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*
     * Подключение wysiwyg-редактора для редактирования контента страницы
     */
    $('textarea[id="editor"]').summernote({
        lang: 'ru-RU',
        height: 300,
        callbacks: {
            /*
             * При вставке изображения загружаем его на сервер
             */
            onImageUpload: function (images) {
                for (let i = 0; i < images.length; i++) {
                    uploadImage(images[i], this);
                }
            },
            /*
             * При удалении изображения удаляем его на сервере
             */
            onMediaDelete: function (target) {
                removeImage(target[0].src);
            }
        }
    });

    /*
     * Загружает на сервер вставленное в редакторе изображение
     */
    function uploadImage(image, textarea) {
        let data = new FormData();
        data.append('image', image);

        $.ajax({
            data: data,
            type: 'POST',
            url: '/admin/page/upload/image',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                $(textarea).summernote('insertImage', data.image, function ($img) {
                    $img.css('max-width', '100%');
                });
            },
            error: function (reject) {
                $.each(reject.responseJSON.errors, function (key, value) {
                    alert(value);
                });
            }
        });
    }

    /*
    * Удаляет на сервере удаленное в редакторе изображение
    */
    function removeImage(src) {
        $.ajax({
            data: {'image': src, '_method': 'DELETE'},
            type: 'POST',
            url: '/admin/page/remove/image',
            cache: false,
            success: function (msg) {
                // console.log(msg);
            }
        });
    }
});
