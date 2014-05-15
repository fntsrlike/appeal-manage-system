Appeal Manage System (申訴案件管理系統)
---
## CH1: 關於
### 簡述
申訴管理系統是用來處理申訴案件的一個CMS（內容管理器），希望能借由這個系統幫助事務上需要處理申訴案件的單位。本系統是從學權申訴導向為基礎編寫的，並且往不限於學權的彈性的CMS方向發展。

## CH2: 安裝
#### 步驟
- 執行終端指令 `git clone <本專案git位址>` 本專案到指定資料夾
- 將網路伺服器設定根目錄到本專案的public資料夾，或是指定到本專案根目錄的server資料夾。_（註1）_
- 執行終端指令 `composer update` ，更新vendor。_（註1）_
- 編輯 `app/config/app.php` ，將 `url` 參數修改為本專案的根目錄，並且更新 `key` 參數的值。_（註1）_
- 編輯 `app/config/database.php` ，修改資料庫連線參數。_（註1）_
- 編輯 `app/config/appeal.php` ，這是針對本程式客製化的設定檔，請修改裡面的參數以符合您的預期。
- 編輯 `app/config/mail.php` ，修改Email Sever的相關參數。_（註1）_
- 執行終端指令 `php artisan migrate` ，建立資料表。
- 連線到網站，測試是否正常：
    - 是否能正常看到頁面。
    - 到處丟測資，看會不會出現系統錯誤訊息，若有，請檢查是否為伺服器環境的問題。若認為是程式問題，請到本專案的頁面提報Issue。
- 清除各項測資。
- 編輯 `app/config/app.php` ，將 `debug` 參數改為 `false` 。
- 開始運作本網站囉！

#### 備註
1. 詳細請參照 [Laravel Framework][1] 的說明文件。

## CH3: 架構
- 本專案是基於PHP Framework Laravel所建立的CMS。
- 本專案登入系統目前是採用同作者開發的Ilt Member System，作為唯一登入的方式。但考慮日後開發成可以選擇登入方式為Ilt Member System或其他登入方式。
- 本專案是Single-page Application，採用後端經權限檢查後輸出JSON資料，給前端處理。
- 前端目前單純採用 jQuery編寫，日後考慮採用 Backbone.js 作為前端框架。
- 前端目前使用JavaScript編寫，日後考慮改使用CoffeeScript編寫源碼，在編譯成JavaScipt使用。

## CH4: 授權
- 目前本程式尚未選定License。預計會採用GPL 2.0，但還在考量中。
- 本程式在未選定License，本程式基本上遵循下列授權條款：
    - 本程式著作所有權為Fntsrlike所有。
    - 本程式以Open Source對外開放，且不論未來License為何，皆會持續。
    - 使用時請維持網站頁面下方，本專案的聯結與作者名稱。
    - 不允許商業性行為使用。
    - 歡迎使用本專案，並且自行客製化成所需版本。強烈建議修改後維持Open Source。




  [1]: http://laravel.com/
