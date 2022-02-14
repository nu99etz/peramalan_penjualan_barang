<?php

class Page {

    /**
    * Mendapatkan content
    *
    **/
    public static function getContent() {
      global $content;

      $contents = ob_get_contents();
      if(empty($content) or strlen($contents) > 0)
        $content[] = $contents;

      ob_clean();
    }

    public static function useLayout($layout) {
      global $layouts;

      self::getContent();

      $layouts = $layout;
    }

    public static function buildLayout() {

      global $content,$layouts,$p_title,$p_act,$p_col,$p_namepage,$a_coloumn,$a_form,$config;

      if(!empty($layouts)) {
        self::getContent();
        include(Route::getViewPath('layout/'.$layouts));
      }
    }

    public static function usePage($name = null) {

      if($name == null) {
        $path = 'pages/form.php';
      } else {
        $path = 'pages/'.$name.'.php';
      }
      return $path;
    }

    // public static function useLayout($name) {
    //   return $name.'.php';
    // }

    public static function getLayout($name) {

      return '../assets/layout/'.$name.'.php';

    }

    public static function getErrorCode($code) {

      return '../assets/layout/'.$code.'.php';

    }

    public static function usePartial($name) {

      return 'partial/'.$name.'.php';

    }

    // public static function getDetailColumn($column) {
    //
    // }

    public static function getPostDetail($column,$post) {

      $record = array();
      foreach($column as $key => $value) {
        if($value['input'] == 'file') {
          if(empty($_FILES[$value['name']]['error']))
            $spost = $_FILES[$value['name']]['name'];
        } else {
          $spost = trim($post[$value['name']]);
          $spost = (String) $spost;
        }
        $record[end(explode('.',$value['name']))] = $spost;
      }

      return $record;
    }

    public static function pageInsert($model,$record) {

      $add = $model::recInsert($record);
      if($add == 0) {
        Route::redirect('success','Data Berhasil Ditambah');
      } else if($add == -5) {
        Route::redirect('failed','Data Gagal Ditambah',Route::selfPage());
      }

    }

    public static function pageUpdate($record,$model,$id) {

      $update = $model::recUpdate($model::fillable,$record,$id);
      if($update) {
        Route::redirect('success','Data Berhasil Diubah',Route::selfgetPage());
      } else {
        Route::redirect('failed','Data Gagal Diubah',Route::selfPage());
      }
    }

    public static function pageDelete($model,$id) {

      $delete = $model::recDelete($id);
      if($delete) {
        Route::redirect('success','Data Berhasil Dihapus',Route::selfPage());
      } else {
        Route::redirect('failed','Data Gagal Dihapus',Route::selfPage());
      }
    }
}

 ?>
