<?php
session_start();
$login_error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html
  lang="vi"
  csrf-token="2SfWZY+0CTp6/E8En6WaTxIKo8QAXkuEm+kNKotJ+Iof0+nNQAkZDlLwdWslPQcibDq0owmAv4IufoK5ZM3xkJ9E4BgKSo+tJD6Q9mRvKbat3WtMuCuZvivq2ft5bSA/ZMYXXhxfZBsKXoGTMbnZ5g==">
<!-- Mirrored from thoitrang09.themeweb4s.com/member/login by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Mar 2025 08:45:47 GMT -->
<!-- Added by HTTrack -->
<meta
  http-equiv="content-type"
  content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
  <title>Đăng nhập</title>

  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <meta name="description" content="eeeeee" />
  <meta name="keywords" content="" />

  <link rel="canonical" href="login.html" />
  <link rel="alternate" hreflang="vi" href="login.html" />

  <!-- Twitter Card data -->
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="" />
  <meta name="twitter:title" content="Đăng nhập" />
  <meta name="twitter:description" content="eeeeee" />
  <meta
    name="twitter:image"
    content="../../cdn3533.cdn-template-4s.com/media/logo/logo-1970.html" />

  <!-- Open Graph data -->
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="" />
  <meta property="og:title" content="Đăng nhập" />
  <meta property="og:url" content="login.html" />
  <meta
    property="og:image"
    content="../../cdn3533.cdn-template-4s.com/media/logo/logo-1970.html" />
  <meta property="og:description" content="eeeeee" />

  <meta http-equiv="x-dns-prefetch-control" content="on" />
  <link rel="dns-prefetch" href="https://cdn3533.cdn-template-4s.com/" />

  <link href="/duan11/assets/favicon.ico" rel="icon" type="image/x-icon" />

  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/bootstrap.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/swiper.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/lib/fontawesome/css/fontawesome.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/lib/fontawesome/css/light.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/lib/fontawesome/css/solid.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/lib/fontawesome/css/brands.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/lightgallery.css"
    rel="stylesheet"
    type="text/css" />

  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/variable.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap-datepicker/bootstrap-datepicker.min.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap-select/bootstrap-select.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/lib/jquery-ui/jquery-ui.min.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/catalogue.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/comment-rating.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/member.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/order.css"
    rel="stylesheet"
    type="text/css" />

  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/variable.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/compare.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/page.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/utilities.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="/duan11/assets/templates/thoitrang05/assets/css/custom.css"
    rel="stylesheet"
    type="text/css" />

  <style type="text/css">
    /* <![CDATA[ */
    @font-face {
      font-family: "Font Awesome 6 Pro";
      font-style: normal;
      font-weight: 300;
      font-display: block;
      src: url("/duan11/assets/templates/thoitrang05/assets/fonts/fa-light-300.html") format("woff2"),
        url("/duan11/assets/templates/thoitrang05/assets/fonts/fa-light-300.ttf") format("truetype");
      font-display: swap;
    }

    @font-face {
      font-family: "Font Awesome 6 Pro";
      font-style: normal;
      font-weight: 900;
      font-display: block;
      src: url("/duan11/assets/templates/thoitrang05/assets/fonts/fa-solid-900.html") format("woff2"),
        url("/duan11/assets/templates/thoitrang05/assets/fonts/fa-solid-900.ttf") format("truetype");
      font-display: swap;
    }

    @font-face {
      font-family: "Font Awesome 6 Brands";
      font-style: normal;
      font-weight: 400;
      font-display: block;
      src: url("/duan11/assets/templates/thoitrang05/assets/fonts/fa-brands-400.html") format("woff2"),
        url("/duan11/assets/templates/thoitrang05/assets/fonts/fonts/fa-brands-400.html") format("truetype");
      font-display: swap;
    }

    /* ]]> */
  </style>
</head>

<body class="member">
  <header>
    <div nh-row="p7fsjoq" class="align-row-center header-main py-4">
      <div class="row no-gutters">
        <div class="col-md-4 col-12">
          <div nh-block="hzfxs24" nh-block-cache="true" class="">
            <div class="menu-container menu-pc">
              <a
                class="btn-menu-mobile"
                nh-menu="btn-open"
                menu-type="main"
                href="javascript:;"><i class="fa-light fa-bars-staggered"></i></a>
              <div class="back-drop"></div>
              <nav class="menu-section" nh-menu="sidebar" menu-type="main">
                <div class="menu-top">
                  <span class="menu-header">Menu</span><a
                    href="javascript:;"
                    nh-menu="btn-close"
                    class="close-sidebar effect-rotate icon-close"><i class="fa-light fa-xmark"></i></a>
                </div>
                <ul>
                  <li class="">
                    <a href="index.php">
                      Trang chủ<span class="fa-light fa-chevron-down"></span></a>
                  </li>
                  <li class="position-relative has-child">
                    <a href="../san-pham.html">Sản phẩm<span
                        class="fa-light fa-chevron-down"></span></a><span class="grower" nh-toggle="emuqg5k26i"></span>
                    <ul
                      nh-toggle-element="emuqg5k26i"
                      class="entry-menu dropdown">
                      <li class=" ">
                        <a class="menu-link" href="../ao-nam.html">Áo Nam</a>
                      </li>
                      <li class=" ">
                        <a class="menu-link" href="../quan-nam.html">Quần Nam</a>
                      </li>
                    </ul>
                  </li>
                  <li class="">
                    <a href="../trang-tin-tuc.html">Bài viết<span class="fa-light fa-chevron-down"></span></a>
                  </li>
                  <li class="">
                    <a href="../lien-he.html">Liên hệ<span class="fa-light fa-chevron-down"></span></a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-12">
          <div nh-block="qhdw2uy" nh-block-cache="true" class="">
            <div class="logo-section">
              <a href="../index.html"><img
                  class="img-fluid"
                  src="/duan11/assets/templates/thoitrang05/assets/media/logo/logo.png"
                  alt="logo" /></a>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-12">
          <div nh-block="8bxkyf0" nh-block-cache="true" class="">
            <div class="entire-action-header entire-action-search">
              <span class="btn-action-header btn-mini-search"><img
                  src="/duan11/assets/templates/thoitrang05/assets/media/icon/search.svg"
                  class="icon" /></span>
              <form
                class="form-search position-relative"
                action="https://thoitrang09.themeweb4s.com/tim-kiem"
                method="get"
                autocomplete="off">
                <div class="input-group">
                  <div class="input-group-append">
                    <button
                      nh-btn-submit
                      class="btn btn-submit"
                      type="submit">
                      <img
                        src="/duan11/assets/templates/thoitrang05/assets/media/icon/search.svg"
                        class="icon" />
                    </button>
                  </div>
                  <input
                    nh-auto-suggest="product"
                    name="keyword"
                    placeholder="Từ khóa tìm kiếm"
                    type="text"
                    class="form-control"
                    value="" />
                </div>
              </form>
            </div>
          </div>
          <div
            nh-block="g1syznh"
            nh-block-cache="true"
            class="float-lg-right">
            <div nh-mini-member class="entire-action-header">
              <a
                class="btn-action-header"
                title="Tài khoản"
                href="javascript:;"
                data-toggle="modal"
                data-target="#login-modal"><i class="fa-light fa-user"></i></a>
            </div>
          </div>
          <div nh-block="mgqafzd" nh-block-cache="true" class="float-right">
            <div class="entire-action-header">
              <a
                class="btn-action-header btn-mini-wishlist"
                title="Yêu thích"
                href="../yeu-thich.html"><i class="fa-light fa-heart"></i><span wishlist-total="all" class="items-number">0</span>
              </a>
            </div>
          </div>
          <div nh-block="i57yxn3" nh-block-cache="true" class="float-right">
            <div class="entire-action-header">
              <a
                class="btn-mini-cart btn-action-header"
                nh-mini-cart="open"
                title="Giỏ hàng"
                href="javascript:;"><i class="fa-light fa-basket-shopping"></i><span nh-total-quantity-mini-cart class="items-number">0</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div nh-row="x1rviay" class="bg-light pb-5">
    <div class="row no-gutters">
      <div class="col-md-12 col-12">
        <div nh-block="xd2nm91" nh-block-cache="false" class="">
          <div class="p-3 bg-white mb-5">
            <div class="container">
              <nav class="breadcrumbs-section">
              <a href="index.php?page=home">Trang chủ</a><span>Đăng nhập</span>
              </nav>
            </div>
          </div>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-xl-5 col-lg-6 col-md-8 col-12">
                <div class="rounded shadow bg-white mt-5 rounded-8">
                  <div
                    class="modal-title h2 text-uppercase text-center font-weight-bold pt-5">
                    Đăng nhập
                  </div>
                  <form action="/duan11/routes/User.php?action=login" method="POST">
                    <div class="p-5">
                      <div class="row mx-n2">
                        <div class="col-md-6 col-12 px-2">
                          <span
                            nh-btn-login-social="google"
                            nh-oauthserver="https://accounts.google.com/o/oauth2/v2/auth"
                            class="btn btn-submit d-flex align-items-center justify-content-center text-center mb-3 rounded-8">
                            <i class="fa-2x fa-brands fa-google mr-3"></i>
                            Đăng nhập google
                          </span>
                        </div>
                        <div class="col-md-6 col-12 px-2">
                          <span
                            nh-btn-login-social="facebook"
                            nh-oauthserver="https://www.facebook.com/v14.0/dialog/oauth"
                            class="btn btn-submit d-flex align-items-center justify-content-center text-center mb-3 rounded-8">
                            <i class="fa-2x fa-brands fa-facebook mr-3"></i>
                            Đăng nhập facebook
                          </span>
                        </div>
                      </div>
                      <div class="text-line-through mb-3">
                        <span>Hoặc tài khoản</span>
                      </div>
                      <?php if (!empty($login_error)): ?>
                        <div style="color: red; margin-bottom: 10px;">
                          <?php echo htmlspecialchars($login_error); ?>
                        </div>
                      <?php endif; ?>
                      <form action="/duan11/routes/User.php?action=login" method="POST">
                        

                    
                      <div class="form-group mb-4">
                        <input
                          name="email"
                          id="email"
                          type="email"
                          class="form-control required" required
                          placeholder="Tài khoản" />
                      </div>

                      <div class="form-group mb-4">
                        <input
                          name="password"
                          id="password"
                          type="password"
                          class="form-control required"
                          placeholder="Mật khẩu" />
                      </div>

                      <button
                        nh-btn-action="submit"
                        class="btn btn-submit w-100 mb-3">
                        Đăng nhập
                      </button>
                      <input type="hidden" name="redirect" value="" />
                      <div
                        class="d-flex justify-content-between align-items-center mt-3">
                        <a
                          href="register.php"
                          class="d-block text-uppercase font-weight-bold color-highlight">
                          Đăng ký ngay
                        </a>
                        <a
                          class="d-block text-dark"
                          href="forgot-password.html">
                          Quên mật khẩu ?
                        </a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div nh-row="601bgio" class="border-bottom-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-12">
            <div nh-block="qhdw2uy" nh-block-cache="true" class="">
              <div class="logo-section">
                <a href="../index.html"><img
                    class="img-fluid"
                    src="/duan11/assets/templates/thoitrang05/assets/media/logo/logo.png"
                    alt="logo" /></a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div nh-block="ze61uwh" nh-block-cache="true" class="">
              <div class="footer-description-right">
                <div class="btn-gop-y">
                  <a href="../lien-he.html">GÓP Ý TỪ BẠN</a>
                </div>
                <div class="text-description-comments">
                  Mỗi đóng góp từ bạn chính là kim chỉ nam đề chúng tôi không
                  ngừng thay đôi và cải thiện mỗi ngày
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div nh-row="ileq1fy" class="border-bottom-footer-01">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-12">
            <div nh-block="w41f9sj" nh-block-cache="true" class="">
              <div class="menu-footer">
                <div class="title-footer">về chúng tôi</div>
                <ul>
                  <li class=""><a href="../index.html">Thông tin</a></li>
                  <li class=""><a href="../tin-tuc.html">Blog</a></li>
                  <li class=""><a href="../index.html">Tuyển dụng</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-12">
            <div nh-block="p9mqyc2" nh-block-cache="true" class="">
              <div class="menu-footer">
                <div class="title-footer">CHÍNH SÁCH KHÁCH HÀNG</div>
                <ul>
                  <li class="">
                    <a href="../index.html">Chính sách kiểm hàng</a>
                  </li>
                  <li class="">
                    <a href="../tin-tuc.html">Chính sách đổi trả</a>
                  </li>
                  <li class="">
                    <a href="../index.html">Bảo mật thông tin</a>
                  </li>
                  <li class="">
                    <a href="../index.html">Thanh toán - Giao hàng</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-12">
            <div nh-block="8z96myo" nh-block-cache="true" class="">
              <div class="menu-footer">
                <div class="title-footer">Liên hệ</div>
                <ul>
                  <li class="">
                    <a href="../mailto_%20contact%40sm4s.html">Email: contact@sm4s.vn</a>
                  </li>
                  <li class="">
                    <a href="../tel_0901191616.html">Hotline(Zalo): 0901191616</a>
                  </li>
                  <li class="">
                    <a href="../tel_1900%206680.html">Điện thoại: 1900 6680</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-12">
            <div nh-block="5cpl2oh" nh-block-cache="true" class="">
              <div class="entire-info-website">
                <div class="title-footer">Hệ thống cửa hàng</div>
                <address>
                  <p>
                    <span class="d-inline-block mr-2 font-weight-bold">Hà Nội:</span>Tầng 4, Tòa nhà số 97 - 99 Láng Hạ, Đống Đa, Hà Nội (Tòa
                    nhà Petrowaco)
                  </p>
                </address>
                <address>
                  <p>
                    <span class="d-inline-block mr-2 font-weight-bold">HCM:</span>927/1 CMT8, Phường 7, Quận Tân Bình, TP.HCM
                  </p>
                </address>
                <address>
                  <p>
                    <span class="d-inline-block mr-2 font-weight-bold">Vinh:</span>Tầng 2 chung cư saigonsky, Ngõ 26, Nguyễn Thái Học,
                    Phường Đội Cung, TP. Vinh, Nghệ An
                  </p>
                </address>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div nh-row="8kh5p9q" class="">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-12">
            <div nh-block="47gc3wp" nh-block-cache="true" class="">
              <div class="text-white copyright text-center pb-4">
                Copyright © 2024 Web4s. All rights reserved.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <div
    id="login-modal"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content rounded-8">
        <div class="modal-body p-0">
          <div
            class="modal-title h2 text-uppercase text-center font-weight-bold pt-5">
            Đăng nhập
          </div>
          <form
            nh-form="member-login"
            action="https://thoitrang09.themeweb4s.com/member/ajax-login"
            class="input-form-member"
            method="post"
            autocomplete="off">
            <div class="p-5">
              <div class="row mx-n2">
                <div class="col-md-6 col-12 px-2">
                  <span
                    nh-btn-login-social="google"
                    nh-oauthserver="https://accounts.google.com/o/oauth2/v2/auth"
                    class="btn btn-submit d-flex align-items-center justify-content-center text-center mb-3 rounded-8">
                    <i class="fa-2x fa-brands fa-google mr-3"></i>
                    Đăng nhập google
                  </span>
                </div>
                <div class="col-md-6 col-12 px-2">
                  <span
                    nh-btn-login-social="facebook"
                    nh-oauthserver="https://www.facebook.com/v14.0/dialog/oauth"
                    class="btn btn-submit d-flex align-items-center justify-content-center text-center mb-3 rounded-8">
                    <i class="fa-2x fa-brands fa-facebook mr-3"></i>
                    Đăng nhập facebook
                  </span>
                </div>
              </div>
              <div class="text-line-through mb-3">
                <span>Hoặc tài khoản</span>
              </div>

              <div class="form-group mb-4">
                <input
                  name="username"
                  id="username"
                  type="text"
                  class="form-control required"
                  placeholder="Tài khoản" />
              </div>

              <div class="form-group mb-4">
                <input
                  name="password"
                  id="password"
                  type="password"
                  class="form-control required"
                  placeholder="Mật khẩu" />
              </div>

              <button
                nh-btn-action="submit"
                class="btn btn-submit w-100 mb-3">
                Đăng nhập
              </button>
              <input type="hidden" name="redirect" value="" />
              <div
                class="d-flex justify-content-between align-items-center mt-3">
                <a
                  href="register.html"
                  class="d-block text-uppercase font-weight-bold color-highlight">
                  Đăng ký ngay
                </a>
                <a class="d-block text-dark" href="forgot-password.html">
                  Quên mật khẩu ?
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div
    id="info-comment-modal"
    class="modal fade"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-body">
          <h3 class="modal-comment-title text-center">
            <b>Thông tin người gửi</b>
          </h3>
          <div class="modal-comment-content">
            <div class="text-center mb-5">
              Để gửi bình luận bạn vui lòng cung cấp thêm thông tin liên hệ
            </div>
            <form id="info-comment-form" method="POST" autocomplete="off">
              <div class="form-group">
                <label>Tên hiển thị:<span class="required">*</span></label><input name="full_name" class="form-control" type="text" />
              </div>
              <div class="form-group">
                <label>Email:<span class="required">*</span></label><input name="email" class="form-control" type="text" />
              </div>
              <div class="form-group">
                <label>Số điện thoại:<span class="required">*</span></label><input name="phone" class="form-control" type="text" />
              </div>
            </form>
          </div>
          <button
            id="btn-send-info"
            type="button"
            class="col-12 btn btn-primary">
            Cập nhật
          </button>
        </div>
      </div>
    </div>
  </div>
  <div
    id="toasts"
    class="position-fixed p-3"
    style="z-index: 100000; right: 0; top: 0"></div>

  <div
    id="quick-view-modal"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div
      class="modal-dialog modal-xl h-100 d-flex flex-column justify-content-center my-0">
      <div class="modal-content entire-quickview p-4"></div>
    </div>
  </div>
  <div nh-compare="modal" class="compare-modal"></div>
  <div
    id="compare-search-modal"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" class="box-suggest">
            <div class="input-group">
              <input
                nh-auto-suggest="compare"
                name="keyword"
                placeholder="Tìm kiếm sản phẩm"
                type="text"
                class="form-control" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div nh-mini-cart="sidebar" class="sidebar-mini-cart">
    <div
      class="title-top-cart d-flex justify-content-between align-items-center mx-3 mx-md-5 mt-5">
      <div class="title-cart h3 font-weight-bold mb-0">Giỏ hàng của bạn</div>
      <div class="sidebar-header">
        <a
          href="javascript:;"
          nh-mini-cart="close"
          class="close-sidebar effect-rotate icon-close"><i class="fa-light fa-xmark"></i></a>
      </div>
    </div>
    <div class="content-mini-cart">
      <div class="box-minicart" nh-total-quantity-cart="0">
        <ul class="cart-list list-unstyled mb-0">
          <li class="empty text-center mt-5">
            <i class="fa-brands fa-opencart"></i>
            <div class="empty-cart">Chưa có sản phẩm nào trong giỏ hàng</div>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <input
    id="nh-data-init"
    type="hidden"
    value='{"device":0,"member":null,"social":null,"template":{"code":"thoitrang05","url":"\/templates\/thoitrang05\/"},"cdn_url":"https:\/\/cdn3533.cdn-template-4s.com","wishlist":null,"recaptcha":null,"embed_code":null,"cart":null,"product":{"check_quantity":null}}' />

  <script type="application/ld+json">
    {
      "@context": "https:\/\/schema.org",
      "@type": "Organization",
      "name": "Web4s Company",
      "legalName": "C\u00d4NG TY C\u1ed4 PH\u1ea6N GI\u1ea2I PH\u00c1P C\u00d4NG NGH\u1ec6 4S",
      "url": "https:\/\/thoitrang09.themeweb4s.com\/",
      "logo": "https:\/\/cdn3533.cdn-template-4s.com\/media\/logo\/logo-1970.png"
    }
  </script>

  <script type="application/ld+json">
    {
      "@context": "https:\/\/schema.org",
      "@type": "WebSite",
      "url": "https:\/\/thoitrang09.themeweb4s.com",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https:\/\/thoitrang09.themeweb4s.com\/tim-kiem?keyword={query}",
        "query-input": "required name=query"
      }
    }
  </script>

  <script type="application/ld+json">
    {
      "@context": "https:\/\/schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [{
          "@type": "ListItem",
          "position": 1,
          "item": {
            "@id": "https:\/\/thoitrang09.themeweb4s.com",
            "name": "Web4s Company"
          }
        },
        {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@id": "https:\/\/thoitrang09.themeweb4s.com\/member\/login",
            "name": "T\u00e0i kho\u1ea3n th\u00e0nh vi\u00ean"
          }
        }
      ]
    }
  </script>

  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/jquery/jquery-3.6.0.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/jquery-lazy/jquery.lazy.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/jquery-lazy/jquery.lazy.plugins.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/jquery/jquery.validate.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/jquery/jquery.cookie.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap/popper.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap/util.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap/dropdown.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap/collapse.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap/modal.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap/toast.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap/tab.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/swiper/swiper-bundle.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/constants.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/locales/vi.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/lazy.js"
    type="text/javascript"></script>

  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/inputmask/jquery.inputmask.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/lightgallery-all.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap-select/bootstrap-select.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap-datepicker/bootstrap-datepicker.min.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/bootstrap-datepicker/locales/vi.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/lib/tocbot/tocbot.min.js"
    type="text/javascript"></script>

  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/main.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/menu.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/search.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/product.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/order.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/wishlist.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/compare.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/member.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/contact.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/custom.js"
    type="text/javascript"></script>

  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/catalogue.js"
    type="text/javascript"></script>
  <script
    src="/duan11/assets/templates/thoitrang05/assets/js/comment.js"
    type="text/javascript"></script>
</body>

<!-- Mirrored from thoitrang09.themeweb4s.com/member/login by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Mar 2025 08:45:47 GMT -->

</html>