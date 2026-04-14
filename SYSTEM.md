# 社工師公會管理系統 — 系統功能說明文件

> **框架**：Laravel 12 ／ **PHP**：8.5+（Homebrew）／ **資料庫**：MySQL 8.0（MAMP port 8889）
> **開發伺服器**：`php artisan serve` → http://127.0.0.1:8000
> **最後更新**：2026-03-12

---

## 目錄

1. [專案概覽](#1-專案概覽)
2. [技術架構](#2-技術架構)
3. [資料庫設計](#3-資料庫設計)
4. [資料表詳細說明](#4-資料表詳細說明)
5. [狀態機設計](#5-狀態機設計)
6. [測試資料](#6-測試資料)
7. [路由規劃（待實作）](#7-路由規劃待實作)
8. [功能模組規劃](#8-功能模組規劃)
9. [環境設定](#9-環境設定)
10. [常用指令](#10-常用指令)

---

## 1. 專案概覽

本系統為 **台灣社工師公會** 後台管理平台，提供以下核心功能：

| 模組 | 說明 | 狀態 |
|------|------|------|
| 使用者管理 | 管理員、社工師會員、一般訪客三種角色 | DB 完成 |
| 最新消息 | 公告、活動、會員福利發布管理 | DB 完成 |
| 繼續教育課程 | 課程開設、報名管理、積分時數紀錄 | DB 完成 |
| 課程預約 | 報名流程、狀態機管理、付款追蹤 | DB 完成 |
| 前台頁面 | 公開查詢、會員登入報名 | 待實作 |

---

## 2. 技術架構

```
ai-socialwork-assoc/
├── app/
│   ├── Http/
│   │   └── Controllers/          # 控制器（待新增）
│   └── Models/
│       └── User.php              # 使用者模型（已設定）
├── database/
│   ├── migrations/               # 6 個 migration（全部完成）
│   ├── seeders/                  # 4 個 Seeder（全部完成）
│   └── factories/
│       └── UserFactory.php
├── resources/
│   └── views/
│       └── welcome.blade.php     # 預設首頁
├── routes/
│   └── web.php                   # 僅首頁路由
├── .env                          # 環境設定
└── composer.json                 # Laravel 12, PHP ^8.2
```

### 相依套件

| 套件 | 版本 | 用途 |
|------|------|------|
| laravel/framework | ^12.0 | 核心框架 |
| laravel/tinker | ^2.10.1 | 互動式 REPL |
| fakerphp/faker | ^1.23 | 測試假資料 |
| laravel/pint | ^1.24 | 程式碼風格修正 |
| phpunit/phpunit | ^11.5.3 | 單元測試 |

---

## 3. 資料庫設計

### ER Diagram（文字版）

```
users ─┬──< news           (一對多：使用者發布公告)
       ├──< courses         (一對多：使用者建立課程)
       └──< reservations    (一對多：使用者報名課程)

courses ──< reservations    (一對多：課程包含多筆預約)

reservations.confirmed_by → users.id   (外鍵：確認的管理員)
reservations.cancelled_by → users.id   (外鍵：取消的操作者)
```

### 資料表清單

| 資料表 | 說明 | SoftDelete |
|--------|------|------------|
| users | 使用者帳號 | 否 |
| password_reset_tokens | 密碼重設 Token | 否 |
| sessions | 登入 Session | 否 |
| cache / cache_locks | 快取 | 否 |
| jobs / job_batches / failed_jobs | 佇列任務 | 否 |
| news | 最新消息 | 是 |
| courses | 繼續教育課程 | 是 |
| reservations | 課程預約 | 否 |

---

## 4. 資料表詳細說明

### 4.1 users — 使用者

| 欄位 | 型別 | 預設 | 說明 |
|------|------|------|------|
| id | bigint PK | auto | 主鍵 |
| name | varchar(255) | — | 姓名 |
| email | varchar(255) unique | — | 電子郵件 |
| email_verified_at | timestamp | null | Email 驗證時間 |
| password | varchar(255) | — | 密碼（bcrypt hashed） |
| phone | varchar(20) | null | 聯絡電話 |
| role | enum | guest | 角色：admin / member / guest |
| license_number | varchar(50) | null | 社工師證號 |
| avatar | varchar(255) | null | 頭像圖片路徑 |
| is_active | boolean | true | 帳號是否啟用 |
| remember_token | varchar(100) | null | 記住我 Token |
| created_at / updated_at | timestamp | — | 時間戳記 |

**角色說明**

| role | 中文 | 說明 |
|------|------|------|
| admin | 管理員 | 系統全權管理 |
| member | 社工師會員 | 持有社工師證號，可參加課程、享有福利 |
| guest | 一般訪客 | 瀏覽公開資訊，尚未加入會員 |

---

### 4.2 news — 最新消息

| 欄位 | 型別 | 預設 | 說明 |
|------|------|------|------|
| id | bigint PK | auto | 主鍵 |
| user_id | bigint FK | — | 發布者（→ users） |
| title | varchar(255) | — | 標題 |
| excerpt | varchar(255) | null | 摘要 |
| content | longText | — | 內容（支援 HTML） |
| thumbnail | varchar(255) | null | 封面圖片路徑 |
| category | enum | announcement | 分類 |
| is_published | boolean | false | 是否發布 |
| published_at | timestamp | null | 發布時間 |
| view_count | integer | 0 | 瀏覽次數 |
| created_at / updated_at | timestamp | — | 時間戳記 |
| deleted_at | timestamp | null | 軟刪除 |

**分類（category）**

| 值 | 中文 | 說明 |
|----|------|------|
| announcement | 公告 | 重要通知、系統訊息 |
| activity | 活動 | 公益論壇、研討會等 |
| welfare | 會員福利 | 保險方案、優惠訊息 |
| other | 其他 | 不符合上述分類 |

**索引**：`[is_published, published_at]`、`[category]`

---

### 4.3 courses — 繼續教育課程

| 欄位 | 型別 | 預設 | 說明 |
|------|------|------|------|
| id | bigint PK | auto | 主鍵 |
| user_id | bigint FK | — | 建立者/主辦人（→ users） |
| title | varchar(255) | — | 課程名稱 |
| description | text | null | 課程說明 |
| instructor | varchar(255) | null | 講師姓名 |
| location | varchar(255) | null | 上課地點 |
| start_at | timestamp | — | 開始時間 |
| end_at | timestamp | — | 結束時間 |
| max_participants | uint | 30 | 招收人數上限 |
| registered_count | uint | 0 | 已報名人數（快取值） |
| price | decimal(10,2) | 0.00 | 費用（0 = 免費） |
| credit_hours | tinyUint | 0 | 繼續教育時數（換照積分） |
| status | enum | draft | 課程狀態 |
| cancel_reason | text | null | 取消原因 |
| created_at / updated_at | timestamp | — | 時間戳記 |
| deleted_at | timestamp | null | 軟刪除 |

**課程狀態（status）**

| 值 | 中文 | 說明 |
|----|------|------|
| draft | 草稿 | 尚未開放，規劃中 |
| open | 開放報名 | 可接受報名 |
| closed | 截止報名 | 已達人數上限或截止日到期 |
| cancelled | 已取消 | 課程取消，需填寫取消原因 |

**索引**：`[status, start_at]`

---

### 4.4 reservations — 課程預約

| 欄位 | 型別 | 預設 | 說明 |
|------|------|------|------|
| id | bigint PK | auto | 主鍵 |
| user_id | bigint FK | — | 報名者（→ users） |
| course_id | bigint FK | — | 報名課程（→ courses） |
| status | enum | pending | 報名狀態（狀態機） |
| confirmed_at | timestamp | null | 確認時間 |
| cancelled_at | timestamp | null | 取消時間 |
| attended_at | timestamp | null | 出席時間 |
| no_show_at | timestamp | null | 缺席標記時間 |
| confirmed_by | bigint FK | null | 確認者管理員（→ users） |
| cancelled_by | bigint FK | null | 取消操作者（→ users） |
| cancel_reason | varchar(255) | null | 取消原因 |
| notes | text | null | 備註（報名者填寫） |
| payment_status | enum | unpaid | 付款狀態 |
| paid_at | timestamp | null | 付款時間 |
| created_at / updated_at | timestamp | — | 時間戳記 |

**付款狀態（payment_status）**

| 值 | 中文 |
|----|------|
| unpaid | 未付款 |
| paid | 已付款 |
| refunded | 已退款 |
| exempt | 免費/豁免 |

**唯一約束**：`[user_id, course_id]`（同一人不可重複報名同一課程）
**索引**：`[course_id, status]`、`[user_id, status]`

---

## 5. 狀態機設計

### 5.1 課程預約狀態機

```
                  管理員確認
  pending ──────────────────→ confirmed
     │                            │
     │ 使用者/管理員取消           ├──→ attended   (管理員標記出席)
     ↓                            │
  cancelled ←─────────────────── ├──→ no_show    (管理員標記缺席)
                 確認後取消        │
                                  ↓
                              cancelled          (需填寫取消原因)
```

**合法狀態轉換**

| 從 | 到 | 操作者 | 條件 |
|----|----|--------|------|
| pending | confirmed | 管理員 | 課程仍 open，且未達人數上限 |
| pending | cancelled | 使用者 / 管理員 | 任何時間可取消 |
| confirmed | attended | 管理員 | 課程結束後標記 |
| confirmed | no_show | 管理員 | 課程結束後標記 |
| confirmed | cancelled | 管理員 | 需填寫 cancel_reason |

**防呆機制**
- 各狀態對應獨立時間欄位（`confirmed_at`、`cancelled_at` 等），可驗證轉換合法性
- 資料庫層唯一約束確保不重複報名
- `registered_count` 為快取值，確認報名時 +1，取消時 -1

---

### 5.2 課程狀態流

```
draft ──→ open ──→ closed
              └──→ cancelled
```

---

## 6. 測試資料

執行指令：`php artisan migrate:fresh --seed`

### 使用者帳號

| 姓名 | Email | 密碼 | 角色 |
|------|-------|------|------|
| 系統管理員 | admin@socialwork.org.tw | password | admin |
| 陳雅婷 | yating.chen@example.com | password | member（SW-001234） |
| 林志明 | chiaming.lin@example.com | password | guest |

### 消息公告（3 筆）

| 標題 | 分類 | 狀態 |
|------|------|------|
| 114年度社工師繼續教育課程報名開始 | announcement | 已發布（128 次瀏覽） |
| 【活動】世界社工日公益論壇報名 | activity | 已發布（256 次瀏覽） |
| 會員福利｜職業責任險團體投保方案更新 | welfare | 草稿（未發布） |

### 課程（3 門）

| 課程名稱 | 費用 | 時數 | 狀態 |
|----------|------|------|------|
| 家庭暴力防治與社工實務工作坊 | NT$500 | 6h | open（12/30人） |
| 社區工作與倡議策略進階研習 | 免費 | 3h | open（3/50人） |
| 老人保護個案評估與處遇 | NT$800 | 6h | draft |

### 預約記錄（3 筆）

| 報名者 | 課程 | 狀態 | 付款 |
|--------|------|------|------|
| 陳雅婷 | 家庭暴力防治工作坊 | confirmed | paid |
| 陳雅婷 | 社區工作進階研習 | pending | unpaid |
| 林志明 | 家庭暴力防治工作坊 | cancelled（臨時有事） | unpaid |

---

## 7. 路由規劃（待實作）

### 前台（Public）

```
GET  /                    首頁
GET  /news                消息列表
GET  /news/{id}           消息詳情
GET  /courses             課程列表
GET  /courses/{id}        課程詳情
```

### 會員（Auth Required）

```
GET  /dashboard           會員儀表板
GET  /my/reservations     我的報名紀錄
POST /courses/{id}/reserve  報名課程
DELETE /reservations/{id}   取消報名
```

### 管理後台（Admin Only）

```
# 消息管理
GET    /admin/news           消息列表
POST   /admin/news           新增消息
PUT    /admin/news/{id}      修改消息
DELETE /admin/news/{id}      刪除消息

# 課程管理
GET    /admin/courses         課程列表
POST   /admin/courses         新增課程
PUT    /admin/courses/{id}    修改課程
DELETE /admin/courses/{id}    刪除課程

# 報名管理
GET    /admin/reservations                     所有報名
PUT    /admin/reservations/{id}/confirm        確認報名
PUT    /admin/reservations/{id}/cancel         取消報名
PUT    /admin/reservations/{id}/mark-attended  標記出席
PUT    /admin/reservations/{id}/mark-no-show   標記缺席

# 使用者管理
GET    /admin/users           使用者列表
PUT    /admin/users/{id}      修改使用者
```

---

## 8. 功能模組規劃

### 8.1 已完成

- [x] 資料庫 Migration（6 張表）
- [x] 測試資料 Seeder（4 個）
- [x] User Model（含 fillable / casts / hidden）
- [x] 狀態機設計文件（reservations）

### 8.2 待實作

**Models**
- [ ] `News` Model（含關聯：belongsTo User、scopePublished）
- [ ] `Course` Model（含關聯：belongsTo User、hasMany Reservations）
- [ ] `Reservation` Model（含狀態機方法、關聯）

**Controllers**
- [ ] `Auth/LoginController` — 登入/登出
- [ ] `NewsController` — 前台消息
- [ ] `CourseController` — 前台課程
- [ ] `ReservationController` — 報名操作
- [ ] `Admin/NewsController` — 後台消息管理
- [ ] `Admin/CourseController` — 後台課程管理
- [ ] `Admin/ReservationController` — 後台報名管理
- [ ] `Admin/UserController` — 使用者管理

**Views**
- [ ] layouts/app.blade.php（主版型）
- [ ] 首頁
- [ ] 消息列表 / 詳情
- [ ] 課程列表 / 詳情
- [ ] 報名表單
- [ ] 會員儀表板
- [ ] 管理後台頁面群

**其他**
- [ ] Policy（角色權限控制）
- [ ] FormRequest（表單驗證）
- [ ] 報名上限檢查（race condition 防護）

---

## 9. 環境設定

### .env 關鍵設定

```dotenv
APP_NAME=Laravel              # 建議改為：台灣社工師公會
APP_URL=http://localhost:8888

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889                  # MAMP MySQL port
DB_DATABASE=ai_socialwork_assoc
DB_USERNAME=root
DB_PASSWORD=root

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

### 注意事項

- MAMP 最高 PHP 8.3.9，**無法**直接透過 MAMP Apache 跑此專案（vendor 需要 PHP >= 8.4）
- 請使用 `php artisan serve` 啟動（使用 Homebrew PHP 8.5.3）
- 開發網址：**http://127.0.0.1:8000**

---

## 10. 常用指令

```bash
# 啟動開發伺服器
php artisan serve

# 執行 Migration
php artisan migrate

# 重置資料庫並重新填入測試資料
php artisan migrate:fresh --seed

# 只跑測試資料（不重建資料表）
php artisan db:seed

# 開啟 Tinker（互動式 REPL）
php artisan tinker

# 查詢所有路由
php artisan route:list

# 清除快取
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 程式碼風格修正
./vendor/bin/pint
```

---

*此文件由 Claude Code 自動產生，請隨功能實作進度持續更新。*
