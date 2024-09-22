# Rese
概要説明：登録したユーザーがそれぞれの店舗の予約を簡単に行えるアプリ。

トップ画面の画像：http://localhost/?_token=pad0pdCLiNQd2IquHrmi7Bz1NwutG2kB8Se2ol4x

## 作成した目的


## アプリケーションURL
localhost/

## 機能一覧
- 利用者の会員登録
- メール認証
- 店舗代表者の登録
- 店舗代表者の情報の編集
- 店舗代表者検索
- 店舗代表者削除
- 利用者へのメール送信
- 店舗作成
- 店舗削除
- 店舗編集
- 店舗検索
- 予約情報確認
- ログイン機能
- ログアウト機能
- お気に入り登録
- お気に入り削除
- 予約作成
- レビュー作成
- 予約削除
- 予約編集
- QRコード作成
- 決済処理

## 使用技術
- フレームワーク：Laravel8.83.27
- PHP：7.4.9
- Webサーバー：Nginx/1.21.1
- データベース：MySQL8.0.26
- Docker：Docker Compose 3.8

　アプリケーションの実行環境はDockerを使用して構築されています。以下のサービスが'docker-compose.yml'に定義されています。
version: '3.8'

services: // バージョン1.21.1を使用して、Webサーバーとして動作。
    nginx:
        image: nginx:1.21.1
        ports:
            - "80:80"
        volumes:
            - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
            - ./src:/var/www/
        depends_on:
            - php

    php: // PHP環境を提供し、Webサーバーとして動作。
        build: ./docker/php
        volumes:
            - ./src:/var/www/

    mysql: // MySQL8.0.26を使用して、データベース接続を提供。
        image: mysql:8.0.26
        environment:
            MYSQL_ROOT_PASSWORD: root
            MYSQL_DATABASE: laravel_db
            MYSQL_USER: laravel_user
            MYSQL_PASSWORD: laravel_pass
        command:
            mysqld --default-authentication-plugin=mysql_native_password
        volumes:
            - ./docker/mysql/data:/var/lib/mysql
            - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf

    phpmyadmin: // データベースの管理を容易にするためのGUIツール。
        image: phpmyadmin/phpmyadmin
        environment:
            - PMA_ARBITRARY=1
            - PMA_HOST=mysql
            - PMA_USER=laravel_user
            - PMA_PASSWORD=laravel_pass
        depends_on:
            - mysql
        ports:
            - 8080:80
　アプリケーションの環境設定は'.env'ファイルで管理されています。以下のような重要な設定が含まれています。
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:2RuhgDm7apAHtIqcbqzpmk+du/WH03C4Th73YKSq+XY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=hosomitadasi@gmail.com
MAIL_PASSWORD=yylvcsorcyscjthq
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hosomitadasi@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

STRIPE_KEY=pk_test_51PpAOfP5Gj9Ev2BwBU8b8b5dBIsXPslkeofLcumexqr6FTzjPlC6qkJHCmkGcvfMgQyPwFCyvU5Z6qiyHYDjfbVS00uq6mHVFz
STRIPE_SECRET=sk_test_51PpAOfP5Gj9Ev2BwpYi8svYtdhgqNv3Oe3iXt2dFbK8dDMTAgmOXQPSAb38vuvrLsSnj085Ht5P5wM0cYmZkpKgv00RkUdjPy7

## ER図
Rese.dio
