-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: db
-- Thời gian đã tạo: Th12 10, 2021 lúc 12:18 PM
-- Phiên bản máy phục vụ: 8.0.27
-- Phiên bản PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `article_app`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `articles`
--

CREATE TABLE `articles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_id` bigint DEFAULT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_view` bigint UNSIGNED NOT NULL DEFAULT '0',
  `author_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `articles`
--

INSERT INTO `articles` (`id`, `title`, `thumbnail_id`, `content`, `page_view`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 'Raspberry Pi財団が2021年10月28日に新製品「Raspberry Pi Zero 2 W」を発表、スイッチサイエンスウェブショップでも近く発売予定', 1, 'Raspberry Pi財団は、2021年10月28日にRaspberry Pi製品の中でも小型で手頃なRaspberry Pi Zeroファミリーの最新製品として「Raspberry Pi Zero 2 W」を発表しました。 本製品は、512 MBのRAMと、1 GHz駆動の64 bit Arm Cortex-A53 クアッドコア BCM2710A1を中心としたRaspberry Pi RP3A0 SiPを搭載しており、従来のRaspberry Pi Zeroと比べてシングルスレッド性能が40%、マルチスレッド性能が5倍向上しています。また、2.4 GHz 802.11 b/g/nワイヤレスLANとBluetooth 4.2 / Bluetooth Low Energy（BLE）が利用可能です。 本製品は2021年10月28日現在、工事設計認証を取得していないため、株式会社スイッチサイエンス（本社：東京都新宿区、代表取締役：金本茂）では、工事設計認証を取得され次第取り扱いを開始します。', 0, 1, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(2, 'スマホアプリ『リーグ・オブ・レジェンド：ワイルドリフト』10月28日でサービス開始から1周年！「ワイリフ1周年記念祭」を11月1日～11月30日に開催', 2, 'Riot Games, Inc.（米国）の日本法人である合同会社ライアットゲームズ（港区六本木、社長/CEO：小宮山 真司）は、スマホ向け（Android / iOS）タイトルの異世界マルチバトル「リーグ・オブ・レジェンド：ワイルドリフト」（以下、ワイルドリフト）が本日10月28日に1周年を迎えることを記念して、「ワイリフ1周年記念祭」を2021年11月1日（月）から11月30日（火）まで開催します。「ワイリフ1周年記念祭」では、ワイルドリフトをプレイして抽選券を貯め、毎週行われる抽選をすることでワイリフ限定グッズやインゲームアイテムが当たる「抽選キャンペーン」や、10万円の賞金サポートする認定大会の開催、公式Twitterでのキャンペーンなどなど、さまざまな企画を実施します。 ワイルドリフトをプレイして抽選券を貯め、毎週行われる抽選をすることでワイリフ限定グッズやインゲームアイテムが当たります。', 0, 1, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(3, '日向坂46 佐々木美玲がパーソナリティ！リスナーの一週間の疲れを癒やすラジオ番組、始動！『星のドラゴンクエスト presents 日向坂46 佐々木美玲のホイミーぱん』', 3, 'この番組は、10月29日（金）までレギュラー放送をしていた番組『星のドラゴンクエスト presents 日向坂46 小坂菜緒の「小坂なラジオ」』でも代演パーソナリティとして放送を盛り上げてきた日向坂46 佐々木美玲がパーソナリティをつとめ、装いを新たにスタートする番組です。日向坂46のメンバーとして活動する傍ら、雑誌専属モデル、女優、情報番組リポーターとしても活躍している「みーぱん」こと、佐々木美玲が、ゲーム『ドラゴンクエスト』に登場する回復系呪文「ホイミ」のように、「一週間の疲れを癒やす」ことを番組コンセプトに、普段は聴くことのできない素のトークもお届けしていきます。 番組への意気込みを佐々木美玲は、「ラジオの出演経験が少なかったので、最初は不安だったのですが、回数を重ねていくうちに『あっ、私お喋りするの好きだな』って気持ちになり、今は楽しくさせていただいています。『ホイミーぱん』では、新しいコーナーも始まるので、楽しみにしていてください。そして私も、今ハマっている『星ドラ』の主人公と、リスナーの皆さんと共に成長出来ればなと思います。お仕事や学校など1週間の疲れを癒せるよう、ホイミの呪文をかけられるような番組にしていきたいと思います。」と語りました。 さらに、番組では新コーナー「教えて！ガイアス」もスタート。『星のドラゴンクエスト』にまつわるゲーム知識を、初心者にもわかりやすくお伝えします。１１月5日（金）の初回放送を、お楽しみに！', 0, 2, '2021-12-10 12:14:38', '2021-12-10 12:14:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `article_categories`
--

CREATE TABLE `article_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `article_categories`
--

INSERT INTO `article_categories` (`id`, `article_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(2, 1, 2, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(3, 1, 3, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(4, 2, 4, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(5, 2, 5, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(6, 2, 6, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(7, 3, 7, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(8, 3, 8, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(9, 3, 9, '2021-12-10 12:14:38', '2021-12-10 12:14:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `authors`
--

CREATE TABLE `authors` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `birthday` date DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `authors`
--

INSERT INTO `authors` (`id`, `email`, `username`, `fullname`, `password`, `avatar`, `address`, `birthday`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'mrahn1234@gmail.com', 'mrahn1234', 'Hoang Tu Le', '$2y$10$7tv4THkCKZppElV1v/N7quzDCol7mpSZf5Kbvkja0dlb8/mfmT366', '', 'Trung Nu Vuong', '1998-01-07', '0774444770', '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(2, 'admin@gmail.com', 'adminn', 'Admin ne', '$2y$10$inAb/4No7Se5XG5J0OOFHe9DpDUwE5YYP.6oNBtydUvS2zE4YZhqS', '', 'Le Cao Lang', '1998-01-07', '0774444779', '2021-12-10 12:14:38', '2021-12-10 12:14:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'モバイル', NULL, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(2, 'アプリ', NULL, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(3, 'エンタメ', NULL, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(4, 'ビューティー', NULL, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(5, 'ファッション', NULL, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(6, 'ライフスタイル', NULL, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(7, 'ビジネス', NULL, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(8, 'グルメ', NULL, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(9, 'スポーツ', NULL, '2021-12-10 12:14:38', '2021-12-10 12:14:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `images`
--

CREATE TABLE `images` (
  `id` bigint UNSIGNED NOT NULL,
  `src` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `images`
--

INSERT INTO `images` (`id`, `src`, `article_id`, `created_at`, `updated_at`) VALUES
(1, 'article-1.jpg', 1, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(2, 'article-2.png', 2, '2021-12-10 12:14:38', '2021-12-10 12:14:38'),
(3, 'article-3.jpg', 3, '2021-12-10 12:14:38', '2021-12-10 12:14:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_12_09_051322_create_authors_table', 1),
(5, '2021_12_09_051454_create_articles_table', 1),
(6, '2021_12_09_052731_create_images_table', 1),
(7, '2021_12_09_052845_create_categories_table', 1),
(8, '2021_12_09_053016_create_article_categories_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `birthday` date DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articles_author_id_foreign` (`author_id`);

--
-- Chỉ mục cho bảng `article_categories`
--
ALTER TABLE `article_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `authors_email_unique` (`email`),
  ADD UNIQUE KEY `authors_username_unique` (`username`),
  ADD UNIQUE KEY `authors_phone_unique` (`phone`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_article_id_foreign` (`article_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `article_categories`
--
ALTER TABLE `article_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`);

--
-- Các ràng buộc cho bảng `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
