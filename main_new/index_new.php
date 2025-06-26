<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Екатеринбург - город контрастов</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        :root {
            --primary-color: #234;
            --accent-red: #e63946;
            --accent-orange: #f77f00;
            --accent-purple: #7209b7;
            --accent-green: #2a9d8f;
            --accent-blue: #4361ee;
            --accent-yellow: #ffb703;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://page1.genspark.site/v1/base64_upload/99755a31203b837f07cf159171c9ba79');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }

        .hero-content {
            z-index: 2;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            position: relative;
            display: flex;
            align-items: center;
        }

        .section-title::after {
            content: '';
            flex-grow: 1;
            height: 1px;
            background: #ddd;
            margin-left: 20px;
        }

        .card-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            flex: 1 0 calc(33.333% - 20px);
            min-width: 250px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .card-content {
            padding: 20px;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #345;
        }

        .btn-more {
            display: block;
            margin: 0 auto;
            width: fit-content;
        }

        .swiper {
            width: 100%;
            height: 100%;
            margin-bottom: 40px;
        }

        .swiper-slide {
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Color themes for cards */
        .card-red { background-color: var(--accent-red); color: white; }
        .card-orange { background-color: var(--accent-orange); color: white; }
        .card-purple { background-color: var(--accent-purple); color: white; }
        .card-green { background-color: var(--accent-green); color: white; }
        .card-blue { background-color: var(--accent-blue); color: white; }
        .card-yellow { background-color: var(--accent-yellow); color: white; }

        /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-column {
            flex: 1 0 200px;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .copyright {
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            color: #ccc;
            font-size: 0.9rem;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .card {
                flex: 1 0 100%;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .hero-section {
                height: 70vh;
            }
        }
    </style>
</head>
<body>
<!-- Hero Section -->
<header class="hero-section">
    <div class="hero-content">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">ЕКАТЕРИНБУРГ</h1>
        <h2 class="text-2xl md:text-3xl mb-6">ГОРОД КОНТРАСТОВ</h2>
        <a href="#" class="btn">ПОДРОБНЕЕ</a>
    </div>
</header>

<!-- For City Guests Section -->
<section class="py-12 md:py-16">
    <div class="container">
        <h2 class="section-title">ГОСТЯМ ГОРОДА</h2>
        <div class="card-grid">
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content card-red">
                    <h3 class="card-title">ТЕАТРЫ</h3>
                    <p>Культурный отдых в уральской столице</p>
                </div>
            </div>
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content card-orange">
                    <h3 class="card-title">КУЛИНАРИЯ</h3>
                    <p>Рестораны и кафе на любой вкус</p>
                </div>
            </div>
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content card-purple">
                    <h3 class="card-title">МУЗЕИ</h3>
                    <p>История и искусство в одном месте</p>
                </div>
            </div>
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content card-green">
                    <h3 class="card-title">ПАРКИ</h3>
                    <p>Отдых на свежем воздухе</p>
                </div>
            </div>
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content card-blue">
                    <h3 class="card-title">СПОРТ</h3>
                    <p>Активный образ жизни</p>
                </div>
            </div>
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content card-yellow">
                    <h3 class="card-title">ПАМЯТНИКИ</h3>
                    <p>Исторические места города</p>
                </div>
            </div>
        </div>
        <a href="#" class="btn btn-more">ПОКАЗАТЬ ЕЩЕ</a>
    </div>
</section>

<!-- Events Section -->
<section class="py-12 bg-gray-100">
    <div class="container">
        <h2 class="section-title">АФИША</h2>
        <div class="swiper events-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="card w-full">
                        <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                        <div class="card-content">
                            <h3 class="card-title">Фестиваль современного искусства</h3>
                            <p>15-20 июня</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card w-full">
                        <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                        <div class="card-content">
                            <h3 class="card-title">Концерт классической музыки</h3>
                            <p>25 июня</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card w-full">
                        <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                        <div class="card-content">
                            <h3 class="card-title">Выставка уральских художников</h3>
                            <p>1-10 июля</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <a href="#" class="btn btn-more">ПОКАЗАТЬ ВСЕ</a>
    </div>
</section>

<!-- Ural Rock Year Section -->
<section class="py-12 md:py-16 relative" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7'); background-size: cover; color: white;">
    <div class="container">
        <h2 class="section-title text-white">ГОД УРАЛЬСКОГО РОКА 2026</h2>
        <div class="card-grid">
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content">
                    <h3 class="card-title">Фестиваль "Старый Новый Рок"</h3>
                    <p>Легендарный уральский фестиваль</p>
                </div>
            </div>
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content">
                    <h3 class="card-title">Музей рок-музыки</h3>
                    <p>История уральского рока</p>
                </div>
            </div>
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content">
                    <h3 class="card-title">Рок-клубы города</h3>
                    <p>Легендарные площадки</p>
                </div>
            </div>
        </div>
        <a href="#" class="btn btn-more">УЗНАТЬ БОЛЬШЕ</a>
    </div>
</section>

<!-- City Digest Section -->
<section class="py-12 md:py-16">
    <div class="container">
        <h2 class="section-title">ГОРОДСКОЙ ДАЙДЖЕСТ</h2>
        <div class="swiper digest-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="card w-full">
                        <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                        <div class="card-content">
                            <h3 class="card-title">Новые архитектурные проекты</h3>
                            <p>Как изменится город к 2030 году</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card w-full">
                        <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                        <div class="card-content">
                            <h3 class="card-title">Транспортная реформа</h3>
                            <p>Изменения маршрутов общественного транспорта</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card w-full">
                        <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                        <div class="card-content">
                            <h3 class="card-title">Экологические инициативы</h3>
                            <p>Зеленый город будущего</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <a href="#" class="btn btn-more">ПОКАЗАТЬ ВСЕ</a>
    </div>
</section>

<!-- World Level Section -->
<section class="py-12 md:py-16 bg-gray-100">
    <div class="container">
        <h2 class="section-title">МИРОВОЙ УРОВЕНЬ</h2>
        <div class="card-grid">
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content">
                    <h3 class="card-title">Международные выставки</h3>
                    <p>ИННОПРОМ и другие мероприятия</p>
                </div>
            </div>
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content">
                    <h3 class="card-title">Спортивные события</h3>
                    <p>Чемпионаты мирового уровня</p>
                </div>
            </div>
            <div class="card">
                <div class="card-img" style="background-image: url('https://page1.genspark.site/v1/base64_upload/9ae078aca18ab3723e510fe44e210ce7')"></div>
                <div class="card-content">
                    <h3 class="card-title">Небоскреб "Высоцкий"</h3>
                    <p>Самый высокий небоскреб за пределами Москвы</p>
                </div>
            </div>
        </div>
        <a href="#" class="btn btn-more">УЗНАТЬ БОЛЬШЕ</a>
    </div>
</section>

<!-- Reviews Section -->
<section class="py-12 md:py-16">
    <div class="container">
        <h2 class="section-title">ОТЗЫВЫ</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="mb-4">"Прекрасный город с богатой историей и культурой. Обязательно вернусь еще!"</p>
                <p class="font-bold">- Анна, Москва</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="mb-4">"Удивительное сочетание истории и современности. Рекомендую всем!"</p>
                <p class="font-bold">- Михаил, Санкт-Петербург</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="mb-4">"Уральская кухня - это нечто! Обязательно посетите местные рестораны."</p>
                <p class="font-bold">- Елена, Казань</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="mb-4">"Удобная инфраструктура и дружелюбные люди. Отличное место для туризма!"</p>
                <p class="font-bold">- Дмитрий, Новосибирск</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-column">
                <h3 class="footer-title">О ГОРОДЕ</h3>
                <ul class="footer-links">
                    <li><a href="#">История</a></li>
                    <li><a href="#">Современность</a></li>
                    <li><a href="#">Статистика</a></li>
                    <li><a href="#">Символика</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3 class="footer-title">ТУРИСТУ</h3>
                <ul class="footer-links">
                    <li><a href="#">Достопримечательности</a></li>
                    <li><a href="#">Размещение</a></li>
                    <li><a href="#">Транспорт</a></li>
                    <li><a href="#">Карта города</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3 class="footer-title">АФИША</h3>
                <ul class="footer-links">
                    <li><a href="#">Театры</a></li>
                    <li><a href="#">Концерты</a></li>
                    <li><a href="#">Выставки</a></li>
                    <li><a href="#">Фестивали</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3 class="footer-title">КОНТАКТЫ</h3>
                <ul class="footer-links">
                    <li><a href="#">Туристический центр</a></li>
                    <li><a href="#">Администрация</a></li>
                    <li><a href="#">Обратная связь</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            © 2023 Екатеринбург - город контрастов. Все права защищены.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Events Swiper
        const eventsSwiper = new Swiper('.events-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });

        // Digest Swiper
        const digestSwiper = new Swiper('.digest-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
    });
</script>
</body>
</html>