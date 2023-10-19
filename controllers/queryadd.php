<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Parameter Example</title>
    <script type="text/javascript" src="/ncmb.min.js" charset="utf-8"></script>
</head>
<body>
<h1 class="topics">デビコインの購入ありがとうございました！</h1>
<?php
    // クエリパラメータを取得
    if (isset($_GET['query'])) {
        $query = $_GET['query'];
        echo '<p>クエリパラメータ: ' . htmlspecialchars($query) . '</p>';

        // JavaScriptに渡すために変数に代入
        echo '<script>';
        echo 'var queryParam = ' . json_encode($query) . ';';
        echo '</script>';
    } else {
        echo '<p>クエリパラメータがありません。</p>';
    }
?>

<script type="text/javascript">
    var ncmb = new NCMB(window.atob('MGJiNDBkYzI3M2NkNjUxMjMzYTk4ZDI1MDk1MjRhMTQzYjk4NmNjNzM0NDk4MmJkYjdlMGQ1M2U1ZGFmYjNiOA=='), window.atob('ZWZiOTdkZGE0ZjA2MGUxNjg4OWIyNjRmOGEzNGI5NzcyODc4NTM5MWUzNmY4N2IyNGEyMDliNTcyZmJmOTc0NQ=='));
    
    // JavaScriptでの変数の利用例
    if (typeof queryParam !== 'undefined') {
        console.log('JavaScriptでのクエリパラメータ:', queryParam);

        var iptmp = "";
        var addresstmp ="";
        var ipobj = null;
        var adsobj =null;
        var querynum = parseFloat(queryParam);

        fetch('https://ipinfo.io?callback')
        .then(res => res.json())
        .then(json => {
            iptmp = json.ip;

            var BuyClass = ncmb.DataStore("BuyClass");
            return BuyClass.equalTo("ip", iptmp).order("ip", true).fetchAll();
        })
        .then(results => {
            for (var i = 0; i < results.length; i++) {
                var object = results[i];
                if (object.get("ip") === iptmp) {
                    ipobj = results[i];
                    addresstmp = ipobj.get("address");
                }
            }
            if (ipobj === null) {
                console.log('取得できる獲得デビコインが見当たりませんでした');
                // 最低保証の10デビコインを関数から付与
            } else {
                return AdDevCoin(querynum);
            }
        })
        .then(result => {
            ipobj.delete()
            .then(function(result){
                console.log(result); // true
            })
            .catch(function(err){
                // エラー処理
            });
        })
        .catch(err => {
            console.log('取得でエラーが発生しました', err);
        });

        function AdDevCoin(num) {
            var AdsClass = ncmb.DataStore("AdsClass");
            return AdsClass.equalTo("mpurseAddress", addresstmp).order("mpurseAddress", true).fetchAll()
            .then(results => {
                for (var i = 0; i < results.length; i++) {
                    var object = results[i];
                    if (object.get("mpurseAddress") === addresstmp) {
                        adsobj = results[i];
                        var tmpcoin = adsobj.get("adsCoin");
                        var tmpprice = tmpcoin + num;
                        adsobj.set("adsCoin", tmpprice);
                        return adsobj.update();
                    }
                }
            })
            .then(adsobj => {
                alert(num+'デビコインが購入されました！\nありがとうございます！（ ´∀｀）\n*このページはすぐに閉じても構いません。');
            })
            .catch(err => {
                console.log('取得でエラーが発生しました', err);
            });
        }
    } else {
        console.log('クエリパラメータはありません。');
    }
</script>

</body>
</html>
