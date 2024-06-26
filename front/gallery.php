<?php
// 檢查$_GET來判斷當前是否有按版面類型或使用者來進行分類，並取得符合分類條件的資料筆數來進行分頁計算
$total;
if(isset($_GET['type'])) $total = $Gallery->count(['type_id'=>$_GET['type']]);
else if(isset($_GET['user'])) $total = $Gallery->count(['user'=>$_GET['user']]);
else $total = $Gallery->count();
// 每頁最大顯示20張圖片
$pageCount = ceil($total / 20);
$currentPage = (isset($_GET['p']) && $_GET['p']<=$pageCount? $_GET['p']:1);
$start = ($currentPage-1) * 20;
$end = ($currentPage==$pageCount? $total:$currentPage*20);

$orderDate = $_GET;
$orderDate['order'] = "id";
$orderLike = $_GET;
$orderLike['order'] = "like_count";

$order = "id";
if(isset($_GET['order']) && in_array($_GET['order'], ["id", "like_count"])) $order = $_GET['order'];
$option = "order by `$order` desc limit $start,20";

// getUrl function in ./api/db.php
?>

<div class="container">
    <div class="d-flex justify-content-center">
        <a class="btn <?=$order=='id'?"btn-warning":"btn-secondary"?> m-3" href="<?=getUrl($orderDate)?>">最新上傳</a>
        <a class="btn <?=$order=='like_count'?"btn-warning":"btn-secondary"?> m-3" href="<?=getUrl($orderLike)?>">最多人喜歡</a>
    </div>

    <?php
    // 檢查$_GET來判斷當前是否有按版面類型或使用者來進行分類，並取得符合分類條件的所有資料
    $gallerys;
    if(isset($_GET['type'])) $gallerys = $Gallery->searchAll(['type_id'=>$_GET['type']], $option);
    else if(isset($_GET['user'])) $gallerys = $Gallery->searchAll(['user'=>$_GET['user']], $option);
    else $gallerys = $Gallery->searchAll([], $option);

    $user = "";
    if(isset($_SESSION['user'])) $user = $_SESSION['user'];
    $index = 0;
    if($total > 0){
        // 使用巢狀迴圈印出5列，每列4個圖片
        for($i=0; $i<5; $i++){
            echo "<div class='row'>";
            for($j=0; $j<4; $j++){
                $gallery = $gallerys[$index];
                $like = 'fa-regular';
                if(strlen($user)>0 && $GalleryLike->count(['gallery_id'=>$gallery['id'], 'user'=>$user])) $like = 'fa-solid';
                echo "
                <div class='col-12 col-md-3 gallery-grid' data-id='{$gallery['id']}' data-user='"
                    .(isset($_SESSION['user'])? $_SESSION['user']:"")."'>
                    <img class='gallery-img' src='./gallery/{$gallery['img']}'>
                    <div class='gallery-info'>
                        <div class='gallery-title ps-2'>{$gallery['title']}</div>
                        <div class='gallery-user ps-2'>{$gallery['user']}</div>
                        <div class='gallery-like' id='gallery-{$gallery['id']}'>
                            <i class='$like fa-heart'></i>
                            <span class='like-count'>{$gallery['like_count']}</span>
                        </div>
                    </div>
                </div>
                ";

                $index++;
                if($index >= count($gallerys)) break;
            }
            echo "</div>";
            if($index >= count($gallerys)) break;
        }
    }
    // 如果總頁數大於1，印出分頁按鈕
    if($pageCount > 1){
        echo "<div class='container text-center'>";
        for($i=1; $i<=$pageCount; $i++){
            $target = "";
            if(isset($_GET['type'])) $target = "&type={$_GET['type']}";
            else if(isset($_GET['user'])) $target = "&user={$_GET['user']}";
            $btn = ($i==$currentPage? "btn-primary":"btn-secondary");
            $page = $_GET;
            $page['p'] = $i;
            echo "<a class='btn $btn m-2' href='".(getUrl($page))."'>$i</a>";
        }
        echo "</div>";
    }
    ?>
</div>

