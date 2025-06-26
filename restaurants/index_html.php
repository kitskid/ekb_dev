<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Рестораны города | Екатеринбург");
?>
<main class="main">
    <section class="section section--intro" style="--background: url('../assets/images/main-bg-3.jpg')">
        <div class="container">
            <div class="intro">
                <h1 class="title title--light">
                    Гостиницы города
                </h1>
                <p class="subtitle">
                    В 2023 году Екатеринбург отпразднует свое 300-летие. Свою историю город отсчитывает с 18 ноября 1723
                    года, когда были запущены цеха крупнейшего в России железоделательного Екатерининского завода.
                </p>
            </div>
        </div>
    </section>
    <section class="section section--gradient pt-130 ptm-64 pb-125 pbm-30">
        <div class="container">
            <div class="header-block">
                <h2 class="title">Где остановиться</h2>
            </div>
            <div class="hotels">
                <div class="filter">
                    <a href="#" class="tag tag--filter active" target="_blank">
                        <span>гостиницы 5</span>
                        <svg>
                            <use xlink:href="./assets/sprite.svg#icon-star"></use>
                        </svg>
                    </a>
                    <a href="#" class="tag tag--filter active" target="_blank">
                        <span>гостиницы 4</span>
                        <svg>
                            <use xlink:href="./assets/sprite.svg#icon-star"></use>
                        </svg>
                    </a>
                    <a href="#" class="tag tag--filter active" target="_blank">
                        <span>гостиницы 3</span>
                        <svg>
                            <use xlink:href="./assets/sprite.svg#icon-star"></use>
                        </svg>
                    </a>
                    <a href="#" class="tag tag--filter" target="_blank">хостелы</a>
                    <a href="#" class="tag tag--filter" target="_blank">кемпинги</a>
                    <a href="#" class="tag tag--filter" target="_blank">глемпинги</a>
                </div>
                <div class="hotels__list">
                    <a href="#" class="article-news article-news--max-size article-news--attraction article-news--light">
                    <span class="article-news__badges">
                        <span class="badge">топ!</span>
                    </span>
                        <picture class="article-news__picture">
                            <img src="./assets/images/hotel-1.png" alt="">
                        </picture>
                        <div class="article-news__info">
                            <h2 class="article-news__title">
                                Отель-гостиница Мегалайт
                            </h2>
                            <p class="article-news__place">
                                <svg>
                                    <use xlink:href="./assets/sprite.svg#icon-location"></use>
                                </svg>
                                <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                            </p>
                        </div>
                    </a>
                    <a href="#" class="article-news article-news--max-size article-news--attraction article-news--light">
                    <span class="article-news__badges">
                        <span class="badge">топ!</span>
                    </span>
                        <picture class="article-news__picture">
                            <img src="./assets/images/hotel-2.jpg" alt="">
                        </picture>
                        <div class="article-news__info">
                            <h2 class="article-news__title">
                                Отель-гостиница Мегалайт
                            </h2>
                            <p class="article-news__place">
                                <svg>
                                    <use xlink:href="./assets/sprite.svg#icon-location"></use>
                                </svg>
                                <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                            </p>
                        </div>
                    </a>
                    <a href="#" class="article-news article-news--max-size article-news--attraction article-news--light">
                    <span class="article-news__badges">
                        <span class="badge">топ!</span>
                    </span>
                        <picture class="article-news__picture">
                            <img src="./assets/images/hotel-3.png" alt="">
                        </picture>
                        <div class="article-news__info">
                            <h2 class="article-news__title">
                                Отель-гостиница Мегалайт
                            </h2>
                            <p class="article-news__place">
                                <svg>
                                    <use xlink:href="./assets/sprite.svg#icon-location"></use>
                                </svg>
                                <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                            </p>
                        </div>
                    </a>
                    <a href="#" class="article-news article-news--max-size article-news--attraction article-news--light">
                    <span class="article-news__badges">
                        <span class="badge">топ!</span>
                    </span>
                        <picture class="article-news__picture">
                            <img src="./assets/images/hotel-4.png" alt="">
                        </picture>
                        <div class="article-news__info">
                            <h2 class="article-news__title">
                                Отель-гостиница Мегалайт
                            </h2>
                            <p class="article-news__place">
                                <svg>
                                    <use xlink:href="./assets/sprite.svg#icon-location"></use>
                                </svg>
                                <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                            </p>
                        </div>
                    </a>
                </div>
                <button class="button button--down">
                    <span>Показать больше</span>
                    <span class="button__icon">
                    <svg>
                        <use xlink:href="./assets/sprite.svg#icon-arrow-down"></use>
                    </svg>
                </span>
                </button>
            </div>
        </div>
    </section>

    <section class="section section--logo-bg section--logo-bg-top pt-130 ptm-55 pb-130 pbm-80">
        <div class="container">
            <div class="header-block">
                <h2 class="title">Карта гостиниц</h2>
            </div>
            <div class="map">
                <iframe src="https://yandex.ru/map-widget/v1/?ll=60.599925%2C56.828213&z=13.62" width="560" height="400"
                        frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
            </div>
        </div>
    </section>

</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
