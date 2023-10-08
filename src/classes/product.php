<?php
// スーパークラスであるDbDataを利用するため													
require_once __DIR__ . '/dbdata.php';  // 「__DIR__」の「__」部分はアンダースコア（ _ ）が2個あり！！		

// Productクラスの宣言													
class  Product  extends  DbData
{
    // 選択されたジャンルの商品を取り出す													
    public  function  getItems($genre)
    {
        $sql  =  "select  *  from  items  where  genre  =  ?";
        $stmt = $this->query($sql,  [$genre]);  // DbDataクラスに定義したquery( )メソッドを実行している		
        $items = $stmt->fetchAll();
        return  $items;  // 抽出した商品データの結果セットを返す		
    }
    // 選択された商品を取り出す														
    public  function  getItem($ident)
    {
        $sql  =  "select  *  from  items  where  ident  =  ?";
        $stmt = $this->query($sql,  [$ident]);
        $item = $stmt->fetch();  // 1件だけ抽出するのでfetch( )メソッドを使用						
        return  $item;  // 抽出した商品データを返す（1件だけ）																			
    }
}
