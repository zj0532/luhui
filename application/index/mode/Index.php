<?php
namespace app\index\mode;
use think\Db;

class Index {

  public function get_news_list(){
    $result = [];
     $sql = "SELECT * FROM base_news   ORDER BY ns_intime DESC ";
      $result["xinwen"]= Db::name('base_news')->order('ns_intime','desc')->paginate(8);

     $result["banner2"] = Db::query($sql);
     $result["banner_count"] = [];
     $banner_count = count($result["banner2"]);
     for($dd =0;$dd < $banner_count;$dd++) {
         $result["banner_count"][] = $dd + 1;
     }
    return $result;
  }

  public function get_news_info($news_id){
    $result = [];
 
     $sql = "SELECT * FROM base_news WHERE ns_id =  '$news_id'  ORDER BY ns_intime DESC";
     $result = Db::query($sql);

//     $result["banner2"] = Db::query($sql);
//     $result["banner_count"] = [];
//     $banner_count = count($result["banner2"]);
//     for($dd =0;$dd < $banner_count;$dd++){
//       $result["banner_count"][] = $dd+1;
//     }
    return $result;
  }

    //banner
    public function get_banner(){
        $sql = "SELECT * FROM base_banner  ORDER BY bn_order DESC ";
        $result = Db::query($sql);
        return $result;
    }

}
?>
