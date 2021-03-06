-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022 年 2 月 04 日 08:10
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- データベース: `db_local`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `chapter_comments`
--

CREATE TABLE `chapter_comments` (
  `id` int(11) NOT NULL COMMENT 'id',
  `chapter_id` int(11) NOT NULL,
  `comment_name` varchar(100) NOT NULL DEFAULT '通りすがりの佐々木' COMMENT 'コメント名',
  `comment` varchar(1000) NOT NULL COMMENT 'コメント本文',
  `comment_datetime` datetime NOT NULL COMMENT 'コメントした日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `chapter_comments`
--

INSERT INTO `chapter_comments` (`id`, `chapter_id`, `comment_name`, `comment`, `comment_datetime`) VALUES
(29, 1, '通りすがりの佐々木', '面白いです', '2022-01-31 12:06:26'),
(30, 1, '上田大智', 'おもしろし', '2022-01-31 12:06:58'),
(31, 1, '通りすがりの佐々木', '面白かったです', '2022-02-03 08:38:39'),
(32, 1, '上田大智', '面白かったです', '2022-02-03 08:38:51');

-- --------------------------------------------------------

--
-- テーブルの構造 `chapter_votes`
--

CREATE TABLE `chapter_votes` (
  `user_id` int(11) NOT NULL,
  `offered_chapters_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `novels`
--

CREATE TABLE `novels` (
  `id` int(11) NOT NULL COMMENT 'id',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーid照会',
  `novel_title` varchar(100) NOT NULL COMMENT '小説のタイトル',
  `summery` varchar(1000) NOT NULL COMMENT '小説の概要',
  `category` varchar(100) DEFAULT NULL COMMENT '小説のカテゴリー',
  `favorite_count` int(11) NOT NULL DEFAULT '0' COMMENT 'お気に入り登録の人数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `novels`
--

INSERT INTO `novels` (`id`, `user_id`, `novel_title`, `summery`, `category`, `favorite_count`) VALUES
(1, 1, '走れメロス', '羊飼いのメロスは純朴で正義感の強い青年である。彼は妹の結婚式を挙げるため、シラクスの町へ買い物にきた。すると、昔は賑やかだったシラクスはとても寂しく落ち込んでいた。\r\n\r\n　メロスは町の人から、王様が人間不信に陥ったため人々を虐殺しているという事実を聞き、激怒する。邪智暴虐（じゃちぼうぎゃく）の王を暗殺しようと決意した彼は、短剣を携えて城へ侵入するもすぐに捕まる。さらに王に向かって「人の心を疑うのは、最も恥ずべき悪徳だ」と言い放つ。\r\n\r\n　そうして死刑が確定したメロスは、妹のもとに帰って結婚式を挙げてやるために、3日後の日没まで猶予をくれと頼む。そしてセリヌンティウスという親友を人質として王の前に差し出した。人間不信の王は、メロスが親友を裏切って逃げるのもまた見ものだと思い、これを承諾する。', '少年漫画', 0),
(2, 2, '心', '古典文学', '恋愛小説', 0),
(4, 4, 'どうも、勇者の父です。この度は愚息がご迷惑を掛けて、申し訳ありません。　〜幼馴染みの許嫁を捨て、そこらで好き放題やってる息子をぶん殴るために旅に出ます。今更謝ってももう遅い〜', '何か', 'わからん', 0),
(7, 8, '蝿の王', '怖い', 'ホラー', 0),
(10, 9, 'あの日みた', 'あの日見たんです', '恋愛', 0),
(11, 9, '鴨鍋', '鴨南蛮', '鴨鍋', 0),
(12, 9, '髪の毛', '髪の毛', '髪の毛', 0),
(13, 9, 'よなま', '四畳半', '夜中', 0),
(23, 9, '小説始めるよー', 'はじめました', '初心者', 0),
(24, 22, '人魚姫', '1月12日投稿開始\r\n　深い深い海の底に、サンゴの壁と琥珀のまどのお城があります。\r\n　そのお城は、人魚の王さまのお城です。\r\n　王さまには六人の姫がいて、その中でも、とりわけ一番末の姫はきれいでした。\r\n　その肌はバラの花びらのようにすきとおり、目は深い海のように青くすんでいます。', '恋愛', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `novel_chapters`
--

CREATE TABLE `novel_chapters` (
  `id` int(11) NOT NULL COMMENT 'id',
  `novel_id` int(11) NOT NULL COMMENT 'novelsテーブル照会',
  `chapter_title` varchar(100) NOT NULL COMMENT 'チャプターのタイトル',
  `chapter_number` int(11) NOT NULL COMMENT '小説の話数',
  `body` varchar(10000) NOT NULL COMMENT '小説の本文',
  `create_at` datetime NOT NULL COMMENT '投稿日時',
  `update_at` datetime NOT NULL COMMENT '編集日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `novel_chapters`
--

INSERT INTO `novel_chapters` (`id`, `novel_id`, `chapter_title`, `chapter_number`, `body`, `create_at`, `update_at`) VALUES
(1, 1, 'メロスは激怒した', 1, 'メロスは激怒した。必ず、かの邪智暴虐じゃちぼうぎゃくの王を除かなければならぬと決意した。メロスには政治がわからぬ。メロスは、村の牧人である。笛を吹き、羊と遊んで暮して来た。けれども邪悪に対しては、人一倍に敏感であった。きょう未明メロスは村を出発し、野を越え山越え、十里はなれた此このシラクスの市にやって来た。メロスには父も、母も無い。女房も無い。十六の、内気な妹と二人暮しだ。この妹は、村の或る律気な一牧人を、近々、花婿はなむことして迎える事になっていた。結婚式も間近かなのである。メロスは、それゆえ、花嫁の衣裳やら祝宴の御馳走やらを買いに、はるばる市にやって来たのだ。先ず、その品々を買い集め、それから都の大路をぶらぶら歩いた。メロスには竹馬の友があった。セリヌンティウスである。今は此のシラクスの市で、石工をしている。その友を、これから訪ねてみるつもりなのだ。久しく逢わなかったのだから、訪ねて行くのが楽しみである。歩いているうちにメロスは、まちの様子を怪しく思った。ひっそりしている。もう既に日も落ちて、まちの暗いのは当りまえだが、けれども、なんだか、夜のせいばかりでは無く、市全体が、やけに寂しい。のんきなメロスも、だんだん不安になって来た。路で逢った若い衆をつかまえて、何かあったのか、二年まえに此の市に来たときは、夜でも皆が歌をうたって、まちは賑やかであった筈はずだが、と質問した。若い衆は、首を振って答えなかった。しばらく歩いて老爺ろうやに逢い、こんどはもっと、語勢を強くして質問した。老爺は答えなかった。メロスは両手で老爺のからだをゆすぶって質問を重ねた。老爺は、あたりをはばかる低声で、わずか答えた。\r\n「王様は、人を殺します。」\r\n「なぜ殺すのだ。」\r\n「悪心を抱いている、というのですが、誰もそんな、悪心を持っては居りませぬ。」\r\n「たくさんの人を殺したのか。」\r\n「はい、はじめは王様の妹婿さまを。それから、御自身のお世嗣よつぎを。それから、妹さまを。それから、妹さまの御子さまを。それから、皇后さまを。それから、賢臣のアレキス様を。」\r\n「おどろいた。国王は乱心か。」\r\n「いいえ、乱心ではございませぬ。人を、信ずる事が出来ぬ、というのです。このごろは、臣下の心をも、お疑いになり、少しく派手な暮しをしている者には、人質ひとりずつ差し出すことを命じて居ります。御命令を拒めば十字架にかけられて、殺されます。きょうは、六人殺されました。」\r\n　聞いて、メロスは激怒した。「呆あきれた王だ。生かして置けぬ。」\r\n　メロスは、単純な男であった。買い物を、背負ったままで、のそのそ王城にはいって行った。たちまち彼は、巡邏じゅんらの警吏に捕縛された。調べられて、メロスの懐中からは短剣が出て来たので、騒ぎが大きくなってしまった。メロスは、王の前に引き出された。\r\n「この短刀で何をするつもりであったか。言え！」暴君ディオニスは静かに、けれども威厳を以もって問いつめた。その王の顔は蒼白そうはくで、眉間みけんの皺しわは、刻み込まれたように深かった。\r\n「市を暴君の手から救うのだ。」とメロスは悪びれずに答えた。\r\n「おまえがか？」王は、憫笑びんしょうした。「仕方の無いやつじゃ。おまえには、わしの孤独がわからぬ。」\r\n「言うな！」とメロスは、いきり立って反駁はんばくした。「人の心を疑うのは、最も恥ずべき悪徳だ。王は、民の忠誠をさえ疑って居られる。」\r\n「疑うのが、正当の心構えなのだと、わしに教えてくれたのは、おまえたちだ。人の心は、あてにならない。人間は、もともと私慾のかたまりさ。信じては、ならぬ。」暴君は落着いて呟つぶやき、ほっと溜息ためいきをついた。「わしだって、平和を望んでいるのだが。」\r\n「なんの為の平和だ。自分の地位を守る為か。」こんどはメロスが嘲笑した。「罪の無い人を殺して、何が平和だ。」\r\n「だまれ、下賤げせんの者。」王は、さっと顔を挙げて報いた。「口では、どんな清らかな事でも言える。わしには、人の腹綿の奥底が見え透いてならぬ。おまえだって、いまに、磔はりつけになってから、泣いて詫わびたって聞かぬぞ。」\r\n「ああ、王は悧巧りこうだ。自惚うぬぼれているがよい。私は、ちゃんと死ぬる覚悟で居るのに。命乞いなど決してしない。ただ、――」と言いかけて、メロスは足もとに視線を落し瞬時ためらい、「ただ、私に情をかけたいつもりなら、処刑までに三日間の日限を与えて下さい。たった一人の妹に、亭主を持たせてやりたいのです。三日のうちに、私は村で結婚式を挙げさせ、必ず、ここへ帰って来ます。」\r\n「ばかな。」と暴君は、嗄しわがれた声で低く笑った。「とんでもない嘘うそを言うわい。逃がした小鳥が帰って来るというのか。」\r\n「そうです。帰って来るのです。」メロスは必死で言い張った。「私は約束を守ります。私を、三日間だけ許して下さい。妹が、私の帰りを待っているのだ。そんなに私を信じられないならば、よろしい、この市にセリヌンティウスという石工がいます。私の無二の友人だ。あれを、人質としてここに置いて行こう。私が逃げてしまって、三日目の日暮まで、ここに帰って来なかったら、あの友人を絞め殺して下さい。たのむ、そうして下さい。」', '2022-01-12 09:16:06', '2022-01-12 09:16:06'),
(3, 1, '走るのをやめた', 2, '疲れた、、', '2022-01-21 07:50:23', '2022-01-21 07:50:23'),
(5, 10, 'っk', 1, 'm、', '2022-01-21 14:47:01', '2022-01-21 14:47:01'),
(7, 10, ',,', 2, ',,', '2022-01-21 14:51:59', '2022-01-21 14:51:59'),
(8, 12, 'ささ', 1, 'ささ', '2022-01-22 17:34:40', '2022-01-22 17:34:40'),
(9, 10, 'あの日見たんです', 3, 'あの日見たんすよ', '2022-01-22 23:55:54', '2022-01-22 23:55:54'),
(10, 21, 'チャプタータイトる', 1, '小説本文', '2022-01-23 00:09:48', '2022-01-23 00:09:48'),
(11, 22, '小説第一章', 1, '小説本文', '2022-01-23 00:17:03', '2022-01-23 00:17:03'),
(12, 28, '俺たち三羽烏', 1, 'ああああああああああ', '2022-01-27 06:36:31', '2022-01-27 06:36:31'),
(13, 30, '王子救出編', 1, '人魚たちの世界では、十五歳になると海の上の人間の世界を見に行くことを許されていました。　末っ子の姫は、お姉さんたちが見てきた人間の世界の様子を、いつも胸ときめかして聞いています。「ああ、はやく十五歳になって、人間の世界を見てみたいわ」　そうするうちに、一番末の姫もついに十五歳をむかえ、はれて海の上に出る日がきました。　喜んだ姫が上へ上へとのぼっていくと、最初に目に入ったのは大きな船でした。「わあー、すごい。人間て、こんなに大きな物を作るんだ」　人魚姫は船を追いかけると、甲板のすき間から、そっと中をのぞいてみました。　船の中はパーティーをしていて、にぎやかな音楽が流れるなか、美しく着かざった人たちがダンスをしています。　その中に、ひときわ目をひく美しい少年がいました。　それは、パーティーの主役の王子です。　そのパーティーは、王子の十六歳の誕生日を祝う誕生パーティーだったのです。「すてきな王子さま」　人魚姫は夜になっても、うっとりと王子のようすを見つめていました。と、突然、海の景色が変わりました。　稲光が走ると風がふき、波がうねりはじめたのです。「あらしだわ！」　 水夫たちがあわてて帆(ほ)をたたみますが、あらしはますます激しくなると、船は見るまに横倒しになってしまいました。　船に乗っていた人びとが、荒れくるう海に放り出されます。「大変！　王子さまー！」　人魚姫は大急ぎで王子の姿を探しだすと、ぐったりしている王子のからだをだいて、浜辺へと運びました。「王子さま、しっかりして。王子さま！」　人魚姫は王子さまを、けんめいに看病しました。　気がつくと、もう朝になっていました。　そこへ、若い娘が走ってきます。「あっ、いけない」　人魚姫はビックリして、海に身をかくしました。　すると娘は王子に気がついて、あわてて人を呼びました。　王子はそのとき、息をふきかえしました。「あ、ありがとう。あなたが、わたしを助けてくれたのですね」　王子は目の前にいる娘を、命の恩人と勘違いしてしまいました。　人魚姫はションボリして城に帰ってきましたが、どうしても王子のことが忘れられません。「ああ、すてきな王子さま。・・・そうだ、人間になれば、王子さまにまた会えるかもしれない」　そこで魔女(まじょ)のところへ出かけると、人間の女にしてくれるようたのみました。', '2022-01-29 11:42:24', '2022-01-29 11:42:24'),
(14, 30, '王子', 2, '人魚たちの世界では、十五歳になると海の上の人間の世界を見に行くことを許されていました。<br /><br />\r\n末っ子の姫は、お姉さんたちが見てきた人間の世界の様子を、いつも胸ときめかして聞いています。<br /><br />\r\nああ、はやく十五歳になって、人間の世界を見てみたいわ」<br /><br />\r\nそうするうちに、一番末の姫もついに十五歳をむかえ、はれて海の上に出る日がきました。<br /><br />\r\n喜んだ姫が上へ上へとのぼっていくと、最初に目に入ったのは大きな船でした。<br /><br />\r\n「わあー、すごい。人間て、こんなに大きな物を作るんだ」<br /><br />\r\n人魚姫は船を追いかけると、甲板のすき間から、そっと中をのぞいてみました。<br /><br />\r\n船の中はパーティーをしていて、にぎやかな音楽が流れるなか、美しく着かざった人たちがダンスをしています。<br /><br />\r\nその中に、ひときわ目をひく美しい少年がいました。<br /><br />\r\nそれは、パーティーの主役の王子です。<br /><br />\r\nそのパーティーは、王子の十六歳の誕生日を祝う誕生パーティーだったのです。<br /><br />\r\n「すてきな王子さま」<br /><br />\r\n人魚姫は夜になっても、うっとりと王子のようすを見つめていました。<br /><br />\r\nと、突然、海の景色が変わりました。<br /><br />\r\n稲光が走ると風がふき、波がうねりはじめたのです。<br /><br />\r\n「あらしだわ！」<br /><br />\r\n水夫たちがあわてて帆(ほ)をたたみますが、あらしはますます激しくなると、船は見るまに横倒しになってしまいました。<br /><br />\r\n船に乗っていた人びとが、荒れくるう海に放り出されます。<br /><br />\r\n「大変！　王子さまー！」<br /><br />\r\n人魚姫は大急ぎで王子の姿を探しだすと、ぐったりしている王子のからだをだいて、浜辺へと運びました。<br /><br />\r\n「王子さま、しっかりして。王子さま！」<br /><br />\r\n人魚姫は王子さまを、けんめいに看病しました。', '2022-01-29 11:44:39', '2022-01-29 11:44:39'),
(15, 12, ' 王子救出編', 2, '人魚たちの世界では、十五歳になると海の上の人間の世界を見に行くことを許されていました。<br /><br />\r\n末っ子の姫は、お姉さんたちが見てきた人間の世界の様子を、いつも胸ときめかして聞いています。<br /><br />\r\nああ、はやく十五歳になって、人間の世界を見てみたいわ」<br /><br />\r\nそうするうちに、一番末の姫もついに十五歳をむかえ、はれて海の上に出る日がきました。<br /><br />\r\n喜んだ姫が上へ上へとのぼっていくと、最初に目に入ったのは大きな船でした。<br /><br />\r\n「わあー、すごい。人間て、こんなに大きな物を作るんだ」<br /><br />\r\n人魚姫は船を追いかけると、甲板のすき間から、そっと中をのぞいてみました。<br /><br />\r\n船の中はパーティーをしていて、にぎやかな音楽が流れるなか、美しく着かざった人たちがダンスをしています。<br /><br />\r\nその中に、ひときわ目をひく美しい少年がいました。<br /><br />\r\nそれは、パーティーの主役の王子です。<br /><br />\r\nそのパーティーは、王子の十六歳の誕生日を祝う誕生パーティーだったのです。<br /><br />\r\n「すてきな王子さま」<br /><br />\r\n人魚姫は夜になっても、うっとりと王子のようすを見つめていました。<br /><br />\r\nと、突然、海の景色が変わりました。<br /><br />\r\n稲光が走ると風がふき、波がうねりはじめたのです。<br /><br />\r\n「あらしだわ！」<br /><br />\r\n水夫たちがあわてて帆(ほ)をたたみますが、あらしはますます激しくなると、船は見るまに横倒しになってしまいました。<br /><br />\r\n船に乗っていた人びとが、荒れくるう海に放り出されます。<br /><br />\r\n「大変！　王子さまー！」<br /><br />\r\n人魚姫は大急ぎで王子の姿を探しだすと、ぐったりしている王子のからだをだいて、浜辺へと運びました。<br /><br />\r\n「王子さま、しっかりして。王子さま！」<br /><br />\r\n人魚姫は王子さまを、けんめいに看病しました。', '2022-01-29 11:53:09', '2022-01-29 11:53:09'),
(16, 31, '王子救出編', 1, '人魚たちの世界では、十五歳になると海の上の人間の世界を見に行くことを許されていました。<br /><br />\r\n末っ子の姫は、お姉さんたちが見てきた人間の世界の様子を、いつも胸ときめかして聞いています。<br /><br />\r\nああ、はやく十五歳になって、人間の世界を見てみたいわ」<br /><br />\r\nそうするうちに、一番末の姫もついに十五歳をむかえ、はれて海の上に出る日がきました。<br /><br />\r\n喜んだ姫が上へ上へとのぼっていくと、最初に目に入ったのは大きな船でした。<br /><br />\r\n「わあー、すごい。人間て、こんなに大きな物を作るんだ」<br /><br />\r\n人魚姫は船を追いかけると、甲板のすき間から、そっと中をのぞいてみました。<br /><br />\r\n船の中はパーティーをしていて、にぎやかな音楽が流れるなか、美しく着かざった人たちがダンスをしています。<br /><br />\r\nその中に、ひときわ目をひく美しい少年がいました。<br /><br />\r\nそれは、パーティーの主役の王子です。<br /><br />\r\nそのパーティーは、王子の十六歳の誕生日を祝う誕生パーティーだったのです。<br /><br />\r\n「すてきな王子さま」<br /><br />\r\n人魚姫は夜になっても、うっとりと王子のようすを見つめていました。<br /><br />\r\nと、突然、海の景色が変わりました。<br /><br />\r\n稲光が走ると風がふき、波がうねりはじめたのです。<br /><br />\r\n「あらしだわ！」<br /><br />\r\n水夫たちがあわてて帆(ほ)をたたみますが、あらしはますます激しくなると、船は見るまに横倒しになってしまいました。<br /><br />\r\n船に乗っていた人びとが、荒れくるう海に放り出されます。<br /><br />\r\n「大変！　王子さまー！」<br /><br />\r\n人魚姫は大急ぎで王子の姿を探しだすと、ぐったりしている王子のからだをだいて、浜辺へと運びました。<br /><br />\r\n「王子さま、しっかりして。王子さま！」<br /><br />\r\n人魚姫は王子さまを、けんめいに看病しました。', '2022-01-29 12:10:30', '2022-01-29 12:10:30'),
(17, 33, '王子救出編', 1, '人魚たちの世界では、十五歳になると海の上の人間の世界を見に行くことを許されていました。<br /><br />\r\n末っ子の姫は、お姉さんたちが見てきた人間の世界の様子を、いつも胸ときめかして聞いています。<br /><br />\r\nああ、はやく十五歳になって、人間の世界を見てみたいわ」<br /><br />\r\nそうするうちに、一番末の姫もついに十五歳をむかえ、はれて海の上に出る日がきました。<br /><br />\r\n喜んだ姫が上へ上へとのぼっていくと、最初に目に入ったのは大きな船でした。<br /><br />\r\n「わあー、すごい。人間て、こんなに大きな物を作るんだ」<br /><br />\r\n人魚姫は船を追いかけると、甲板のすき間から、そっと中をのぞいてみました。<br /><br />\r\n船の中はパーティーをしていて、にぎやかな音楽が流れるなか、美しく着かざった人たちがダンスをしています。<br /><br />\r\nその中に、ひときわ目をひく美しい少年がいました。<br /><br />\r\nそれは、パーティーの主役の王子です。<br /><br />\r\nそのパーティーは、王子の十六歳の誕生日を祝う誕生パーティーだったのです。<br /><br />\r\n「すてきな王子さま」<br /><br />\r\n人魚姫は夜になっても、うっとりと王子のようすを見つめていました。<br /><br />\r\nと、突然、海の景色が変わりました。<br /><br />\r\n稲光が走ると風がふき、波がうねりはじめたのです。<br /><br />\r\n「あらしだわ！」<br /><br />\r\n水夫たちがあわてて帆(ほ)をたたみますが、あらしはますます激しくなると、船は見るまに横倒しになってしまいました。<br /><br />\r\n船に乗っていた人びとが、荒れくるう海に放り出されます。<br /><br />\r\n「大変！　王子さまー！」<br /><br />\r\n人魚姫は大急ぎで王子の姿を探しだすと、ぐったりしている王子のからだをだいて、浜辺へと運びました。<br /><br />\r\n「王子さま、しっかりして。王子さま！」<br /><br />\r\n人魚姫は王子さまを、けんめいに看病しました。', '2022-01-31 12:11:46', '2022-01-31 12:11:46'),
(18, 24, '王子救出編', 1, '人魚たちの世界では、十五歳になると海の上の人間の世界を見に行くことを許されていました。<br /><br />\r\n末っ子の姫は、お姉さんたちが見てきた人間の世界の様子を、いつも胸ときめかして聞いています。<br /><br />\r\nああ、はやく十五歳になって、人間の世界を見てみたいわ」<br /><br />\r\nそうするうちに、一番末の姫もついに十五歳をむかえ、はれて海の上に出る日がきました。<br /><br />\r\n喜んだ姫が上へ上へとのぼっていくと、最初に目に入ったのは大きな船でした。<br /><br />\r\n「わあー、すごい。人間て、こんなに大きな物を作るんだ」<br /><br />\r\n人魚姫は船を追いかけると、甲板のすき間から、そっと中をのぞいてみました。<br /><br />\r\n船の中はパーティーをしていて、にぎやかな音楽が流れるなか、美しく着かざった人たちがダンスをしています。<br /><br />\r\nその中に、ひときわ目をひく美しい少年がいました。<br /><br />\r\nそれは、パーティーの主役の王子です。<br /><br />\r\nそのパーティーは、王子の十六歳の誕生日を祝う誕生パーティーだったのです。<br /><br />\r\n「すてきな王子さま」<br /><br />\r\n人魚姫は夜になっても、うっとりと王子のようすを見つめていました。<br /><br />\r\nと、突然、海の景色が変わりました。<br /><br />\r\n稲光が走ると風がふき、波がうねりはじめたのです。<br /><br />\r\n「あらしだわ！」<br /><br />\r\n水夫たちがあわてて帆(ほ)をたたみますが、あらしはますます激しくなると、船は見るまに横倒しになってしまいました。<br /><br />\r\n船に乗っていた人びとが、荒れくるう海に放り出されます。<br /><br />\r\n「大変！　王子さまー！」<br /><br />\r\n人魚姫は大急ぎで王子の姿を探しだすと、ぐったりしている王子のからだをだいて、浜辺へと運びました。<br /><br />\r\n「王子さま、しっかりして。王子さま！」<br /><br />\r\n人魚姫は王子さまを、けんめいに看病しました。', '2022-02-03 08:45:15', '2022-02-03 08:45:15');

-- --------------------------------------------------------

--
-- テーブルの構造 `offered_chapters`
--

CREATE TABLE `offered_chapters` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `novel_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'ユーザー名',
  `email` varchar(100) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(200) NOT NULL COMMENT 'ログイン時のパスワード',
  `user_type` tinyint(4) NOT NULL COMMENT '0:仮登録 1:一般 2:管理者',
  `password_reset_token` varchar(200) DEFAULT NULL COMMENT 'パスワード再設定時とユーザー登録の際に使う'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `password_reset_token`) VALUES
(1, 'ダダ大のだい', 'daidai111@gmail.com', 'ppp', 2, NULL),
(3, '上田大智', 'gimamama@jjjj', '$2y$10$0WVTGr9Z3cMAdZWtKgu2JuioohccesEzFU/EmyajQS4hkAjfNsWLW', 1, ''),
(4, '上田大智', 'dai@jp', '$2y$10$AQnYLSkRINK/dYuTB8pqiu0XyY/rP4tBZEu2vB.3U8z0pKwNGHSSq', 0, '$2y$10$DbARFSwbk43RlxtsadiSrOtWgLPJCLelIcxjFjrN8yN6NZpuRhT.y'),
(5, '上田大智', 'dai1@j', '$2y$10$MTcrAcNCtuXD0BNu.KpKNeoySg00QNMhEcai0.EOHag7DQrN5K4Lq', 0, '$2y$10$L/Gk/n0IId6CRwJSWQVAR.9NK5aFjHb1fbLTs3TInxxMu5Sesx8Yi'),
(6, '田中次郎', 'tanaka@gmail.com', '$2y$10$qfXkqU3ryqybZq..KpKmxuT0jYG0s6UsbVA82TVKfRw5rjk3vYVeu', 1, ''),
(7, '上田大智', 'dai@jpp', '$2y$10$QeAoeNDScesFO84t1qAgu.4ZCBo.9D.JW8qcs0qKlYAoYcFGxZnT.', 1, '$2y$10$e4hnwCwADZPzoKLA473CUOrxEc0QIiIuyTmp1eLRvtN5i4Er8lZO.'),
(8, '上田大智', 'daidai11@gmail.com', '$2y$10$ugVmj0p0shHY2La4U18EiebCoBX3XB37UbGCjUG.o932swNeJM2Ce', 0, '$2y$10$F/JisyENdBTB9hh1v0F0cu6gdb9JEsEEDI9.opb58.Tvu1OoxvJjy'),
(9, '東大', 'toudai11@mail.com', '$2y$10$uzK3H.Rr3kUFx6FmSo/RbOVPhxhAq1MBDyS4WP4j6EASSPts/IxXi', 0, '$2y$10$ct1D/jWz9zbJ5iNscGCEJ.QW19Nret.l03g9WxIGZ2OwfaSr07dRa'),
(10, '神の子', 'god@mail.com', '$2y$10$6y85lxt5P/1EbBWYQ7dyBeC8o2Xzg7yg1TI4FD.AWK6LL/5mZjgz6', 0, '$2y$10$wNduqzP/ogm.eLYrB4zyMe/NWgO8bT/Q5vKIpxjMW.NHlVa.Ox51a'),
(12, 'わさわさ', 'wasawasa@gmail.com', '$2y$10$K4TMecNFDwsiKzkyTQChOu1SGPUTBUG1669iUqw93dvRNRbZNVdmO', 0, '$2y$10$Xn1gw.XYqg/23TLV3vOd.ustBYykMrD8Uuu9BBKD2By3bHXhAThXm'),
(13, '三郎', 'saburou@mail.com', '$2y$10$jExj9PZ1gVmIF8P5SopumOuVUXDAjBGKMVtSeVLW47YijKAnttQLq', 0, '$2y$10$WiMatuizjT38PnmfW/aEXucrchtjiNq4/zWXZcyWHsjheIOF5XTqu'),
(14, '小説太郎', 'syousetu@mail.com', '$2y$10$xPjN7Fu3KtzYd/dccC8Ub.r6KB3bMwG77pMfa7LaSIlhX02r.sG7.', 1, ''),
(15, '佐々木', 'sasaki@gmail.com', '$2y$10$xyspcSeR3CoMKbO1enNHuOcRyjQtJW1vzlOxm5RCSDqyZ.ax7JIua', 0, '$2y$10$RFDxYjz1znr98iqejVnbI.Sc.uCsh6DswuH29iM1uW5KfYkuPsfFO'),
(21, '佐々木', 'sasaki@email.com', '$2y$10$IsMPzHsvGugLYSGnXfqpjOPGoZW8.qit9PJlGBast/MggJcBQ8yj2', 0, '$2y$10$LUidd09fNhjxG.bclT6Hyul5AJRw1zefRUwObCYYyhE9QniTgxq7i'),
(22, '上田大智', 'ueda@mail.com', '$2y$10$WAAPmA9iVaNwIAIkrWpt9Ob93vunJ3HvbbdhV447q1/4l.Z3OvdoK', 0, '$2y$10$sXiEAgmzS065dAn8XawcD.oWUGDK9WcgElFJ9uZ8qr57lu/choL3y');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_favorites`
--

CREATE TABLE `user_favorites` (
  `user_id` int(11) NOT NULL COMMENT 'user_id',
  `novel_id` int(11) NOT NULL COMMENT 'ノベルid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `user_favorites`
--

INSERT INTO `user_favorites` (`user_id`, `novel_id`) VALUES
(0, 1),
(8, 1),
(8, 4),
(9, 11),
(20, 1),
(22, 24);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `chapter_comments`
--
ALTER TABLE `chapter_comments`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `chapter_votes`
--
ALTER TABLE `chapter_votes`
  ADD PRIMARY KEY (`user_id`);

--
-- テーブルのインデックス `novels`
--
ALTER TABLE `novels`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `novel_chapters`
--
ALTER TABLE `novel_chapters`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `offered_chapters`
--
ALTER TABLE `offered_chapters`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD PRIMARY KEY (`user_id`,`novel_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `chapter_comments`
--
ALTER TABLE `chapter_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=33;

--
-- テーブルの AUTO_INCREMENT `novels`
--
ALTER TABLE `novels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=25;

--
-- テーブルの AUTO_INCREMENT `novel_chapters`
--
ALTER TABLE `novel_chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `offered_chapters`
--
ALTER TABLE `offered_chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;