<?php
// CREATE TABLE `page_requests` (
//   `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
//   `ref` VARCHAR(255) NOT NULL,
//   `ip` VARCHAR(45) NOT NULL,            -- يدعم IPv4 و IPv6
//   `user_agent` TEXT NULL,
//   `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
//   PRIMARY KEY (`id`),
//   INDEX (`ref`),
//   INDEX (`created_at`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

// track.php

	$dbHost = '127.0.0.1';
	$dbName = 'mubasher_db';
	$dbUser = 'mubasher_user';
	$dbPass = '!BIyBXyQrB+L';
	$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";

	try {
		$pdo = new PDO($dsn, $dbUser, $dbPass, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_PERSISTENT => false,
		]);
	} catch (PDOException $e) {
		// لو حاب تعرض خطأ أثناء التطوير:
		// die("DB connection failed: " . $e->getMessage());
		// http_response_code(500);
		// exit;
	}

	function get_client_ip() {
		$keys = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		];

		foreach ($keys as $k) {
			if (!empty($_SERVER[$k])) {
				$ipList = explode(',', $_SERVER[$k]);
				$ip = trim(current($ipList));
				if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) ||
					filter_var($ip, FILTER_VALIDATE_IP)) {
					return $ip;
				}
			}
		}
		return '0.0.0.0';
	}

	$ref = isset($_GET['ref']) ? trim($_GET['ref']) : '';
	if ($ref === '') {
		$ref = 'not_set';
	}
	$ref = mb_substr($ref, 0, 255);

	$ip = get_client_ip();
	$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;

	$sql = "INSERT INTO page_requests (`ref`, `ip`, `user_agent`) VALUES (:ref, :ip, :ua)";
	$stmt = $pdo->prepare($sql);

	try {
		$stmt->execute([
			':ref' => $ref,
			':ip'  => $ip,
			':ua'  => $userAgent
		]);
		// echo 'OK';
	} catch (PDOException $e) {
		// http_response_code(500);
		// // error_log($e->getMessage());
		// exit;
	}

	$influencer = isset($_GET['influencer']) ? trim($_GET['influencer']) : '';
	if ($influencer === '') {
		$influencer = 'not_set';
	}
	$influencer = mb_substr($influencer, 0, 255);

	$sqlInf = "INSERT INTO influencer_requests (`influencer`, `ip`, `user_agent`) VALUES (:influencer, :ip, :ua)";
	$stmtInf = $pdo->prepare($sqlInf);

	try {
		$stmtInf->execute([
			':influencer' => $influencer,
			':ip'  => $ip,
			':ua'  => $userAgent
		]);
		// echo 'OK';
	} catch (PDOException $e) {
		// http_response_code(500);
		// // error_log($e->getMessage());
		// exit;
	}
?>

<!doctype html>
<html class="no-js" lang="en">


<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title  -->
	<title>مباشر</title>

	<!-- Favicon  -->
	<link rel="icon" href="assets/img/logo/logo.png">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cairo:slnt,wght@-11..11,200..1000&display=swap" rel="stylesheet">

	<!-- ***** All CSS Files ***** -->

	<!-- Style css -->
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/ar.css">

</head>

<body>
	<div class="main">
		<!-- ***** Preloader Start ***** -->
		<div class="preloader-main">
			<div class="preloader-wapper">
				<svg class="preloader" xmlns="http://www.w3.org/2000/svg" version="1.1" width="600" height="200">
					<defs>
						<filter id="goo" x="-40%" y="-40%" height="200%" width="400%">
							<feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
							<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -8" result="goo" />
						</filter>
					</defs>
					<g filter="url(#goo)">
						<circle class="dot" cx="50" cy="50" r="25" fill="#1a6390" />
						<circle class="dot" cx="50" cy="50" r="25" fill="#1a6390" />
					</g>
				</svg>
				<div>
					<div class="loader-section section-left"></div>
					<div class="loader-section section-right"></div>
				</div>
			</div>
		</div>
		<!-- ***** Preloader End ***** -->

		<!-- ***** Header Start ***** -->
		<header id="header">
			<!-- Navbar -->
			<nav data-aos="zoom-out" data-aos-delay="800" class="navbar gameon-navbar navbar-expand">
				<div class="container header">

					<!-- Logo -->
					<a class="navbar-brand" href="#!">
						<img src="assets/img/logo/logo.png" alt="Brand Logo" />
					</a>

					<div class="ms-auto"></div>

					<!-- Navbar Nav -->
					<ul class="navbar-nav items mx-auto">
						<li class="nav-item dropdown">
							<a href="#" class="nav-link">الرئيسية</a>
						</li>
						<li class="nav-item">
							<a class="nav-link smooth-anchor" href="#features">المميزات</a>
						</li>
						<li class="nav-item">
							<a class="nav-link smooth-anchor" href="#screenshots">لقطات شاشة</a>
						</li>
						<li class="nav-item">
							<a class="nav-link smooth-anchor" href="#contact">تواصل معنا</a>
						</li>
					</ul>

					<!-- Navbar Icons -->
					<!-- <ul class="navbar-nav icons">
						<li class="nav-item">
							<a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#search">
								<i class="icon-magnifier"></i>
							</a>
						</li>
					</ul> -->

					<!-- Navbar Toggler -->
					<ul class="navbar-nav toggle">
						<li class="nav-item">
							<a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#menu">
								<i class="icon-menu m-0"></i>
							</a>
						</li>
					</ul>

				</div>
			</nav>
		</header>
		<!-- ***** Header End ***** -->

		<!-- ***** Hero Section Start ***** -->
		<section id="home" class="hero-section layout-1 has-overlay overlay-gradient">
			<div class="container">
				<div class="row justify-content-center align-items-center">
					<div class="col-12 col-md-7 col-lg-6">
						<!-- Hero Content -->
						<div class="hero-content">
							<h1 class="text-white">إعلانك المميز</h1>
							<p class="sub-heading text-white my-4">مع منصة مباشر استعرض وانشر الإعلانات الآن بسهولة وتصفح الإعلانات المميزة</p>

							<!-- Download Button -->
							<div class="button-group download-button">
								<a href="https://play.google.com/store/apps/details?id=tr.mubashar.mubashar">
									<img src="assets/img/content/google-play.png" alt="">
								</a>
								<a href="https://apps.apple.com/eg/app/mubashar-com/id6740783671">
									<img src="assets/img/content/app-store.png" alt="">
								</a>
								<a href="/mubashar.apk">
									<img src="assets/img/content/direct-download.png" alt="">
								</a>
							</div>
							<span class="d-block fst-italic fw-light text-white mt-3">* متوفر على iPhone وiPad وجميع أجهزة Android</span>
						</div>
					</div>
					<div class="col-12 col-md-5 col-lg-6">
						<!-- Hero Thumb -->
						<div class="hero-thumb mx-auto" data-aos="fade-left" data-aos-delay="500" data-aos-duration="1000">
							<img src="assets/img/content/hero-thumb.png" alt="">
						</div>
					</div>
				</div>
			</div>

			<!-- Shape Bottom -->
			<div class="shape-bottom">
				<svg viewBox="0 0 1920 310" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="svg replaced-svg">
					<title>sApp Shape</title>
					<desc>Created with Sketch</desc>
					<defs></defs>
					<g id="sApp-Landing-Page" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<g id="sApp-v1.0" transform="translate(0.000000, -544.000000)" fill="#FFFFFF">
							<path d="M-3,551 C186.257589,757.321118 319.044414,856.322454 395.360475,848.004007 C509.834566,835.526337 561.525143,796.329212 637.731734,765.961549 C713.938325,735.593886 816.980646,681.910577 1035.72208,733.065469 C1254.46351,784.220361 1511.54925,678.92359 1539.40808,662.398665 C1567.2669,645.87374 1660.9143,591.478574 1773.19378,597.641868 C1848.04677,601.75073 1901.75645,588.357675 1934.32284,557.462704 L1934.32284,863.183395 L-3,863.183395" id="sApp-v1.0"></path>
						</g>
					</g>
				</svg>
			</div>
		</section>
		<!-- ***** Hero Section End ***** -->

		<!-- ***** Features Area Start ***** -->
		<section id="features" class="features-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-10 col-lg-7">
						<!-- Intro -->
						<div class="intro text-center mb-4">
							<span class="badge rounded-pill text-bg-light">
								<i class="fa-regular fa-lightbulb"></i>
								<span>مميزات</span>
								<span>مباشر</span>
							</span>
							<h2 class="title">ماذا يجعلنا مميزين؟</h2>
							<p>ستحظى من خلال تجربة تطبيق مباشر على تجربة استثنائية في استكشاف الإعلانات المناسبة لك</p>
						</div>
					</div>
				</div>

				<div class="row items">
					<div class="col-12 col-md-6 col-lg-4 item">
						<!-- Image Box -->
						<div class="image-box text-center wow fadeInLeft" data-wow-delay="0.4s">
							<img class="avatar-sm" src="assets/img/content/icon-1.png" alt="">
							<!-- Content -->
							<div class="content">
								<h4 class="mb-3">إعلانات مميزة</h4>
								<p class="mt-3">إعلانات متميزة بعلامات توضح تميزها وموثقة من قبل فريق مباشر.</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-4 item">
						<!-- Image Box -->
						<div class="image-box text-center wow fadeInUp" data-wow-delay="0.2s">
							<img class="avatar-sm" src="assets/img/content/icon-2.png" alt="">
							<!-- Content -->
							<div class="content">
								<h4 class="mb-3">تواصل مع المعلنين</h4>
								<p class="mt-3">يمكنك التواصل مباشرة مع صاحب الإعلان دون وسيط.</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-4 item">
						<!-- Image Box -->
						<div class="image-box text-center wow fadeInRight" data-wow-delay="0.4s">
							<img class="avatar-sm" src="assets/img/content/icon-3.png" alt="">
							<!-- Content -->
							<div class="content">
								<h4 class="mb-3">سرية عالية</h4>
								<p class="mt-3">في مباشر نحافظ على خصوصية بيانات مستخدمينا.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Features Area End ***** -->

		<!-- ***** Content Section Start ***** -->
		<section class="content-section primary-bg">
			<div class="container">
				<div class="row justify-content-between">
					<div class="col-12 col-lg-6">
						<div class="content">
							<h2 class="mt-0">إجعل إعلاناتك تظهر للجمهور المناسب</h2>

							<ul class="list-group list-group-flush">
								<li class="list-group-item d-flex align-items-center border-0">
									<!-- Icon Box -->
									<div class="icon-box ms-3">
										<div class="icon shadow-sm">
											<span class="material-symbols-outlined">tab_inactive</span>
										</div>
									</div>
									<span>في مباشر نحرص على عدم تكرار الإعلانات من خلال الرقابة الدورية على جميع الإعلانات ضمن منصتنا.</span>
								</li>

								<li class="list-group-item d-flex align-items-center border-0">
									<!-- Icon Box -->
									<div class="icon-box ms-3">
										<div class="icon shadow-sm">
											<span class="material-symbols-outlined">verified</span>
										</div>
									</div>
									<span>حسابات معلنين موثقة من قبلنا تضمن نشر إعلانات حقيقية غير مزيفة.</span>
								</li>

								<li class="list-group-item d-flex align-items-center border-0">
									<!-- Icon Box -->
									<div class="icon-box ms-3">
										<div class="icon shadow-sm">
											<span class="material-symbols-outlined">swap_calls</span>
										</div>
									</div>
									<span>نرشدك في تطبيقنا إلى مكان الإعلان بالشكل الصحيح والمناسب لك.</span>
								</li>

								<li class="list-group-item d-flex align-items-center border-0">
									<!-- Icon Box -->
									<div class="icon-box ms-3">
										<div class="icon shadow-sm">
											<span class="material-symbols-outlined">schedule</span>
										</div>
									</div>
									<span>نوفر في مباشر ميزة تمويل الإعلان لفترة محدودة.</span>
								</li>
							</ul>
						</div>
					</div>

					<div class="col-12 col-lg-4 d-none d-md-block">
						<img src="assets/img/content/thumb-1.png" alt="">
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Content Section End ***** -->

		<!-- ***** Content Section Start ***** -->
		<section class="content-section">
			<div class="container">
				<div class="row justify-content-between">
					<div class="col-12 col-lg-6">
						<img src="assets/img/content/thumb-2.png" alt="">
					</div>

					<div class="col-12 col-lg-6">
						<div class="content">
							<h2 class="mt-0">على ماذا تحصل من خلال نشر إعلاناتك بمباشر؟</h2>

							<ul class="list-group list-group-flush">
								<li class="list-group-item d-flex border-0 p-0">
									<div class="icon layout-2 align-items-start mt-1 me-2">
										<span class="material-symbols-outlined">task_alt</span>
									</div>
									<span>نشر إعلاناتك بكل سهولة.</span>
								</li>

								<li class="list-group-item d-flex border-0 p-0">
									<div class="icon layout-2 align-items-start mt-1 me-2">
										<span class="material-symbols-outlined">task_alt</span>
									</div>
									<span>تقييم إعلاناتك من قبل مستخدمين التطبيق.</span>
								</li>

								<li class="list-group-item d-flex border-0 p-0">
									<div class="icon layout-2 align-items-start mt-1 me-2">
										<span class="material-symbols-outlined">task_alt</span>
									</div>
									<span>تقييم ناشرين الإعلان.</span>
								</li>

								<li class="list-group-item d-flex border-0 p-0">
									<div class="icon layout-2 align-items-start mt-1 me-2">
										<span class="material-symbols-outlined">task_alt</span>
									</div>
									<span>إتاحة إمكانية وضع المزارع للأجار.</span>
								</li>
							</ul>

							<ul class="list-group list-group-horizontal list-group-flush">
								<li class="list-group-item border-0">
									<!-- Icon Box -->
									<div class="icon-box shadow-sm border rounded">
										<div class="icon">
											<span class="material-symbols-outlined">pinch</span>
										</div>
									</div>
								</li>

								<li class="list-group-item border-0">
									<!-- Icon Box -->
									<div class="icon-box shadow-sm border rounded">
										<div class="icon">
											<span class="material-symbols-outlined">multiple_stop</span>
										</div>
									</div>
								</li>

								<li class="list-group-item border-0">
									<!-- Icon Box -->
									<div class="icon-box shadow-sm border rounded">
										<div class="icon">
											<span class="material-symbols-outlined">step</span>
										</div>
									</div>
								</li>
							</ul>

						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Content Section End ***** -->

		<!-- ***** Work Area Start ***** -->
		<section class="work-section has-overlay overlay-gradient">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-10 col-lg-7">
						<!-- Intro -->
						<div class="intro text-center">
							<h2 class="title text-white layout-2 mt-0">كيف يعمل مباشر؟</h2>
							<p class="text-white">نحن نعمل على خلق قناة تواصل مريحة بين المعلنين والزبائن.</p>
						</div>
					</div>
				</div>
				<div class="row items">
					<div class="col-12 col-md-4 item">
						<div class="icon-box text-center px-3">
							<img class="avatar-md" src="assets/img/content/step-1.png" alt="">
							<h4 class="text-white">حمل التطبيق</h4>
							<p class="text-white">حمل التطبيق الآن من المتجر بحسب جهازك وابدأ باستخدامه فوراً.</p>
						</div>
					</div>
					<div class="col-12 col-md-4 item">
						<div class="icon-box text-center px-3">
							<img class="avatar-md" src="assets/img/content/step-2.png" alt="">
							<h4 class="text-white">أنشأ حسابك</h4>
							<p class="text-white">بعد تحميل التطبيق قم بتسجيل حساب جديد وابدأ بالاستخدام</p>
						</div>
					</div>
					<div class="col-12 col-md-4 item">
						<div class="icon-box text-center px-3">
							<img class="avatar-md" src="assets/img/content/step-3.png" alt="">
							<h4 class="text-white">استكشف عالم مباشر</h4>
							<p class="text-white">بعد إنشاء حسابك الخاص الآن أنت في عالم مباشر، ابدأ بالاستمتاع بمزايا مباشر.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Work Area End ***** -->

		<!-- ***** Screenshots Area Start ***** -->
		<section id="screenshots" class="screenshots-area">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-10 col-lg-7">
						<!-- Intro -->
						<div class="intro text-center">
							<span class="badge rounded-pill text-bg-light">
								<i class="fa-solid fa-wand-magic-sparkles"></i>
								<span>واجهات</span>
								<span>مميزة</span>
							</span>
							<h2 class="title">الإبداع والبساطة في تصميم الواجهات</h2>
							<p>نفتخر بمباشر في أننا التطبيق الأفضل تميزاً في تصميم واجهات بسيطة وملائمة تتمتع بمزايا متنوعة.</p>
						</div>
					</div>
				</div>
				<div class="app-screenshots-slides">
					<div class="swiper-container slider-mid">
						<div class="swiper-wrapper">
							<!-- Single Slide -->
							<div class="swiper-slide item">
								<img src="assets/img/content/1.png" alt="">
							</div>
							<!-- Single Slide -->
							<div class="swiper-slide item">
								<img src="assets/img/content/2.png" alt="">
							</div>
							<!-- Single Slide -->
							<div class="swiper-slide item">
								<img src="assets/img/content/3.png" alt="">
							</div>
							<!-- Single Slide -->
							<div class="swiper-slide item">
								<img src="assets/img/content/4.png" alt="">
							</div>
							<!-- Single Slide -->
							<div class="swiper-slide item">
								<img src="assets/img/content/5.png" alt="">
							</div>
							<!-- Single Slide -->
							<div class="swiper-slide item">
								<img src="assets/img/content/6.png" alt="">
							</div>
							<!-- Single Slide -->
							<div class="swiper-slide item">
								<img src="assets/img/content/7.png" alt="">
							</div>
							<!-- Single Slide -->
							<div class="swiper-slide item">
								<img src="assets/img/content/8.png" alt="">
							</div>
						</div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Screenshots Area End ***** -->

		<!-- ***** FAQ Area Start ***** -->
		<section class="faq">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-10 col-lg-7">
						<!-- Intro -->
						<div class="intro text-center">
							<h2 class="title mt-0">الأسئلة الشائعة</h2>
							<p>اعثر على إجابات للأسئلة الأكثر شيوعاً، والتي تغطي كل شيء بدءاً من الإعداد وحتى الميزات المتقدمة، لمساعدتك في تحقيق أقصى استفادة من مباشر.</p>
						</div>
					</div>
				</div>

				<div class="row justify-content-center">
					<div class="col-12 col-md-10">
						<!-- sApp Accordion -->
						<div class="accordion accordion-flush" id="sapp-accordion">
							<!-- Accordion Item -->
							<div class="accordion-item">
								<h4 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
									كيف تقوم بتحميل التطبيق؟
									</button>
								</h4>
								<div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#sapp-accordion">
									<div class="accordion-body">لكي تقوم بتحميل تطبيق مباشر، يكفي أن تذهب لأي متجر من متاجر التطبيقات الشهيرة وابحث عن مباشر وحمل التطبيق مباشرة.</div>
								</div>
							</div>

							<!-- Accordion Item -->
							<div class="accordion-item">
								<h4 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
									كيف أقوم بتعديل بياناتي الشخصية؟
									</button>
								</h4>
								<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#sapp-accordion">
									<div class="accordion-body">بعد تحميل التطبيق وتسجيل حسابك يمكنك الولوج إلى واجهة حسابي وتعديل بياناتك الشخصية.</div>
								</div>
							</div>

							<!-- Accordion Item -->
							<div class="accordion-item">
								<h4 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
									هل النشر مجاني؟
									</button>
								</h4>
								<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#sapp-accordion">
									<div class="accordion-body">نعم في مباشر نؤمن أن الإعلانات يجب أن تكون مجانية وتعتمد سياستنا في الربح من خلال تمويل الإعلانات بناء على رغبة الزبائن وليست إجبارية أو إلزامية.</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** FAQ Area End ***** -->

		<!-- ***** Download Area Start ***** -->
		<section class="download-area has-overlay overlay-dark">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-10 col-lg-9">
						<!-- Content -->
						<div class="content text-center">
							<h2 class="text-white">مباشر متاح لجميع الجوالات</h2>
							<p class="text-white">استمتع بتعدد استخدامات تطبيق مباشر، المصمم للعمل بسلاسة على جميع الأجهزة. سواءً كنت تستخدم هاتفًا ذكيًا أو جهازًا لوحيًا، حمّل التطبيق الآن واستمتع بميزاته الفعّالة في أي وقت ومن أي مكان!</p>

							<!-- Download Button -->
							<div class="button-group download-button justify-content-center">
								<a href="https://play.google.com/store/apps/details?id=tr.mubashar.mubashar">
									<img src="assets/img/content/google-play.png" alt="">
								</a>
								<a href="https://apps.apple.com/eg/app/mubashar-com/id6740783671">
									<img src="assets/img/content/app-store.png" alt="">
								</a>
							</div>
							<span class="d-block fst-italic fw-light text-white mt-3">* متوفر على iPhone وiPad وجميع أجهزة Android</span>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Download Area End ***** -->

		<!-- ***** Subscribe Area Start ***** -->
		<section class="subscribe-area">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-10 col-lg-7">
						<div class="content text-center">
							<h2 class="mt-0">اشترك في نشرتنا الاخبارية</h2>
							<p>ابقى على تواصل معنا، سجل الآن واحصل على آخر تحديثات والحصريات عن مباشر.</p>

							<!-- Subscribe Form -->
							<form class="contact-form outlined">
								<div class="form-floating mb-3">
									<input type="email" class="form-control" id="email" placeholder="name@example.com">
									<label for="email">البريد الإلكتروني</label>
								</div>
								<button type="submit" class="btn subscribe-btn swap-icon w-100">اشترك<i class="icon bi bi-arrow-left-short"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Subscribe Area End ***** -->

		<!--====== Contact Area Start ======-->
		<section id="contact" class="contact-area primary-bg">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-10 col-lg-7">
						<!-- Intro -->
						<div class="intro text-center">
							<h2 class="title mt-0">ابقى على تواصل</h2>
							<p>هل لديك استفسار، هل لديك أي معلومة، لا تتردد في التواصل معنا.</p>
						</div>
					</div>
				</div>
				<div class="row justify-content-between align-items-center">
					<div class="col-12 col-md-5">
						<div class="contact-info">
							<h3 class="mt-0">حدد موعدًا للمكالمة معنا لمعرفة ما إذا كان بإمكاننا المساعدة</h3>
							<p>سواء كنت تبحث عن بدء مشروع جديد أو تريد الدردشة فقط، فلا تتردد في التواصل معنا!</p>

							<ul class="list-group list-group-flush">
								<li class="list-group-item d-flex align-items-center">
									<!-- Icon Box -->
									<div class="icon-box ms-3">
										<div class="icon">
											<span class="contact-icon material-symbols-outlined">call</span>
										</div>
									</div>
									<span><a href="tel:00963989011150">00963.989.011.150</a></span>
								</li>

								<li class="list-group-item d-flex align-items-center">
									<!-- Icon Box -->
									<div class="icon-box ms-3">
										<div class="icon">
											<span class="contact-icon material-symbols-outlined">mark_email_unread</span>
										</div>
									</div>
									<span><a href="mailto:info@mubashar.tr">info@mubashar.tr</a></span>
								</li>

								<li class="list-group-item d-flex align-items-center">
									<!-- Icon Box -->
									<div class="icon-box ms-3">
										<div class="icon">
											<span class="contact-icon material-symbols-outlined">location_on</span>
										</div>
									</div>
									<span>سوريا، دمشق</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-12 col-md-6 mt-4 mt-md-0">
						<form id="contact-form" class="contact-form outlined" method="POST" action="#!">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
								<label for="name">الاسم</label>
							</div>
							<div class="form-floating mb-3">
								<input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
								<label for="email">البريد الإلكتروني</label>
							</div>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
								<label for="subject">الموضوع</label>
							</div>
							<div class="form-floating mb-4">
								<textarea class="form-control" name="message" id="message" placeholder="Leave a comment here" required style="height: 100px"></textarea>
								<label for="message">الرسالة</label>
							</div>
							<button type="submit" class="btn swap-icon">أرسل<i class="icon bi bi-arrow-left-short"></i></button>
						</form>
						<p class="form-message"></p>
					</div>
				</div>
			</div>
		</section>
		<!--====== Contact Area End ======-->

		<!--====== Height Emulator Area Start ======-->
		<div class="height-emulator d-none d-lg-block"></div>
		<!--====== Height Emulator Area End ======-->

		<!--====== Footer Area Start ======-->
		<footer class="footer-area footer-fixed p-0">
			<!-- Footer Top -->
			<div class="footer-top">
				<div class="container">
					<div class="row items">
						<div class="col-12 col-sm-6 col-lg-3 item">
							<!-- Footer Items -->
							<div class="footer-items">
								<!-- Logo -->
								<a class="navbar-brand" href="#!">
									<img class="logo" src="assets/img/logo/logo.png" alt="">
								</a>
								<p class="slug mt-3">مباشر، من البائع إلى الزبون</p>

								<hr>

								<!-- Social Icons -->
								<div class="social-icons d-flex mt-3">
									<a class="icon has-overlay overlay-gradient" href="https://www.facebook.com/profile.php?id=61574052329120">
										<i class="fa-brands fa-facebook-f"></i>
										<i class="fa-brands fa-facebook-f"></i>
									</a>
									<!-- <a class="icon has-overlay overlay-gradient" href="https://www.instagram.com/mubasharapp"> -->
									<a class="icon has-overlay overlay-gradient" href="https://www.instagram.com/mubasharapp1">
										<i class="fa-brands fa-instagram"></i>
										<i class="fa-brands fa-instagram"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6 col-lg-3 item">
							<!-- Footer Items -->
							<div class="footer-items">
								<h4 class="footer-title mt-0">روابط مفيدة</h4>

								<!-- Navigation -->
								<ul class="nav flex-column">
									<li class="nav-item">
										<a class="nav-link" href="#!">الرئيسية</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#">حول</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-12 col-sm-6 col-lg-3 item">
							<!-- Footer Items -->
							<div class="footer-items">
								<h4 class="footer-title mt-0">صفحات مهمة</h4>

								<!-- Navigation -->
								<ul class="nav flex-column">
									<li class="nav-item">
										<a class="nav-link" href="#">سياسة الخصوصية</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#">الشروط والقواعد</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-12 col-sm-6 col-lg-3 item">
							<!-- Footer Items -->
							<div class="footer-items">
								<h4 class="footer-title mt-0">تحميل</h4>

								<!-- Download Button -->
								<div class="button-group download-button">
									<a href="https://play.google.com/store/apps/details?id=tr.mubashar.mubashar">
										<img src="assets/img/content/google-play-black.png" alt="">
									</a>
									<a href="https://apps.apple.com/eg/app/mubashar-com/id6740783671">
										<img src="assets/img/content/app-store-black.png" alt="">
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Footer Bottom -->
			<div class="footer-bottom">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<!-- Copyright Area -->
							<div class="copyright-area d-flex flex-wrap justify-content-center justify-content-sm-between align-items-center text-center py-4">
								<span>&copy; 2025 مباشر | جميع الحقوق محفوظة</span>
								<span>طور <i class="fa-solid fa-heart"></i> بواسطة <a href="https://elit-it.com" target="_blank">ELIT IT</a></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!--====== Footer Area End ======-->

		<!--====== Modal Search Area Start ======-->
		<div id="search" class="p-0 modal fade">
			<div class="modal-dialog modal-dialog-slideout">
				<div class="modal-content full">
					<div class="modal-header" data-bs-dismiss="modal">
						Search <i class="icon-close"></i>
					</div>
					<div class="modal-body">
						<form class="row">
							<div class="col-12 align-self-center p-0">
								<div class="row">
									<div class="col-12 p-0 pb-3">
										<h2 class="modal-heading mt-0 mb-3">What are you looking for?</h2>
										<form class="contact-form outlined">
											<div class="form-floating mb-3">
												<input type="text" class="form-control" name="keywords" id="keywords" placeholder="Enter Keywords">
												<label for="keywords">Enter Keywords</label>
											</div>
											<input type="submit" class="search-submit" value="Search">
										</form>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--====== Modal Search Area End ======-->

		<!--====== Modal Responsive Menu Area Start ======-->
		<div id="menu" class="modal fade p-0">
			<div class="modal-dialog modal-dialog-slideout">
				<div class="modal-content full">
					<div class="modal-header" data-bs-dismiss="modal">
						Menu <i class="icon-close"></i>
					</div>
					<div class="menu modal-body">
						<div class="row w-100">
							<div class="items p-0 col-12 text-center">
								<!-- Append [navbar] -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--====== Modal Responsive Menu Area End ======-->

		<!--====== Scroll To Top Area Start ======-->
		<div id="scroll-to-top" class="scroll-to-top">
			<a href="#home" class="smooth-anchor">
				<i class="fa-solid fa-arrow-up"></i>
			</a>
		</div>
		<!--====== Scroll To Top Area End ======-->
	</div>


	<!-- ***** All jQuery Plugins ***** -->

	<!-- jQuery(necessary for all JavaScript plugins) -->
	<script src="assets/js/vendor/jquery.min.js"></script>

	<!-- Bootstrap js -->
	<script src="assets/js/vendor/popper.min.js"></script>
	<script src="assets/js/vendor/bootstrap.min.js"></script>

	<!-- Plugins js -->
	<script src="assets/js/vendor/slider.min.js"></script>
	<script src="assets/js/vendor/owl.carousel.min.js"></script>
	<script src="assets/js/vendor/counterup.js"></script>
	<script src="assets/js/vendor/waypoint.js"></script>
	<script src="assets/js/vendor/aos.js"></script>
	<script src="assets/js/vendor/wow.min.js"></script>
	<script src="assets/js/vendor/countdown.min.js"></script>
	<script src="assets/js/vendor/gallery.min.js"></script>

	<!-- Main js -->
	<script src="assets/js/main.js"></script>
	<script>
		// const userAgent = navigator.userAgent || navigator.vendor || window.opera;
		// const isAndroid = /android/i.test(userAgent);
		// const isIOS = /iPad|iPhone|iPod/.test(userAgent) && !window.MSStream;
        // const isMobile = isAndroid || isIOS;

		// const appScheme = 'myapp://home'; // your app's custom URL scheme
		// const androidStore = 'https://play.google.com/store/apps/details?id=tr.mubashar.mubashar';
		// const iosStore = 'https://apps.apple.com/app/id6740783671';

        // function openApp() {
        //     if (!isMobile) {
        //         // Don't do anything on desktop
        //         return;
        //     }

        //     const start = Date.now();
        //     const storeUrl = isAndroid ? androidStore : iosStore;

        //     window.location = appScheme;

        //     setTimeout(() => {
        //         if (Date.now() - start < 2000) {
        //             window.location = storeUrl;
        //         }
        //     }, 100);
        // }

        // openApp();
	</script>

</body>


</html>