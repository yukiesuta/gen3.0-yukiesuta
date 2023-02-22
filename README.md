# 請求書送信機能
1. docker-compose up -d
2. docker compose exec php bash
3. php artisan command:sendInvoice
4. mailhog開いて直近のメールを開いてMIMEを押してpdfをダウンロード

# seederが存在しない
1. php artisan optimize:clear
2. composer dump-autoload

# 請求書送信しようとするとtrying to get 'email' of a non-object,mpdf not found
1. composer install
2. php artisan optimize:clear


# 環境構築手順

1. `git clone git@github.com:posse-ap/hackathon-202202-sample.git`

2. `cd hackathon-202202-sample`

3. `cp ./src/.env.dev ./src/.env`

3. `docker-compose build --pull`

4. `docker-compose up -d`

5. `docker-compose exec php bash`

6. `cd ichiichiban`

7. `composer install`

8. `php artisan migrate:refresh --seed`

9. `npm install`

10. `npm run dev`

11. Please try to access `http://localhost:80`


# シーダー実行後のログインできるサンプルユーザー

```
管理者1
admin1@gmail.com
password

管理者2
admin2@gmail.com
password

user1（購入者）
user1@gmail.com
password

user2（購入者）
user2@gmail.com
password

ドライバー1
delivery_agent1@gmail.com
password

ドライバー2
delivery_agent2@gmail.com
password

ドライバー3
delivery_agent3@gmail.com
password

ドライバー4
delivery_agent4@gmail.com
password
```


# メール確認
ブラウザで `http://localhost:8025/` にアクセスしてください、メールボックスが表示されます
所定のURLに飛ぶと先月分の請求書PDFを各userに送信します

# スラック通知
注文後に管理者に通知がいくように実装してあります
