<?php

namespace App\Helper;

use Exception;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class Helper
{
    /**
     * Storing image into storage and return filename
     *
     * @param  mixed $img
     * @param  string $location
     * @return $filename
     */
    public static function store_image($img, $location)
    {
        try {
            // 未定義である・複数ファイルである・$_FILES Corruption 攻撃を受けた
            // どれかに該当していれば不正なパラメータとして処理する
            if (!isset($img) || !is_int($img->getError())) {
                throw new RuntimeException('パラメータが不正です');
            }

            switch ($img->getError()) {
                case UPLOAD_ERR_OK: // OK
                    break;
                case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                    throw new RuntimeException('ファイルが選択されていません');
                case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過 (設定した場合のみ)
                    throw new RuntimeException('ファイルサイズが大きすぎます');
                default:
                    throw new RuntimeException('その他のエラーが発生しました');
            }

            if ($img->getSize() > 2000000) {  //file maxsize 2x10^6 byte ~ 2mb;
                throw new RuntimeException('ファイルサイズが大きすぎます');
            }
            //mime_content_type:  return file extension
            //～すごいコード～
            if (!$ext = array_search(
                $img->getMimeType(),
                array(
                    'gif' => 'image/gif',
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                ),
                true // strict_parameter. Explain:  absolutely compare, ex: 3 !== "3", 3===3
            )) {
                throw new RuntimeException('ファイル形式が不正です');
            }

            // check folder existed before storage
            if (!file_exists($location) || !is_dir($location)) {
                mkdir($location, 0777, true); // create folder with path is $location
            }
            // ファイルデータからSHA-1ハッシュを取ってファイル名を決定し，保存する
            if (!move_uploaded_file(
                $img,
                $path = sprintf(
                    $location . '%s.%s',
                    $filename = sha1_file($img), //hash & get filename for return and save database
                    $ext
                )
            )) {
                throw new RuntimeException('ファイル保存時にエラーが発生しました');
            }

            // ファイルのパーミッションを確実に0644に設定する
            chmod($path, 0644);
            //get filename with extension
            $filename .= '.' . $ext;

            return $filename;
        } catch (RuntimeException $e) {

            echo $e->getMessage();
        }
    }

    /**
     * Removing images from storage
     *
     * @param  mixed $filesName
     * @param  string $location
     * @return bool
     */
    public static function remove_image_from_storage($filesName = [], $location)
    {
        try {
            foreach ($filesName as $fn) {
                if (file_exists($location . $fn)) { //check file exist before remove
                    unlink($location . $fn);
                }
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
        return true;
    }
}
