<?php

namespace App\Components;

class ExifComponent
{
    /**
     * 画像（バイナリ）のEXif情報を元に回転する
     */
    public static function rotateFromBinary($binary)
    {
        $exif_data = self::getExifFromBinary($binary);
        if (empty($exif_data['Orientation']) || in_array($exif_data['Orientation'], [1, 2])) {
            return $binary;
        }
        return self::rotate($binary, $exif_data);
    }

    /**
     * バイナリデータからexif情報を取得
     */
    private static function getExifFromBinary($binary)
    {
        $temp = tmpfile();
        fwrite($temp, $binary);
        fseek($temp, 0);

        $meta_data = stream_get_meta_data($temp);
        $exif_data = @exif_read_data($meta_data['uri']);

        fclose($temp);
        return $exif_data;
    }

    /**
     * 画像を回転させる
     */
    private static function rotate($binary, $exif_data)
    {
        ini_set('memory_limit', '256M');

        $src_image = imagecreatefromstring($binary);

        $degrees = 0;
        $mode = '';
        switch ($exif_data['Orientation']) {
            case 2: // 水平反転
                $mode = IMG_FLIP_VERTICAL;
                break;
            case 3: // 180度回転
                $degrees = 180;
                break;
            case 4: // 垂直反転
                $mode = IMG_FLIP_HORIZONTAL;
                break;
            case 5: // 水平反転、 反時計回りに270回転
                $degrees = 270;
                $mode = IMG_FLIP_VERTICAL;
                break;
            case 6: // 反時計回りに270回転
                $degrees = 270;
                break;
            case 7: // 反時計回りに90度回転（反時計回りに90度回転） 水平反転
                $degrees = 90;
                $mode = IMG_FLIP_VERTICAL;
                break;
            case 8: // 反時計回りに90度回転（反時計回りに90度回転）
                $degrees = 90;
                break;
        }

        if (!empty($mode)) {
            imageflip($src_image, $mode);
        }
        if ($degrees > 0) {
            $src_image = imagerotate($src_image, $degrees, 0);
        }

        ob_start();
        if (empty($exif_data['MimeType']) || $exif_data['MimeType'] == 'image/jpeg') {
            imagejpeg($src_image);
        } elseif ($exif_data['MimeType'] == 'image/png') {
            imagepng($src_image);
        } elseif ($exif_data['MimeType'] == 'image/gif') {
            imagegif($src_image);
        }
        imagedestroy($src_image);
        return ob_get_clean();
    }
}
