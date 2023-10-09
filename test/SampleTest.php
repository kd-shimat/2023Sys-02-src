
<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\WebDriverBy;

class SampleTest extends TestCase
{
    protected $pdo; // PDOオブジェクト用のプロパティ(メンバ変数)の宣言
    protected $driver;

    public function setUp(): void
    {
        // PDOオブジェクトを生成し、データベースに接続
        $dsn = "mysql:host=db;dbname=shop;charset=utf8";
        $user = "shopping";
        $password = "site";
        try {
            $this->pdo = new PDO($dsn, $user, $password);
        } catch (Exception $e) {
            echo 'Error:' . $e->getMessage();
            die();
        }

        #XAMPP環境で実施している場合、$dsn設定を変更する必要がある
        //ファイルパス
        $rdfile = __DIR__ . '/../src/classes/dbdata.php';
        $val = "host=db;";

        //ファイルの内容を全て文字列に読み込む
        $str = file_get_contents($rdfile);
        //検索文字列に一致したすべての文字列を置換する
        $str = str_replace("host=localhost;", $val, $str);
        //文字列をファイルに書き込む
        file_put_contents($rdfile, $str);

        // chrome ドライバーの起動
        $host = 'http://172.17.0.1:4444/wd/hub'; #Github Actions上で実行可能なHost
        // chrome ドライバーの起動
        $this->driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
    }

    public function testCart()
    {
        // 指定URLへ遷移 (Google)
        $this->driver->get('http://php/src/index.php');

        // トップページ画面のpcリンクをクリック
        $element_a = $this->driver->findElements(WebDriverBy::tagName('a'));
        $element_a[4]->click();

        // ジャンル別商品一覧画面の詳細リンクをクリック
        $element_a = $this->driver->findElements(WebDriverBy::tagName('a'));
        $element_a[4]->click();

        // 商品詳細画面の注文数を「2」にし、「カートに入れる」をクリック
        $selector = $this->driver->findElement(WebDriverBy::tagName('select'));
        $selector->click();
        $this->driver->getKeyboard()->sendKeys("2");
        $selector->click();
        $selector->submit();

        //データベースの値を取得
        $sql = 'select items.ident, items.name, items.maker, items.price, cart.quantity, 								
        items.image, items.genre from cart join items on cart.ident = items.ident where items.ident = ?';       // SQL文の定義
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([1]);
        $cart = $stmt->fetch();

        // assert
        $this->assertEquals(2, $cart['quantity'], 'カート追加処理に誤りがあります。');


        // カート画面の注文数を「5」にし、「カートに入れる」をクリック
        $selector = $this->driver->findElement(WebDriverBy::tagName('select'));
        $selector->click();
        $this->driver->getKeyboard()->sendKeys("5");
        $selector->click();
        $selector->submit();

        //データベースの値を取得
        $sql = 'select items.ident, items.name, items.maker, items.price, cart.quantity, 								
        items.image, items.genre from cart join items on cart.ident = items.ident where items.ident = ?';       // SQL文の定義
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([1]);
        $cart = $stmt->fetch();

        // assert
        $this->assertEquals(5, $cart['quantity'], 'カート追加処理に誤りがあります。');

        // カート画面のinputタグの要素を取得
        $element_form = $this->driver->findElements(WebDriverBy::tagName('form'));
        $element_form[1]->submit();

        //データベースの値を取得
        $sql = 'select items.ident, items.name, items.maker, items.price, cart.quantity, 								
        items.image, items.genre from cart join items on cart.ident = items.ident';     // SQL文の定義
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([]);
        $count = $stmt->rowCount();    // レコード数の取得

        // assert
        $this->assertEquals(0, $count, 'カート削除処理に誤りがあります。');
    }
}
