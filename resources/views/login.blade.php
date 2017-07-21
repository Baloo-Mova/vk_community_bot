<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Knocker - сервис умных рассылок ВКонтакте</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <!-- Animate CSS -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">
    <!-- Lity CSS -->
    <link href="{{ asset('css/lity.min.css') }}" rel="stylesheet">
    <!-- Our Min CSS -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- Start Preloader -->
<div class="preloader">
    <div class="spinner">
        <div class="cube1"></div>
        <div class="cube2"></div>
    </div>
</div>
<!-- End Preloader -->
<!-- Start Header -->
<header>
    <nav class="navbar navbar-default appy-menu" data-spy="appy-menu">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_menu" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand scroll-section" href="#home_banner"><img src="{{ asset('img/logo.png') }}" class="img-responsive" alt=""></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="main_menu">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a class="scroll-section" href="#home_banner">Домой </a></li>
                    <li><a class="scroll-section" href="#about">Для кого</a></li>
                    <li><a class="scroll-section" href="#features">Что умеет</a></li>
                    <li><a class="scroll-section" href="#ft2">Преимущества</a></li>
                    <li><a class="scroll-section" href="#testimonial">Отзывы</a></li>
                    <li><a class="scroll-section" href="#price">Цена</a></li>
                    <li><a class="scroll-section" href="#faq">FAQ</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <section id="home_banner" class="home-slide" style="">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="mt-250"></div>
                    <h3>Достучитесь до своей аудитории
                        с Knocker </h3>
                    <p>Создавайте рассылки в социальной сети ВКонтакте с открываемостью до 97%
                        и повысьте доходность своего бизнеса без дополнительных затрат</p>
                    <a class="btn btn-default scroll-section" href="#features" role="button">Узнать больше </a>
                    <a class="btn btn-default" href="{{ route('vk_login') }}" role="button">Войти</a>
                </div>
                <div class="col-md-6">
                    <div class="mt-200 hidden-sm hidden-xs"></div>
                    <img src="{{ asset('img/mockup.png') }}" class="img-responsive center-block" alt="">
                </div>
            </div>
        </div>
    </section>
</header>
<!-- End Header -->
<!-- Start About Section -->
<section id="about" class="padding-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade text-center">
                <h3>Для кого</h3>
                <div class="space-25"></div>
                <p>Кому рекомендовано использовать <br />
                    рассылки в личные сообщения </p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-4 text-center about-box" data-aos="fade-up" data-aos-delay="200">
                <img src="{{ asset('img/infobiz.png') }}" class="img-responsive center-block" alt="">
                <h4>Инфобизнесменам</h4>
                <p>Открываемость 97%, против ≈15% другими способами, позволяет повысить доходность без дополнительных затрат </p>
            </div>
            <div class="col-md-4 text-center about-box" data-aos="fade-up" data-aos-delay="400">
                <img src="{{ asset('img/owner.png') }}" class="img-responsive center-block" alt="">
                <h4>Владельцам бизнеса</h4>
                <p>Принимая заявки и рассказывая клиентам об акциях
                    в личных сообщениях, Вы существенно повысите свою прибыль </p>
            </div>
            <div class="col-md-4 text-center about-box" data-aos="fade-up" data-aos-delay="600">
                <img src="{{ asset('img/smm.png') }}" class="img-responsive center-block" alt="">
                <h4>SMM-менеджерам </h4>
                <p>Предложите клиентам новый способ сбора заявок
                    и увеличьте эффективность их рекламы минимум в 1.6 раза.</p>
            </div>
        </div>
    </div>
</section>
<!-- End About Section -->
<!-- Start Features Section -->
<section id="features" class="pt-100" style="">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade white text-center">
                <h3>Что умеет сервис </h3>
                <div class="space-25"></div>
                <p>Мы регулярно проводим обновления сервиса по пожеланиям клиентов, <br >благодаря чему функционал постоянно расширяется </p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-4 text-right">
                <div class="features-wrapper right-icon">
                    <ul class="list-unstyled">
                        <li>
                            <div class="single-feature" data-aos="fade-right" data-aos-delay="200">
                                <div class="features-icon">
                                    <img src="{{ asset('img/autoanswer.png') }}" class="img-responsive" alt="">
                                </div>
                                <div class="features-details">
                                    <h5>Автоматические ответы</h5>
                                    <p>Бот сам вышлет Вашим клиентам бесплатный курс, уточнит удобное время для консультации
                                        или пригласит в закрытую группу – достаточно создать соответствующий сценарий </p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <li>
                            <div class="single-feature" data-aos="fade-right" data-aos-delay="400">
                                <div class="features-icon">
                                    <img src="{{ asset('img/list.png') }}" class="img-responsive" alt="">
                                </div>
                                <div class="features-details">
                                    <h5>Распределение по спискам </h5>
                                    <p>Как написать только тем, кто записывался на консультацию или на вебинар?
                                        Сервис автоматически распределит людей по спискам в зависимости от их поведения</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <li>
                            <div class="single-feature" data-aos="fade-right" data-aos-delay="600">
                                <div class="features-icon">
                                    <img src="{{ asset('img/moderator.png') }}" class="img-responsive" alt="">
                                </div>
                                <div class="features-details">
                                    <h5>Модератор (скоро!)</h5>
                                    <p>Узнайте о новом сообщении, комментарии, записи под товаром или фотографией, о вступившем и вышедшем – оповещения можно настроить на почту или телефон </p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 text-center about-box hidden-sm hidden-xs" data-aos="fade-up">
                <img src="{{ asset('img/phone.png') }}" class="img-responsive center-block" style="margin-top: 100px" alt="">
            </div>
            <div class="col-md-4 text-left about-box">
                <div class="features-wrapper left-icon">
                    <ul class="list-unstyled">
                        <li>
                            <div class="single-feature" data-aos="fade-left" data-aos-delay="200">
                                <div class="features-icon">
                                    <img src="{{ asset('img/mailing.png') }}" class="img-responsive" alt="">
                                </div>
                                <div class="features-details">
                                    <h5> Мгновенные рассылки </h5>
                                    <p> Отправляйте письма сейчас или запланируйте их на потом, отправляйте всем или только тем, кто записался на прошлый вебинар, но не купил тренинг – возможно все.</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <li>
                            <div class="single-feature" data-aos="fade-left" data-aos-delay="400">
                                <div class="features-icon">
                                    <img src="{{ asset('img/mails.png') }}" class="img-responsive" alt="">
                                </div>
                                <div class="features-details">
                                    <h5>Цепочки писем</h5>
                                    <p> Взаимодействуйте с пользователем в течение длительного времени, отсылая ему новый контент через определенное время после подписки – можно указать промежуток с точностью до минуты. </p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <li>
                            <div class="single-feature" data-aos="fade-left" data-aos-delay="600">
                                <div class="features-icon">
                                    <img src="{{ asset('img/subscribe.png') }}" class="img-responsive" alt="">
                                </div>
                                <div class="features-details">
                                    <h5> Подписка через сайт (скоро!)</h5>
                                    <p> Добавляйте на сайт кнопку, которая сразу подпишет людей на нужный список рассылок или цепочку и позволит отследить эффективность каждого канала через utm-метки</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Start Features Section -->
<!-- Start One Feature Section -->
<section class="one-feature pt-100" id="ft2">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hidden-sm hidden-xs" data-aos="fade-right" data-aos-delay="600">
                <img src="{{ asset('img/preim-1.png') }}" class="img-responsive center-block" alt="" alt="">
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                <h2>Аудитория,<Br /> которая онлайн </h2>
                <p>На сегодняшний день все больше людей проверяют почту не каждый день, в их ящиках скапливается более сотни непрочитанных писем. В это время Вконтакте стал первым по посещаемости сайтом России, пользователи заходят на этот сайт ежедневно и регулярно читают входящие сообщения </p>
                <a class="btn btn-default colored scroll-section" href="#price" role="button">Узнать цену</a>
            </div>
        </div>
    </div>
</section>
<!-- End One Feature Section -->
<!-- Start One Feature Section -->
<section class="one-feature pt-100">
    <div class="container">
        <div class="row">
            <div class="col-md-6" data-aos="fade-right" data-aos-delay="200">
                <h2>Увеличение <br />конверсии материалов </h2>
                <p>Одинаковое объявление, ведущее на сторонний сайт и на страницу ВКонтакте, во втором случае даст конверсию примерно в 1,4 раза, так как аудитория сайта не любит покидать его. С помощью сервиса Вы сможете делать воронки и запуски, даже не создавая для этого лендинг </p>
                <a class="btn btn-default colored scroll-section" href="#price" role="button">Узнать цену</a>
            </div>
            <div class="col-md-6 hidden-sm hidden-xs" data-aos="fade-left" data-aos-delay="600">
                <img src="{{ asset('img/preim-2.png') }}" class="img-responsive center-block" alt="" alt="">
            </div>
        </div>
    </div>
</section>
<!-- End One Feature Section -->
<!-- Start One Feature Section -->
<section class="one-feature padding-100">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hidden-sm hidden-xs" data-aos="fade-right" data-aos-delay="600">
                <img src="{{ asset('img/preim-3.png') }}" class="img-responsive center-block" alt="">
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                <h2>Обновления, которые нужны именно Вам </h2>
                <p>Мы открыты для новых предложений, а так же сами придумываем обновления, которые будут полезны инфобизнесменам и владельцам бизнеса, так как сами работаем в этих сферах. </p>
                <a class="btn btn-default colored scroll-section" href="#price" role="button">Узнать цену</a>
            </div>
        </div>
    </div>
</section>
<!-- End One Feature Section -->
<!-- Start Testimonial Section -->
<section id="testimonial" class="padding-100" style="">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade white text-center">
                <h3>Рассылка в цифрах </h3>
                <div class="space-25"></div>
                <p>Результаты наших клиентов при рассылке ВКонтакте </p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-12">
                <div class="testimonial-slider owl-carousel owl-theme">
                    <div class="item">
                        <div class="col-sm-6">
                            <div class="col-md-4 text-center hidden">
                                <div class="client-img center-block">
                                    <img src="{{ asset('img/simpsons-avatar_oze1t.jpg') }}" class="img-responsive center-block" alt="">
                                </div>
                                <h4 class="hidden">Mr. John Doe</h4>
                                <div class="client-rate">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-8 col-lg-offset-6 col-md-offset-4 spis">
                                <p class="center"><strong>
                                        Без сервиса:
                                    </strong></p>
                                <p>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>Затрачено: 2395 рублей <br/>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>Заявок на консультацию: 9 <br/>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>Дошли до консультации: 0 <br/>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-md-4 text-center hidden">
                                <div class="client-img center-block">
                                    <img src="{{ asset('img/simpsons-avatar_oze1t.jpg') }}" class="img-responsive center-block" alt="">
                                </div>
                                <h4>Mr. John Doe</h4>
                                <div class="client-rate">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-8 spis">
                                <p class="center"><strong>С сервисом:</strong> </p>
                                <p>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Затрачено: 534 рубля <br />
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Заявок на консультацию: 11 <br />
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Дошли до консультации: 9
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--item 2-->
                    <div class="item">
                        <div class="col-sm-6">
                            <div class="col-md-4 text-center hidden">
                                <div class="client-img center-block">
                                    <img src="{{ asset('img/simpsons-avatar_oze1t.jpg') }}" class="img-responsive center-block" alt="">
                                </div>
                                <h4 class="hidden">Mr. John Doe</h4>
                                <div class="client-rate">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-8 col-lg-offset-6 col-md-offset-4 spis">
                                <p class="center"><strong>
                                        Без сервиса:
                                    </strong></p>
                                <p>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>Затрачено: 45694 рублей <br/>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>Записалось на вебинар: 1176  <br/>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>Доход: 136000 рубля  <br/>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-md-4 text-center hidden">
                                <div class="client-img center-block">
                                    <img src="{{ asset('img/simpsons-avatar_oze1t.jpg') }}" class="img-responsive center-block" alt="">
                                </div>
                                <h4>Mr. John Doe</h4>
                                <div class="client-rate">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-8 spis">
                                <p class="center"><strong>С сервисом:</strong> </p>
                                <p>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Затрачено: 29521 рубль <br />
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Записалось на вебинар: 1089 <br />
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Доход: 324000 рублей
                                </p>
                            </div>
                        </div>
                    </div>


                    <!--item 3-->
                    <div class="item">
                        <div class="col-sm-6">
                            <div class="col-md-4 text-center hidden">
                                <div class="client-img center-block">
                                    <img src="{{ asset('img/simpsons-avatar_oze1t.jpg') }}" class="img-responsive center-block" alt="">
                                </div>
                                <h4 class="hidden">Mr. John Doe</h4>
                                <div class="client-rate">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-8 col-lg-offset-6 col-md-offset-4 spis">
                                <p class="center"><strong>
                                        Без сервиса:
                                    </strong></p>
                                <p>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>Затрачено: 12034 рубля <br/>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>Записалось в автоворонку: 624   <br/>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>Доход: 40000 рублей  <br/>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-md-4 text-center hidden">
                                <div class="client-img center-block">
                                    <img src="{{ asset('img/simpsons-avatar_oze1t.jpg') }}" class="img-responsive center-block" alt="">
                                </div>
                                <h4>Mr. John Doe</h4>
                                <div class="client-rate">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-8 spis">
                                <p class="center"><strong>С сервисом:</strong> </p>
                                <p>
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Затрачено: 10935 рублей <br />
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Записалось в автоворонку: 753 <br />
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Доход: 67000
                                </p>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Testimonial Section -->
<!-- Start Screenshots Section -->
<section id="screenshots" class="padding-100 hidden">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade text-center">
                <h3>screenshots</h3>
                <div class="space-25"></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    <br>sed do eiusmod tempor incididunt ut labore.</p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6 text-center">
                <div class="screenshots-slider owl-carousel owl-theme">
                    <div class="item"><img src="http://via.placeholder.com/265x470" class="img-responsive" alt=""></div>
                    <div class="item"><img src="http://via.placeholder.com/265x470" class="img-responsive" alt=""></div>
                    <div class="item"><img src="http://via.placeholder.com/265x470" class="img-responsive" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Screenshots Section -->
<!-- Start Countup Section -->
<section id="countup" class="padding-100 hidden" style="">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade white text-center">
                <h3>statistics</h3>
                <div class="space-25"></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    <br>sed do eiusmod tempor incididunt ut labore.</p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="countup-box" data-aos="fade-zoom-in">
                    <img src="{{ asset('img/icon-10.png') }}" class="img-responsive center-block" alt="">
                    <div class="count-num"><span>16</span>K</div>
                    <div class="count-name">Download</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="countup-box" data-aos="fade-zoom-in">
                    <img src="{{ asset('img/icon-11.png') }}" class="img-responsive center-block" alt="">
                    <div class="count-num"><span>2500</span></div>
                    <div class="count-name">Line code</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="countup-box" data-aos="fade-zoom-in">
                    <img src="{{ asset('img/icon-12.png') }}" class="img-responsive center-block" alt="">
                    <div class="count-num"><span>255</span></div>
                    <div class="count-name">coffee cups</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="countup-box" data-aos="fade-zoom-in">
                    <img src="{{ asset('img/icon-13.png') }}" class="img-responsive center-block" alt="">
                    <div class="count-num"><span>1500</span></div>
                    <div class="count-name">shere</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Countup Section -->
<!-- Start Price Section -->
<section id="price" class="padding-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade text-center">
                <h3>Сколько стоит</h3>
                <div class="space-25"></div>
                <p>Оплачивая сейчас, Вы получаете бесплатный <br/>доступ ко всем обновлениями </p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-4 hidden">
                <div class="price-table text-center">
                    <div class="space-50"></div>
                    <h4>Starter</h4>
                    <div class="space-50"></div>
                    <div class="cost">
                        <h3>20<span>$</span></h3>
                    </div>
                    <div class="space-50"></div>
                    <ul class="list-unstyled">
                        <li>100 MB Disk Space</li>
                        <li>2 Subdomains</li>
                        <li>5 Email Accounts</li>
                        <li>Webmail Support</li>
                        <li>Customer Support 24/7</li>
                    </ul>
                    <div class="space-50"></div>
                    <a class="btn btn-default blue" href="#" role="button">Read More</a>
                    <div class="space-50"></div>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
                <div class="price-table text-center feature">
                    <div class="space-50"></div>

                    <div class="space-50"></div>
                    <div class="cost">
                        <h3><span>до&nbsp;&nbsp;&nbsp;</span>399<span>&nbsp;&nbsp;&nbsp;руб</span></h3>
                    </div>
                    <div class="space-50"></div>
                    <ul class="list-unstyled">
                        <li>Цена за 1 группу на месяц </li>
                        <li>Скидки при оплате за несколько месяцев </li>
                        <li>Отзывчивая техподдержка </li>
                        <li>Регулярные обновления</li>

                    </ul>
                    <div class="space-50"></div>
                    <a class="btn btn-default colored" href="{{ route('vk_login') }}" role="button">Перейти к сервису</a>
                    <div class="space-50"></div>
                </div>
            </div>
            <div class="col-md-4 hidden">
                <div class="price-table text-center">
                    <div class="space-50"></div>
                    <h4>unlimited</h4>
                    <div class="space-50"></div>
                    <div class="cost">
                        <h3>40<span>$</span></h3>
                    </div>
                    <div class="space-50"></div>
                    <ul class="list-unstyled">
                        <li>100 MB Disk Space</li>
                        <li>2 Subdomains</li>
                        <li>5 Email Accounts</li>
                        <li>Webmail Support</li>
                        <li>Customer Support 24/7</li>
                    </ul>
                    <div class="space-50"></div>
                    <a class="btn btn-default blue" href="#" role="button">Read More</a>
                    <div class="space-50"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Price Section -->
<!-- Start Video Section -->
<section id="video" class="padding-100 hidden" style="">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade white text-center">
                <h3>Watch video</h3>
                <div class="space-25"></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    <br>sed do eiusmod tempor incididunt ut labore.</p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-12 text-center">
                <a href="http://www.youtube.com/watch?v=XSGBVzeBUbk" data-lity>
                    <img src="{{ asset('img/icon-14.png') }}" class="img-responsive center-block" alt="">
                </a>
            </div>
        </div>
    </div>
</section>
<!-- End Video Section -->
<!-- Start Team Section -->
<section id="team" class="padding-100 hidden">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade text-center">
                <h3>Meet the Team</h3>
                <div class="space-25"></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    <br>sed do eiusmod tempor incididunt ut labore.</p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-12">
                <div class="team-slider owl-carousel owl-theme">
                    <div class="item">
                        <div class="person">
                            <img src="http://via.placeholder.com/420x525" class="img-responsive" alt="">
                            <div class="person-info overlay">
                                <div class="info-bottom">
                                    <h4>Jonh Doe</h4>
                                    <h6>Front-end Developer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Proin sodales.</p>
                                    <ul class="list-inline social-icons">
                                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="person">
                            <img src="http://via.placeholder.com/420x525" class="img-responsive" alt="">
                            <div class="person-info overlay">
                                <div class="info-bottom">
                                    <h4>Jonh Doe</h4>
                                    <h6>Front-end Developer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Proin sodales.</p>
                                    <ul class="list-inline social-icons">
                                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="person">
                            <img src="http://via.placeholder.com/420x525" class="img-responsive" alt="">
                            <div class="person-info overlay">
                                <div class="info-bottom">
                                    <h4>Jonh Doe</h4>
                                    <h6>Front-end Developer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Proin sodales.</p>
                                    <ul class="list-inline social-icons">
                                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="person">
                            <img src="http://via.placeholder.com/420x525" class="img-responsive" alt="">
                            <div class="person-info overlay">
                                <div class="info-bottom">
                                    <h4>Jonh Doe</h4>
                                    <h6>Front-end Developer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Proin sodales.</p>
                                    <ul class="list-inline social-icons">
                                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="person">
                            <img src="http://via.placeholder.com/420x525" class="img-responsive" alt="">
                            <div class="person-info overlay">
                                <div class="info-bottom">
                                    <h4>Jonh Doe</h4>
                                    <h6>Front-end Developer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Proin sodales.</p>
                                    <ul class="list-inline social-icons">
                                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="person">
                            <img src="http://via.placeholder.com/420x525" class="img-responsive" alt="">
                            <div class="person-info overlay">
                                <div class="info-bottom">
                                    <h4>Jonh Doe</h4>
                                    <h6>Front-end Developer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Proin sodales.</p>
                                    <ul class="list-inline social-icons">
                                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="person">
                            <img src="http://via.placeholder.com/420x525" class="img-responsive" alt="">
                            <div class="person-info overlay">
                                <div class="info-bottom">
                                    <h4>Jonh Doe</h4>
                                    <h6>Front-end Developer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Proin sodales.</p>
                                    <ul class="list-inline social-icons">
                                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="person">
                            <img src="http://via.placeholder.com/420x525" class="img-responsive" alt="">
                            <div class="person-info overlay">
                                <div class="info-bottom">
                                    <h4>Jonh Doe</h4>
                                    <h6>Front-end Developer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Proin sodales.</p>
                                    <ul class="list-inline social-icons">
                                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="person">
                            <img src="http://via.placeholder.com/420x525" class="img-responsive" alt="">
                            <div class="person-info overlay">
                                <div class="info-bottom">
                                    <h4>Jonh Doe</h4>
                                    <h6>Front-end Developer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Proin sodales.</p>
                                    <ul class="list-inline social-icons">
                                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Team Section -->
<!-- Start Download Section -->
<section id="download" class="padding-100" style="">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade white text-center">
                <h3>Наша группа </h3>
                <div class="space-25"></div>
                <p> Подпишитесь, <Br />чтобы быть в курсе всех новостей </p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-4 text-center hidden" data-aos="fade-right" data-aos-delay="300">
                <a class="btn btn-default" href="#" role="button"><i class="fa fa-apple" aria-hidden="true"></i> <span>App Store</span></a>
            </div>
            <div class="col-md-4 col-md-offset-4 text-center" data-aos="fade-up" data-aos-delay="300">
                <a class="btn btn-default" href="https://vk.com/vkknocker" role="button" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i> <span>Vkontakte</span></a>
            </div>
            <div class="col-md-4 text-center hidden" data-aos="fade-left" data-aos-delay="300">
                <a class="btn btn-default" href="#" role="button"><i class="fa fa-windows" aria-hidden="true"></i> <span>Windows Store</span></a>
            </div>
        </div>
    </div>
</section>
<!-- End Download Section -->
<!-- Start FAQ Section -->
<section id="faq" class="padding-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade text-center">
                <h3>faq</h3>
                <div class="space-25"></div>
                <p>Если у Вас остались вопросы – <Br />Вы можете задать их в сообщениях нашей группы </p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-6" data-aos="fade-right" data-aos-delay="200">
                <div class="space-50"></div>
                <div class="space-50"></div>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel">
                        <div class="panel-heading" role="tab" id="heading_1">
                            <h4 class="panel-title">
                                <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_1" aria-expanded="true" aria-controls="collapse_1">
                                    Как люди получают мое сообщение?
                                </a>
                            </h4>
                        </div>
                        <div id="collapse_1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_1">
                            <div class="panel-body">
                                Ваше письмо придет как личное сообщение от имени Вашей группы. При отсутствии группы, ее придется создать
                            </div>
                        </div>
                    </div>
                    <!---->
                    <div class="panel">
                        <div class="panel-heading" role="tab" id="heading_2">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_2" aria-expanded="true" aria-controls="collapse_2">
                                    Я могу писать кому угодно в своей группе?
                                </a>
                            </h4>
                        </div>
                        <div id="collapse_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_2">
                            <div class="panel-body">
                                Нет, Вы можете писать только людям, которые давали на это согласие с помощью нажатия кнопки подписки на уведомления или тем, кто хоть раз писал в сообщения Вашей группы. В окне диалоге человек также может отписаться от сообщений
                            </div>
                        </div>
                    </div>
                    <!---->
                    <div class="panel">
                        <div class="panel-heading" role="tab" id="heading_3">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_3" aria-expanded="true" aria-controls="collapse_2">
                                    Я могу писать что угодно?
                                </a>
                            </h4>
                        </div>
                        <div id="collapse_3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_3">
                            <div class="panel-body">
                                Нет, по правилам Вконтакте Вы не можете в личном сообщении принуждать человека к подписке/лайку/репосту за обещание награды (например, курс за подписку), а так же рассылать нетематическую рекламу. Зато Вы можете ставить подписку условием в рекламном сообщении (не ограничивая технически получение подарка людьми, просто написавшими боту) и рассылать рекламу своей деятельности, которой посвящена Ваша группа.
                            </div>
                        </div>
                    </div>
                    <!---->
                    <div class="panel">
                        <div class="panel-heading" role="tab" id="heading_4">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_4" aria-expanded="true" aria-controls="collapse_2">
                                    Я могу перенести базу с другого рассыльщика?
                                </a>
                            </h4>
                        </div>
                        <div id="collapse_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_4">
                            <div class="panel-body">
                                Да, для этого сохраните список id из другого сервиса и Вы сможете без проблем загрузить его к нам. Мы не будем рассылать письма о Вашем переезде Вашим подписчикам в целях саморекламы, как это делают некоторые сервисы.
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="600">
                <img src="{{ asset('img/macbook.png') }}" class="img-responsive center-block" alt="">
            </div>
        </div>
    </div>
</section>
<!-- End FAQ Section -->
<!-- Start Contact Section -->
<section id="contact" class="padding-100 hidden" style="background-image: url('http://via.placeholder.com/1920x1396'); background-size: cover; background-position: 50% 50%;background-attachment: fixed;">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heade white text-center">
                <h3>get in touch</h3>
                <div class="space-25"></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    <br>sed do eiusmod tempor incididunt ut labore.</p>
                <div class="space-50"></div>
            </div>
            <div class="col-md-8">
                <form>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <input class="form-control" type="text" id="yourname" placeholder="Enter Your Name" required>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <input type="email" class="form-control" id="youremail" placeholder="Enter Your Email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="yoursubject" placeholder="Enter Your Subject" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="yourmessage" rows="6" placeholder="Enter Your Message" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-default center-block">submit</button>
                </form>
            </div>
            <div class="col-md-4">
                <ul class="list-unstyled contact-info">
                    <li>
                        <div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                        <div class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                    </li>
                    <li>
                        <div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                        <div class="text">0123456778</div>
                    </li>
                    <li>
                        <div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                        <div class="text"><a href="mailto:mail@appy.com">mail@appy.com</a></div>
                    </li>
                </ul>
                <ul class="list-inline social-icons">
                    <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Section -->
<!-- Start Subscribe Section -->
<section id="subscribe" class="padding-100 hidden">
    <div class="container">
        <div class="row">
            <div class="col-md-6 section-heade">
                <h3>Subscribe</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    <br>sed do eiusmod tempor incididunt ut labore.</p>
            </div>
            <div class="col-md-6 text-center">
                <div class="space-25"></div>
                <form action="#">
                    <div class="subcribe-form">
                        <input class="form-control" name="email" id="email" type="email" placeholder="Your Email" required>
                        <button class="btn btn-default" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Subscribe Section -->
<!-- Start Footer Section -->
<footer class="text-center">
    <p>Knocker - сервис умных рассылок ВКонтакте. <Br />
        © ИП Баранова Василина Михайловна
        ОГРНИП 315784700094696 <Br />
        +79111333950
        Санкт-Петербург, пр-т Авиаконструкторов 12-58, 197350 <br>
        <a href="#mailto:admin@vasilinabaranova.ru">admin@vasilinabaranova.ru</a> </p>
</footer>
<!-- End Footer Section -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- Bootstrap JS -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- Owl Carousel JS -->
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<!-- Counterup JS -->
<script src="{{ asset('js/waypoints.min.js') }}"></script>
<script src="{{ asset('js/jquery.counterup.js') }}"></script>
<!-- AOS JS -->
<script src="{{ asset('js/aos.js') }}"></script>
<!-- lity JS -->
<script src="{{ asset('js/lity.min.js') }}"></script>
<!-- Our Main JS -->
<script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
